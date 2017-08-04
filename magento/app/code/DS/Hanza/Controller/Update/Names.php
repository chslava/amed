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
            
            $prod_data= $this->helper->get_product_data($sku);
            if(!$prod_data){
                $this->products->disable($sku,$id);
                continue;
            }
            
            //TODO Update code
          
            
            print("Updating prduct name for:".$product->getName()." (".$product->getId()."/".$product->getSku().") <br/>");
            
                
            $languages = ["lv","en","ru"];
            foreach($languages as $lang){
                
                $result = $this->products->add_language($product->getId(), $prod_data["name"],$lang,$sku);
                if ($result["status"]){
                    print("Updated: $lang : ".$prod_data["name"]."<br/>");
                } else {
                    print("Failed: $lang : ".$prod_data["name"]."<br/>");
                }
            }
            
        
        }
        
    }

}