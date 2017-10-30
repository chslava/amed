<?php
namespace DS\Importer\Helper;

class Attributes extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Catalog\Api\ProductAttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * @var array
     */
    protected $attributeValues;

    /**
     * @var \Magento\Eav\Model\Entity\Attribute\Source\TableFactory
     */
    protected $tableFactory;

    /**
     * @var \Magento\Eav\Api\AttributeOptionManagementInterface
     */
    protected $attributeOptionManagement;

    /**
     * @var \Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory
     */
    protected $optionLabelFactory;

    /**
     * @var \Magento\Eav\Api\Data\AttributeOptionInterfaceFactory
     */
    protected $optionFactory;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository
     * @param \Magento\Eav\Model\Entity\Attribute\Source\TableFactory $tableFactory
     * @param \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement
     * @param \Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory $optionLabelFactory
     * @param \Magento\Eav\Api\Data\AttributeOptionInterfaceFactory $optionFactory
     */
    private $class = null;
    private $helper = null;
    private $cache = null;
    private $ttl_hour = 3600;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository,
        \Magento\Eav\Model\Entity\Attribute\Source\TableFactory $tableFactory,
        \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement,
        \Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory $optionLabelFactory,
        \Magento\Eav\Api\Data\AttributeOptionInterfaceFactory $optionFactory
    ) {
        
        
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);

        $this->attributeRepository = $attributeRepository;
        $this->tableFactory = $tableFactory;
        $this->attributeOptionManagement = $attributeOptionManagement;
        $this->optionLabelFactory = $optionLabelFactory;
        $this->optionFactory = $optionFactory;
        
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->helper = $this->_objectManager->create('DS\Importer\Helper\Data');
        $this->cache = $this->_objectManager->create('DS\Importer\Helper\Cache');
        parent::__construct($context);
        
    }

    /**
     * Get attribute by code.
     *
     * @param string $attributeCode
     * @return \Magento\Catalog\Api\Data\ProductAttributeInterface
     */
    public function getAttribute($attributeCode)
    {
        return $this->attributeRepository->get($attributeCode);
    }

    /**
     * Find or create a matching attribute option
     *
     * @param string $attributeCode Attribute the option should exist in
     * @param string $label Label to find or add
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createOrGetId($attributeCode, $label, $lv_label ="")
    {
        
        if (strlen($label) < 1) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Label for %1 must not be empty.', $attributeCode)
            );
        }
        
        if (!$lv_label){
            $lv_label = $label;
        }

        // Does it already exist?
        //print($attributeCode." ".$label."<br/>");
        $optionId = $this->getOptionId($attributeCode, $label);
        
        //var_dump($optionId);
        //print(" $attributeCode $label <br/>");
        
        if (!$optionId) {
            // If no, add it.

            /** @var \Magento\Eav\Model\Entity\Attribute\OptionLabel $optionLabel */
            $optionLabel = $this->optionLabelFactory->create();
            $optionLabel->setStoreId(0);
            $optionLabel->setLabel($label);
            
            $optionLabel_lv = $this->optionLabelFactory->create();
            $optionLabel_lv->setStoreId($this->helper->get_store_id("lv"));
            $optionLabel_lv->setLabel($lv_label);

            $option = $this->optionFactory->create();
            $option->setLabel($optionLabel);
            $option->setStoreLabels([$optionLabel,$optionLabel_lv]);
            $option->setSortOrder(0);
            $option->setIsDefault(false);

            $this->attributeOptionManagement->add(
                \Magento\Catalog\Model\Product::ENTITY,
                $this->getAttribute($attributeCode)->getAttributeId(),
                $option
            );
            $this->cache->set_cache_data($attributeCode,false,$this->class);

            // Get the inserted ID. Should be returned from the installer, but it isn't.
            $optionId = $this->getOptionId($attributeCode, $label);
            
            return $optionId;
        } else {
            return $optionId;    
        }
    }

    /**
     * Find the ID of an option matching $label, if any.
     *
     * @param string $attributeCode Attribute code
     * @param string $label Label to find
     * @param bool $force If true, will fetch the options even if they're already cached.
     * @return int|false
     */
    public function getOptionId($attributeCode, $label, $force = false)
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute */

        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $attribute = $this->_objectManager->create('\Magento\Catalog\Model\Product\Attribute\Repository');    
        $attribute = $attribute->get($attributeCode);
        foreach ($attribute->getOptions() as $option) {
        
            $db_value = $option->getValue();
            $db_label = $option->getLabel();
            if ($db_label==$label){
                return $db_value;
            }
        }
    }


    public function get_attribute_option_id($attr_code,$admin_value){

        $data_to_return = $this->cache->get_cache_data($attr_code."_".$admin_value, $this->class);

        if ($data_to_return){
            return $data_to_return;
        }

        $all_options= $this->get_attribute_options($attr_code);

        foreach($all_options as $option_id => $data){

            if($admin_value==$data["label"]){
                $this->cache->set_cache_data($attr_code."_".$admin_value,$option_id, $this->class);
                return $option_id;
            }
        }
        return false;
    }
    
    
    public function get_attribute_options($attribute_code){

        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();

        $attribute = $this->_objectManager->create('\Magento\Catalog\Model\Product\Attribute\Repository');    
        $attribute = $attribute->get($attribute_code)->setStoreId(0);
        $data_to_return= [];
        foreach ($attribute->getOptions() as $option) {
            $db_value = $option->getValue();
            $db_label = $option->getLabel();
            $data_to_return[$db_value] = ['label'=>$db_label];
        }
        return $data_to_return;
    }
    
}