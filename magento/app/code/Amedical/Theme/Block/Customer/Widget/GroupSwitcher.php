<?php

namespace Amedical\Theme\Block\Customer\Widget;


use Amedical\Theme\Helper\Data;

class GroupSwitcher extends \Magento\Framework\View\Element\Template
{
    /**
     * @var array
     */
    protected $jsLayout;

    /**
     * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
     */
    protected $layoutProcessors;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $layoutProcessors = [],
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->layoutProcessors = $layoutProcessors;
    }

    /**

     * @return string

     */
    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }
}