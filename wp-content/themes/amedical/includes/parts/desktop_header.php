<div class="main-logo">
    <a href="<?php echo home_url('/'); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/logo.png" alt="<?php print(get_bloginfo( 'name' )); ?>" title="<?php print(get_bloginfo( 'name' )); ?>">
    </a>
</div>
<div class="ui container fluid main-column">
    <div class="mob-menu" style="display:none">
        <div class="ui computer vertically reversed grid">
            <div class="ui text menu lang">
                <?php $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0, 'link_empty_to' => get_home_url() ) ); ?>
                <?php foreach($languages as $key=> $lang): ?>
                    <a class="item <?php if ($lang["active"]):?>active<?php endif;?>" href="<?php print($lang['url']); ?>">
                        <?php print(strtoupper($lang['language_code'])); ?>
                    </a>
                <?php endforeach; ?>

                <div class="right menu">
                    <a class="ui basic small button" href="<?php the_field("login_url","option"); ?>">
                        <?php _e("Login","amedical"); ?>
                    </a>
                </div>

            </div>
            <div class="row">
                <nav class="ui secondary stackable menu main-menu">

                    <a class="item home" href="<?php echo home_url('/'); ?>"><span><?php print(get_bloginfo( 'name' )); ?></span><i class="icon-home-icon"></i></a>
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
            <div class="row">

                <div class="ui secondary text stackable menu top-menu">
                    <div class="item computer-search">
                            <div class="ui icon input search">
                                <form id="search-form" method="get" action="<?php the_field("search_url","option"); ?>">
                                    <input name="search" placeholder="<?php _e("Search","amedical"); ?>">
                                    <i class="search icon"></i>
                                </form>
                            </div>
                    </div>
                    <?php print_menu("top-m","",1,0,"","SimpleLinks"); ?>
                </div>

            </div>
        </div>
    </div>
</div>