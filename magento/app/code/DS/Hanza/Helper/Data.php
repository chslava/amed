<?php

namespace DS\Hanza\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    
    public $force = false;
    private $image_files = null;
    private $product_data_from_gapi = null;
    private $_objectManager = null;
    private $_storeManager = null;
    private $ttl_hour = 3600;
    
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);
        
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->cache = $this->_objectManager->create('DS\Hanza\Helper\Cache');
        $this->csv = $this->_objectManager->create('DS\Hanza\Helper\Csv');
        $this->store = $this->_objectManager->create('DS\Hanza\Helper\Store');
        $this->_storeManager = $this->_objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        
    }


    
    function get_magento_product_img_cache_dir(){
        $cache_dir = $this->store->get_absolute_media_path()."catalog/product/cache";
        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0755,true);
        }
        return $cache_dir;
    }

    public function get_image_destination_dir(){
        $img_dst_dir= $this->store->get_cache_dir()."/images";
        if (!file_exists($img_dst_dir)){
            mkdir($img_dst_dir,0777,true);
        }
        return $img_dst_dir;
    }



    public function get_import_filename($file){

        switch($file) {
            

            case 'products':
                return $this->store->get_import_dir()."/items.csv";
                break;

            default:
                return $this->store->get_import_dir()."/$file";
                break;
        }

    }


    public function get_lang_code($csv_langcode){
        if (substr($csv_langcode,0,2)=="IA"){
            $csv_langcode = str_replace("IA","",$csv_langcode);
        } else {
            $csv_langcode = str_replace("I","",$csv_langcode);
        }
        switch($csv_langcode){
            case "LAT":
                return "lv";
                break;
            case "RUS":
                return "ru";
                break;
            case "LIT": case "LT":
            return "lt";
            break;
            case "ENG":
                return "en";
                break;
            default:
                print($csv_langcode);
                die();
                break;
        }
    }


   


    


    /*
     *
     *  File caching functionality, that some some static data, should not be retrieved several times form
     * magento database
     *
     *
     */

    


    //geting data
    public function get_cache_data($id){
        $cache_file = $this->get_cache_dir()."/".$id.".json.php";
        if (file_exists($cache_file)){
            return json_decode(file_get_contents($cache_file),true);
        }
        return false;
    }


    public function get_product_data($sku)
    {
        $data = $this->cache->get_cache_data($sku,"products");
        return $data;

    }


    function get_product_ids(){
        $ids = [];
        if ($ids = $this->get_cache_data(__FUNCTION__)){
            return $ids;
        }
        $file_name = $this->get_import_filename("products");

        $ids = $this->split_file_into_rows(0,$file_name,"product.json",null,0,1);
        $this->set_cache_data(__FUNCTION__,$ids);
        return $ids;
    }

    
    public function get_imported_images($sku)
    {
        $c_img = $this->cache->get_cache_data($sku,"imported_images",24*3600);
        if ($c_img){
            return $c_img;
        }
        //if there was no data then saving existing situation
        $product_id = $this->get_product_id_by_sku($sku);
        $images = $this->get_magento_images_list($product_id);
        if (count($images)>0){
            $this->set_imported_images($sku,$images);    
        }
        return $images;
    }


    public function set_imported_images($sku,$data)
    {
        return $this->cache->set_cache_data($sku,$data,"imported_images");
    }



    public function delete_cached_files($img_filename_to_delete,$directory=false){
        
        if (!$directory){
            $directory = $this->get_magento_product_img_cache_dir();    
        }
        $files = glob($directory.'/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)){
                if (substr_count($file, $img_filename_to_delete)){
                    unlink ($file);
                }
            } else {
                $this->delete_cached_files($img_filename_to_delete,$file);
            }
        }
        //deletes all cahce files for particular image
    }
    
    function delete_dir_content($path_to_dir){
        //deletes all files in directory
        $files = glob($path_to_dir.'/*'); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
    }



    


    public function print_line_by_line($what){
        $src_file= $this->get_import_filename($what);
        if (($handle = fopen($src_file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, "\t",chr(8))) !== FALSE) {
                print(implode("[TAB]",$data)."<br/>");
            }
        }

    }

    
    private function print_r_nice($data){
        $text="<br/>";
        foreach($data as $key => $value){
            $text.="<b>$key</b>:".print_r($value,true)."<br/>";
        }
        return $text;
    }
    
    
    
    public function resave_categories($disable=false){
        /*
         * function gets all categories from root category and rerranges them by the hanza id
         * one hanza cat can be linked to several categories
         */
        
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        }
        
        $stores = $this->store->get_magento_stores();
        $data = [];
        $data['status']=true;
        $data['message'] = [];
        foreach($stores as $store_key => $store){
            
            $categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
            $categories = $categoryFactory->create()                              
                ->addAttributeToSelect('*')
                ->setStore($store["storeId"]); //categories from current store will be fetched
                
            $counter=0;
            foreach ($categories as $category){
                $counter++;
                if ($counter==1 || strlen($category->getData("hanza_category"))==0){
                    continue;
                }
                $_cat = $this->_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
                
                $text="";
                if ($disable){
                    $text=" Disabled!";
                    $_cat->setData("is_active",0);    
                } else {
                    $_cat->setData("is_active",1);    
                }
                $_cat->save();
                $data["message"][]=$_cat->getName()." saved [$store_key] $text";
            }
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
    
    
    public function get_current_store_data(){
        $_storeManager = $this->_objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $store_id = $_storeManager->getStore()->getId();
        $website_id = $_storeManager->getStore()->getWebsiteId();
        $store_code = $_storeManager->getStore()->getCode();
        $store_name = $_storeManager->getStore()->getName();
        return [
                "website_id"=>$website_id,
                "store_code"=>$store_code,
                "store_name"=>$store_name
                ];
    }
    
    public function get_current_store_code(){
        $store_data = $this->get_current_store_data();
        return $store_data["store_code"];
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
    
    
    public function get_store_id($code){
        $all_stores = $this->store->get_magento_stores();
        $i=0;
        $first_store_id=0;
        foreach($all_stores as $c => $store){
            $i++;
            if ($i==1){
                $first_store_id=$store['storeId'];
            }
            if ($c ==$code){
                return $store['storeId'];
            }
        }

        return $first_store_id;

    }


    public function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false) {
        //source: https://www.if-not-true-then-false.com/2010/php-mb_ucfirst-make-a-strings-first-character-uppercase-multibyte-function/
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
        if ($lower_str_end) {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        }
        else {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }
        $str = $first_letter . $str_end;
        return $str;
    }
}
