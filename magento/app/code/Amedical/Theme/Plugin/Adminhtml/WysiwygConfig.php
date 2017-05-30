<?php
namespace Amedical\Theme\Plugin\Adminhtml;

class WysiwygConfig {
    public function afterGetConfig($subject, \Magento\Framework\DataObject $config)
    {
        $styleArray = [
            'Amedical-List-Square' => 'list-style-square'
        ];

        $styles = array_map(function($title, $class) {
            return "{$title}={$class} ";
        }, array_keys($styleArray), array_values($styleArray));

        $config->addData(["settings" => ["theme_advanced_styles" => implode("; ", $styles)]]);

        return $config;
    }
}