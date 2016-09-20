<section class="subscribe">
    <div class="ui container">
        <form class="ui form">
            <div class="ui centered relaxed grid">
                <div class="title"><?php the_field("newsletter_title","option"); ?></div>
                <input class="subscribe ui input" placeholder="<?php the_field("newsletter_placeholder","option"); ?>">
                <button class="ui primary button"><?php the_field("newsletter_cta_button","option"); ?></button>
            </div>
        </form>
    </div>
</section>