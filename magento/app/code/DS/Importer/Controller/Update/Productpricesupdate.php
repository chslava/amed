<?php
namespace DS\Importer\Controller\Update;

use Magento\Framework\App\Action\Context;

class Productpricesupdate extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;

    public  $helper = false;
    public  $products = false;


    public function __construct(Context $context)
    {
        die("disabled");
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->helper = $this->_objectManager->create('DS\Importer\Helper\Data');
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        $this->products = $this->_objectManager->create('DS\Importer\Helper\Products');
        parent::__construct($context);
    }


    public function execute() {

        $hash = md5("justdoit".date("Y-m-d"));
        if (!isset($_GET["exec"]) || $hash!=$_GET["exec"]){
            print("Almoust, but did not do, need key $hash");
            die();
        }

        $already_executed=$this->cache->get_cache_data("executed_price_update","Update");
        if (!$already_executed){


            $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
            $collection = $productCollection->create()
                ->addAttributeToSelect('*')
                ->load();

            foreach ($collection as $product){

                $sku = $product->getSku();
                $price_with_vat=0;
                $price_without_vat=0;
                $price_with_vat =$product->getPrice();
                $tax_rate_class= $product->getTaxClassId();
                switch($tax_rate_class){

                    case 0:
                        $tax_rate = 0;
                        break;
                    case 2:
                        $tax_rate = 0.21;
                        break;
                    case 4:
                        $tax_rate = 0.12;
                        break;
                    default:
                        print($tax_rate_class);
                        die();
                        break;
                }


                $price_without_vat = $price_with_vat/(1+$tax_rate);
                $vat = $price_with_vat - $price_without_vat;
                print("sku: $sku    tax: $tax_rate    price: $price_with_vat     price without vat: $price_without_vat vat: $vat<br/>");
                $product->setPrice($price_without_vat);

                try {

                    $product->save();
                    print($sku." : ".$product->getId()." Updated. <br/>");

                } catch (\Exception $e) {

                        print($sku." : ".$product->getId()." could not save. <br/>");

                }

            }

        } else {
            print("already done stuff");
        }

        $already_executed=$this->cache->set_cache_data("executed_price_update",true,"Update");


        die();
    }

}