<?php

namespace Amedical\Theme\Observer\Customer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\App\RequestInterface;

class CustomerSetGroup implements ObserverInterface
{

    /**
     * @var RequestInterface
     */
    private $_request;

    /**
     * @var CustomerRepositoryInterface
     */
    private $_customerRepository;

    /**
     * @var GroupRepositoryInterface
     */
    private $_groupRepository;

    public function __construct(
        RequestInterface $request,
        CustomerRepositoryInterface $customerRepository,
        GroupRepositoryInterface $groupRepository
    )
    {
        $this->_request = $request;
        $this->_customerRepository = $customerRepository;
        $this->_groupRepository = $groupRepository;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){

        $customer = $observer->getEvent()->getCustomer();

        $group_id = (int)$this->_request->getParam('customer_group');

        if ($group_id && $this->_groupRepository->getById($group_id)->getId()) {
            $customer->setGroupId($group_id);

            $this->_customerRepository->save($customer);
        }
    }
}