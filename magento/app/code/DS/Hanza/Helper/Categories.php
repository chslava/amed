<?php
namespace DS\Hanza\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;
class Categories extends AbstractHelper
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

    
    public function get_magento_product_img_cache_dir(){
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
                    3=>"status"
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

    
    public function add_category($name,$description, $parent_id=null,$csv_category){      
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        }

        $category = $this->_objectManager->get('\Magento\Catalog\Model\CategoryFactory')->create();
        $category->setName($name);
        //$category->setData("",$csv_category['id']);
        
        if ($parent_id){
            $category->setParentId($parent_id); // 1: root category.    
        } else {
            $category->setParentId($this->get_root_cat()); // 1: root category.
        }
        
        $category->setIsActive(true);
        $category->setCustomAttributes(['description' => $description,"hanza_category"=>$csv_category['id']]);
        
        try {
            $this->_objectManager->get('\Magento\Catalog\Api\CategoryRepositoryInterface')->save($category);
            return ["status"=>true,"message"=>"Category saved"];
        } catch (\Exception $e) {
            return ["status"=>true,"message"=>"Category NOT saved".$e->getMessage()];
        }
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
    
    
    public function get_all_categories()
    {
    
        $cats_to_return = [];
        //if ($cats_to_return=$this->get_cache_data(__FUNCTION__)){
        //    return $cats_to_return;
        //}
        
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        }
        
        $categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
            $categories = $categoryFactory->create()                              
                ->addAttributeToSelect('*');
            
        $cats_by_name = [];
        $cats_by_shop_id=[];
        
        foreach ($categories as $category){
            $cat_name=$category->getName();
            if (strlen($cat_name)==0){
                $cat_name="-root-";
            }
            $cat_id = trim($category->getData("hanza_category"));
            if (!is_numeric($cat_id)){
                $cat_id=0;
            }
            $cats_by_name[$category->getId()] = $cat_name;
            $cats_by_shop_id[$category->getId()] =$cat_id;
        }
        
        $cats_to_return=[$cats_by_name, $cats_by_shop_id];
        
        //$this->set_cache_data(__FUNCTION__,$cats_to_return);
        

        return $cats_to_return;    
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
}