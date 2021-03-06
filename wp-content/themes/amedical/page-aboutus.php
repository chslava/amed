<?php
/*
Template Name: Aboutus
*/
get_header();

?>

<main class="ui container about-us page">

  <?php include_once('includes/parts/breadcrumbs.php');?>

  <div class="ui grid" id="about-us-text">
    <div class="ui row">
      <div class="sixteen wide mobile sixteen wide tablet six wide computer column">

        <h1 class="ui header left decored">
            <?php the_title(); ?>
            <div class="ui large sub header"><?php the_field("tagline"); ?></div>
        </h1>
        <?php the_content(); ?>
      </div>
      <div class="sixteen wide mobile sixteen wide tablet ten wide computer column">
        <?php the_post_thumbnail("side-content-image",array("class"=>'ui shadowed image','id' => "about-image")) ?>
      </div>
    </div>
  </div>
</main>

<?php if (have_rows("service_items")):?>
  <section class="secondary-services">
    <div class="ui container" >
      <h2 class="centered ui header" id="service-directions">
        <?php the_field("service_block_title"); ?>
      </h2>
      <div class="ui relaxed grid">
          <?php $services_icons = ["computer.png","cog.png","house.png","shield.png"]; ?>
          <?php $counter=0; ?>
        <?php while (have_rows("service_items")): the_row(); ?>
          <div class="sixteen wide mobile eight wide tablet four wide computer column">

              <img class="image-icon icon-shield" src="<?= get_template_directory_uri(); ?>/img/<?= $services_icons[$counter] ?>">
          
            <p class="content"><?php the_sub_field("service_title"); ?></p>
          </div>
            <?php $counter++ ?>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
<?php endif; ?>



<?php if (have_rows("missinon_items")):?>
  <section class="benefits very padded">
  <div class="ui container">
  <div class="sixteen wide column">
  <h2 class="ui header centered decored">
      <?php the_field("mission_title"); ?>
  </h2>
  <?php while (have_rows("missinon_items")): the_row(); ?>
      <div class="sixteen wide mobile eight wide tablet four wide computer column">
        <p class="content"><em><?php the_sub_field("mission_title"); ?>:</em> <?php the_sub_field("mission_text"); ?></p>
      </div>
    <?php endwhile; ?>
    </div>
    </div>
    </section>
<?php endif; ?>




<?php if (have_rows("key_point_items")):?>
    <section class="services" id="about-services">
      <div class="ui container">
        <div class="ui center aligned grid">
          <?php while(have_rows("key_point_items")): the_row(); ?>

            <div class="sixteen wide mobile sixteen wide tablet five wide computer center aligned column">
                <div class="icon-title">
                  <div class="service-icon <?php the_sub_field("key_point_icon"); ?>"></div>
                </div>
                <p><?php the_sub_field("key_point_text"); ?></p>
            </div>

          <?php endwhile; ?>
        </div>
      </div>
    </section>
<?php endif; ?>




<section class="coo-respose">
  <div class="ui container">
    <div class="ui grid">
      <div class="sixteen wide mobile ten wide tablet eight wide computer column right floated column">
        <h2 class="ui left header decored">
          <?php the_field("corp_resp_title"); ?>
        </h2>
        <?php the_field("corp_resp_text"); ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>