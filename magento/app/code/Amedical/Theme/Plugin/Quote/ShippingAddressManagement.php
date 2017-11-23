<?php

namespace Amedical\Theme\Plugin\Quote;

class ShippingAddressManagement
{

    protected $logger;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        $this->logger = $logger;
        $this->quoteRepository = $quoteRepository;
    }

    public function beforeAssign(
        \Magento\Quote\Model\ShippingAddressManagement $subject,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $address
    ) {

        $extAttributes = $address->getExtensionAttributes();
        if (!empty($extAttributes)) {

            try {
                /** @var \Magento\Quote\Model\Quote $quote */
                $quote = $this->quoteRepository->get($cartId);

                $address->setBankName($extAttributes->getBankName());
                $address->setBankAccount($extAttributes->getBankAccount());
                $address->setCompany($extAttributes->getCustomerCompany());

                $quote->getExtensionAttributes()->setCustomerGroupAssign($extAttributes->getCustomerGroupAssign());
                $quote->getExtensionAttributes()->setCustomerPositionOccupation($extAttributes->getCustomerPositionOccupation());
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }

        }

    }
}