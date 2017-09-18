<?php

namespace Amedical\Theme\Plugin\Quote;

use Magento\Customer\Model\Address\AddressModelInterface;
use Magento\Customer\Api\Data\AddressInterface;

class AddressUpdate
{
    public function beforeUpdateData (AddressModelInterface $subject, AddressInterface $address)
    {
        $customAttributesMethods = ['bank_name' => 'getBankName', 'bank_account' => 'getBankAccount'];

        foreach($customAttributesMethods as $code => $method) {
            if($address->$method()) {
                $subject->setData($code, $address->$method());
            }
        }
    }
}