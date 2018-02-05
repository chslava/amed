<?php

    namespace DS\PopularityByViews\Block;

   class Popularity extends \Magento\Framework\View\Element\Template
   {
       public function __construct(
           \Magento\Framework\View\Element\Template\Context $context,
           array $data = []
       ) {
           parent::__construct($context, $data);
       }

   }