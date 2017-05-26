<?php


namespace DS\Hanza\Controller\Json;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{

    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {

        $this->_resultPageFactory = $resultPageFactory;
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->helper = $this->_objectManager->create('DS\Hanza\Helper\Data');
        $this->force=false;

        parent::__construct($context);

    }


    private function add_product($data){
        //adding product
        //same as update just at the start we dont have
        //product id
        return $this->update_product(false,$data);
    }



    public function update_product($product_id, $data){
        
        //adds or updates existing product
        //@product_id = product id that must be updated (magento product id)
        // could be null if there is no product, then product will be created
        //@data = product data array from csv files
        
        
        //fixed qty, not linked with warehouse for now
        //TODO : link this with warehouse
        $qty = 20000;

        $stores = $this->helper->get_magento_stores();
        if (!$product_id){
            $product = $this->_objectManager->create('Magento\Catalog\Model\Product');

            $product->setTypeId('simple');
            $product->setAttributeSetId($this->helper->get_attribute_set());
            $product->setSku($data["sku"]);
            if (isset($stores["lv"]["websiteId"])){
                $website_id = $stores["lv"]["websiteId"];
            } else {
                $website_id = $stores["default"]["websiteId"];
            }
            $product->setWebsiteIds([$website_id]);
            $product->setVisibility(4);

            $product->setStockData(array(
                    'use_config_manage_stock' => 0, //'Use config settings' checkbox
                    'manage_stock' => 0, //manage stock
                    'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
                    'max_sale_qty' => $qty, //Maximum Qty Allowed in Shopping Cart
                    'is_in_stock' => 1, //Stock Availability
                    'qty' => $qty //qty
                )
            );
        } else {
            
            $product = $this->_objectManager->get('Magento\Catalog\Model\Product')->load($product_id);
        
            $product->setData('_edit_mode', true);

            $product->setStockData(array(
                    'use_config_manage_stock' => 0, //'Use config settings' checkbox
                    'manage_stock' => 0, //manage stock
                    'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
                    'max_sale_qty' => $qty, //Maximum Qty Allowed in Shopping Cart
                    'is_in_stock' => 1, //Stock Availability
                    'qty' => $qty //qty
                )
            );
        
        }
        
        // saving all attributes
        // some attributes are skipped cause they are for debugging or saved elsware
        foreach($data  as $key => $value){
            //checking if there is need for update

            switch($key){
                
                case "original_data":
                    //print("<pre>");
                    //print_r($data);
                    //print("</pre>");
                    break;
                
                case "image":
                    $data[$key] = $this->helper->get_absolute_image_path()."/".$value;
                    break;
                case "url":
                    //todo
                    break;
                case "sale":
                    //todo
                    break;
                
                case "sale_price":
                    //todo
                    break;
                case "new":
                    //todo
                    break;
                case "title":
                case "link_to_image":
                case "class_lvl_1":
                case "class_lvl_2":
                case "class_lvl_3":
                case "sold_by_item":
                case "sold_by_package":
                case "sold_by_box":
                case "images":
                    //skipping some values, tha we are not saved directly
                    // images are saved after product save/update
                    // with function sync_product_img
                    continue;
                    break;
                case "price":
                    if ($data['price']<0.01){
                        $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
                        $status_changed=true;
                    }
                    $product->setPrice($data['price']);
                    break;
                
                case "name":
                        $product->setName($data['title']);
                
                    break;
                
                case "description":
                        $product->setDescription($data['description']);
                    break;
    
                case "categories":
                    //getting existing ids
                    $existing_cat_ids = $product->getCategoryIds();
                    $home_page_cat = $this->helper->get_homepage_cat();
                    
                    if (count($existing_cat_ids)>0 && in_array($home_page_cat,$existing_cat_ids)) {   
                        $value[] = $home_page_cat;
                    }
                    $product->setCategoryIds($value);
                    
                    break;
                case "original_data": default:
                    if ($key!="categories"){
                        if (empty($value)){
                            //Todo set empty value the correct way
                            //
                            $value=" ";
                            $product->setData($key, $value);
                        } else {
                            $product->setData($key,$value);
                        }
                    }
                    break;
            }
        }

        //trying to save products
        try {        
            $product->save();

            //TODO other languages
            
            //$this->add_language($product->getId(), $data,"default",$data["sku"]);
            //foreach($stores as $key => $store){
            //    $this->add_language($product->getId(), $data,$key,$data["sku"]);
            //}

            if (!$product_id){
                return ["status"=>true,"message"=>"Product added.", 'data'=>$data];
            } else {
                return ["status"=>true,"message"=>"Product updated.", 'data'=>$data];
            }

        } catch (\Exception $e) {
            if (!$product_id){
                return ["status"=>false,"message"=>"Could not add product! ".__LINE__.__FUNCTION__." ".$e->getMessage(), 'data'=>$data];
            } else {
                return ["status"=>false,"message"=>"Could not update product! ".__LINE__.__FUNCTION__." ".$e->getMessage(), 'data'=>$data];
            }

        }

        return ["status"=>false,"message"=>"Could not update product!", 'data'=>$data];
    }


    private function add_language($_product_id, $data, $lang, $sku)
    {

        $default = false;
        if ($lang =="default"){
            $lang="lv";
            $default=true;
        } else {
            $stores = $this->helper->get_magento_stores();
        }
        if (!isset($data['name'][$lang])){
            return 1;
        }


        $product = $this->_objectManager->create('\Magento\Catalog\Model\Product');
        $product->load($_product_id);

        if ($default){
            $product->setName($data['name'][$lang]." ".$sku);
        } else {
            $product->setName($data['name'][$lang]);
        }

        if (isset($data['description'][$lang])){
            $product->setDescription($data['description'][$lang]);
        }

        //TODO default value update
        if (!$default){
            $product->setWebsiteIds([$stores[$lang]["websiteId"]]);
            $product->setStoreId($stores[$lang]["storeId"]);
        }


        try {
            $product->save();
            return ["status"=>true,"message"=>"Language data updated"];

        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return ["status"=>false,"message"=>"Update language related data failed. ".$e->getMessage()." "];
        }
    }


    private function disable_product($sku){

        $data=[];
        $data["status"]=false;
        $data["message"]="Disabling failed";

        $_product = $this->_objectManager->create('Magento\Catalog\Model\Product');
        $id = $_product->getIdBySku($sku);

        if ($id){
            $_product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
            try {
                $_product->save();
                return ["status"=>true,"message"=>"Product disabled."];
            } catch (\Exception $e) {
                return ["status"=>false,"message"=>"Product disbalation failed ".$e->getMessage()." "];
            }

        } else {
            $data["status"]=false;
            $data["message"]="No product nothing to dissable";
        }
        return $data;
    }

    
    private function sync_product_img($sku, $force=true, $only_delete=true, $prod_data=null){
        
        //function that updates product images by sky
        // @$sku - product sku
        // @force - forces update images even if image count is equal (flag for testing)
        // @only_delete - deletes files does not add images even if there is images (flag for testing)
        
        // getting product
        $data=[];
        $data['status']=false;
        $data['message']="No harm done / actually nothing done";
        
        
        $images_to_add = [$prod_data["image"]];
        
        
        
        $id = $this->helper->get_product_id_by_sku($sku);
        if (!$id){
            //if there is no id, there is no product
            $data['status']=false;
            $data["message"]="No product, skipping, could not add images to nonexisting produc $sku";
            return $data;
        }
        
        //remove images from product
        $p = $this->_objectManager->create('Magento\Catalog\Model\Product');
        $productRepository = $this->_objectManager->create('\Magento\Catalog\Api\ProductRepositoryInterface');
        $existingMediaGalleryEntries = $p->load($id)->getMediaGalleryEntries();
        
        if (count($images_to_add)==0 && count($existingMediaGalleryEntries)==0){
            $data['status']=false;
            $data['message']="No images, skipping!";
            return $data;
        }
        
        if (count($existingMediaGalleryEntries)==count($images_to_add)){
            if(count($images_to_add)>0){
                $changed=false;
                foreach($images_to_add as $image) {
                    $img_file_name = basename($image);
                    $src = $this->helper->get_image_import_dir()."/".$img_file_name;
                    $src_time_stamp = filemtime($src);
                    $cache_time_stamp = $this->helper->get_cache_data(basename($this->helper->get_image_timestamp_dir())."/".basename($src));
                                
                    if ($src_time_stamp!=$cache_time_stamp){
                        //file has been chage
                        //we need to update file
                        $path_dst = $this->helper->get_image_destination_dir();
                        $dst = $path_dst."/".basename($src);
                        if (file_exists($dst)){
                            unlink($dst);
                            $this->helper->delete_cached_files($img_file_name);
                        }
                        copy($src,$dst);
                        $changed=true;
                    }
                }
                if (!$changed && !$force) {
                    $data['status']=false;
                    $data["message"]="Image count is the same, image list of the product was not updated";
                    return $data;
                }
            } else {
                if (!$force){
                    $data['status']=false;
                    $data["message"]="Image count is the same, image list of the product was not updated";
                    return $data;    
                } else {
                    
                }
            }
            
            
        }
        
        //could be that there is no images, so skipping deleting them
        $delete_counter=0;
        if ($existingMediaGalleryEntries){
            
            foreach ($existingMediaGalleryEntries as $key => $entry) {
                //We can add your condition here
                $media_dir = $this->helper->get_absolute_media_path();
                $file = $media_dir."catalog/product".$entry->getFile();
                if (file_exists($file)){
                    
                    unlink ($file);
                }
                $delete_counter++;
                unset($existingMediaGalleryEntries[$key]);
            }
            $p->setMediaGalleryEntries($existingMediaGalleryEntries);
            try {        
                $productRepository->save($p);                
            } catch (\Exception $e) {                
                return ["status"=>false,"message"=>"Could not updata images!  ".$e->getMessage()];
            }
        }
            
          
        $data['status']=true;
        $data['message']="Image removed!";
        
        
        if ($only_delete){
            return $data;
        }
        
        $this->helper->set_imported_images($sku,[]);
        
        //adding images
        $p = $this->_objectManager->get('Magento\Catalog\Model\Product')->load($id);
        $counter=0;
        $images_imported=[];
        foreach($images_to_add as $image_to_add){
            
            $img_file_name = basename($image_to_add);
            $src = $this->helper->get_image_import_dir()."/".$img_file_name;
            
            $src_time_stamp = filemtime($src);
            $this->helper->set_cache_data(basename($this->helper->get_image_timestamp_dir())."/".basename($src),$src_time_stamp);
            
            
            
            $counter++;
            $images_imported[] = basename($image_to_add);
            $image_to_add = $src;
            if ($counter==1){
                $p->addImageToMediaGallery($image_to_add, array('image', 'small_image', 'thumbnail'), false, false); // Add Image 3
            } else {
                
                $p->addImageToMediaGallery($image_to_add, [], false, false); // Add Image 3
            }
            
           
        }
        
        if (count($images_imported)>0){
            $this->helper->set_imported_images($sku, $images_imported);    
        }
    
    
        
        if ($counter>0){
           $p->save();
           $data['status']=true;
           $data['message']="Image/s added ($counter)!";
        } else if($delete_counter > 0){
            $p->save();
            $data['status']=true;
            $data['message']="Image/s deleted ($counter)!";    
        } else {
            
        }
        
        
        
        if ($force){
            $data['message'].=" Force mode!";
        }
        
        return $data;
    }
    
    

    private function sync_product($sku, $skip_if_no_price=false, $skip_if_no_image=false){

        $force = $this->force;
        $data=[];
        $data["status"]=false;
        $data["message"]="Update failed";

        //checming if there is product
        $prod_data= $this->helper->get_product_data($sku);


        if (isset($prod_data['status']) && !$prod_data['status']){
            if ($sku){
                $this->disable_product($sku);
            }
            return $prod_data;
        }

        if ($skip_if_no_image && count($prod_data['images'])==0) {
            $data["status"]=false;
            $data["message"]="There is no image for product so skipping:  ".$sku;
        }

        if ($skip_if_no_price && !is_numeric($prod_data['price'])) {
            $data["status"]=false;
            $data["message"]="There is no price for product so skipping:  ".$sku;
        }

        //

        if ($prod_data){
            $id = $this->helper->get_product_id_by_sku($sku);
            if (!$id){
                //there is no product so we have to add the product
                $result = $this->add_product($prod_data);
                if ($result["status"]){
                    $image_import_result = $this->sync_product_img($sku,$force, false, $prod_data);
                    $result["message"].=" ".$image_import_result["message"];
                }
                return $result;
            } else {
                //exists updating, so we are updating
                $result = $this->update_product($id,$prod_data);
                if (!$result['status']){
                    $this->disable_product($id);
                } else {
                    $image_import_result = $this->sync_product_img($sku,$force, false,$prod_data);
                    $result["message"].=" ".$image_import_result["message"];
                }
                return $result;

            }
        } else {
            $data["status"]=false;
            $data["message"]="There is no data for product by sku ".$sku    ;
        }
        //if there is no product then we have to add product
        return $data;
    }
    
    
    private function products_that_does_not_have_images($reverse=false){
        // returning list of products that does not have images
        $data = ["status"=>true, "message"=>"We got the list"];
        $data["data"]=[];
        
        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();
        foreach ($collection as $product){
            
            $existingMediaGalleryEntries = null;
            $existingMediaGalleryEntries = $this->helper->get_images($product->getId());
            
            if (count($existingMediaGalleryEntries)>0 && !$reverse){
                
            } else {
                $data["data"][] = [
                               "sku"=>$product->getSku(),
                               "name"=>$product->getName(),
                               "url"=>$product->getProductUrl(),
                               "files"=>implode(",",$existingMediaGalleryEntries),
                               
                               ];    
            }
            
        }
        return $data;
    }


    public function execute(){

        $data = [];

        if (isset($_GET['force'])){
            $this->helper->get_ids_for_update();
            $this->force=true;
        }
        
        if (isset($_GET['action'])){
            switch($_GET['action']){

                case "copy_images":
                    print("<pre>");
                    $good_bad_products = $this->helper->rename_files_names_to_uppercase(true,true);

                    print("Good:".count($good_bad_products["good"])."<br/>");
                    print("Bad:".count($good_bad_products["bad"])."<br/>");
                    print_r($good_bad_products["bad"]);
                    print("</pre>");
                    break;


                case "products_with_images":
                    $this->helper->rename_files_names_to_uppercase(true,true);
                    break;
 
                case "output_products_line_by_line":
                    $this->helper->print_line_by_line("products");
                    break;
                
                case "debug_no_price_products":
                    $only_prices = true;
                    $data = $this->helper->get_invalid_products($only_prices);
                    break;

                case "debug_good_products":
                     $data = $this->helper->get_invalid_products(false, true);
                     break;
                    
                case "debug_bad_products":
                    $data = $this->helper->get_invalid_products();
                    break;

                case 'get_product_list':
                    //products that has been changed (attributes)
                    $data=$this->helper->get_ids_for_update(isset($_GET['force']));

                   
                    break;
                
                case 'update_image':
                    if(isset($_GET["id"])){
                        
                        $only_delete = false;
                        if (isset($_GET['only_delete'])){
                            $only_delete = true;
                        }
                        
                        $data = $this->sync_product_img($_GET["id"],$this->force,$only_delete);
                    } else {
                        $data["status"]=false;
                        $data["message"]="No id given";
                    }
                    break;
                case 'add_product':
                    if(isset($_GET["id"])){
                        if (isset($_GET["skip"]) && $_GET["skip"]=="no_price_no_image") {
                            $skip_if_no_price = true;
                            $skip_if_no_image = true;
                            $data = $this->sync_product($_GET["id"],$skip_if_no_price,$skip_if_no_image);
                        } else {
                            $data = $this->sync_product($_GET["id"]);
                        }

                    } else{
                        $data["status"]=false;
                        $data["message"]="No id given";
                    }
                    break;
                case 'resave-categories':
                    $disable=false;
                    if (isset($_GET['disable'])){
                        $disable=true;
                    }
                    $data = $this->helper->resave_categories($disable);
                    break;
                case 'products-no-images':
                    $data = $this->products_that_does_not_have_images();
                    break;
                default:
                    $data["status"]=false;
                    $data["message"]="Action does not exist ".$_GET["action"];
                    break;

            }
        }

        print(json_encode($data));
        exit();
    }

}