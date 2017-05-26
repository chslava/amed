<?php
namespace DS\Hanza\Block;

class Tests extends \Magento\Framework\View\Element\Template
{

    public function getAbsoluteMediaPath() {
        /*    /** @var \Magento\Framework\App\ObjectManager $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\Filesystem $filesystem */
        $filesystem = $om->get('Magento\Framework\Filesystem');
        /** @var \Magento\Framework\Filesystem\Directory\ReadInterface|\Magento\Framework\Filesystem\Directory\Read $reader */
        $reader = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        return $reader->getAbsolutePath();
    }

    public function getTitle()
    {
        return 'Tests';
    }

}