<?php

namespace DS\Importer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\Registry;

class Products extends AbstractHelper
{
    
    private $class ="";
    private $_objectManager;
    private $image_files = null;

    
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
    
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);
        
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        $this->csv = $this->_objectManager->create('DS\Importer\Helper\Csv');
        $this->store = $this->_objectManager->create('DS\Importer\Helper\Store');
    
        $this->helper = $this->_objectManager->create('DS\Importer\Helper\Data');
        $this->registry = $this->_objectManager->create('Magento\Framework\Registry');;
        
    }
 
    
    
    // FUNCTIONS RELATED TO PRODUCT UPDATE / SAVE
    
    
    public function add_language($_product_id, $data, $lang, $sku)
    {
        $stores = $this->store->get_magento_stores();
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
        
        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();
            $counter=0;
        foreach ($collection as $product){
            
            $existingMediaGalleryEntries = null;
            $existingMediaGalleryEntries = $this->get_magento_images_list($product->getId(),true);
            $prod_data= $this->get_product_data($product->getSku());
            
            
            if (count($existingMediaGalleryEntries)>0 && !$reverse){
                
                
            } else {
                    
                $data["data"][] = [
                    "id"=>$product->getId(),
                    "sku"=>$product->getSku(),
                    "name"=>$product->getName(),
                    "url"=>$product->getProductUrl(),
                    "files"=>implode(",",$existingMediaGalleryEntries),
                    ];          
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
            $data["message"]="No product nothing to dissable";
        }
        return $data;
    }


    public function enable($sku,$id=null){
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
            $_product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
            try {
                $_product->save();
                return ["status"=>true,"message"=>"Product enabled."];
            } catch (\Exception $e) {
                return ["status"=>false,"message"=>"Product enabled failed ".$e->getMessage()." "];
            }
        } else {
            $data["status"]=false;
            $data["message"]="No product nothing to dissable";
        }
        return $data;
    }
     
		     
    public function get_product_id_by_sku($sku) {
        //getting product by sku
        //returns product id
        //
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        }

        $_product = $this->_objectManager->create('Magento\Catalog\Model\Product');
        $id = $_product->getIdBySku($sku);

        if ($id){
            return $id;
        }else{
            return false;
        }
    }
    
    
    public function add_relations($sku_to, $sku_list,$type="related"){
        
        if (count($sku_list)==0){
            return ["status"=>true, "message"=>"Success, nothing to add/link."];
        }
        $link_data=[];
        
        foreach($sku_list as $sku_to_add) {
            /** @var \Magento\Catalog\Api\Data\ProductLinkInterface $productLink */
            $productLink = $this->_objectManager->create('Magento\Catalog\Api\Data\ProductLinkInterface')
                ->setSku($sku_to)
                ->setLinkedProductSku($sku_to_add)
                ->setLinkType($type);
            $link_data[] = $productLink;
            
        }
        
        /**
        * @var $product \Magento\Catalog\Model\Product\Interceptor
        */
        $product = $this->_objectManager->create('Magento\Catalog\Api\ProductRepositoryInterface')->get($sku_to);
        $product->setProductLinks($link_data)->save();
        
        
    }
    
    
    public function get_magento_images_list($sku,$id_passed=false){

        //return array of filenames of the product by product id
        // used mostly for comparing the exisitng images  and already imported images
        // to see if there is new files
        // comparing only count not the files
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        }
        if (!$id_passed){
            $prod_id = $this->get_product_id_by_sku($sku);
        } else {
            $prod_id=$sku;
        }


        $files =[];
        $p = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($prod_id);

        // could be that there is no such product.
        if ($p){
            $existingMediaGalleryEntries = $p->getMediaGalleryEntries();
            //could be that there is no images
            if ($existingMediaGalleryEntries){
                foreach($existingMediaGalleryEntries as $entry){
                    $files[] = $entry['file'];
                }
            }
        }
        return $files;
    }
    
    
    function update_image_attributes($product_id){

        if (!is_numeric($product_id)){
            return ["status"=>false, "message"=>"There is no product!"];
        }
        $existingMediaGalleryEntries = null;
        $existingMediaGalleryEntries = $this->get_magento_images_list($product_id,true);

        if(count($existingMediaGalleryEntries)>0) {
            $fi=array_shift($existingMediaGalleryEntries);
            $fir=$fi;
            $fi = $this->store->get_absolute_media_path()."catalog/product".$fi;
            if (file_exists($fi)) {
                $magento_sores=$this->helper->get_magento_stores();
                foreach($magento_sores as $store) {

                    $_product=null;
                    $_product = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($product_id);
                    $im_absolute_path="";
                    $sid = $store["storeId"];

                    $_product->setStoreId($sid)
                    ->setImage($fir)
                    ->setSmallImage($fir)
                    ->setThumbnail($fir);

                    try {
                        $_product->save();
                        return ["status"=>true,"message"=>"Media atributes update succeded"];
                    } catch (\Exception $e) {
                        return ["status"=>false,"message"=>"Media atributes update failed"];
                    }
                }               
            } else {
                return ["status"=>false, "message"=>"Image does not exist!"];
            }
        } else {
            return ["status"=>true, "message"=>"No images linked to product! Skipped!"];
        }
    }
    
    
    function add_upsells($prod_data){
        
        if (isset($prod_data["grouped_with"]) && is_array($prod_data["grouped_with"])){
            $sku = $prod_data["sku"];
            $sku_list=[];
            foreach($prod_data["grouped_with"] as $linked_prod) {
                if ($this->get_product_id_by_sku($linked_prod["vendorcode"]) && $linked_prod["vendorcode"]!=$sku){
                    $sku_list[]= $linked_prod["vendorcode"];    
                }
            }
            try {
                $this->add_relations($sku, $sku_list,"upsell");
                return ["status"=>true,"message"=>"Upsells products linked ".count($sku_list).". "];
            } catch (\Exception $e) {
                return ["status"=>false,"message"=>"Upsells products linking faile  ".$e->getMessage()." "];
            }
        } else {
            return ["status"=>true,"message"=>"Nothing to add to upsells."];
        }
    }
    
    
     /**
    * function that returns list of images that matches product sku
    * @sku product sku to search in the filesystem to match images
    * @bad_symbols mixed  bad symbols to replace  (sku can have slashes or some other characters that could not be allowed by filesystem)
    * @replace_symbols mixed  symbol to replace bad symbolss
    * @return array
    */
    public function get_image_list_from_filesystem($sku,$bad_symbols="/",$replace_symbol="_"){
        $img_list = [];
        $max_images =10;
        $posible_extensions = [".jpg",".jpeg",".JPG",".png"];

        if (!$this->image_files){
            $image_dir = $this->helper->get_image_destination_dir();
            $this->image_files = $this->helper->get_files_from_dir($image_dir,$image_dir);
        }
        $files = $this->image_files;

        foreach($posible_extensions as $ext){
            $img_basename = str_replace($bad_symbols,$replace_symbol,$sku);
            $image_name = $img_basename.$ext;
            if (isset($files[$image_name]) && file_exists($files[$image_name])){
                $img_list[]=$files[$image_name];
            }
            for($i=1; $i <= $max_images; $i++){
                $img_name = $img_basename."_".$i.$ext;
                if (isset($files[$img_name]) && file_exists($files[$img_name])){
                    $img_list[]=$files[$img_name];
                }
            }
        }
        return $img_list;
    }


    /**
    * returns merged cases of image lists if there is several bad symbol replace rules
    * @sku product sku to search in the filesystem to match images
    * @return array
    */
    function get_image_list($sku){
        //grenardi has several bad symbol cases thats why we use wrapper to get all cases of images matching sku
        $img_list = [];
        $img_list = $this->get_image_list_from_filesystem($sku);
        $img_list = array_merge($img_list, $this->get_image_list_from_filesystem($sku,"/",":"));
        $img_list_to_return=[];

        //removes dublicate entries
        foreach($img_list as $img){
            if (!in_array($img, $img_list_to_return)){
                $img_list_to_return[] = $img;
            }

        }
        return $img_list_to_return;
    }
    
}
