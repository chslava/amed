<?php

namespace DS\Importer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\Registry;

class Products extends AbstractHelper
{
    
    private $class ="";
    private $_objectManager;

    
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
    
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);
        
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        $this->helper = $this->_objectManager->create('DS\Importer\Helper\Data');
        $this->gapi = $this->_objectManager->create('DS\Importer\Helper\Gapi');
        $this->registry = $this->_objectManager->create('Magento\Framework\Registry');;
        
    }
    
    //get al nems related to type id of the product
    public function get_product_names(){
        $product_names =$this->cache->get_cache_data('product_names',"Gapi");
        $return_product_names = [];
        foreach($product_names as $item){         
            $return_product_names[$item["type_id"]] = $item;
            $return_product_names[$item["type_id"]]["ee_en"]=$return_product_names[$item["type_id"]]["en"];
            $return_product_names[$item["type_id"]]["ee_ru"]=$return_product_names[$item["type_id"]]["ru"];
                
        }
        return $return_product_names;
    }
    
    
    // FUNCTIONS RELATED TO PRODUCT UPDATE / SAVE
    
    
    public function add_language($_product_id, $data, $lang, $sku)
    {
        $stores = $this->helper->get_magento_stores();
        if (!isset($stores[$lang])){
            $lang="default";
        }
        
        if (empty($data)){
            return 1;
        }
        
        $product = $this->_objectManager->create('\Magento\Catalog\Model\Product');
        $product->load($_product_id);
        
        $product->setName($data); 
        $product->setWebsiteIds([$stores[$lang]["websiteId"]]);
        $product->setStoreId($stores[$lang]["storeId"]);
        
        try {
            $product->save();
            return ["status"=>true,"message"=>"Language data updated"];
    
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return ["status"=>false,"message"=>"Update language related data failed. ".$e->getMessage()." "];
        }
    }
    
    
    public function delete_product_by_id($id) {
        //$this->registry = 
        $this->registry->unregister('isSecureArea');
        $this->registry->register('isSecureArea', true);
        $p = $this->_objectManager->create('\Magento\Catalog\Model\Product')->load($id);
        if ($p){
            try {
                $p->delete();
                return ["status"=>true,"message"=>"Product deleted"];
        
            } catch (\Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                return ["status"=>false,"message"=>"Could not delete product. ".$e->getMessage()." "];
            }    
        } else {
            return ["status"=>false,"message"=>"Could not find product by id $id !"];
        }
        
    }
    
    
    public function products_that_does_not_have_images($reverse=false){
              
        // returning list of products that does not have images
        $data = ["status"=>true, "message"=>"We got the list"];
        $data["data"]=[];
        $brands = $this->gapi->get_all_brands();
        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();
            $counter=0;
        foreach ($collection as $product){
            
            $existingMediaGalleryEntries = null;
            $existingMediaGalleryEntries = $this->helper->get_images($product->getId(),true);
            $prod_data= $this->helper->get_product_data($product->getSku());
            
            
            if (count($existingMediaGalleryEntries)>0 && !$reverse){
                
                
            } else {
                
                if (isset($prod_data["status"]) && !$prod_data["status"]){
                    $data["data"][] = [
                               "id"=>$product->getId(),
                               "sku"=>$product->getSku(),
                               "name"=>$product->getName(),
                               "brand"=>"---no product file---",
                               "url"=>$product->getProductUrl(),
                               "files"=>implode(",",$existingMediaGalleryEntries),
                               ];
                } else {
                    if (isset($brands[$prod_data["original_data"]['brandID']])){
                        $brand = $brands[$prod_data["original_data"]['brandID']];
                        $brand = $brand["name"];
                    } else {
                        $brand="Unknow brand (".$prod_data["original_data"]['brandID'].")";
                    }
                    $data["data"][] = [
                               "id"=>$product->getId(),
                               "sku"=>$product->getSku(),
                               "name"=>$product->getName(),
                               "brand"=>$brand,
                               "url"=>$product->getProductUrl(),
                               "files"=>implode(",",$existingMediaGalleryEntries),
                               ];
                }
                
                
                
            }
            
        }
        return $data;
    }
    
    
    
    public function disable($sku,$id=null){
        // function disables product either by sku or id
        $data=[];
        $data["status"]=false;
        $data["message"]="Disabling failed";
        $_product = $this->_objectManager->create('Magento\Catalog\Model\Product');
        if (!$id){            
            $id = $_product->getIdBySku($sku);
        } else {
            $_product->load($id);
        }
        

        if ($id){
            $_product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
            try {
                $_product->save();
                return ["status"=>true,"message"=>"Product disabled."];
            } catch (\Exception $e) {
                return ["status"=>false,"message"=>"Product disbalation failed ".$e->getMessage()." "];
            }

        } else {
            $data["status"]=false;
            $data["message"]="No product.";
        }
        return $data;
    }
     
    
}
