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

        $tested_categories = [];
        foreach ([0,1,2,3] as $store_id){
            $categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
            $categories = $categoryFactory->create()
                ->setStoreId($store_id)
                ->addAttributeToSelect('*');
            print("<h1>$store_id</h1>");
            //categories from current store will be fetched

            foreach($categories as $cat){

                $c = $this->_objectManager->create('Magento\Catalog\Model\Category')->setStoreId($store_id)->load($cat->getId());

                if (!isset($tested_categories[$c->getId()]))
                {
                    $tested_categories[$c->getId()] = [
                        "name"=>$c->getData("name"),
                        "include_in_menu"=>$c->getData("include_in_menu"),
                        "is_active"=>$c->getData("is_active"),
                        "position" =>$c->getData("position")
                    ];
                } else {
                    $print_out = false;

                    if ($tested_categories[$c->getId()]["name"]!=$c->getData("name")){
                        $print_out="Name differs!";
                    }
                    if ($tested_categories[$c->getId()]["include_in_menu"]!=$c->getData("include_in_menu")){
                        $print_out="Include in menu differs!";
                    }
                    if ($tested_categories[$c->getId()]["is_active"]!=$c->getData("is_active")){
                        $print_out="Is activediffers!";
                    }
                    if ($tested_categories[$c->getId()]["position"]!=$c->getData("position")){
                        $print_out="Position!";
                    }

                    if ($print_out){

                        print("<h2>");
                        print($print_out);
                        print("</h2>");

                        print("include in menu:");
                        var_dump($c->getData("include_in_menu"));
                        print("enable:");
                        var_dump($c->getData("is_active"));



                        print(" name:");
                        print($c->getData("name"));

                        print(" id:");
                        print($c->getId());
                        print("<br/>");
                    }
                }


            }
        }
        print("<pre>");
        print_r($tested_categories);
        print("</pre>");

    }



}