<?php

// Various clean up functions
// Removing some items
 require_once('includes/cleanup.php');

// Enqueue scripts
// what scripts should be imported
 require_once('includes/enqueue-scripts.php');

// Image settings goes here
 require_once('includes/theme-support.php');

//Register options
 require_once('includes/option_pages.php');

// Widgets should be registred here
 require_once('includes/widget-areas.php');

// Menus goes here
 require_once('includes/navigation.php');

 // WPML lang menu
  require_once('includes/wpml-lang-menu.php');

// Menu walker for custom menu structures
 require_once('includes/menu-walker.php');

// Gravity forms split in columns http://stackoverflow.com/questions/26308742/gravity-forms-columns-side-by-side
 require_once('includes/gravity-forms-columns.php');

 // Add post types
  require_once('includes/post_types/slider.php');
