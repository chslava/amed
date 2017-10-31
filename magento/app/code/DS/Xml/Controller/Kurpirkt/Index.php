<?php


namespace DS\XML\Controller\Kurpirkt;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{


    private $_h_image = null;
    private $_h_categories = null;

    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {


        $this->_resultPageFactory = $resultPageFactory;
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->_h_image = $this->_objectManager->create('\Magento\Catalog\Helper\ImageFactory');
        $this->_h_categories = $this->_objectManager->create('\DS\Importer\Helper\Categories');
        $this->_h_cache = $this->_objectManager->create('DS\Importer\Helper\Cache');




        parent::__construct($context);
    }


    private function get_xml_template(){

        $template="
        <item>
				<name>[name]</name>
				<link>[product_link]</link>
				<price>[price]</price>
				<image>[image]</image>
				<category>[category_name]</category>
				<category_full>[category_full]</category_full>
				<category_link>[category_link]</category_link>
		</item>
		";
        return $template;
    }





    public function execute()
    {
        $xml_data = $this->_h_cache->get_cache_data("kurpirkt","xml",24 * 3600);
        if ($xml_data && false){
            print($xml_data);
            die();
        }

        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();

        $items="";

        foreach ($collection as $product) {

            $category_tree = $this->_h_categories->get_category_tree_names($product->getCategoryIds());
            $category_tree_names = $category_tree["names"];
            $category_tree_names = implode(" &gt; ",$category_tree_names);
            $category_name = end($category_tree["names"]);
            $category_id = end($category_tree["ids"]);
            $price = $product->getFinalPrice();
            if ($price<0.01){
                continue;
            }

            if ($product->getImage()){
                $image_url= $this->_h_image->create()->init($product, 'image')->getUrl();
                if (substr_count($image_url,"placeholder")){
                    $image_url="";
                }
            }
            $category_link=$this->_h_categories->get_url($category_id);
            $product_link=$this->_h_categories->get_url($category_id);

            if (!empty($image_url)){
                print_r($image_url);
                die();
            }

            $item_xml = $this->get_xml_template();
            $item_xml = str_replace("[name]",$product->getName(),$item_xml);
            $item_xml = str_replace("[product_link]",$product_link,$item_xml);
            $item_xml = str_replace("[price]",$price,$item_xml);
            $item_xml = str_replace("[image]",$image_url,$item_xml);
            $item_xml = str_replace("[category_name]",$category_name ,$item_xml);
            $item_xml = str_replace("[category_full]",$category_tree_names ,$item_xml);
            $item_xml = str_replace("[category_link]",$category_link ,$item_xml);

            $items.="
            ".$item_xml;
        }

        $xml_data = "<?xml version='1.0' encoding='utf-8' ?>
<root>
    $items
</root>";
        $this->_h_cache->set_cache_data("kurpirkt",$xml_data, "xml");

        print($xml_data);
        die();
    }

}