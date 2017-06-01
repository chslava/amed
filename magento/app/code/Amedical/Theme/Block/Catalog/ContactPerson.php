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
        return $this->_registry->registry('product');
    }

    public function getProductCategoryContacts ()
    {
        $contacts = false;
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory) {
            $contacts = $this->_getCategoryContacts($currentCategory);
        }

        if ( (!isset($contacts['name']) || !isset($contacts['phone'])) && $this->getProduct()) {
            $cats = $this->getProduct()->getCategoryIds();
            usort($cats, function ($a,$b){return ($a > $b) ? -1 : 1;});
            if (count($cats)) {
                foreach ($cats as $categoryId) {
                    $category = $this->_categoryFactory->create()->load($categoryId);
                    $contacts = $this->_searchCategoryContacts($category);
                    if (is_array($contacts)) { break; }
                }
            }
        }

        return $contacts;
    }

    protected function _searchCategoryContacts(\Magento\Catalog\Api\Data\CategoryInterface $category)
    {
        $contacts = $this->_getCategoryContacts($category);
        if (!$contacts) {
            $contacts = $this->_getParentCategoryContacts($category);
        }

        return $contacts;
    }

    protected function _getCategoryContacts (\Magento\Catalog\Api\Data\CategoryInterface $category)
    {
        $contacts = false;

        if ($category->getContactPersonName() && $category->getContactPersonPhone()) {
            $contacts = ['name' => $category->getContactPersonName(), 'phone' => $category->getContactPersonPhone()];
        }

        return $contacts;
    }

    protected function _getParentCategoryContacts (\Magento\Catalog\Api\Data\CategoryInterface $category)
    {
        $contacts = false;
        $parent = $category->getParentCategory();

        if ($parent && $parent->getId() >= 2) {
            $contacts = $this->_getCategoryContacts($parent);

            if (!$contacts) {
                $contacts = $this->_getParentCategoryContacts($parent);
            }
        }

        return $contacts;
    }
}