<?php

namespace DS\Importer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Controller\ResultFactory;

class Data extends AbstractHelper
{

    public $force = false;
    private $image_files = null;
    private $ttl_24h = 3600 * 24;

    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);

        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        $this->store = $this->_objectManager->create('DS\Importer\Helper\Store');
        $this->products= $this->_objectManager->create('DS\Importer\Helper\Products');
        $this->_storeManager = $this->_objectManager->create('\Magento\Store\Model\StoreManagerInterface');

    }



    private function product_is_changed($product){

        $sku = $product["sku"];
        $prod_last_update=$this->cache->get_cache_data($product["sku"],"last_update_products");

        if (!$prod_last_update){
            return ["sku"=>$sku,"reason"=>"There is no last update cache!"];
        }

        $string_product = json_encode($product["original_data"]);
        $string_product_cache = json_encode($prod_last_update["original_data"]);
        if ($string_product!=$string_product_cache){
            return ["sku"=>$sku,"reason"=>"Some attribute differs from last update!"];
        }


        $images_imported = $this->products->get_magento_images_list($product["sku"]);
        $images_existing = $this->products->get_image_list($product["sku"]);


        if (count($images_imported)==count($images_existing)) {
            // as the item count is the same
            // we have to test if the time tamp of images has not been changed
            if (count($images_existing)>0){
                $changed=false;
                foreach($images_existing as $image){
                    $img_file_name = basename($image);
                    $src = $this->store->get_image_import_dir()."/".$img_file_name;
                    $src_time_stamp = filemtime($src);
                    $cache_time_stamp = $this->store->get_cache_data(basename($this->helper->get_image_timestamp_dir())."/".basename($src));
                    if ($src_time_stamp!=$cache_time_stamp){
                        return ["sku"=>$sku,"reason"=>"Image time stamp differ!"];
                    }
                }
            }
        } else {
            return ["sku"=>$sku,"reason"=>"Image count differ! M:".count($images_imported)." I:".count($images_existing)];
        }

        return false;
    }


    public function get_files_from_dir($dir,$path){
        $files_to_return=[];
        $files = scandir($dir);
        foreach($files as $file){
            if ($file=="." || $file==".."){
                continue;
            }

            if (is_dir($path."/".$file)){
                $files_to_return=array_merge($files_to_return,$this->get_files_from_dir($path."/".$file,$path."/".$file));
            } else {
                $files_to_return[$file] = $path."/".$file;
            }
        }
        return $files_to_return;
    }


    public function get_possible_extensions(){
        $posible_extensions = [".jpg",".jpeg",".JPG",".png"];
        return $posible_extensions;
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
        $posible_extensions = $this->get_possible_extensions();

        if (!$this->image_files){
            $image_dir = $this->get_image_destination_dir();
            $this->image_files = $this->get_files_from_dir($image_dir,$image_dir);
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
        $barcode_images = $this->cache->get_cache_data($sku,"images_with_barcode");
        if (!$barcode_images){
            $barcode_images=[];
        }
        $img_list = array_unique(array_merge($img_list,
                                $this->get_image_list_from_filesystem($sku,"/",":"),
                                $this->get_image_list_from_filesystem(strtolower($sku),"/",":"),
                                $this->get_image_list_from_filesystem($sku),
                                $barcode_images
                                ));
        $img_list_to_return=[];

        //removes dublicate entries
        foreach($img_list as $img){
            if (!in_array($img, $img_list_to_return)){
                $img_list_to_return[] = $img;
            }

        }
        return $img_list_to_return;
    }




    /*
     *
     * methods related to product
     *
     *
     */




    public function get_magento_categories($type,$sex)
    {
        $all_cats = $this->get_all_magento_categories();
        $cats = $all_cats["cats"];
        if (isset($cats[$type]) && isset($cats[$type][$sex])){
            return $cats[$type][$sex];
        } else {
            return $this->get_root_cat();
        }
    }

    function get_attribute_code($key){
        switch($key){
            case "ID":
                return false;
                break;
            case "probeID":
                return false;
                break;
            case "colorID":
                return "material_colors";
                break;
            case "stoneColorID":
                return "stone_colors";
                break;
            default:
                    return $key;
                break;
        }
    }


    function get_attribute_ids($attr_code,$ids){
        $data_to_return = [];
        if (!is_array($ids)){
            $ids = [$ids];
        }

        foreach($ids as $id){
            if (!is_array($id)){
                $magento_id = $this->cache->get_cache_data($id,$attr_code);
                if ($magento_id){
                    $data_to_return[] = $magento_id;
                } else {
                    //print("1 something went wrong $id $attr_code");
                    //die();
                }
            } else {

                foreach($id as $k=> $v){
                    if ($k=="ID"){
                        //print("$k $v <br/>");
                        $magento_id = $this->cache->get_cache_data($v,$attr_code);
                        if ($magento_id){
                            $data_to_return[$attr_code][] = $magento_id;
                        }
                    }

                    if ($a_code = $this->get_attribute_code($k)){

                        $magento_id = $this->cache->get_cache_data($v,$a_code);
                        if ($magento_id){
                            $data_to_return[$a_code][] = $magento_id;
                        } else {
                            //print("2 something went wrong $v $a_code");
                            //die();
                        }


                    }

                }
            }


        }
        return $data_to_return;
    }


    public function get_product_data($sku)
    {
        $data = $this->cache->get_cache_data($sku,"products");

        if(!$data){

            if (!$this->product_data_from_gapi){
                $this->product_data_from_gapi = $this->gapi->get_all_products();
            }
            
            if (isset($this->product_data_from_gapi[$sku])){
                $data=$this->product_data_from_gapi[$sku];
            } else {
                return [
                    "status"=>false,
                    "message"=>"No product file"
                ];
            }
            $data=$this->map_values($data);
        }
        
        //geting magento categories
        $data["categories"] = $this->get_magento_categories($data["type_id"],$data["sex"]);

        
        if (!is_array($data['categories'])){
            $data["categories"]= [$data["categories"]];
        }

        $type_name = $this->gapi->get_item_type($data["type_id"]);
        $brand_name = $this->gapi->get_brand($data["brand_id"]);
        $brand_name = $brand_name['name'];
        $type_name = $type_name['title'];
        $data["name"] = $type_name;
        $data["url"] = $data["name"]." ".$data["sku"];

        $data['sex']=$this->get_attribute_ids("sex",$data["sex"]);
        $data['materials']=$this->get_attribute_ids("materials",$data["materials"]);
        $data['stones']=$this->get_attribute_ids("stones",$data["stones"]);
        $data['brand_id']=$this->get_attribute_ids("brands",$data["brand_id"]);

        $data["images"]= $this->get_image_list($sku);
        return $data;

    }


    public function set_imported_images($sku,$data)
    {
        $this->set_cache_data($sku,$data,"products_images");
        return true;
    }


    function delete_dir_content($path_to_dir){
        //deletes all files in directory
        $files = glob($path_to_dir.'/*'); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file)){
            unlink($file); // delete file
          }
        }
    }


     public function list_categories($disable=false){

        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        }

        $stores = $this->get_magento_stores();
        $data = [];
        $data['status']=true;
        $data['message'] = [];

        //$stores["default"]=[];


        $categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
        $categories = $categoryFactory->create()
        ->addAttributeToSelect('*'); //categories from current store will be fetched


        $counter=0;
        foreach ($categories as $category){
            $counter++;
            $_cat = $this->_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());

            print("try to resave category: ".$_cat->getName()." ".$_cat->getId()." <br/>Sex:".$_cat->getData("g_sex")." <br/>TypeID".$_cat->getData("g_type_id")."  <br/><br/>");
            $text="";
            if ($disable){
                $text=" Disabled!";
                $_cat->setData("is_active",0);
            } else {
                $_cat->setData("is_active",1);
            }


            $data["message"][]=$_cat->getName()." saved [] $text";
        }

        return $data;
    }



    public function resave_categories($disable=false){

        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        }

        $stores = $this->get_magento_stores();
        $data = [];
        $data['status']=true;
        $data['message'] = [];

        //$stores["default"]=[];


        foreach($stores as $store_key => $store){

            print("<pre>");
            print_r($stores);
            print("</pre>");

            $categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
            if ($store_key=="default"){
                continue;
                //$categories = $categoryFactory->create()
                //    ->addAttributeToSelect('*'); //categories from current store will be fetched
            } else {
                $categories = $categoryFactory->create()
                    ->addAttributeToSelect('*')
                    ->setStore($store["storeId"]); //categories from current store will be fetched
            }


            $counter=0;
            foreach ($categories as $category){
                $counter++;
                $_cat = $this->_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
                if ($_cat->getId()==1 || $_cat->getId()==2){ continue; }
                print("try to resave category: ".$_cat->getName()." ".$_cat->getId()." ".$store["storeId"]."  ".$_cat->getUrlKey()." <br/>");
                $text="";
                if ($disable){
                    $text=" Disabled!";
                    $_cat->setData("is_active",0);
                } else {
                    $_cat->setData("is_active",1);
                }
                $_cat->setData("url_key",$_cat->getName()." ".$store_key." ".$_cat->getId());
                $_cat->save();
                $data["message"][]=$_cat->getName()." saved [$store_key] $text";
            }
        }
        return $data;
    }


    public function get_base_url(){
        return $this->_storeManager->getStore()->getBaseUrl();
    }


    public function clear_cache(){

        try {
            $this->_cacheTypeList = $this->_objectManager->create('\Magento\Framework\App\Cache\TypeListInterface');
            $this->_cacheFrontendPool = $this->_objectManager->create('\Magento\Framework\App\Cache\Frontend\Pool');

            $types = array('config','layout','block_html','collections','reflection','db_ddl','eav','config_integration','config_integration_api','full_page','translate','config_webservice');

            foreach ($types as $type) {
                $this->_cacheTypeList->cleanType($type);
            }
            foreach ($this->_cacheFrontendPool as $cacheFrontend) {
                $cacheFrontend->getBackend()->clean();
            }


            $this->_indexerFactory = $this->_objectManager->create('\Magento\Indexer\Model\IndexerFactory');
            $this->_indexerCollectionFactory = $this->_objectManager->create('\Magento\Indexer\Model\Indexer\CollectionFactory');

            $indexerCollection = $this->_indexerCollectionFactory->create();
            $ids = $indexerCollection->getAllIds();
            foreach ($ids as $id) {
                $idx = $this->_indexerFactory->create()->load($id);
                $idx->reindexAll($id); // this reindexes all
                //$idx->reindexRow($id); // or you can use reindexRow according to your need
            }
        } catch (\Exception $e) {

        }
    }


    public function get_store_phone(){

        $scopeConfig = $this->_objectManager->create('\Magento\Framework\App\Config\ScopeConfigInterface');
        $storeManager = $this->_objectManager->create('\Magento\Store\Model\StoreManagerInterface');

        $phone = $scopeConfig->getValue('general/store_information/phone', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeManager->getStore()->getStoreId());
        return " ".$phone;
    }

}