<?php
/**
 * Data Model implementing the Address interface
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Amedical\Theme\Model\Customer\Data;

/**
 * Class Address
 *
 */
class Address extends \Magento\Customer\Model\Data\Address
{
    public function getBankName()
    {
        return $this->_get('bank_name');
    }

    public function getBankAccount()
    {
        return $this->_get('bank_account');
    }
}
