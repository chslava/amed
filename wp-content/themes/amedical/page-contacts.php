<?php
/*
Template Name: Contacts
*/
get_header();

?>

<main class="contacts">
  <div class="ui container vertically divided grid">
    <div class="five wide column">
      <div class="ui breadcrumb"><a class="section" href="index.html">Sākums</a>
        <div class="divider">//</div>
        <div class="active section">Kontakti</div>
      </div>
      <h1>Kontakti</h1>
      <p>Adrese: Varkaļu iela 13A, Rīga, Latvija, LV-1067</p>
      <p>Tālrunis: 66103003, 20277153</p>
      <p>Fakss: 66103010</p>
      <p>E-pasts: info@amedical.eu</p>
      <p>Darba laiks: 8:30 - 17:30</p>
      <div class="ui divider"></div>
      <h1>Rekvizīti</h1>
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
    <div class="two column row">
      <div class="column">
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
      <div class="column"><img class="ui shadowed image" src="<?php echo get_stylesheet_directory_uri() ;?>/img/contact-us.jpg"></div>
    </div>
  </div>
</section>
<section class="subscribe">
  <div class="ui container">
    <form class="ui form">
      <div class="ui centered relaxed grid">
        <h4 class="ui header">Pieteikties Jaunumiem</h4>
        <input class="subscribe ui input" placeholder="Ievadi savu e-pastu">
        <button class="ui primary button">Pieteikties</button>
      </div>
    </form>
  </div>
</section>

<?php get_footer(); ?>
