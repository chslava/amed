<?php

namespace DS\Importer\Controller\Update;

use Magento\Framework\App\Action\Context;

class RemoveStoreViewTexts extends \Magento\Framework\App\Action\Action
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
        $stores = $this->store->get_magento_stores();

        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();

        foreach ($collection as $p) {

            if (!is_object($p)) {
                $p = $this->products->get_product_by_sku($p);
            }
            $sku = $p->getSku();

            foreach($stores as $key => $s){
                ?>
                <h8><?= $key ?></h8>
                <?php

                try {
                    $this->_objectManager->create('Magento\Catalog\Model\Product')
                        ->load($p->getId())
                        ->setStoreId($s["storeId"])
                        ->setDescription(null)
                        ->setShortDescription(null)
                        ->setName(null)
                        ->save();
                    print($sku." saved!<br/>");
                } catch (\Exception $e) {
                    print($sku." <strong style=\"color:red;\">failed</strong>!<br/>");
                }

            }
        }
    }
}