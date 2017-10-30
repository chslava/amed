<?php

namespace DS\Importer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Store extends AbstractHelper
{
    
    private $_objectManager = null;
    private $_storeManager = null;
    private $class = null;
    private $ttl_hour = 3600;
    private $cache = null;
    
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);
    
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        
        $this->_storeManager = $this->_objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        
    }
    

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


    public function get_path_xml_import(){
        //TODO make it read from settings
        return $this->get_absolute_base_path()."WEB_EXCHANGE/pamata/import.xml";
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


    public function get_absolute_base_path(){
        /*    /** @var \Magento\Framework\App\ObjectManager $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\Filesystem $filesystem */
        $filesystem = $om->get('Magento\Framework\Filesystem');
        /** @var \Magento\Framework\Filesystem\Directory\ReadInterface|\Magento\Framework\Filesystem\Directory\Read $reader */
        $reader = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::ROOT);
        return $reader->getAbsolutePath();
    }


    public function get_absolute_var_path() {
        /*    /** @var \Magento\Framework\App\ObjectManager $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\Filesystem $filesystem */
        $filesystem = $om->get('Magento\Framework\Filesystem');
        /** @var \Magento\Framework\Filesystem\Directory\ReadInterface|\Magento\Framework\Filesystem\Directory\Read $reader */
        $reader = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::VAR);
        return $reader->getAbsolutePath();
    }
    
    
    public function get_absolute_image_path() {
        $image_path = $this->get_absolute_media_path()."import/image/source";
        return $image_path;
    }


    public function get_cache_dir(){
        $cache_dir = $this->get_absolute_var_path()."import_cache";
        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0755,true);
        }
        return $cache_dir;
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
        $img_dst_dir= $this->get_absolute_media_path()."import/image/source";
        if (!file_exists($img_dst_dir)){
            mkdir($img_dst_dir,0777,true);
        }
        return $img_dst_dir;
    }


     public function get_value_maping($type){

        switch($type){

            default:
                print(__FUNCTiON__);
                print("-".__FILE__);
                print($type);
                die();
                return null;
                break;
        }
    }


    function get_magento_stores(){

        //$stores=$this->cache->get_cache_data(__FUNCTION__,$this->class,$this->ttl_hour);
        //if ($stores){
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

        //$this->cache->set_cache_data(__FUNCTION__,$stores,$this->class);
        return $stores;
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
        $all_stores = $this->get_magento_stores();
        $i=0;
        foreach($all_stores as $c => $store){
            $i++;
            if ($i==1){
                $first_store_id=$store['storeId'];
            }
            if ($c ==$code){
                return $store['storeId'];
            }
        }
    }


    public function map_values($p,$type="product"){

        $map = $this->get_value_maping($type);
        $data_to_return = [];
        $data_to_return['original_data'] = $p;
        foreach($map as $k => $v){
            if (isset($p[$k])){
                $data_to_return[$v] = $p[$k];
            } else {
                $data_to_return[$v] = false;
                error_log("bad key :(".__LINE__.")");
            }
        }
        return $data_to_return;
    }


    public function get_default_language_code(){
        return "lv";
    }

}
