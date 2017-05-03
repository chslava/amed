<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 20.04.17
 * Time: 13:02
 */

namespace Amedical\Theme\Plugin\Block;


use Magento\Framework\Data\Tree\NodeFactory;
use \Magento\Store\Model\StoreManagerInterface;

class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;
    protected $storeManager;

    public function __construct(
        NodeFactory $nodeFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->storeManager = $storeManager;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $menu = $subject->getMenu();

        $node = $this->nodeFactory->create(
            [
                'data' => $this->_getNodeAsArray(),
                'idField' => 'id',
                'tree' => $menu->getTree()
            ]
        );

//        $menu->addChild($node);

        $hpRefNode = $this->nodeFactory->create(
            [
                'data' => $this->_getHomePageNodeAsArray(),
                'idField' => 'id',
                'tree' => $menu->getTree()
            ]
        );

        $this->_prependNode($hpRefNode, $menu);
    }

    protected function _getNodeAsArray()
    {
        return [
            'name' => __('Custom Item'),
            'id' => 'custom-menu-id',
            'url' => 'http://www.example.com/',
            'has_active' => false,
            'is_active' => false // (expression to determine if menu item is selected or not)
        ];
    }

    protected function _getHomePageNodeAsArray()
    {
        return [
            'name' => __('Home'),
            'id' => 'home-link',
            'url' => $this->storeManager->getStore()->getBaseUrl(),
            'has_active' => false,
            'is_active' => false // (expression to determine if menu item is selected or not)
        ];
    }

    protected function _prependNode(\Magento\Framework\Data\Tree\Node $node, \Magento\Framework\Data\Tree\Node $tree)
    {
        $nodes = unserialize(serialize($tree->getChildren()));

        foreach ($nodes as $_node) {
            $tree->removeChild($_node);
        }

        $tree->addChild($node);

        foreach ($nodes as $_node) {
            $tree->addChild($_node);
        }
    }
}