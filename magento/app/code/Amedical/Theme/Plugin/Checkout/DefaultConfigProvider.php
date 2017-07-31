<?php

namespace Amedical\Theme\Plugin\Checkout;

use \Magento\Store\Model\StoreManagerInterface;

class DefaultConfigProvider
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Parent layout of the block
     *
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        StoreManagerInterface $storeManager
    ) {
        $this->_layout = $context->getLayout();
        $this->storeManager = $storeManager;
    }

    public function afterGetConfig(\Magento\Checkout\Model\DefaultConfigProvider $subject, $output)
    {
        $cmsBlockIdentifier = 'cart_sidebar_bottom';

        $output['storeBaseUrl'] = $this->storeManager->getStore()->getBaseUrl();

        try {
            $content = $this->_layout->createBlock('Magento\Cms\Block\Block')->setBlockId($cmsBlockIdentifier)->toHtml();
        } catch (LocalizedException $e) {
            $content = "";
        }

        $output['cmsBlockContent'] = $content;

        return $output;
    }
}