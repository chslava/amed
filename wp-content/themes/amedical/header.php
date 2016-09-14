<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<?php include('includes/parts/head_common.php'); ?>
	</head>
	<body <?php body_class(); ?>>

	<nav class="mobile-menu">

    				<div class="menu-toggle">
    					<span></span>
    					<span></span>
    					<span></span>
    				</div>

    				<?php wp_nav_menu(array('theme_location' => 'main-menu', 'menu_id' => 'mobile-menu', 'menu_class' => 'navigation-mobile', 'walker' => new Mobile_Menu_walker())); ?>
    </nav>

	<header>
			<div class="language-switcher">
    			<?php dswp_print_language_menu(); ?>
    		</div>

			<div class="row column">

					<div class="text-center">
					<a href="<?php echo esc_url(home_url()); ?>" class="logo">
							<img src="<?php echo get_stylesheet_directory_uri().'/images/logo.svg'; ?>"
									 alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
					</a>
					<h1>Digital Score Wordpress Framework</h1>
					</div>

					<?php wp_nav_menu(array('theme_location' => 'main-menu','menu_id' => 'main-menu','menu_class' => 'navigation-primary')); ?>
			</div>
	</header>

		<div class="content-wrapper">

    <?php include('includes/parts/breadcrumbs.php'); ?>
