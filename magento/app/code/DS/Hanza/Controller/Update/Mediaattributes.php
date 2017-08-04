<?php
namespace DS\Hanza\Controller\Update;

use Magento\Framework\App\Action\Context;

class Mediaattributes extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;

    public  $helper = false;
    public  $products = false;


    public function __construct(Context $context)
    {
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->helper = $this->_objectManager->create('DS\Hanza\Helper\Data');
        $this->cache = $this->_objectManager->create('DS\Hanza\Helper\Cache');
        $this->products = $this->_objectManager->create('DS\Hanza\Helper\Products'); 
        parent::__construct($context);
    }
    

    public function execute()
    {
        $verbose=false;
        if (isset($_GET["clear_cache"])){
            $this->cache->clear_cache_data("image_stores_set");
            $url = $this->helper->get_base_url()."hanza/update/mediaattributes";
            header("Location: $url");
        }     
        if (isset($_GET["verbose"])){
            $verbose = true;
        }
        $counter_skipped=0;
        $counter=0;
        $counter_cached=0;
        $updated=0;
        
        if ($verbose){
            print("Will update Media attributes to all store views!<br/>");    
        }
        
        
        // returning list of products that does not have images
        $data = ["status"=>true, "message"=>"We got the list"];
        $data["data"]=[];
        
        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();
            $counter=0;
            
        foreach ($collection as $product){
            
            $existingMediaGalleryEntries = null;
            $existingMediaGalleryEntries = $this->products->get_magento_images_list($product->getId(),true);
            $counter++;
            if(count($existingMediaGalleryEntries)>0){
                
                $fi=array_shift($existingMediaGalleryEntries);
                $fir=$fi;
                $fi = $this->helper->get_absolute_media_path()."catalog/product".$fi;
                if (file_exists($fi)){
                    
                    if (!$this->cache->get_cache_data($product->getSku(),"image_stores_set")){
                        if ($verbose){
                            print("$counter : ----------------<br/>");
                            print($product->getSku()."<br/>");
                            print($fi."<br/>");    
                        }
                        
                        $magento_sores=$this->helper->get_magento_stores();            
                        foreach($magento_sores as $store){
                            
                            
                             
                            $_product=null;
                            $im_absolute_path="";
                            $sid = $store["storeId"];
                            $_product = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($product->getId());
                            $_product->setStoreId($sid)
                            ->setImage($fir)
                            ->setSmallImage($fir)
                            ->setThumbnail($fir);
                            
                            try {
                                
                                $_product->save();
                                $this->cache->set_cache_data($product->getSku(),true,"image_stores_set");
                                $updated++;
                            } catch (\Exception $e) {
                                $this->cache->set_cache_data($product->getSku(),false,"image_stores_set");
                                if ($verbose){
                                    print($counter." : ".$_product->getId()." could not save. <br/>");    
                                }
                                
                            }
                        }    
                    } else {
                        $counter_skipped++;
                        $counter_cached++;
                        if ($verbose){
                            print($counter." : ".$fi." Skipped <br/>");        
                        }
                        
                    }

                } else {
                
                    $counter_skipped++;
                    if ($verbose){
                        print($counter." : ".$fi." Skipped <br/>");    
                    }
                    
                }
                
                
            }
            
        }
        if (($counter==$counter_skipped || ($counter_cached/$counter)>0.7) && $verbose){
        
            $url = $this->helper->get_base_url()."hanza/update/mediaattributes?clear_cache";
            ?>
            <a href="<?= $url ?>">Looks, like script already had done its job. Click on this link to redo.</a><br/>
            <?php
            
        }
        print(json_encode(["status"=>true, "message"=>"Media attributes updated Skipped: $counter_skipped   Updated: $updated   Total: $counter"]));
        die();
    }

}