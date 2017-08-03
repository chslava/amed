<?php

namespace DS\Hanza\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Csv extends AbstractHelper
{
    private $helper = null;
    private $cache = null;
    private $ttl_hour = 3600;
    
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);
        
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->cache = $this->_objectManager->create('DS\Hanza\Helper\Cache');
        $this->helper = $this->_objectManager->create('DS\Hanza\Helper\Data');
        $this->_storeManager = $this->_objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        
    }
    
    
    public function get_prices($sku){
        $all_prices = $this->get_all_prices();
        if (isset($all_prices[$sku])){
            return $all_prices[$sku];    
        } else {
            return false;
        }
        
    }
    
    
    
    public function get_all_prices(){
        
        $c_data=$this->cache->get_cache_data(__FUNCTION__,$this->class,$this->ttl_hour);
        if ($c_data){
            return $c_data;
        }
        $data_to_return = [];
        $file_prefix="prices";
        $file_to_split = $this->helper->get_import_filename($file_prefix);

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
                    if (!isset($data_to_return[$price['sku']])){
                        $data_to_return[$price['sku']]= [];    
                    }
                    $data_to_return[$price['sku']][$price['price_group_id']] = $price;
                }
            }
        }
        if (count($data_to_return)>0){
            $this->cache->set_cache_data(__FUNCTION__, $data_to_return, $this->class);    
        }
        return $data_to_return;
    }
    
}
