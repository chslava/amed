<?php


namespace DS\Importer\Controller\Update;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_objectManager;
    protected $_storeManager;

    public  $_helper = false;
    


    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        die("disabled");
        $this->_storeManager = $storeManager;
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->helper = $this->_objectManager->create('DS\Importer\Helper\Data');
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        $this->products = $this->_objectManager->create('DS\Importer\Helper\Products');
        parent::__construct($context);
    }
    
    
    public function execute()
    {
        $url = $this->helper->get_base_url()."importer/update/names"; ?>
        <a href="<?= $url ?>">Update product names</a><br/>
        
        <?php $url = $this->helper->get_base_url()."importer/update/mediaattributes"; ?>
        <a href="<?= $url ?>">Update Media attributes</a><br/>
        <!--
        <?php $url = $this->helper->get_base_url()."importer/update/removenoimagesproducts"; ?>
        <a href="<?= $url ?>">Remove products that has no images</a><br/>
        
        <?php $url = $this->helper->get_base_url()."importer/update/disableremovedproducts"; ?>
        <a href="<?= $url ?>">Disable products that ar not in hanza anymore</a><br/>
        -->

        <?php $url = $this->helper->get_base_url()."importer/update/productpricesupdate"; ?>
        <a href="<?= $url ?>">Product prices update</a><br/>

        <?php $url = $this->helper->get_base_url()."importer/update/names"; ?>
        <a href="<?= $url ?>">Product names update</a><br/>

        
        
        <?php
        die();
    }

}