<?php
namespace DS\Importer\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;
class Categories extends AbstractHelper
{
    
    
    private $class ="";
    private $_objectManager;

    
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
    
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);
        
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->helper = $this->_objectManager->create('DS\Importer\Helper\Data');
        $this->store = $this->_objectManager->create('DS\Importer\Helper\Store');
        
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

    
    public function add($name, $parent_id=null,$attributes){
        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        }

        $category = $this->_objectManager->get('\Magento\Catalog\Model\CategoryFactory')->create();
        $category->setName($name);
        //$category->setData("",$csv_category['id']);
        
        if ($parent_id){
            $category->setParentId($parent_id); // 1: root category.    
        } else {
            $category->setParentId($this->store->get_root_cat()); // 1: root category.
        }
        
        $category->setIsActive(true);
        if (is_array($attributes)){
            $category->setCustomAttributes($attributes);
        }

        
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


    public function get_all_magento_categories(){
        /*
         * function gets all categories from root category and rerranges them by the hanza id
         * one hanza cat can be linked to several categories
         */
        $cats_to_return = [];
        //if ($cats_to_return=$this->cache->get_cache_data(__FUNCTION__)){
        //    return $cats_to_return;
        //}

        if (!isset($this->_objectManager)){
            $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        }

        $categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
        $categories = $categoryFactory->create()
            ->addAttributeToSelect('*');
        //->setStore($store["storeId"]); //categories from current store will be fetched

        $cats_to_return = [];
        $cats_to_return["magento_cats"] = [];
        $cats_to_return["cats"] = [];
        foreach ($categories as $category){
            $cats_to_return["magento_cats"][$category->getId()] = [];
            foreach($g_sex as $sid){
                foreach($g_type as $tid){
                    $cats_to_return["magento_cats"][$category->getId()][]=[
                        'sex'=>$sid,
                        'type_id'=>$tid
                    ];

                    if (!isset($cats_to_return["cats"][$tid] )){
                        $cats_to_return["cats"][$tid] = [];
                    }
                    $cats_to_return["cats"][$tid][$sid] = $category->getId();
                }
            }

        }

        $this->cache->set_cache_data(__FUNCTION__,$cats_to_return);

        return $cats_to_return;
    }

}