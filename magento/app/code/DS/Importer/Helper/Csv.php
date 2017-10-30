<?php

namespace DS\Importer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Csv extends AbstractHelper
{
    private $store = null;
    private $cache = null;
    private $ttl_hour = 3600;
    private $class = null;
    
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);
        
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        $this->store = $this->_objectManager->create('DS\Importer\Helper\Store');
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

        $cache_dir= $this->store->get_cache_dir()."/".$file_prefix;
        $value_mapping = $this->store->get_value_maping($file_prefix);

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
    
    
    function get_product($sku){
        $c_data=$this->cache->get_cache_data($sku,"products");
        if ($c_data){
            return $c_data;
        }
        $products = $this->get_all_products();
        if (!empty($products[$sku])){
            $this->cache->set_cache_data($sku, $products[$sku],"products");
            return $products[$sku];
        } else {
            return false;
        }
    }
    
    
    function get_all_products(){
 
        $c_data=$this->cache->get_cache_data(__FUNCTION__,$this->class);
        if ($c_data){
            return $c_data;
        }
 
 
        $data_to_return = [];
        $value_mapping=null;
        $return_field="sku";
        $file_to_split = $this->store->get_import_filename("products");
        $file_prefix="products";
        $field_number=0;

        $return_field_original = $field_number;

        $cache_dir= $this->store->get_cache_dir()."/".$file_prefix;

        
        $value_mapping = $this->store->get_value_maping(basename($file_to_split));
        

        $line = null;
        $data_to_return =[];

        $current_sku="";
        $language_data=[];

        //reading file
        $first_row=true;
        $skus = [];
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
                    
                    $product = [];
                    $product["original_data"]= $data;
                    foreach($value_mapping as $k => $v){
                        $product[$v]=$data[$k];
                    }
                    
                    $product["code"] = trim($product["code"]);
                    if (!empty($product["code"])){
                        $product["sku"] = $product["code"]; 
                    }
                    
                    $product["sku"] = trim($product["sku"]);
                    $product["sku"] = str_replace(["\\u00a0"," ","+"],"-",$product["sku"]);
                    $product["sku"] = urlencode($product["sku"]);
//                    $product["sku"] = str_replace(["%28","%C2%A0"," ","+"],"-",$product["sku"]);
                    $product["sku"] = str_replace(["%C2%A0"," ","+"],"-",$product["sku"]);
                    $product["sku"] = urldecode($product["sku"]);
                    
                    
                    
                    if (!isset($skus[$product["sku"]])){
                        $sku_sufix="";
                        $skus[$product["sku"]] = [];
                    } else {
                        $sku_sufix="-".count($skus[$product["sku"]]);
                    }
                    $skus[$product["sku"]][] = $product;
                    $product["sku"] = $product["sku"].$sku_sufix;
                    
                    $data_to_return[$product["sku"]] = $product;            
                }
            }
        }
        if (count($data_to_return)>0){
            $this->cache->set_cache_data(__FUNCTION__,$data_to_return,$this->class);
        }
    }
    
}
