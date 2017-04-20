<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 20.04.17
 * Time: 13:02
 */

namespace Amedical\Theme\Plugin\Block;


use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;

    public function __construct(
        NodeFactory $nodeFactory
    ) {
        $this->nodeFactory = $nodeFactory;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray(),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    protected function getNodeAsArray()
    {
        return [
            'name' => __('Custom Item'),
            'id' => 'custom-menu-id',
            'url' => 'http://www.example.com/',
            'has_active' => false,
            'is_active' => false // (expression to determine if menu item is selected or not)
        ];
    }
}