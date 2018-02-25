<?php

namespace DS\Importer\Controller\Update;

use Magento\Framework\App\Action\Context;

class ContactImport extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;

    public  $helper = false;
    public  $products = false;
    public  $_skip_ssh = true;


    public function __construct(Context $context)
    {
        ini_set('max_execution_time', 4800);
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->store = $this->_objectManager->create('DS\Importer\Helper\Store');
        $this->products = $this->_objectManager->create('DS\Importer\Helper\Products');
        $this->categories = $this->_objectManager->create('DS\Importer\Helper\Categories');
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');

        parent::__construct($context);
    }






    public function execute()
    {

        $contacts_data= json_decode(file_get_contents($this->store->get_old_shop_data_dir()."/contact_persons.json"),true);

        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');

        foreach($contacts_data as $c){
            $product_name = $c["name_lv"];
            $c_name = $c["contact_name"];
            $c_phone = $c["contact_phone"];
            $c_email = $c["contact_email"];


            $collection = $productCollection->create()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter([
                    [
                        'attribute'=>'name',
                        'like'=>"%$product_name%"
                    ]
                ]);

            foreach ($collection as $p) {

                if (!is_object($p)) {
                    $p = $this->products->get_product_by_sku($p);
                }
                $sku = $p->getSku();

                try {
                    $this->_objectManager->create('Magento\Catalog\Model\Product')
                        ->load($p->getId())
                        ->setStoreId(0)
                        ->setData("contact_person",$c_name)
                        ->setData("contact_phone",$c_phone)
                        ->setData("contact_email",$c_email)
                        ->save();
                    print($sku." saved!<br/>");
                } catch (\Exception $e) {
                    print($sku." <strong style=\"color:red;\">failed</strong>!<br/>");
                }


            }




        }




    }
}