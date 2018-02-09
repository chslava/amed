<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 01.06.17
 * Time: 11:35
 */

namespace Amedical\Theme\Block\Catalog;

use Magento\Catalog\Model\Product;

class ContactPerson extends \Magento\Framework\View\Element\Template
{
    protected $_categoryFactory;
    protected $_registry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_categoryFactory = $categoryFactory;
        $this->_registry = $registry;
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        parent::__construct($context, $data);
    }


    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category');
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->_registry->registry('current_product');
    }

    public function getProductCategoryContacts ()
    {
        $contacts = false;

        $p = $this->getProduct();

        $contact_person = trim($p->getData("contact_person"));
        $contact_phone = trim($p->getData("contact_phone"));
        if (!empty($contact_person) && !empty($contact_phone)){
            return [
                'name' => $contact_person,
                'phone' => $contact_phone
            ];
        }



        $categories = $p->getCategoryIds();
        if(count($categories)){
            foreach($categories as $cId){
                $_cat_model = $this->_objectManager->create('\Magento\Catalog\Model\CategoryRepository');
                $c=$_cat_model->get($cId);
                $contact_person = trim($c->getData("contact_person_name"));
                $contact_phone = trim($c->getData("contact_person_phone"));
                if (!empty($contact_person) && !empty($contact_phone)){
                    return [
                        'name' => $contact_person,
                        'phone' => $contact_phone
                    ];
                }
                $contacts = $this->_getCategoryContacts($c->getParentId());
                if (is_array($contacts)){
                    return $contacts;
                }
            }
        }

        return $contacts;
    }


    private function _getCategoryContacts ($categoryId)
    {
        if ($categoryId>2){
            $_cat_model = $this->_objectManager->create('\Magento\Catalog\Model\CategoryRepository');
            $c=$_cat_model->get($categoryId);
            $contact_person = trim($c->getData("contact_person_name"));
            $contact_phone = trim($c->getData("contact_person_phone"));
            if (!empty($contact_person) && !empty($contact_phone)){
                return [
                    'name' => $contact_person,
                    'phone' => $contact_phone
                ];
            } else {
                return $this->_getCategoryContacts($c->getParentId());
            }

        } else {
            return false;
        }
    }
}