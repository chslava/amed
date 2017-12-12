<?php

namespace Amedical\Theme\Plugin\Checkout;


class CreateAccount
{
    protected $logger;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        $this->customerFactory = $customerFactory;
    }

    public function afterCreate(\Magento\Sales\Model\Order\CustomerManagement $subject, $customerData, $orderId)
    {
        $order = $this->orderRepository->get($orderId);
        $customer = $this->customerFactory->create();

        if($order->getId()) {
            $customerData->setCustomAttribute('position_occupation', $order->getCustomerPositionOccupation());
            $customerData->setGroupId($order->getCustomerGroupAssign());

            $orderBillingAddress = $order->getBillingAddress();
            $customerData->setCustomAttribute('company', $orderBillingAddress->getCompany());
            $customer->updateData($customerData);
            $customer->save();
        }
    }
}