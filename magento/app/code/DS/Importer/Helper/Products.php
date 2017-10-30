<?php

namespace DS\Importer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\Registry;

class Products extends AbstractHelper
{
    
    private $class ="";
    private $_objectManager;
    private $image_files = null;
    private $ttl_hour = 3600;
    private $stores=null;
    private $websites=null;

    
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
    
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);
        
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        $this->store = $this->_objectManager->create('DS\Importer\Helper\Store');
        $this->registry = $this->_objectManager->create('Magento\Framework\Registry');;
        
    }
    
   


    public function add_language($_product_id, $data, $lang)
    {
        $stores = $this->helper->get_magento_stores();
        if (!isset($stores[$lang])){
            return ["status"=>false,"message"=>"No store for that language ($lang)"];
        }
        
        if (empty($data)){
            return ["status"=>false,"message"=>"No data for name update"];
        }
        
        $product = $this->_objectManager->create('\Magento\Catalog\Model\Product');
        $product->setStoreId($stores[$lang]["storeId"]);
        $product->load($_product_id);
        if (trim($product->getName())==trim($data)){
            return ["status"=>true,"message"=>"The name is the same, no need to update"];
        }
        $product->setName($data);
        $product->setUrlKey($this->slugify($data." ".$product->getIdentificator()));
        $product->setWebsiteIds([$stores[$lang]["websiteId"]]);
        $product->setStoreId($stores[$lang]["storeId"]);
        $product->setStatus(null);
        
        try {
            $product->save();
            return ["status"=>true,"message"=>"Language data updated"];
    
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return ["status"=>false,"message"=>"Update language related data failed. ".$e->getMessage()." "];
        }
    }


    public function alpha_extended_translate($text){
        $translit= ['á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja'];
        $tr_keys = array_keys($translit);
        $tr_values = array_values($translit);
        $text = str_replace($tr_keys,$tr_values,$text);
        return $text;
    }



    public function slugify($text)
    {
        $text = $this->alpha_extended_translate($text);
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }




    public function set_url($_product_id, $url){
        $url = $this->slugify($url);

        $product = $this->_objectManager->create('\Magento\Catalog\Model\Product');
        $product->load($_product_id);
        $existing_url_key = $product->getUrlKey();


        if ($existing_url_key==$url){
            return ["status"=>true,"message"=>"Url key same, nothing to update ($url)"];
        }

        $product->setUrlKey($url);
        $product->setStoreId(0);

        try {
            $product->save();
            return ["status"=>true,"message"=>"Url key data updated ($url)"];

        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return ["status"=>false,"message"=>"Url key update failed. ".$e->getMessage()." "];
        }
    }


    public function delete_product_by_id($id) {
        $this->registry=$this->_objectManager->create('\Magento\Framework\Registry');
        $this->registry->unregister('isSecureArea');
        $this->registry->register('isSecureArea', true);

        //$productRepository = $this->_objectManager->create('\Magento\Catalog\Model\ProductRepository');
        $productRepository = $this->_objectManager->create('\Magento\Catalog\Api\ProductRepositoryInterface');

        $p = $productRepository->getById($id);

        if ($p){
            try {
                $productRepository->delete($p);
                return ["status"=>true,"message"=>"Product deleted"];

            } catch (\Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                return ["status"=>false,"message"=>"Could not delete product. ".$e->getMessage()." "];
            }
        } else {
            return ["status"=>false,"message"=>"Could not find product by id $id !"];
        }

    }



    public function delete_product_by_sku($sku) {
        $this->registry=$this->_objectManager->create('\Magento\Framework\Registry');
        $this->registry->unregister('isSecureArea');
        $this->registry->register('isSecureArea', true);
        $p = $this->_objectManager->create('\Magento\Catalog\Model\ProductRepository');
        if ($p){
            try {
                $p->deleteById($sku);
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
        foreach ($collection as $product){
            
            $existingMediaGalleryEntries = null;
            $existingMediaGalleryEntries = $this->get_magento_images_list($product->getId(),true);
            $prod_data= $this->get_product_data($product->getSku());
            
            
            if (count($existingMediaGalleryEntries)>0 && !$reverse){
                
                
            } else {
                
                if (isset($prod_data["status"]) && !$prod_data["status"]){
                    $data["data"][] = [
                               "id"=>$product->getId(),
                               "sku"=>$product->getSku(),
                               "name"=>$product->getName(),
                               "url"=>$product->getProductUrl(),
                               "files"=>implode(",",$existingMediaGalleryEntries),
                               ];
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
            $_product->setStoreId(0)->load($id);
        }
        $_product->setStoreId(0);
        

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
            $data["message"]="No product nothing to enable.";
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
    
    
    public function get_imported_images($sku)
    {
        $prod_cache_image_cache = $this->cahce->get_cache_data($sku,"products_images");
        if ($prod_cache_image_cache){
            return $prod_cache_image_cache;
        } else {
            //if there was no data then saving existing situation
            $product_id = $this->get_product_id_by_sku($sku);
            $images = $this->get_images($product_id);
            $this->cache->set_cache_data($sku,$images,"products_images");
            return $images;
        }
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
    
    
    function update_image_attributes($product_id,$sku){

        if (!is_numeric($product_id)){
            return ["status"=>false, "message"=>"There is no product!"];
        }
        $existingMediaGalleryEntries = null;
        $existingMediaGalleryEntries = $this->get_images($product_id,true);

        if (count($existingMediaGalleryEntries)>0){

            if(count($existingMediaGalleryEntries)>0){
                $fi=array_shift($existingMediaGalleryEntries);
                $fir=$fi;
                $fi = $this->get_absolute_media_path()."catalog/product".$fi;
                if (file_exists($fi)){

                    if (!$this->cache->get_cache_data($sku,"image_stores_set")){
                        $magento_sores=$this->get_magento_stores();
                        $all_websites_ids=null;
                        $magento_sores['default']=[
                            'storeId'=>0,
                            'websiteId'=>$all_websites_ids
                        ];
                        foreach($magento_sores as $store){

                            $_product=null;
                            $_product = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($product_id);
                            $sid = $store["storeId"];

                            $_product->setStoreId($sid)
                            ->setImage($fir)
                            ->setSmallImage($fir)
                            ->setThumbnail($fir);

                            try {
                                $_product->save();
                                $this->cache->set_cache_data($_product->getSku(),true,"image_stores_set");
                            } catch (\Exception $e) {
                                $this->cache->set_cache_data($_product->getSku(),false,"image_stores_set");
        ;
                            }
                        }
                    }

                } else {
                    print($fi." Skipped <br/>");
                }
            }
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
            $image_dir = $this->store->get_image_destination_dir();
            $this->image_files = $this->store->get_files_from_dir($image_dir,$image_dir);
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
    
    
    public function validate_product($data,$test_images = false){

        $valid = true;
        $message=[];
        $data["qty_in_package"] = trim($data["qty_in_package"]);
        $data["qty_in_box"] = trim($data["qty_in_box"]);


        if (!isset($data['name']) || !isset($data['name']['lv']) || strlen(trim(isset($data['name']['lv'])))==0){
            $valid = false;
            $message[]="There is no name of the product!";
        }

        if (!isset($data['description']) || !isset($data['description']['lv']) || strlen(trim(isset($data['description']['lv'])))==0 ){
            $valid = false;
            $message[]="There is no description of the product!";
        }

        if (empty($data["qty_in_package"]) || !is_numeric($data["qty_in_package"])){
            $valid = false;
            $message[]="Package qty value is empty!";
        }

        if (empty($data["qty_in_box"]) || !is_numeric($data["qty_in_box"])){
            $valid = false;
            $message[]="Box qty value is empty!";
        }


        if (empty($data["class_lvl_1"])){
            $valid = false;
            $message[]="Class 1 value is empty!";
        }

        if (empty($data["class_lvl_2"])){

            $valid = false;
            $message[]="Class 2 value is empty!";
        }

//        if (!isset($data["price"]) || !is_numeric($data["price"]) || strlen($data["price"])==0){
//            $valid = false;
//            if (!isset($data['price'])){
//                $message[]="Price  missing";
//            } else {
//                $message[]="Price  missing or wrong format [".$data["price"]."]";
//            }
//        }
        if ($data["material"]===false){
            $valid = false;
            $message[]="Could not decode material [".$data["material"]."]";
        }

        if ($data["color"]===false){
            $valid = false;
            $message[]="Could not decode color [".$data["color"]."]";
        }



        if ($test_images){
            $image_list = $this->get_image_list($data["sku"]);
            if(count($image_list)==0){
                $valid = false;
                $message[]="No image found.";
            }
        }

        return ['status'=>$valid, "message"=>implode(", ",$message)];
    }
    
    
    public function get_product_data($sku)
    {
        $data = $this->csv->get_product($sku);
        $prices = $this->csv->get_prices($sku);

        
        //print($file." ".$file_price." ".$file_price_package." ".$file_price_box."<br/>");
        if(!$prices){
            return [
                "status"=>false,
                "message"=>"No prices"
            ];
        } elseif (!$data){
            return [
                "status"=>false,
                "message"=>"No product data"
            ];
        }

        $data["price"]=0;
        $data["price_package"]=0;
        $data["price_box"]=0;

        if (isset($prices["IV"])){
            $data["price"]=$prices["IV"]["price"];
        }
        if (isset($prices["IV2"])){
            $data["price_package"]=$prices["IV2"]["price"];
        }
        if (isset($prices["IV3"])){
            $data["price_box"]=$prices["IV3"]["price"];
        }

        $data = $this->get_real_item_price($data);
        $data["images"]= $this->get_image_list($sku);

        if (strlen(trim($data['color']))){
            $data['color']= $this->decode_color($data['color']);
        }

        if (strlen(trim($data['material']))>0){
            $data['material']=$this->decode_material($data['material']);
        }


        $data['categories'] = $this->helper->get_magento_categories($data);

        return $data;

    }

    
    private function get_real_item_price($data){

        $data["qty_in_package"]=str_replace(" pāri","",$data["qty_in_package"]);
        $data["qty_in_box"]=str_replace(" pāri","",$data["qty_in_box"]);
        //default settings arr that sold all the possible ways
        $sold_by_item=1;
        $sold_by_package=1;
        $sold_by_box=1;

        //if one item price is less than 1 cent then its not sold by one item
        if (!is_numeric($data['price']) || $data['price']<0.01){
            $sold_by_item=0;
        }
        //if there is no qty in package or there is no price then also not by package
        if (!is_numeric($data['price_package']) || $data['price_package']<0.01){
            $sold_by_package=0;
        }
        //if there is no qty in package or there is no price then also not by box
        if (!is_numeric($data['price_box']) || $data['price_box']<0.01){
            $sold_by_box=0;
        }
        
        $data['price_item']=$data['price'];

        $data["sold_by_item"]=$sold_by_item;
        $data["sold_by_package"]=$sold_by_package;
        $data["sold_by_box"]=$sold_by_box;

        return $data;
    }


    private function get_all_color_codes(){

        $data_to_return = $this->cache->get_cache_data(__FUNCTION__,$this->class,$this->ttl_hour);
        $lang_list = $this->helper->get_languages();
        if ($data_to_return){
            return $data_to_return;
        } else {
            $src_file = $this->helper->get_import_filename("colours.txt");

            if (file_exists($src_file)) {
                if (($handle = fopen($src_file, "r")) !== FALSE) {
                    $color_data = [];
                    $lang_data = [];
                    $color_id="";
                    while (($data = fgetcsv($handle, 0, "\t",chr(8))) !== FALSE) {
                        if(strlen($data[0])==3 || in_array($data[0],$lang_list)){

                            if (in_array($data[0],$lang_list)){
                                $lang_data[$this->helper->get_lang_code($data[0])] = $data[1];

                            } else {
                                if ($color_id!=""){

                                    $color_data["language"] = $lang_data;
                                    $data_to_return[$color_id] = $color_data;
                                }
                                $color_data = [];
                                $color_data = $data;

                                $color_id = $data[0];
                            }

                        } else {
                            //skipping
                            continue;
                        }
                    }
                    $data_to_return[$color_id] = $color_data;

                }
            }

        }

        $this->helper->set_cache_data(__FUNCTION__,$data_to_return);
        return $data_to_return;

    }

    
    public function get_ids_for_update($force=false){

        $csv_products = $this->csv->get_all_products();
        foreach($csv_products as $product){

            $prices = $this->csv->get_prices($product["sku"]);

            if(!$prices){
                $data_to_return[] = ["sku"=>$product["sku"],"update"=>false,"reason"=>"No prices! Product should be disabled!"];
            } else {
                $changed = $this->product_is_changed($product,$prices);
                if ($changed){
                    $data_to_return[] = ["sku"=>$product["sku"],"update"=>true,"reason"=>$changed["reason"]];
                } else {
                    $data_to_return[] = ["sku"=>$product["sku"],"update"=>false,"reason"=>"No changes"];
                }
            }

        }
        return $data_to_return;

    }
    
    
    public function get_ids_for_update_by_prices(){

        $data_to_return = [];
        $file_prefix="prices";
        $file_to_split = $this->helper->get_import_filename("prices");

        $cache_dir= $this->helper->get_cache_dir()."/".$file_prefix;
        
        $value_mapping = $this->helper->get_value_maping($file_prefix);

        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0777,true);
        }

        if (!file_exists($file_to_split)){
            print("file does not exist: ".$file_to_split);
            return false;
        }

        if (file_exists($file_to_split)) {
            if (($handle = fopen($file_to_split, "r")) !== FALSE) {

                while (($data = fgetcsv($handle,  0, "\t",chr(8))) !== FALSE) {

                    if (count($data)<2){
                        continue;
                    }

                    $price =[];
                    foreach($value_mapping as $key => $value){
                        $price[$value]=$data[$key];
                    }

                    $cache_file = $this->helper->get_cache_file($price["sku"].".".$price["price_group_id"].".",$file_prefix);

                    $changed = true;
                    if (file_exists($cache_file)){
                        $changed = false;
                        $price_from_file = json_decode(file_get_contents($cache_file),true);
                        foreach($price as $key => $value){
                            if ($price_from_file[$key]!=$value){
                                $changed=true;
                            }
                        }
                        if ($changed){
                            unlink($cache_file);
                        }
                    }

                    if ($changed){
                        $data_to_return[]=$price["sku"];
                        file_put_contents($cache_file,json_encode($price));
                    }
                    //current price value mapping

                }

            }
        }

        return $data_to_return;

    }


    public function add($data, $qty=2000){


        $return_data = ["status"=>false, "message"=>""];
        $defult_language = $this->store->get_default_language_code();
        if (empty($data["name"]) && empty($data["languages"][$defult_language]["name"])){
            return ["status"=>false, "message"=>"Name empty, cant add product with no name!"];
        }

        $update=false;
        $sku =$data["sku"];
        $product_id = $this->get_product_id_by_sku($sku);
        


        unset($data["sku"]);
        if (!$this->stores){
            $this->stores = $this->store->get_magento_stores();
        }
        if(!$this->websites){
            $this->websites =[];
            foreach($this->stores as $store){
                if (!in_array($store["websiteId"],$this->websites)){
                    $this->websites[] = $store["websiteId"];
                }
            }
        }

        $product = $this->_objectManager->create('Magento\Catalog\Model\Product');
        if($product_id){
            $update = true;
            $product->load($product_id);
        } else {
            $product->setTypeId('simple');
            $product->setStoreId(0);
            $product->setSku($sku);
            $product->setVisibility(4);
            $product->setAttributeSetId($this->store->get_attribute_set());
            $product->setWebsiteIds($this->websites);
        }

        if (!empty($data["name"])){
            $product->setName($data["name"]);
            $product->setUrlKey($this->slugify($data["name"]."-".$sku));
        }

        $product->setStockData([
                'use_config_manage_stock' => 0, //'Use config settings' checkbox
                'manage_stock' => 0, //manage stock
                'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
                'max_sale_qty' => $qty, //Maximum Qty Allowed in Shopping Cart
                'is_in_stock' => 1, //Stock Availability
                'qty' => $qty //qty
            ]);

        foreach($data as $key=>$value){
            if ($key=="languages"){


                if (empty($data["name"]) && isset($value[$defult_language])){
                    $name="";
                    if (isset($value[$defult_language]["name"])){
                        $name = $value[$defult_language]["name"];
                        $product->setName($name);
                    }

                    if (!$product->getUrlKey()){
                        if ($name){
                            $slug = $this->slugify($name."-".$sku);
                            $product->setUrlKey($slug);
                        }
                    }
                }

                if (empty($data["description"]) && isset($value[$defult_language]["description"])){
                    $description = $value[$defult_language]["description"];
                    $product->setDescription($description);
                }

                continue;
            }
            if ($key=="categories"){
                $product->setCategoryIds($value);
            }
            $product->setData($key,$value);
        }


        try {

            $product->save();


            if(!is_numeric($product_id)) {
                $product_id = $product->getId();
            }

            if (!is_numeric($product_id)){
                $product_id = $this->get_product_id_by_sku($product->getSku());
                if (!is_numeric($product_id)){
                    $product_id = null;
                }
            }

            if ($product_id) {


                $return_data = $this->sync_product_img($sku,false,false);

                foreach($data["languages"] as $lang=>$lang_data){
                    if (isset($this->stores[$lang])){
                        $product->setStoreId($this->stores[$lang]["storeId"]);
                        if(count($lang_data)>0){
                            foreach($lang_data as $key => $value){
                                if ($key=="name"){
                                    $slug = $this->slugify($value." ".$sku);
                                    $product->setUrlKey($slug);
                                }
                                if (!emtpy($value)){
                                    $product->setData($key,$value);
                                } else {
                                    $product->setData($key,null);
                                }
                            }
                        }
                        $product->save();
                    }

                }
            }
            $this->cache->set_cache_data($sku,$data,"last_update_products");

            if ($update){
                return ["status"=>true,"message"=>" Product updated. ".$return_data["message"]];
            } else {
                return ["status"=>true,"message"=>" Product added. ".$return_data["message"]];
            }

        } catch (\Exception $e) {
                return ["status"=>false,"message"=>" Could not add product! (".$sku." - ".$product->getName()." - ".$product->getUrlKey()." )  ".__LINE__." ".$e->getMessage()." | ".$return_data["message"]];
        }

    }



    private function sync_product_img($sku, $force=true, $only_delete=true){

        //function that updates product images by sky
        // @$sku - product sku
        // @force - forces update images even if image count is equal (flag for testing)
        // @only_delete - deletes files does not add images even if there is images (flag for testing)

        // getting product
        $data=[];
        $data['status']=false;
        $data['message']="Did not do anything";




        $images_to_add = $this->get_image_list($sku);


        $images_by_barcode = $this->cache->get_cache_data($sku,"images_with_barcode");

        if ($images_by_barcode && is_array($images_by_barcode)) {
            foreach($images_by_barcode as $img){
                if (!in_array($img,$images_to_add)){
                    $images_to_add[] = $img;
                }
            }
        }

        $id = $this->get_product_id_by_sku($sku);

        if (!$id){
            //if there is no id, there is no product
            $data['status']=false;
            $data["message"]="No product, skipping, could not add images to nonexisting produc $sku";
            return $data;
        }


        //remove images from product
        $p = $this->_objectManager->create('Magento\Catalog\Model\Product');
        $productRepository = $this->_objectManager->create('\Magento\Catalog\Api\ProductRepositoryInterface');
        $existingMediaGalleryEntries = $p->load($id)->getMediaGalleryEntries();

        if (count($images_to_add)==0 && count($existingMediaGalleryEntries)==0){
            $data['status']=false;
            $data['message']="No images, skipping!";
            return $data;
        }



        if (count($existingMediaGalleryEntries)==count($images_to_add)){
            if(count($images_to_add)>0){
                $changed=false;
                foreach($images_to_add as $image) {
                    $base_name  = basename($image);
                    if(file_exists($image)){
                        $current_filestamp = filemtime($image);
                    } else {
                        $current_filestamp=0;
                    }
                    $prev_filestamp = $this->cache->get_cache_data($image,"image_timestamps");
                    if (!$prev_filestamp || $prev_filestamp!=$current_filestamp){
                        $changed = true;
                    }
                }
                if (!$changed && !$force) {
                    $data['status']=false;
                    $data["message"]="Image count is the same, image list of the product was not updated";
                    return $data;
                }
            } else {
                if (!$force){
                    $data['status']=false;
                    $data["message"]="Image count is the same, image count is zero.";
                    return $data;
                } else {

                }
            }
        }



        //could be that there is no images, so skipping deleting them
        $delete_counter=0;
        if ($existingMediaGalleryEntries){

            foreach ($existingMediaGalleryEntries as $key => $entry) {
                //We can add your condition here
                $media_dir = $this->store->get_absolute_media_path();
                $file = $media_dir."catalog/product".$entry->getFile();

                if (file_exists($file)){
                    unlink ($file);
                }
                $delete_counter++;
                unset($existingMediaGalleryEntries[$key]);
            }
            $p->setMediaGalleryEntries($existingMediaGalleryEntries);
            try {
                $productRepository->save($p);
            } catch (\Exception $e) {
                return ["status"=>false,"message"=>"Could not updata images!  ".$e->getMessage()];
            }
        }

        $data['status']=true;
        $data['message']="Image removed!";


        if ($only_delete){
            return $data;
        }

        //adding images
        $p = $this->_objectManager->get('Magento\Catalog\Model\Product')->load($id);
        $counter=0;
        $images_imported=[];
        foreach($images_to_add as $image_to_add){
            if (!file_exists($image_to_add)){
                continue;
            }
            $img_file_name = basename($image_to_add);
            $src = $image_to_add;
            $src_time_stamp = filemtime($src);

            $prev_filestamp = $this->cache->set_cache_data($img_file_name,$src_time_stamp,"image_timestamps");

            $counter++;
            $images_imported[] = basename($image_to_add);

            if ($counter==1){

                $p->addImageToMediaGallery($image_to_add, array('image', 'small_image', 'thumbnail'), false, false); // Add Image 3

            } else {
                $p->addImageToMediaGallery($image_to_add, [], false, false); // Add Image 3
            }
        }


        if (count($images_imported)>0){
            $this->cache->set_cache_data($sku,false,"image_stores_set");
            $this->cache->set_cache_data($sku, $images_imported,"products_images");
        }



        if ($counter>0){

            try {
                $p->save();
                $data['status']=true;
                $data['message']="Image/s added ($counter)!";
            } catch (\Exception $e) {
                return ["status"=>false,"message"=>"Could not update images!  ".$e->getMessage()];
            }

        } else if($delete_counter > 0){
            try {
                $p->save();
                $data['status']=true;
                $data['message']="Image/s added ($counter)!";
            } catch (\Exception $e) {
                return ["status"=>false,"message"=>"Could not update images!  ".$e->getMessage()];
            }
        } else {
            $data = ["status"=>true,"message"=>"No chagnes so no update!"];
        }

        return $data;
    }

}
