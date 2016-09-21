<body <?php if ($content_change > 0) { echo 'onload="RotateBanners();"';} ?>>


<div id="outer">
    <div id="inner">
        <?php
        if ($content_change == 0) {
            echo '<div id="logo"><a href="' . $root_dir . $_GET["lang"] . '" title="' . $e[1] . '"><img src="' . $root_dir . '/images/a-medical-large.png" width="142" height="150" alt="' . $e[1] . '" /></a></div>';
        } else {
            if ($_SESSION['industry'] == 1) {
                echo '<div id="logo-industry"><a href="' . $root_dir . $_GET["lang"] . '" title="' . $e[1] . '"><img src="' . $root_dir . '/images/a-medical-industry.png" width="103" height="108" alt="' . $e[1] . '" /></a></div>';
            } else {
                echo '<div id="logo-equipment"><a href="' . $root_dir . $_GET["lang"] . '" title="' . $e[1] . '"><img src="' . $root_dir . '/images/a-medical-equipment.png" width="102" height="108" alt="' . $e[1] . '" /></a></div>';
            }
        }
        ?>


        <div id="menu">
            <?php
            $top_menu = array();
            $r = mysqli_query($result_db, "Select * from $tabula where parent_id='0' and publish='on' and lang='$_GET[lang]' and type = '1' order by place asc");
            $i = 0;
            while ($f = mysqli_fetch_array($r)) {
                if ($f["link"] == "null") {
                    $linc = $root_dir . '/' . $_GET["lang"] . "/" . $f["url"];
                } else {
                    $linc = "$f[link]";
                }
                if ($f["target"] == "null") {
                    $tar = "";
                } else {
                    $tar = " target=\"$f[target]\"";
                }

                if ($f["id"] == $izv_id) {
                    $cl = ' class="active"';
                } else {
                    $cl = ' class="passive"';
                }

                $linc = str_replace('http://www.amedical.eu/', $url . '/', $linc);

                if(
                    (strpos($linc, '/produkti') !== false) ||
                    (strpos($linc, '/products') !== false) ||
                    (strpos($linc, '/Продукты') !== false)
                )  {
                    $top_menu[] = "<a href=\"$linc\" title=\"$f[name]\"$cl>$f[name]</a>";
                }
            }

            $wp_base_url = str_replace('/shop', '', $root_dir);


            $top_menu[] = '<a href="' . $wp_base_url . 'projektesana/">Projektēšana</a>';
            $top_menu[] = '<a href="' . $wp_base_url . 'iekartu-serviss/">Iekārtu serviss</a>';
            $top_menu[] = '<a href="' . $wp_base_url . 'par-mums/">Par mums</a>';
            $top_menu[] = '<a href="' . $wp_base_url . 'kontakti/">Kontakti</a>';


            $top_menu = implode("|", $top_menu);

            echo $top_menu;
            ?>
        </div>


        <?php require_once("include/top-banners.php"); ?>
        <?php if ($content_change != 0 && $echo_banners != '') { ?>
            <div id="titul-top-banner">
                <div id="titul-top-banner-container">
                    <?php echo $echo_banners; ?>
                </div>
            </div>
        <?php }
        if ($echo_banners == '' && $content_change > 0) {
            echo '<div style="height: 110px;">&nbsp;</div>';
        }

        ?>