<?php
namespace Amedical\Theme\Plugin\Adminhtml;

class WysiwygConfig {

    protected $_assetRepo;

    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo
    ) {
        $this->_assetRepo = $assetRepo;
    }

    public function afterGetConfig($subject, \Magento\Framework\DataObject $config)
    {
        $styleArray = [
            'Amedical-List-Square' => 'list-style-square',
            'Amedical-Image-Left' => 'am-image-left',
            'Amedical-Image-Right' => 'am-image-right'
        ];

        $styles = array_map(function($title, $class) {
            return "{$title}={$class} ";
        }, array_keys($styleArray), array_values($styleArray));

        $config->addData(["settings" => ["theme_advanced_styles" => implode("; ", $styles)]]);
        $config->setData('content_css', $this->_assetRepo->getUrl('Amedical_Theme/css/wysiwyg/content.css'));

        return $config;
    }
}