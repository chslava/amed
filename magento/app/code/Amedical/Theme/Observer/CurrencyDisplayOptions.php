<?php

namespace Amedical\Theme\Observer;

use Magento\Framework\Event\ObserverInterface;

class CurrencyDisplayOptions implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $currencyOptions = $observer->getEvent()->getCurrencyOptions();

        $currencyOptions->setData('position', \Magento\Framework\Currency::RIGHT);

        return $this;
    }
}