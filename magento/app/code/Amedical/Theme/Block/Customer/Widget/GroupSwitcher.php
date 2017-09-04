<?php

namespace Amedical\Theme\Block\Customer\Widget;


use Amedical\Theme\Helper\Data;

class GroupSwitcher extends \Magento\Framework\View\Element\Template
{

    private $_helper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Amedical\Theme\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context, array $data = [])
    {
        $this->_helper = $helper;
        parent::__construct($context, $data);
    }

    public function getLegalGroupId()
    {
        return $this->_helper->getConfig('amedical_theme/configuration/customer_legal_group_id');
    }
}