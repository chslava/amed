<?php


namespace DS\PopularityByViews\Controller\Add;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{

    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        parent::__construct($context);
    }


    private function addViewCount($pid){

        //$productRepository = $this->_objectManager->create('\Magento\Catalog\Model\ProductRepository');
        $p = $this->_objectManager->create('\Magento\Catalog\Model\Product');
        $p->load($pid);

        $views = 0;

        if ($p){
            try {
                $views = $p->getViewCounter();
                $views ++;
                $p->setViewCounter($views);
                $p->save();

            } catch (\Exception $e) {
                $views = -1;
            }
        } else {
            $views = -2;
        }

        return $views;

    }

    public function execute()
    {
        $views = 0;
        $pid = $this->getRequest()->getPostValue("pid");
        if (is_numeric($pid)){
            $views = $this->addViewCount($pid);
        } else {
            $views = -3;
        }
        print($views);
        die();
    }

}