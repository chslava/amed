<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 20.04.17
 * Time: 13:02
 */

namespace Amedical\Theme\Plugin\Catalog\Helper;


use \Magento\Framework\App\Config\ScopeConfigInterface;

class Output
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Format weight attribute output on frontend
     *
     * @param \Magento\Catalog\Helper\Output $subject
     * @param $method
     * @param $result
     * @param $params
     * @return array
     */
    public function beforeProcess(
        \Magento\Catalog\Helper\Output $subject,
        $method,
        $result,
        $params
    )
    {
        if (isset($params['attribute']) && $params['attribute'] === 'weight') {
            $weightUnit = $this->scopeConfig->getValue('general/locale/weight_unit', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $result = number_format((float)$result, 2) . ' ' . $weightUnit;
        }
        return array($method, $result, $params);
    }
}