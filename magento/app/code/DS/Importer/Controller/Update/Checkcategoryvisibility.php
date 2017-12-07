<?php

namespace DS\Importer\Controller\Update;

use Magento\Framework\App\Action\Context;

class Checkcategoryvisibility extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;

    public  $helper = false;
    public  $products = false;
    public  $_skip_ssh = true;


    public function __construct(Context $context)
    {

        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->helper = $this->_objectManager->create('DS\Importer\Helper\Data');
        $this->products = $this->_objectManager->create('DS\Importer\Helper\Products');

        parent::__construct($context);
    }
    
    
    public function execute()
    {
        foreach ([0,1,2,3] as $store_id){
            $categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
            $categories = $categoryFactory->create()
                ->setStoreId($store_id)
                ->addAttributeToSelect('*');
            print("<h1>$store_id</h1>");
            //categories from current store will be fetched
            foreach($categories as $cat){
                $c = $this->_objectManager->create('Magento\Catalog\Model\Category')->setStoreId(1)->load($cat->getId());
                if (!$c->getData("include_in_menu")){
                    print("include in menu:");
                    var_dump($c->getData("include_in_menu"));



                    print(" name:");
                    print($c->getData("name"));

                    print(" id:");
                    print($c->getId());
                    print("<br/>");
                }

            }
        }

    }

}