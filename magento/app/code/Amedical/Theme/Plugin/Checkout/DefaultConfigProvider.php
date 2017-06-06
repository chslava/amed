<?php

namespace Amedical\Theme\Plugin\Checkout;

use \Magento\Store\Model\StoreManagerInterface;

class DefaultConfigProvider
{
    protected $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    public function afterGetConfig(\Magento\Checkout\Model\DefaultConfigProvider $subject, $output)
    {
        $output['storeBaseUrl'] = $this->storeManager->getStore()->getBaseUrl();

        return $output;
    }
}