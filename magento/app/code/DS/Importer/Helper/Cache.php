<?php

namespace DS\Importer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Cache extends AbstractHelper
{



    public function get_absolute_media_path() {
        /*    /** @var \Magento\Framework\App\ObjectManager $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\Filesystem $filesystem */
        $filesystem = $om->get('Magento\Framework\Filesystem');
        /** @var \Magento\Framework\Filesystem\Directory\ReadInterface|\Magento\Framework\Filesystem\Directory\Read $reader */
        $reader = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        return $reader->getAbsolutePath();
    }


    public function get_absolute_cache_path() {
        /*    /** @var \Magento\Framework\App\ObjectManager $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\Filesystem $filesystem */
        $filesystem = $om->get('Magento\Framework\Filesystem');
        /** @var \Magento\Framework\Filesystem\Directory\ReadInterface|\Magento\Framework\Filesystem\Directory\Read $reader */
        $reader = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::CACHE);
        return $reader->getAbsolutePath();
    }


    public function get_cache_dir(){
        $cache_dir = $this->get_absolute_cache_path()."importer_cache";
        if (!file_exists($cache_dir)){
            mkdir($cache_dir,0755,true);
        }
        return $cache_dir;
    }


    /**
    * Function sets cache gile
    * @id string cache id
    * @prefix string for grouping the cache files
    * @ttl integer seconds for keeping the cache, default cache kept forever
    * @return mixed the content of the cahced file
    */
    public function get_cache_data($id, $prefix = null, $ttl=null) {
        $id = trim(str_replace(["/"," "],["_","_"],trim($id)));
        if (!empty($prefix)){
            $prefix = "/".$prefix;
        }   
        $cache_file = $this->get_cache_dir().$prefix."/".$id.".json.php";
        if (file_exists($cache_file)){
            $data = json_decode(file_get_contents($cache_file),true);
            if ($ttl && is_numeric($ttl) && (filemtime($cache_file)+$ttl)<time()){
                unlink($cache_file);
                return false;
            }
            return $data;
        }
        return false;
    }

    
    /**
    * Function sets cache gile
    * @id string cache id
    * @data mixed data that needs to be pushed into cache
    * @prefix string for grouping the cache files 
    * @return boolean true unlinked / false cache file has not delete 
    */
    public function set_cache_data($id, $data, $prefix = null){
        $id = trim(str_replace(["/"," "],["_","_"],trim($id)));
        if ($prefix){
            $prefix = "/".$prefix;
        }
        
        if (!file_exists($this->get_cache_dir().$prefix)) {
            mkdir($this->get_cache_dir().$prefix,0755,true);
        }
        $cache_file = $this->get_cache_dir().$prefix."/".$id.".json.php";
        file_put_contents($cache_file,json_encode($data));
    }
    
    
    /**
    * Function deltes particluar cache file
    * @id string cache id
    * @prefix string  for grouping the cache files 
    * @return boolean true unlinked / false cache file has not delete 
    */
    public function delete_cache_data($id, $prefix = null){
        $id = trim(str_replace(["/"," "],["_","_"],trim($id)));
        if ($prefix){
            $prefix = "/".$prefix;
        }
        if (!file_exists($this->get_cache_dir().$prefix)) {
            mkdir($this->get_cache_dir().$prefix,0755,true);
        }
        $cache_file = $this->get_cache_dir().$prefix."/".$id.".json.php";
        if (file_exists($cache_file)){
            //return the result of unlinking file
            return unlink($cache_file);
        } else {
            //no file so delete success
            return true;
        }
        return false;
    }

 
    public function clear_cache_data($prefix=""){
        
        $cache_dir = $this->get_cache_dir();
        if ($prefix){
            $cache_dir =$cache_dir."/".$prefix;     
        }
        $files = scandir($cache_dir);
        foreach($files as $file){
            if ($file=="." || $file==".."){
                continue;
            }
            if (file_exists($cache_dir."/".$file)){
                unlink($cache_dir."/".$file);
            }
        }
        
    }
    
    
    function delete_dir_content($path_to_dir){
        //deletes all files in directory
        $files = glob($path_to_dir.'/*'); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
    }

}
