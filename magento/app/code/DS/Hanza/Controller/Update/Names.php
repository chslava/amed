<?php


namespace DS\Hanza\Controller\Update;

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

        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->helper = $this->_objectManager->create('DS\Hanza\Helper\Data');
        $this->products = $this->_objectManager->create('DS\Hanza\Helper\Products');
        $this->store = $this->_objectManager->create('DS\Hanza\Helper\Store');
        $this->cache = $this->_objectManager->create('DS\Hanza\Helper\Cache');
        

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
            $id = $product->getId();
            $counter++;
            
            $prod_data= $this->helper->get_product_data($sku);

            if(!$prod_data){
                print("$counter : Skipped product (there is no product data $sku) name :".$product->getName()." (".$product->getId()."/".$product->getSku().") <br/>");
                $this->products->disable($sku,$id);
                continue;
            }else {
                $this->products->enable($sku,$id);
            }
            
            //TODO Update code

            print("$counter : Updating prduct name for:".$product->getName()." (".$product->getId()."/".$product->getSku().") <br/>");

            $all_websites_ids = null;
            $magento_sores=$this->helper->store->get_magento_stores();

            $magento_sores['default']=[
                'storeId'=>0,
                'websiteId'=>$all_websites_ids
            ];
            $failed=0;
            $update=0;

            foreach($magento_sores as $store){


                $_product=null;
                $sid = $store["storeId"];
                $_product = $this->_objectManager->create('Magento\Catalog\Model\Product')->setStoreId($sid)->load($product->getId());
                $sku = $_product->getSku();
                $prod_store_id = $_product->getStoreId();
                $product_name = $_product->getName();
                $new_product_name = trim(str_replace($sku,"",$product_name));
                if ($new_product_name==$product_name){
                    print("skipped no need to update<br/>");
                    continue;
                }

                $_product->setName($new_product_name);
                $_product->setStoreId($sid);

                try {
                    print("<strong>updated</strong><br/>");
                    $_product->save();
                    $this->cache->set_cache_data($product->getSku(),true,"names_updated");
                    $updated++;
                } catch (\Exception $e) {
                    $this->cache->set_cache_data($product->getSku(),false,"names_updated");
                    $failed++;
                    print("<strong style='color:red'>".$counter." : ".$_product->getId()." could not save. </strong><br/>");

                }

            }


        }
        
    }

}