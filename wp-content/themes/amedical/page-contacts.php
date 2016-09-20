<?php
/*
Template Name: Contacts
*/
get_header();

?>

<main class="contacts">
  <div class="ui container vertically divided grid">
    <div class="sixteen wide mobile eight wide tablet five wide computer column">

      <?php include_once('includes/parts/breadcrumbs.php');?>

      <h1 class="ui header"><?php the_title(); ?></h1>

      gf<div class="ui divider"></div>
      <h2 class="ui header">Rekvizīti</h2>
      <p>SIA "A.Medical"
        PVN reģ. Nr. LV 40103599415
        Varkaļu iela 13A, Rīga, Latvija, LV-1067
      </p>
      <p>A/S „Swedbank”
        Konts: LV25HABA0551034365891
        Kods: HABALV22
      </p>
    </div>
  </div>
  <div class="info"></div>
  <div class="map contact-map" data-lat="56.940" data-lng="24.070"></div>
</main>
<section class="contact-form">
  <div class="ui container grid">
    <div class="ui row">
      <div class="sixteen wide mobile eight wide tablet eight wide computer column">
        <h2 class="left ui header decored">Sazinies ar mums</h2>
        <form class="ui form">
          <div class="eight wide field">
            <label>Vārds un uzvārds</label>
            <input type="text">
          </div>
          <div class="eight wide field">
            <label>Uzņēmums</label>
            <input type="text">
          </div>
          <div class="eight wide field">
            <label>E-pasts</label>
            <input type="text">
          </div>
          <div class="eight wide field">
            <label>Tālrunis</label>
            <input type="text">
          </div>
          <div class="fourteen wide field">
            <label>Jūsu ziņa</label>
            <textarea></textarea>
          </div>
          <button class="ui huge primary button" type="submit">Nosūtīt</button>
        </form>
      </div>
      <div class="sixteen wide mobile eight wide tablet eight wide computer column"><img class="ui shadowed image" src="img/contact-us.jpg"></div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
