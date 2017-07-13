<?php


namespace DS\Hanza\Controller\Index;

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

        //$this= $this->_objectManager->get('\DS\Hanza\Helper\Data');
    //    $this = $helper_factory->get('DS\Hanza\Helper\Data');
        //print("<pre>");

        //print_r(get_object_vars($this));
        //print("</pre>");
        //$this->_coreHelper->getAbsolutepath();


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


        define("__SSH_HOST__",'87.110.182.26');
        define("__SSH_PORT__",'12119');
        define("__SSH_USER__",'hansa');
        define("__SSH_PASS__",'Multip@ck');
        define("__SSH_PATH_TO_DATA__",'/srv/hansa81test/datuapmaina/');
        define("__SSH_PATH_TO_MEDIA__",'/srv/hansa81test/datuapmaina/foto/');
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



    public function get_image_import_dir(){
        return $this->getAbsoluteMediaPath()."img_from_ssh";
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