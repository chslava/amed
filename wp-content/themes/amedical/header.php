<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<?php include('includes/parts/head_common.php'); ?>
	</head>
	<body <?php body_class(); ?>>
<header>
  <div class="ui container relaxed grid">
    <div class="ui two wide column"><a class="logo" href="index.html"><img src="<?php echo get_stylesheet_directory_uri() ;?>/img/logo.png"></a></div>
    <div class="ui fourteen wide column">
      <div class="ui text menu">
        <div class="left menu">
          <div class="item">
            <div class="ui icon input search">
              <input placeholder="Meklēt"><i class="search icon"></i>
            </div>
          </div>
					<?php top_menu(); ?>
					<!-- <a class="item" href="content.html">Jaunumi</a><a class="item" href="#">Blogs</a><a class="item" href="#">Biežāk uzdotie jautājumi</a><a class="item" href="about-us.html">Par mums</a><a class="item" href="contact-us.html">Kontakti</a> -->
        </div>
        <div class="right menu lang"><a class="item active" href="#">LV</a><a class="item" href="#">EN</a><a class="item" href="#">RU</a></div>
        <div class="right menu auth"><a href="#"><span class="ui basic small button">Autorizācija</span></a></div>
      </div>
      <nav class="ui secondary menu"><a class="item" href="index.html"><i class="icon-home-icon"></i></a><a class="item" href="content.html">Medicīnas iekārtas</a>
        <div class="ui simple dropdown item">Medicīnas preces
          <div class="menu"><a class="item" href="#">Medicīnas preces</a><a class="item" href="#">Instrumenti un aprīkojums</a></div>
        </div><a class="item" href="#">Apģērbi un aizsarglīdzekļi</a><a class="item" href="projects.html">Projektēšana</a><a class="item" href="services.html">Iekārtu serviss</a>
        <div class="right menu auth"><a href="#"><i class="icon-basket-icon"></i><span>Grozs</span></a></div>
      </nav>
    </div>
  </div>
</header>
