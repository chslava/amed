<?php


namespace DS\Importer\Controller\Tests;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_objectManager;
    protected $_stores;
    protected $_attribute_sets;
    protected $_ssh_connection;

    public  $_p_count=0;
    public  $_p_added_with_imges=0;
    public  $_p_skipped=0;
    public  $_p_failed=0;
    public  $_p_added=0;
    public  $_p_updated=0;
    public  $_p_empty_row=0;
    public  $_p_prices =array();
    public  $_p_stock = array();
    public  $_p_categories = array();
    public  $_p_categories_names = array();

    public  $_helper = false;
    public  $_skip_ssh = true;


    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {


        $this->_resultPageFactory = $resultPageFactory;
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        
        $this->_stores=false;
        $this->_p_prices = false;
        $this->_p_stock = false;
        $this->_p_categories = false;


        $coll = $this->_objectManager->create(\Magento\Catalog\Model\Product\AttributeSet\Options::class);

        $options=[ ['label'=>'Select Attribute Set', 'value'=>'']];

        foreach($coll->toOptionArray() as $d){
            if($d['label'] !== 'Default') {
                $options[] = ['label' => $d['label'], 'value' => $d['value']];
            }
        }
        $this->_attribute_sets = $options;


        parent::__construct($context);
    }



    private function convert_to_cm($field)
    {
        if (substr_count($field,"mm")){
            $field=str_replace("mm","",$field);
            $field=$field/10;
        }

        if (substr_count($field,"cm")){
            $field=str_replace("cm","",$field);
        }

        if (substr_count($field,"m")){
            $field=str_replace("m","",$field);
            $field=$field*100;
        }
        return $field;

    }



    private function get_product_cache_filename($sku){
        $sku = str_replace("/","-",$sku);
        return $this->getAbsoluteMediaPath()."prod_csv_cache/".$sku.".product.json.php";
    }



    public function update_images($sku){

        $file_names_renamed = $this->get_cache_data("files_renamed");
        if (!$file_names_renamed){
            $this->file_names_to_uppercase();
            $this->set_cache_data("files_renamed",true);
        }
        $_product = $this->_objectManager->create('Magento\Catalog\Model\Product');
        $id = $_product->getIdBySku($sku);

        if (is_numeric($id)){

            $img_sku = str_replace("/","-",$sku);
            $img = $this->store->get_image_import_dir()."/$img_sku.jpg";
            $img_1 = $this->store->get_image_import_dir()."/$img_sku"."_1".".jpg";

            if ( file_exists($img) || file_exists($img_1) ) {
                $p = $this->_objectManager->get('Magento\Catalog\Model\Product')->load($id);
                $images = $p->getMediaGalleryImages();
                if (count($images)>0){
                    for($i=0; $i<10; $i++){
                        if ($i==0){
                            // image path setup
                            $image_src = $this->store->get_image_import_dir()."/".$img_sku.".jpg";
                            $image_dst = $this->store->get_image_import_dir()."/done/".$img_sku.".jpg";

                        } else {
                            // image path setup
                            $image_src = $this->store->get_image_import_dir()."/".$img_sku."_".$i.".jpg";
                            $image_dst = $this->store->get_image_import_dir()."/done/".$img_sku."_".$i.".jpg";
                        }
                        if (file_exists($image_src)){
                            rename($image_src, $image_dst);
                        } else {
                            if ($i>1){
                                //some images has _1 image but not image without _1.jpg
                                //till first missing immage
                                break;
                            }

                        }
                    }
                    return ["status"=>true,"message"=>"<span class='alert warning'>Images already attached to product!</span>"];
                }

                $atleast_one_image_added = false;

                for($i=0; $i<10; $i++){
                    if ($i==0){
                        // image path setup
                        $image_src = $this->store->get_image_import_dir()."/".$img_sku.".jpg";

                    } else {
                        // image path setup
                        $image_src = $this->store->get_image_import_dir()."/".$img_sku."_".$i.".jpg";
                    }
                    if (file_exists($image_src)){
                        $p->addImageToMediaGallery($image_src, array('image', 'small_image', 'thumbnail'), false, false); // Add Image 3
                        $atleast_one_image_added=true;
                    } else {
                        if ($i>1){
                            //some images has _1 image but not image without _1.jpg
                            //till first missing immage
                            break;
                        }

                    }
                }
                if ($atleast_one_image_added){
                    try {
                        $p->save();
                        return ["status"=>false,"message"=>"<span class='alert success'>Image added! Succesfully!</span>"];

                    } catch (\Exception $e) {
                        echo 'Caught exception: ',  $e->getMessage(), "\n";
                        return ["status"=>false,"message"=>"<span class='alert error'>Could not update product! </span>"];
                    }
                }

            } else {
                return ["status"=>false,"message"=>"<span class='alert error'>No image, nothing to update;</span> ".$img.", ".$img_1.""];
            }
        } else {
            return ["status"=>false,"message"=>"<span class='alert error'>No product in magento, nothing to update!</span>"];
        }
        return ["status"=>false,"message"=>"<span class='alert error'>Update failed</span>"];
    }






    private function get_image_count($p_id){

        $_p = $this->_objectManager->get('Magento\Catalog\Model\Product')->load($p_id);
        $_p->load('media_gallery');
        $images = $_p->getMediaGalleryEntries();
        return count($images);
    }

    private function list_bad_products($type="") {

        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()->addAttributeToSelect('*')->load();

        ?>
        <table>
            <tr>
                <td>Nr</td>
                <td>SKU</td>
                <td>Name</td>
                <td>Status</td>
                <td>Problem</td>
            </tr>

            <?php
            $counter=0;
            foreach ($collection as $p){

                $problem=[];
                $problem_classes=[];
                $_p=null;

                if ($type=="" || $type=="images"){

                    $images=null;
                    $_p = null;
                    $objectManager= null;

                    $id = $p->getId();
                    $images_count = $this->get_image_count($id);

                    if ($images_count>0) {

                    } else {
                        $problem[]="No images";
                        $problem_classes[]="no-images";
                    }
                }

                if ($type=="" || $type=="categories"){
                    $categoryids = $p->getCategoryIds();
                    if (count($categoryids)==0) {
                        $problem[]="No categories";
                        $problem_classes[]="no-cats";
                    }
                }

                if ($type=="" || $type=="prices"){
                    $price = $p->getFinalPrice();
                    if ($price<0.01) {
                        //$product_data = $this->get_product_from_csv($p->getSku());
                        $price_data = $this->get_products_price_from_csv($p->getSku());
                        if ($price_data["result"]){
                            $price_data= $price_data['data'];
                        } else {
                            $price_data =[];
                        }

                        $problem[]="No price (".$price.") <br/>".$this->print_r_nice($price_data);
                        $problem_classes[]="no-price";
                    }
                }


                if (count($problem)==0){
                    continue;
                }
                $counter++;

                ?>
                <tr class="<?= implode(" ",$problem_classes) ?>">
                    <td><?= $counter ?></td>
                    <td><?= $p->getSku() ?></td>
                    <td><?= $p->getName() ?></td>
                    <td><?= $p->getSatus() ?></td>
                    <td><?= implode(";<br/>",$problem) ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php

    }


    public function execute()
    {
        if (isset($_GET['color'])){
            $this->get_all_atribute_versions();
            die();
        }

        if (isset($_GET) && isset($_GET['type']) && isset($_GET["action"])){
            switch($_GET['type']){
                case "json":

                    switch($_GET["action"]){
                        case "get_product_list":
                            print(json_encode($this->get_product_ids()));
                            die();
                            break;
                    }

                    break;
            }
        }

        if (isset($_GET) && isset($_GET['update'])){
            switch($_GET['update']){
                case "all":
                    $this->import_from_multipac_csv();
                    break;
                case 'add_product':
                    if (isset($_GET['id']) && strlen($_GET['id'])>0){
                        $result = $this->add_missing_product($_GET['id']);
                        print($result["message"]);
                    }
                    break;
                case 'prices':
                    if (isset($_GET['id']) && strlen($_GET['id'])>0){
                        $result = $this->update_prices($_GET['id']);
                        print($result["message"]);
                    }
                    break;
                case 'description':
                    if (isset($_GET['id']) && strlen($_GET['id'])>0){
                        $result = $this->update_description($_GET['id']);
                        print($result["message"]);
                    }
                    break;
                case 'volume':
                    if (isset($_GET['id']) && strlen($_GET['id'])>0){
                        $result = $this->update_volume($_GET['id']);
                        print($result["message"]);
                    }
                    break;
                case 'images':
                    if (isset($_GET['id']) && strlen($_GET['id'])>0){
                        $result = $this->update_images($_GET['id']);
                        print($result["message"]);
                    }
                    break;

                case 'cats':
                    if (isset($_GET['id']) && strlen($_GET['id'])>0){
                        $result = $this->update_cats($_GET['id']);
                        print($result["message"]);
                    }
                    break;

                case "bad_products":
                    $this->list_bad_products();
                    break;

                case "no_images":
                    $this->list_bad_products("images");
                    break;

                case "no_prices":
                    $this->list_bad_products("prices");
                    break;
                default:

                    break;
            }
            die();
        } else {
            $resultPage = $this->_resultPageFactory->create();
            return $resultPage;
        }

    }

}