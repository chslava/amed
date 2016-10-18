<div class="two column row">

    <div class="left aligned column">
        <a href="<?php echo home_url('/'); ?>" class="logo">
            <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/logo.png" alt="<?php print(get_bloginfo( 'name' )); ?>" title="<?php print(get_bloginfo( 'name' )); ?>">
        </a>
    </div>

    <div class="right aligned column">
        <div class="item computer-search">
            <form id="search-tablet-form" action="<?php the_field("search_url","option"); ?>" method="GET">
                <div class="ui icon input search">
                    <input name="search" placeholder="<?php _e("Search","amedical"); ?>"><i class="search icon"></i>
                </div>
            </form>
        </div><a class="mob-toogle-menu" href="#"><i class="icon-mob-toogle-open"></i></a>
    </div>
</div>