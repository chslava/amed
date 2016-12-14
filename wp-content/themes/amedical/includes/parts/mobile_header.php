<div class="two column row">

    <div class="left aligned column">
        <a href="<?php echo home_url('/'); ?>" class="logo">
            <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/logo.png" alt="<?php print(get_bloginfo( 'name' )); ?>" title="<?php print(get_bloginfo( 'name' )); ?>">
        </a>
    </div>

    <div class="right aligned column">
        <a class="mob-toogle-menu" href="#">
            <i class="icon-mob-toogle-open"></i>
        </a><a class="mob-search" href="#"><i class="search icon"></i></a></div>
</div>
<div class="one column row search-row" style="display:none">
    <div class="column">
        <form
            id="mobile-search"
            class="ui large form"
            action="<?php the_field("search_url","option"); ?>" method="GET">
            <div class="field">
                <input name="search" placeholder="<?php _e("Search","amedical"); ?>">
            </div>
        </form>
    </div>
</div>


