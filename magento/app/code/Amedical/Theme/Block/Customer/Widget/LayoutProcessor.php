<?php

namespace Amedical\Theme\Block\Customer\Widget;


class LayoutProcessor implements \Magento\Checkout\Block\Checkout\LayoutProcessorInterface
{
    /**
     * @var \Amedical\Theme\Helper\Data
     */
    private $_helper;

    /**
     * Constructor
     *
     * @param \Amedical\Theme\Helper\Data $helper
     */
    public function __construct(\Amedical\Theme\Helper\Data $helper)
    {
        $this->_helper = $helper;
    }

    /**
     * Process js Layout of block
     *
     * @param array $jsLayout
     * @return array
     */
    public function process($jsLayout)
    {
        if (!isset($jsLayout['components']['group-switcher']['config']['defaultGroup'])) {
            $jsLayout['components']['group-switcher']['config']['defaultGroup'] = $this->getLegalGroupId();
        }

        return $jsLayout;
    }

    public function getLegalGroupId()
    {
        return $this->_helper->getConfig('amedical_theme/configuration/customer_legal_group_id');
    }
}