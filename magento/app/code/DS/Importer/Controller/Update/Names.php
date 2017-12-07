<?php


namespace DS\Importer\Controller\Update;

use Magento\Framework\App\Action\Context;

class Names extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;

    public  $helper = false;
    public  $products = false;
    public  $product_data = null;
    public  $_skip_ssh = true;


    public function __construct(Context $context)
    {
        die("disabled");
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->helper = $this->_objectManager->create('DS\Importer\Helper\Data');
        $this->products = $this->_objectManager->create('DS\Importer\Helper\Products');
        $this->store = $this->_objectManager->create('DS\Importer\Helper\Store');
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        

        parent::__construct($context);
    }


    public function execute()
    {
        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();
            
        $counter=0;
        foreach ($collection as $product){
            $sku = $product->getSku();
            if($this->cache->get_cache_data($product->getSku(),"pnames_updated")){
                continue;
            }
            $id = $product->getId();
            $counter++;
            
            $prod_data= $this->helper->get_product_data($sku);

            if ($prod_data){
                $original_name = $prod_data["name"];
            }

            $this->products->enable($sku,$id);

            
            //TODO Update code

            print("$counter : Updating prduct name for:".$product->getName()." (".$product->getId()."/".$product->getSku().") <br/>");

            $all_websites_ids = null;
            $magento_sores=$this->helper->store->get_magento_stores();

            $magento_sores['default']=[
                'storeId'=>0,
                'websiteId'=>$all_websites_ids
            ];
            $failed=0;

            $has_been_updated = true;
            foreach($magento_sores as $store){


                $_product=null;
                $sid = $store["storeId"];
                $_product = $this->_objectManager->create('Magento\Catalog\Model\Product')->setStoreId($sid)->load($product->getId());
                $sku = $_product->getSku();
                $sku_remove = [$sku];

                $sku_split = explode("-",$sku);
                $sku_remove = array_merge($sku_remove,$sku_split);
                $sku_split = explode(" ",$sku);
                $sku_remove = array_merge($sku_remove,$sku_split);
                $sku_remove = array_unique($sku_remove);

                $prod_store_id = $_product->getStoreId();
                $product_name = $_product->getName();
                $new_product_name = trim(str_replace($sku_remove,"",$product_name));

                if ($new_product_name==$product_name){
                    print($new_product_name." == ".$product_name);
                    if ($sid!=0){
                        $_product->setName(null);
                        $_product->setStatus(null);
                        $_product->setVisibility(null);
                        $_product->setTaxClassId(null);
                        $_product->setDiscription(null);
                        $_product->setShortDiscription(null);

                        try {
                            print("<strong>updated</strong><br/>");
                            $_product->save();
                            $updated++;
                        } catch (\Exception $e) {

                            $failed++;
                            print("<strong style='color:yellow'>".$counter." : ".$_product->getId()." could not save (".$e->getMessage()."). </strong><br/>");

                        }
                    }

                    print("<br/>skipped no need to update<br/>");
                    $this->cache->set_cache_data($product->getSku(),true,"pnames_updated");
                    continue;
                }

                print(" Have to update ".$new_product_name."(new) == ".$product_name."<br/>");

                $_product->setName($new_product_name);
                $_product->setStoreId($sid);


                try {
                    print("<strong>updated</strong><br/>");
                    $_product->save();
                    $has_been_updated = $has_been_updated && true;
                    $updated++;
                } catch (\Exception $e) {

                    $failed++;
                    $has_been_updated = $has_been_updated && false;
                    print("<strong style='color:yellow'>".$counter." : ".$_product->getId()." could not save (".$e->getMessage()."). </strong><br/>");
                }

            }
            $this->cache->set_cache_data($product->getSku(),$has_been_updated,"pnames_updated");


        }
        
    }

}