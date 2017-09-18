<?php

namespace Amedical\Theme\Plugin\Quote;

class ShippingAddressManagement
{

    protected $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function beforeAssign(
        \Magento\Quote\Model\ShippingAddressManagement $subject,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $address
    ) {

        $extAttributes = $address->getExtensionAttributes();
        if (!empty($extAttributes)) {

            try {
                $address->setBankName($extAttributes->getBankName());
                $address->setBankAccount($extAttributes->getBankAccount());
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }

        }

    }
}