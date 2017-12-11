<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Amedical\Theme\Api;

/**
 * Interface PaymentMethodInterface
 * @api
 * @since 100.0.2
 */
interface GuestPaymentInformationManagementInterface extends \Magento\Checkout\Api\GuestPaymentInformationManagementInterface
{
    /**
     * Set payment information and place order for a specified cart.
     *
     * @param string $cartId
     * @param string $email
     * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
     * @param \Magento\Quote\Api\Data\AddressInterface|null $billingAddress
     * @param string[] $customAttributes
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return int Order ID.
     */
    public function saveAdditionalPaymentInformationAndPlaceOrder(
        $cartId,
        $email,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null,
        $customAttributes = []
    );
}
