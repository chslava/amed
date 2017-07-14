<?php

namespace DS\Hanza\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    
    /*
     *
     * Some methods for returning constats or common settings used in several places
     *
     */
    public function get_root_cat(){
        //hardcoded at the moment
        //TODO make it read from settings
        return 2;
    }
    
    
    public function get_homepage_cat(){
        //TODO make it read from settings
        return 157;
    }


    public function get_attribute_set(){
        //TODO make it read from settings
        return 4;
    }


    public function get_absolute_media_path() {
        /*    /** @var \Magento\Framework\App\ObjectManager $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\Filesystem $filesystem */
        $filesystem = $om->get('Magento\Framework\Filesystem');
        /** @var \Magento\Framework\Filesystem\Directory\ReadInterface|\Magento\Framework\Filesystem\Directory\Read $reader */
        $reader = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        return $reader->getAbsolutePath();
    }
    
    
    public function get_absolute_image_path() {
        return $this->get_absolute_media_path()."old_shop_data/pictures/items/big";
    }


    public function get_cache_dir(){
        $cache_dir = $this->get_absolute_media_path()."hanza_cache";
        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0755,true);
        }
        return $cache_dir;
    }


    public function get_import_dir(){

        return $this->get_absolute_media_path()."old_shop_data";
    }


    public function get_image_import_dir(){
        return $this->get_absolute_image_path();
    }

    
    function get_magento_product_img_cache_dir(){
        $cache_dir = $this->get_absolute_media_path()."catalog/product/cache";
        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0755,true);
        }
        return $cache_dir;
    }

    public function get_image_destination_dir(){
        $img_dst_dir= $this->get_cache_dir()."/images";
        if (!file_exists($img_dst_dir)){
            mkdir($img_dst_dir,0777,true);
        }
        return $img_dst_dir;
    }
    
    
    public function get_image_timestamp_dir(){
        $img_dst_dir= $this->get_cache_dir()."/images_timestamps";
        if (!file_exists($img_dst_dir)){
            mkdir($img_dst_dir,0777,true);
        }
        return $img_dst_dir;
    }


    private function get_cache_file($sku, $prefix){
        //setting and checking the directory
        $sku = str_replace("/","_",$sku);
        $dir = $this->get_cache_dir()."/".$prefix."";
        if (!file_exists($dir)){
            mkdir($dir,0777);
        }
        return $dir."/$sku-$prefix.php";

    }



    private function get_languages(){
        return [
            "ILAT",
            "ILIT",
            "IRUS",
            "IENG",
            "IALAT",
            "IALIT",
            "IARUS",
            "IAENG",
        ];
    }


    private function get_import_filename($file){

        switch($file) {
            case 'prices':
                print("prices called");
                die();
                return $this->get_import_dir()."/prices.txt";
                break;

            case 'products':
                return $this->get_import_dir()."/items.csv";
                break;

            default:
                return $this->get_import_dir()."/$file";
                break;
        }

    }



    public function get_value_maping($type){

        switch($type){
            case "persons":
                
                
                
                break;
            case "branches.csv":
                /*
                id 	int(10) unsigned 	NO 	PRI 	NULL	auto_increment
                name_ee 	varchar(255) 	YES 		NULL	
                name_lv 	varchar(255) 	YES 		NULL	
                name_lt 	varchar(255) 	YES 		NULL	
                name_ru 	varchar(255) 	YES 		NULL	
                name_en 	varchar(255) 	YES 		NULL	
                */
                 return [
                        0=>"id",
                        2=>"name_lv",
                        4=>"name_ru",
                        5=>"name_en",
                        ];
                break;
            
            
             case "branches_items.csv":
                /*
                id 	int(10) unsigned 	NO 	PRI 	NULL	auto_increment
                branche_id 	int(11) 	YES 		NULL	
                item_id 	int(11) 	YES 		NULL	
                place 	int(11) 	YES 		NULL	
                group_type 	int(11) 	YES 		NULL	
                category_id 	int(11) 	YES 		NULL	
                */
                 return [
                        0=>"id",
                        1=>"branche_id",
                        2=>"item_id",
                        3=>"place",
                        4=>"group_type",
                        5=>"category_id"
                        
                        ];
                break;
            case "categories.csv":
                return [
                        0=>"id",
                        1=>"parent_id",
                        5=>"title_lv",
                        7=>"title_ru",
                        8=>"title_en",
                        10=>"description_lv",
                        12=>"description_ru",
                        13=>"description_en",
                        
                        30=>"link_lv",
                        32=>"link_ru",
                        33=>"link_en",
                        
                        40=>"text_lv",
                        42=>"text_ru",
                        43=>"text_en",
                        2=>"status",
                        43=>"person",
                        25=>"name_lv",
                        27=>"name_ru",
                        28=>"name_en"
                        
                        ];
                break;
            case "items.csv":
                return [
                    0=>"sku",
                    1=>"parent_id",
                    44=>"branch",
                    6=>"title",
                    21=>"url",
                    26=>"name",
                    31=>"description",
                    36=>"price",
                    37=>"sale",
                    38=>"sale_price",
                    39=>"new",
                    4=>"image",
                    3=>"status",
                    35=>"code",
                    45=>"rate"
                ];
                break;
            case "prices":
                return [
                    0=>"hvz",
                    1=>"sku",
                    2=>"price_group_id",
                    4=>"price",
                ];
                break;
            default:
                print(__FUNCTiON__);
                print("-".__FILE__);
                print($type);
                die();
                return null;
                break;
        }
    }


    private function get_lang_code($csv_langcode){
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


   


    function get_magento_stores(){

        $stores=[];

        //if ($stores=$this->get_cache_data(__FUNCTION__)){
        //    return $stores;
        //}

        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager =  $om->get('Magento\Store\Model\StoreManagerInterface');
        $websites = $storeManager->getWebsites();
        foreach($websites as $website) {
            foreach($website->getStores() as $store){
                $wedsiteId = $website->getId();
                $storeObj = $storeManager->getStore($store);
                $storeId = $storeObj->getId();
                $storeCode= $storeObj->getCode();
                $url = $storeObj->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
                $stores[$storeCode]["websiteId"] =$wedsiteId;
                $stores[$storeCode]["storeId"] =$storeId;
            }
        }

        $this->set_cache_data(__FUNCTION__,$stores);
        return $stores;
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

    //setting data
    public function set_cache_data($id, $data){
        $cache_file = $this->get_cache_dir()."/".$id.".json.php";
        file_put_contents($cache_file,json_encode($data));
    }




    /*
     *
     *
     * Methods related to categories
     *
     *
     */

    private function get_hanza_ids_for_magento_cat($subcat_id){

        /*
         *
         * Function returns category
         *
         */

        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_subcat = $this->_objectManager->create('Magento\Catalog\Model\Category')->load($subcat_id);
        $_hanza_cats = $_subcat->getData("hanza_category");
        if (substr_count($_hanza_cats,",")){
            $_hanza_cats = explode(",",$_hanza_cats);
        } else {
            $_hanza_cats = [$_hanza_cats];
        }
        return $_hanza_cats;
    }
    
    
    
    public function update_category($cat_id, $name,$description, $parent_id=null,$csv_category){
        
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        }

        $category = $this->_objectManager->get('\Magento\Catalog\Model\CategoryFactory')->create()->load($cat_id);
        $category->setName($name);
        $category->setCustomAttributes(['description' => $description,"hanza_category"=>$csv_category['id']]);
        if ($parent_id){
            $category->setParentId($parent_id); // 1: root category.    
        }
        $category->save();
        
        //$all_shops = $this->get_magento_stores(); 
        //foreach($all_shops as $code => $store){            
        //    $this->update_category_langs($store["storeId"], $csv_category["title_".$code],$csv_category["description_".$code],$cat_id);
        //}
    }
    
    
    
    public function update_category_langs($store_id, $title, $description, $cat_id){
        
        
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        }
        $category = $this->_objectManager->get('\Magento\Catalog\Model\CategoryFactory')->create()->load($cat_id);
        $category->setStoreId($store_id);
        $category->setName($title);
        $category->setDescriptin($description);
        $category->save();
    }
    
    
    public function get_image_list($prod_id){
        $image_dir = $this->get_image_destination_dir();
        $img_list = [];
        //default
        $img_name = $image_dir."/".strtoupper(str_replace("/","_",$prod_id)).".jpg";
        if (file_exists($img_name)){
            $img_list[]=$img_name;
        }
        for($i=1; $i< 11; $i++){
            $img_name = $image_dir."/".strtoupper(str_replace("/","_",$prod_id))."_".$i.".jpg";
            if (file_exists($img_name)){
                $img_list[]=$img_name;
            }
        }
        return $img_list;
    }



    /*
     *
     * methods related to product
     *
     *
     */

    public function get_product_data($sku)
    {
        $file = $this->get_cache_file(urlencode(trim($sku)),"products");
        $data = json_decode(file_get_contents($file),true);
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



    private function split_file_into_rows($field_number, $file_to_split, $file_prefix, $value_mapping="", $return_field="", $force=false){

        $return_field_original = $field_number;

        $cache_dir= $this->get_cache_dir()."/".$file_prefix;

        if (!$value_mapping){
            $value_mapping = $this->get_value_maping(basename($file_to_split));
        }

        if ($value_mapping){
            $field_number = $value_mapping[$field_number];
        }

        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0777,true);
        }
        if (!file_exists($file_to_split)){
            print("file does not exist: ".$file_to_split);
            return false;
        }
        $file_time_stamp = filemtime($file_to_split);
        $prev_time_stamp_file = $cache_dir. "/".basename($file_to_split).".timestamp";


        if (!file_exists($prev_time_stamp_file) || $force){
            if ($force && file_exists($prev_time_stamp_file)){
                unlink($prev_time_stamp_file);
            }
            file_put_contents($prev_time_stamp_file,$file_time_stamp);
        } else {
            $prev_time_stamp = file_get_contents($prev_time_stamp_file);
            if ($file_time_stamp == $prev_time_stamp and ((time() - $prev_time_stamp) > 60*60*24*7)){
                return false;
            }
        }

        $line = null;
        $data_to_return =[];
        // reading import file
        $current_sku="";
        $language_data=[];
        if (file_exists($file_to_split)) {
            if (($handle = fopen($file_to_split, "r")) !== FALSE) {
                while (($data = fgetcsv($handle,  0, "\t",chr(8))) !== FALSE) {

                    $product =[];
                    if ($data[0]!="language"){

                        if ($current_sku!="" && !empty($product)){
                            $prod_cache_file = $this->get_cache_file($product[$field_number],$file_prefix);
                            //no field mapping

                            file_put_contents($prod_cache_file,json_encode($product));
                        }
                        $current_sku = $data[$return_field_original];

                        if (is_array($value_mapping)){
                            foreach($value_mapping as $key => $value){
                                $product[$value]=$data[$key];
                            }
                            $product["original_data"]=$data;
                        } else {
                            $product =$data;
                            $product["original_data"]=$data;
                        }
                        $product["language"]=$language_data;
                        $language_data = [];

                    } else {

                        //language
                        $language_data[] = $data;
                    }
                }

            }
        }
        return $data_to_return;

    }


    public function get_imported_images($sku)
    {
        $prod_cache_image_cache = $this->get_cache_file(str_replace("/","_",$sku),"products_images");
        if (file_exists($prod_cache_image_cache)){
            return json_decode(file_get_contents($prod_cache_image_cache),true);
        } else {
            //if there was no data then saving existing situation
            $product_id = $this->get_product_id_by_sku($sku);
            $images = $this->get_images($product_id);
            $this->set_imported_images($sku,$images);
            return $images;
        }
    }


    public function set_imported_images($sku,$data)
    {
        $prod_cache_image_cache = $this->get_cache_file(str_replace("/","_",$sku),"products_images");
        return file_put_contents($prod_cache_image_cache,json_encode($data));
    }



    private function product_is_changed($product,$field_number,$file_prefix){

        $prod_cache_file = $this->get_cache_file(str_replace("/","_",$product[$field_number]),$file_prefix);
        $changed=true;

        //checking if there is cache file
        if (file_exists($prod_cache_file)) {
            $changed=false;

            $product_from_file = json_decode(file_get_contents($prod_cache_file),true);
            $images_imported = $this->get_imported_images($product["sku"]);
            
            $images_existing = $this->get_image_list($product["sku"]);
            
            if (count($images_imported)==count($images_existing)) {
                // as the item count is the same
                // we have to test if the time tamp of images has not been changed
                if (count($images_existing)>0){
                    $changed=false;    
                    foreach($images_existing as $image){
                        $img_file_name = basename($image);
                        $src = $this->get_image_import_dir()."/".$img_file_name;
                        $src_time_stamp = filemtime($src);
                        $cache_time_stamp = $this->get_cache_data(basename($this->get_image_timestamp_dir())."/".basename($src));
                        if ($src_time_stamp!=$cache_time_stamp){
                            $changed=true;
                        }
                    }
                } else {
                    $changed=false;        
                }
            } else {
                $changed=true;
            }
                        
            if($changed){
                return $product[$field_number];
            }

            //if there is data we have to check the values
            foreach($product_from_file as $key => $item){
                switch($key){
                    default:
                        if ((!isset($product[$key])) || $product[$key]!=$item ){
                            $changed = true;
                        }
                        break;
                }
            }
        }


        if ($changed){
            file_put_contents($prod_cache_file,json_encode($product));
            return $product[$field_number];
        } else {
            return false;
        }

    }



    



    public function get_ids_for_update($force=false){
        
        //detele some chace files
        $this->set_cache_data("files_renamed",false);
        //$this->delete_dir_content($this->get_cache_dir()."/products_images"); 
        $this->delete_dir_content($this->get_image_destination_dir());
 
        $value_mapping=null;
        $return_field="sku";
        $file_to_split = $this->get_import_filename("products");
        $file_prefix="products";
        $field_number=0;

        $return_field_original = $field_number;

        $cache_dir= $this->get_cache_dir()."/".$file_prefix;

        if (!$value_mapping){
            $value_mapping = $this->get_value_maping(basename($file_to_split));
        }

        if ($value_mapping){
            $field_number = $value_mapping[$field_number];
        }

        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0777,true);
        }
        
        if (!file_exists($file_to_split)){
            print("file does not exist: ".$file_to_split);
            return false;
        }

        $line = null;
        $data_to_return =[];

        $current_sku="";
        $language_data=[];

        //reading file
        $first_row=true;
        if (file_exists($file_to_split)) {
            if (($handle = fopen($file_to_split, "r")) !== FALSE) {
                $product =[];
                while (($data = fgetcsv($handle, null,",")) !== FALSE) {
                   
                    if ($first_row){
                        $first_row=false;
                        continue;
                    }
                    if (count($data)<2){
                        continue;
                    }

                    if ($current_sku!="" && !empty($product)){

                        $changed = $this->product_is_changed($product,$field_number,$file_prefix);

                        if ($changed){
                            $data_to_return[] = $changed;
                        } else if ($force){
                            $data_to_return[] = $data[0];
                        }

                        //no field mapping
                        $current_sku="";
                        $product =[];

                    }

                    

                    if (is_array($value_mapping)){
                        foreach($value_mapping as $key => $value){
                            $product[$value]=$data[$key];
                        }
                        if (isset($product["code"]) && strlen(trim($product["code"]))>0){
                            $product["sku"] = urlencode(trim($product["code"]));
                        }
                        $product["original_data"]=$data;
                    } else {
                        $product =$data;
                        $product["original_data"]=$data;
                    }
                    $current_sku = $product["sku"];

                    $language_data = [];

                   
                }
            }
        }
        return $data_to_return;

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
        
        $stores = $this->get_magento_stores();
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
    
    
    public function get_images($prod_id){

        //return array of filenames of the product by product id
        // used mostly for comparing the exisitng images  and already imported images
        // to see if there is new files
        // comparing only count not the files
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
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
}
