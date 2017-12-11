<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Amedical\Theme\Model\Checkout;

use Braintree\Exception;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\Api\SimpleDataObjectConverter;
/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class GuestPaymentInformationManagement extends \Magento\Checkout\Model\GuestPaymentInformationManagement
implements \Amedical\Theme\Api\GuestPaymentInformationManagementInterface
{
    /** @var \Magento\Sales\Api\Data\OrderInterface $order **/
    protected $_order;
    protected $_customAttributes = ['customer_position_occupation', 'customer_group_assign'];
    protected $logger;

    /**
     * @param \Magento\Quote\Api\GuestBillingAddressManagementInterface $billingAddressManagement
     * @param \Magento\Quote\Api\GuestPaymentMethodManagementInterface $paymentMethodManagement
     * @param \Magento\Quote\Api\GuestCartManagementInterface $cartManagement
     * @param \Magento\Checkout\Api\PaymentInformationManagementInterface $paymentInformationManagement
     * @param \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory
     * @param CartRepositoryInterface $cartRepository
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param \Psr\Log\LoggerInterface $logger
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Quote\Api\GuestBillingAddressManagementInterface $billingAddressManagement,
        \Magento\Quote\Api\GuestPaymentMethodManagementInterface $paymentMethodManagement,
        \Magento\Quote\Api\GuestCartManagementInterface $cartManagement,
        \Magento\Checkout\Api\PaymentInformationManagementInterface $paymentInformationManagement,
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory,
        CartRepositoryInterface $cartRepository,
        \Magento\Sales\Api\Data\OrderInterface $order,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($billingAddressManagement,
        $paymentMethodManagement,
        $cartManagement,
        $paymentInformationManagement,
        $quoteIdMaskFactory,
        $cartRepository);
        $this->_order = $order;
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function saveAdditionalPaymentInformationAndPlaceOrder(
        $cartId,
        $email,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null,
        $customAttributes = []
    )
    {
        $orderId = parent::savePaymentInformationAndPlaceOrder( $cartId, $email, $paymentMethod, $billingAddress);
        $order = $this->_order->load($orderId);

        if($order->getId()) {

            $shouldSaveOrder = false;

            foreach($this->_customAttributes as $attribute) {
                if(isset($customAttributes[$attribute])) {
                    $setter = 'set' . SimpleDataObjectConverter::snakeCaseToUpperCamelCase($attribute);
                    try {
                        call_user_func_array([$order, $setter],[$customAttributes[$attribute]]);
                        $shouldSaveOrder = true;
                    } catch (\Exception $e) {
                        $this->logger->critical($e->getMessage());
                    }

                }
            }

            if($shouldSaveOrder) {
                $order->save();
            }
        }

        return $orderId;
    }
}
