<?php

namespace Amedical\Theme\Plugin\Quote;

class BillingAddressManagement
{
    protected $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function beforeAssign(
        \Magento\Quote\Model\BillingAddressManagement $subject,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $address,
        $useForShipping = false
    ) {
        $extAttributes = $address->getExtensionAttributes();
        if (!empty($extAttributes)) {

            try {
                $address->setBankName($extAttributes->getBankName());
                $address->setBankAccount($extAttributes->getBankAccount());
                $address->setCompany($extAttributes->getCustomerCompany());
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }
}