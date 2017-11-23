<?php

namespace Amedical\Theme\Observer\Checkout;

use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\Exception\LocalizedException;
class SaveAdditionalFields implements ObserverInterface
{
    /**
     * @var \Magento\Sales\Api\OrderAddressRepositoryInterface
     */
    protected $orderAddressRepository;
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @param \Magento\Sales\Api\OrderAddressRepositoryInterface $orderAddressRepository
     */
    public function __construct(
        \Magento\Sales\Api\OrderAddressRepositoryInterface $orderAddressRepository,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    ) {
        $this->orderAddressRepository = $orderAddressRepository;
        $this->orderRepository = $orderRepository;
    }
    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $orderInstance */
        $orderInstance = $observer->getEvent()->getOrder();

        /** @var \Magento\Quote\Model\Quote $quoteInstance */
        $quoteInstance = $observer->getEvent()->getQuote();

        $quoteShippingAddress = $quoteInstance->getShippingAddress();
        $quoteBillingAddress = $quoteInstance->getBillingAddress();
        $orderShippingAddress = $orderInstance->getShippingAddress();
        $orderBillingAddress = $orderInstance->getBillingAddress();

        $quoteExtAttributes = $quoteInstance->getExtensionAttributes();
        if (!empty($quoteExtAttributes)) {
            $orderInstance->setCustomerGroupAssign($quoteExtAttributes->getCustomerGroupAssign());
            $orderInstance->setCustomerPositionOccupation($quoteExtAttributes->getCustomerPositionOccupation());
        }
        if ($orderShippingAddress !== null && $quoteShippingAddress !== null) {
            $orderShippingAddress->addData([
                'bank_name' => $quoteShippingAddress->getData('bank_name'),
                'bank_account' => $quoteShippingAddress->getData('bank_account')
            ]);
        }
        if ($orderBillingAddress !== null && $quoteBillingAddress !== null) {
            $orderBillingAddress->addData([
                'bank_name' => $quoteBillingAddress->getData('bank_name'),
                'bank_account' => $quoteBillingAddress->getData('bank_account')
            ]);
        }
        try
        {
            $this->orderRepository->save($orderInstance);
            if ($orderShippingAddress !== null) {
                $this->orderAddressRepository->save($orderShippingAddress);
            }
            if ($orderBillingAddress !== null) {
                $this->orderAddressRepository->save($orderBillingAddress);
            }
        }
        catch (\Exception $e)
        {
            throw new LocalizedException(__('Something went wrong while saving additional fields to order addresses'));
        }
    }
}