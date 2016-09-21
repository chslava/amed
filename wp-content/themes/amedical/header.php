<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<?php include('includes/parts/head_common.php'); ?>
	</head>
	<body <?php body_class(); ?>>
        <header>

            <?php include("includes/parts/mobile_logo_search.php"); ?>
           
            <div class="ui container grid">
                <div class="main-logo">
                    <a href="<?php home_url(); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/logo.png" alt="<?php print(get_bloginfo( 'name' )); ?>" title="<?php print(get_bloginfo( 'name' )); ?>">
                    </a>
                </div>
                <div class="main-column">
                    <div class="ui container computer vertically reversed grid mob-menu" style="display:none">
                        <div class="row">
                            <div class="sixteen wide column">
                                <div class="ui small text menu four item lang">

                                    <?php $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0, 'link_empty_to' => get_home_url() ) ); ?>
                                    <?php foreach($languages as $key=> $lang): ?>
                                        <a class="item <?php if ($lang["active"]):?>active<?php endif;?>" href="<?php print($lang['url']); ?>">
                                            <?php print(strtoupper($lang['language_code'])); ?>
                                        </a>
                                    <?php endforeach; ?>


                                    <div class="item auth">
                                        <a href="<?php the_field("login_url","option"); ?>">
                                            <span class="ui basic small button"><?php _e("Login","amedical"); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="main-menu">
                                <nav class="ui secondary stackable menu">
                                    <a class="item home" href="<?php home_url(); ?>"><span><?php print(get_bloginfo( 'name' )); ?></span><i class="icon-home-icon"></i></a>

                                    <?php $menu_items = get_menu_items("main-m"); ?>

                                    <?php foreach($menu_items as $item):?>

                                        <?php if (isset($item["children"]) && count($item["children"])>0):?>
                                            <div class="ui dropdown item">
                                                <?php print($item["item"]->title); ?>
                                                <div class="menu">
                                                    <?php foreach($item["children"] as $child): ?>
                                                        <a class="item" href="<?php print($child->url); ?>"><?php print($child->title);?></a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a class="item" href="<?php print($item["item"]->url); ?>"><?php print($item["item"]->title); ?></a>
                                        <?php endif; ?>
                                    <?php endforeach;?>

                                    <div class="right menu basket">
                                        <a class="item" href="<?php the_field("cart_url","option"); ?>">
                                            <i class="icon-basket-icon"></i><span><?php _e("Cart","amedical"); ?><!--<b>22</b>--></span>
                                        </a>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <!--top row of menu --->


                        <div class="row">
                            <form method="get" action="<?php the_field("search_url","option"); ?>">
                            <div class="ui secondary text stackable menu top-menu">

                                <div class="item computer-search">
                                    <div class="ui icon input search">

                                            <input name="search" placeholder="<?php _e("Search","amedical"); ?>">
                                            <i class="search icon"></i>


                                    </div>
                                </div>


                                <?php print_menu("top-m","",1,0,"","SimpleLinks"); ?>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>