<?php

namespace DS\Importer\Controller\Update;

use Magento\Framework\App\Action\Context;

class Resavecategories extends \Magento\Framework\App\Action\Action
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
        $disable=false;
        if (isset($_GET['disable'])){
            $disable=true;
        }
        $data = $this->helper->resave_categories($disable);
        print("job done");
        die();
    }

}