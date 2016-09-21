<?php
/*
Template Name: Aboutus
*/
get_header();

?>

<main class="ui container about-us page">
  <?php include_once('includes/parts/breadcrumbs.php');?>
  <div class="ui grid">
    <div class="ui row">
      <div class="sixteen wide mobile eight wide tablet six wide computer column">
        <h1 class="ui header left decored"><?php the_title(); ?>
          <div class="ui large sub header"><?php the_field("tagline"); ?></div>
        </h1>
        <?php the_content(); ?>
      </div>
      <div class="sixteen wide mobile eight wide tablet ten wide computer column">
        <?php the_post_thumbnail("side-content-image",array("class"=>'ui shadowed image')) ?>
      </div>
    </div>
  </div>
</main>

<?php if (have_rows("service_items")):?>
  <section class="secondary-services">
    <div class="ui container">
      <h2 class="centered ui header"><?php the_field("searvice_block_title"); ?></h2>
      <div class="ui relaxed grid">
        <?php while (have_rows("service_items")): the_row(); ?>
          <div class="sixteen wide mobile eight wide tablet four wide computer column">
          <span class="circle-check">
            <i class="icon-check-icon"></i>
          </span>
            <p class="content"><?php the_sub_field("service_title"); ?></p>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
<?php endif; ?>



<?php if (have_rows("missinon_items")):?>
  <section class="benefits very padded">
  <div class="ui relaxed grid container">
  <div class="sixteen wide column">
  <h2 class="ui header centered decored"><?php the_field("mission_title"); ?></h2>
  <?php while (have_rows("missinon_items")): the_row(); ?>
      <div class="sixteen wide mobile eight wide tablet four wide computer column">
        <p class="content"><?php the_sub_field("mission_title"); ?>: <?php the_sub_field("mission_text"); ?></p>
      </div>
    <?php endwhile; ?>
    </div>
    </div>
    </section>
<?php endif; ?>




<?php if (have_rows("key_point_items")):?>
    <section class="services">
      <div class="ui container">
        <div class="ui center aligned grid">
          <?php while(have_rows("key_point_items")): the_row(); ?>

            <div class="sixteen wide mobile five wide tablet five wide computer center aligned column">
              <div class="icon-title">
                <div class="service-icon <?php the_sub_field("key_point_icon"); ?>"></div>
              </div>
              <p>
                <?php the_sub_field("key_point_text"); ?></p>
            </div>

          <?php endwhile; ?>
        </div>
      </div>
    </section>
<?php endif; ?>




<section class="coo-respose">
  <div class="ui container grid">
    <div class="ui row">
      <div class="sixteen wide mobile eight wide tablet eight wide computer column right floated column">
        <h2 class="ui left header decored">
          <?php the_field("corp_resp_title"); ?>
        </h2>
        <?php the_field("corp_resp_text"); ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>