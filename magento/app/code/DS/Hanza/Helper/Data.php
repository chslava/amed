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
    private function get_root_cat(){
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
        return $this->get_absolute_media_path()."../../../amedical/shop/pictures/items/big/";
    }


    public function get_cache_dir(){
        $cache_dir = $this->get_absolute_media_path()."hanza_cache";
        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0755,true);
        }
        return $cache_dir;
    }


    private function get_import_dir(){
        return $this->get_absolute_media_path()."old_shop_data";
    }


    public function get_image_import_dir(){
        return "/home/dig_hanza/dig_hanza/Bildes";
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



    private function get_value_maping($type){

        switch($type){

            case "items.csv":
                return [
                    0=>"sku",
                    6=>"title",
                    21=>"url",
                    26=>"name",
                    31=>"description",
                    36=>"price",
                    37=>"sale",
                    38=>"sale_price",
                    39=>"new",
                    4=>"image",
                ];
                break;
            case "INVc.txt":
                return [
                    0=>"sku",
                    1=>"qty_type",
                    2=>"material",
                    3=>"volume",
                    4=>"width",
                    5=>"height",
                    6=>"thickness",
                    7=>"length",
                    8=>"diameter",
                    9=>"thickness_microns",
                    10=>"weight",
                    11=>"qty_in_package",
                    12=>"qty_in_box",
                    13=>"color",
                    14=>"bar_code",
                    15=>"link_to_image",
                    16=>"class_lvl_1",
                    17=>"class_lvl_2",
                    18=>"class_lvl_3",
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

        if ($stores=$this->get_cache_data(__FUNCTION__)){
            return $stores;
        }

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

    
    private function get_categoties_linked_to_hanza(){
        /*
         * function gets all categories from root category and rerranges them by the hanza id
         * one hanza cat can be linked to several categories
         */
        $cats_to_return = [];
        if ($cats_to_return=$this->get_cache_data(__FUNCTION__)){
            return $cats_to_return;
        }
        
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        }
        
        $categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
            $categories = $categoryFactory->create()                              
                ->addAttributeToSelect('*');
                //->setStore($store["storeId"]); //categories from current store will be fetched
            
        foreach ($categories as $category){
            if (strlen($category->getData("hanza_category"))==0){
                continue;
            }
            $cats_to_return[$category->getId()] = $this->get_hanza_ids_for_magento_cat($category->getId());
        }

        $this->set_cache_data(__FUNCTION__,$cats_to_return);

        return $cats_to_return;
    }


    public function get_magento_categories($data){
        /*
         *
         * This function cobines the cat ids, to create unique id, that used in magento
         * To link categories, thats needed cause hanza can have second level categories id several times
         * (the first level differs)
         *
         *
         */
        
        return [$this->get_root_cat()];

        //values comes in as comma seperated
        $lvl1 = $data['class_lvl_1'];
        $lvl1 = explode(",",$lvl1);
        $lvl2 = $data['class_lvl_2'];
        $lvl2 = explode(",",$lvl2);
        $lvl3 = $data['class_lvl_3'];
        $lvl3 = explode(",",$lvl3);

        $all_ids = array();
        //lopping tough first level
        foreach($lvl1 as $l1){

            $all_ids[] = $l1;
            //attachig firs level to second level
            foreach($lvl2 as $l2){
                if (strlen(trim($l2))>0) {
                    $all_ids[] = $l1."-".$l2;
                }
            }

            //attachig firs level to third level
            foreach($lvl3 as $l3){
                if (strlen(trim($l3))>0){
                    $all_ids[] = $l1."-".$l3;
                }
            }
        }

        $categories = [];
        $magento_cats =$this->get_categoties_linked_to_hanza();
        foreach($magento_cats as $magento_cat_id => $m_cat_arr){
            foreach($all_ids as $hanza_cat_id){
                if (in_array($hanza_cat_id,$m_cat_arr)){
                    $categories[] = $magento_cat_id;
                }
            }
        }
        $categories = array_unique($categories);
        return $categories;
        
    }





    /*
     *
     *
     * Methods related to attributes
     *
     *
     */

    private function get_all_material_codes(){

        $data_to_return = $this->get_cache_data(__FUNCTION__);
        $lang_list = $this->get_languages();
        if ($data_to_return){
            return $data_to_return;
        } else {
            $src_file = $this->get_import_filename("material.txt");

            if (file_exists($src_file)) {
                if (($handle = fopen($src_file, "r")) !== FALSE) {
                    $material_data = [];
                    $lang_data = [];
                    $material_id="";
                    while (($data = fgetcsv($handle, 0, "\t",chr(8))) !== FALSE) {
                        if(strlen($data[0])==3 || in_array($data[0],$lang_list)){

                            if (in_array($data[0],$lang_list)){
                                $lang_data[$this->get_lang_code($data[0])] = $data[1];

                            } else {
                                if ($material_id!=""){

                                    $material_data["language"] = $lang_data;
                                    $data_to_return[$material_id] = $material_data;
                                }
                                $material_data = [];
                                $material_data = $data;

                                $material_id = $data[0];
                            }

                        } else {
                            //skipping
                            continue;
                        }
                    }
                    $data_to_return[$material_id] = $material_data;

                }
            }
        }

        $this->set_cache_data(__FUNCTION__,$data_to_return);
        return $data_to_return;

    }


    private function decode_material($material_code){

        $codes = $this->get_all_material_codes();
        if (isset($codes[$material_code])){
            return $codes[$material_code];
        }
        return false;

    }



    private function get_real_item_price($data){

        $data["qty_in_package"]=str_replace(" pāri","",$data["qty_in_package"]);
        $data["qty_in_box"]=str_replace(" pāri","",$data["qty_in_box"]);
        //default settings arr that sold all the possible ways
        $sold_by_item=1;
        $sold_by_package=1;
        $sold_by_box=1;

        //if one item price is less than 1 cent then its not sold by one item
        if (
            !is_numeric($data['price']) ||
            $data['price']<0.01
        ){
            $sold_by_item=0;
        }

        //if there is no qty in package or there is no price then also not by package
        if (
            strlen(trim($data["qty_in_package"]))==0 ||
            !is_numeric($data["qty_in_package"]) ||
            !is_numeric($data['price_package']) ||
            $data['price_package']<0.01
        ){
            $sold_by_package=0;
        }

        //if there is no qty in package or there is no price then also not by box
        if (
            strlen(trim($data["qty_in_box"]))==0 ||
            !is_numeric($data["qty_in_box"]) ||
            !is_numeric($data['price_box']) && $data['price_box']<0.01
        ){
            $sold_by_box=0;
        }

        $data['price_item']=$data['price'];

        $data["sold_by_item"]=$sold_by_item;
        $data["sold_by_package"]=$sold_by_package;
        $data["sold_by_box"]=$sold_by_box;

        return $data;
    }



    private function get_all_color_codes(){

        $data_to_return = $this->get_cache_data(__FUNCTION__);
        $lang_list = $this->get_languages();
        if ($data_to_return){
            return $data_to_return;
        } else {
            $src_file = $this->get_import_filename("colours.txt");

            if (file_exists($src_file)) {
                if (($handle = fopen($src_file, "r")) !== FALSE) {
                    $color_data = [];
                    $lang_data = [];
                    $color_id="";
                    while (($data = fgetcsv($handle, 0, "\t",chr(8))) !== FALSE) {
                        if(strlen($data[0])==3 || in_array($data[0],$lang_list)){

                            if (in_array($data[0],$lang_list)){
                                $lang_data[$this->get_lang_code($data[0])] = $data[1];

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

        $this->set_cache_data(__FUNCTION__,$data_to_return);
        return $data_to_return;

    }



    public function decode_color($color_code){

        
        $color_code = trim($color_code);
        $color_code = strtoupper($color_code);
        
        //Fixing issue with two colors, particaly same colors
        //K12 = "dzeltena oran\u017ea",
        //K14 = "dzeltena, oran\u017ea",
        if ($color_code == "K12"){
            $color_code ="K14";
        }
        $codes = $this->get_all_color_codes();
        

        if (isset($codes[$color_code])){
            return $codes[$color_code];
        }
        return false;

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



    public function validate_product($data,$test_images = false){

        print(__FUNCTION__);
        print(__LINE__);
        die();
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





    public function get_product_data($prod_id)
    {
        $file = $this->get_cache_file($prod_id,"products");
        
        $data = json_decode(file_get_contents($file),true);

        //upercase
        $this->rename_files_names_to_uppercase();

        $data["images"]= $this->get_image_list($prod_id);

        $data['categories'] = $this->get_magento_categories($data);

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
        if (file_exists($file_to_split)) {
            if (($handle = fopen($file_to_split, "r")) !== FALSE) {
                $product =[];
                while (($data = fgetcsv($handle, null,';')) !== FALSE) {

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

                    $current_sku = $data[0];

                    if (is_array($value_mapping)){
                        foreach($value_mapping as $key => $value){
                            $product[$value]=$data[$key];
                        }
                        $product["original_data"]=$data;
                    } else {
                        $product =$data;
                        $product["original_data"]=$data;
                    }

                    $language_data = [];

                   
                }
            }
        }
        return $data_to_return;

    }


    function get_invalid_products($only_prices=false, $reverse=false){

        $data_to_return= [];
        //loop trough products


        if (!$reverse){
            $data_to_return["summary"]=[
                "error"=>"Summary of the test",
                "value"=>"",
                "products"=>0,
                "invalid_products"=>0
            ];
        }

        $file_to_split = $this->get_import_filename("products");
        if (file_exists($file_to_split)) {
            if (($handle = fopen($file_to_split, "r")) !== FALSE) {
                $product = [];
                while (($data = fgetcsv($handle, 0, "\t",chr(8))) !== FALSE) {

                    if (count($data) < 2) {
                        continue;
                    }



                    if ($data[0] != "language") {

                        $validation_result=false;
                        //products counter
                        if (!$reverse){
                            $data_to_return["summary"]["products"]++;
                        }


                        $sku =$data[0];

                        $prices_file = $this->get_cache_file($sku.".IV.","prices");
                        $prices_file_package = $this->get_cache_file($sku.".IV2.","prices");
                        $prices_file_box = $this->get_cache_file($sku.".IV3.","prices");
                        if (!file_exists($prices_file) && !file_exists($prices_file_package) && !file_exists($prices_file_box)){
                            if ($reverse){
                                //we need to add only good ones in this case
                                continue;
                            }
                            $data_to_return[$sku]=[
                                "error"=>"No price file",
                                "value"=>$prices_file." - ".$prices_file_package." - ".$prices_file_box
                            ];


                        } else {
                            $data_from_file = json_decode(file_get_contents($prices_file),true);
                            $price = $data_from_file['price'];
                            if (!is_numeric($price)){
                                if ($reverse){
                                    //we need to add only good ones in this case
                                    continue;
                                }
                                $data_to_return[$sku]=[
                                    "error"=>"Price is not numeric",
                                    "value"=>$price
                                ];
                            } else {

                            }


                        }
                        $data_from_file=false;
                        if (!$only_prices){
                            $product_file = $this->get_cache_file($sku,"products");
                            if(file_exists($product_file)){

                                $data_from_file=json_decode(file_get_contents($product_file),true);
                                $validation_result = $this->validate_product($data_from_file,true);
                                if (!$validation_result['status']){
                                    if ($reverse){
                                        //we need to add only good ones in this case
                                        continue;
                                    }
                                    $data_to_return[$sku] = [
                                        "error"=>"Invalid product : ".$validation_result["message"],
                                        "value"=>$validation_result["message"]
                                    ];
                                }

                            } else {
                                if ($reverse){
                                    //we need to add only good ones in this case
                                    continue;
                                }
                                $data_to_return[$sku] = [

                                    "error"=>"No product file, pribably should run the sync script first to chache missing products!",
                                    "value"=>$product_file
                                ];
                            }

                        }

                        if ($reverse && $data_from_file){
                            //we need to add only good ones in this case
                            $data_to_return[$sku]=[
                                "error"=>"No error",
                                "value"=>$data_from_file
                            ];
                        }





                        if (isset($data_to_return[$sku]) && !$reverse){
                            $data_to_return["summary"]["invalid_products"]++;
                            //products error type counter
                            if (isset($data_to_return["summary"][$data_to_return[$sku]["error"]])){
                                $data_to_return["summary"][$data_to_return[$sku]["error"]]++;
                            } else {
                                $data_to_return["summary"][$data_to_return[$sku]["error"]]=1;
                            }
                        }

                    }
                }
            }
        }
        if (!$reverse){
            $data_to_return["summary"]["value"] ="Error counters ";
            foreach($data_to_return["summary"] as $key => $value){
                $data_to_return["summary"]["value"].=" [".$key.":".$value."] ";
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



    function rename_files_names_to_uppercase($force = false, $verbose=false){

        $product_skus=[];
        $bad_skus=[];

        $file_names_renamed = $this->get_cache_data("files_renamed");
        if (!$file_names_renamed || $force){
            $this->set_cache_data("files_renamed",true);
        } else {
            return ["status"=>false, "message"=>"No files updated"];
        }


        $rename_counter = 0;

        //renames all to the uppercase
        $path = $this->get_image_import_dir();
        $path_dst = $this->get_image_destination_dir();
        $counter=0;
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ('.' === $file) continue;
                if ('..' === $file) continue;

                $counter++;

                $file_name = basename($file);



                if ($verbose){
                    print("<br/>[$counter] source: $file $file_name <br/>");
                }

                if (substr_count($file_name,".jpg")>0){
                    $file_name = str_replace(".jpg","",$file_name);
                    $file_name_uc = strtoupper($file_name);

                    $src = $path."/".$file_name.".jpg";
                    $dst = $path_dst."/".$file_name_uc.".jpg";

                    $id = basename($dst);
                    $id = str_replace(".jpg","",$id);

                    $prod_data=$this->get_product_data($id);
                    if (isset($prod_data["sku"])){
                        $product_skus[] = $id;
                        if ($verbose){
                            print("Product exists: $id <br/>");
                        }
                    } else {
                        $problem  = $prod_data["message"];
                        $tmp_id  =explode("_",$id);
                        $tmp_id = end($tmp_id);
                        $tmp_id = str_replace("_".$tmp_id,"",$id);
                        $prod_data=$this->get_product_data($tmp_id);

                        if (in_array($tmp_id,$product_skus) || isset($prod_data["sku"])){
                         if ($verbose){
                             print("Product exists: $tmp_id <br/>");
                         }
                        }else {
                            $bad_skus[$id]=$problem." / ".$prod_data["message"];
                            if ($verbose){
                                print("<b style='color:red'>Product does not exist</b>: $id ($tmp_id) <br/>");
                            }
                        }

                    }



                    if ($verbose){
                        print("destination: $dst <br/>");
                    }
                    
                    $time_stamp = $this->get_cache_data(basename($this->get_image_timestamp_dir())."/".basename($src));
                    if (!file_exists($dst) || $time_stamp!=filemtime($src)){
                        if (copy($src,$dst)){

                            if ($verbose){
                                print("[$counter] Copied: $src -> $dst <br/>");
                            }

                        }else {
                            if ($verbose){
                                print("<b style=\"color:red\">[$counter] Failed</b>: $src -> $dst <br/>");
                            }
                        }
                    } else {
                        if ($verbose){
                            print("<b>[$counter] Exists</b>: $src -> $dst <br/>");
                        }
                    }


                }


            }
            closedir($handle);
        }
        return ["good"=>$product_skus,"bad"=>$bad_skus];
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
