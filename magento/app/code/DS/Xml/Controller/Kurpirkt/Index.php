<?php


namespace DS\XML\Controller\Kurpirkt;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{


    private $_h_image = null;

    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {


        $this->_resultPageFactory = $resultPageFactory;
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $this->_h_image = $this->_objectManager->create('\Magento\Catalog\Helper\ImageFactory');
        $this->_h_categories = $this->_objectManager->create('\DS\Importer\Helper\Categories');




        parent::__construct($context);
    }


    private function get_xml_template(){

        $tempalte="
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

        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();

        foreach ($collection as $product) {
            $imageUrl = $this->_h_image->create()->init($product, 'image')->getUrl();
            $categories = $this->categories->get_categories($product->getCategoryIds());

            print_r($imageUrl);
            print_r($categories);
            die();
            $item_xml = $this->get_xml_template();
            $item_xml = str_replace("[name]",$product->getName(),$item_xml);
            $item_xml = str_replace("[product_link]","product price",$item_xml);
            $item_xml = str_replace("[price]",$product->getFinalPrice(),$item_xml);

            //$image = $product->getData('image');
            $item_xml = str_replace("[category_name]",$imageUrl ,$item_xml);
            $item_xml = str_replace("[category_full]",$category_full ,$item_xml);
            $item_xml = str_replace("[category_link]",$category_link ,$item_xml);

        }
    }

}