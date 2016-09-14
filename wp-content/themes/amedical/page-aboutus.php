<?php
/*
Template Name: Aboutus
*/
get_header();

?>

<main class="ui container about-us page">
  <div class="ui breadcrumb"><a class="section" href="index.html">Sākums</a>
    <div class="divider">//</div>
    <div class="active section">Par mums</div>
  </div>
  <div class="ui grid">
    <div class="two column row">
      <div class="column">
        <h1 class="ui header left decored">Par A Medical
          <div class="ui large sub header">Dinamisks. Uzticams. Daudzpusīgs.</div>
        </h1>
        <p>A.Medical komanda sastāv no nozares profesionāļiem, kuriem ir daudzu gadu pieredze medicīnas iekārtu tirdzniecības un</p>
        servisa nozarēs. Pēdējo 20 gadu laikā mūsu komanda kopā ar Latvijas vadošajām medicīnas iestādēm realizējusi projektus
        vairāku miljonu eiro apjomā. Paplašinot savu darbības sfēru, esam veiksmīgi uzsākuši sadarbību ar vadošiem drošības un
        industriālo risinājumu ražotājiem, piedāvājot mūsu klientiem profesionālos risinājumus šajā jomā.
      </div>
      <div class="column"><img class="ui shadowed image" src="<?php echo get_stylesheet_directory_uri() ;?>/img/about-us.jpg"></div>
    </div>
  </div>
</main>
<section class="secondary-services">
  <div class="ui container">
    <h2 class="centered ui header">A.Medical darbības virzieni:</h2>
    <div class="ui four columns relaxed grid">
      <div class="column"><span class="circle-check"><i class="icon-check-icon"></i></span>
        <p class="content">Visa veida medicīnas iekārtu un medicīnas preču pārdošana</p>
      </div>
      <div class="column"><span class="circle-check"><i class="icon-check-icon"></i></span>
        <p class="content">Medicīnas iekārtu uzstādīšana un apkalpošana</p>
      </div>
      <div class="column"><span class="circle-check"><i class="icon-check-icon"></i></span>
        <p class="content">Medicīnas iestāžu un nodaļu projektēšana un renovācija</p>
      </div>
      <div class="column"><span class="circle-check"><i class="icon-check-icon"></i></span>
        <p class="content">Industriālo un drošības risinājumu tirdzniecība, uzstādīšana un apkalpošana</p>
      </div>
    </div>
  </div>
</section>
<section class="benefits very padded">
  <div class="ui relaxed grid container">
    <div class="sixteen wide column">
      <h2 class="ui header centered decored">Mūsu vīzija un misija</h2>
      <p class="content">VĪZIJA: Būt par klientu svarīgāko partneri medicīnas tehnoloģijās.</p>
      <p class="content">MISIJA: Kā daudzpusīga un pieredzējusi profesionāļu komanda ar izcilu produktu portfolio mēs veidojam ilgtspējīgu medicīnas nozari Baltijā.</p>
    </div>
  </div>
</section>
<section class="services">
  <div class="ui container">
    <div class="ui three columns center aligned grid">
      <div class="column">
        <h3 class="ui header">
          <div class="service-icon icon-first-icon"></div>
        </h3>
        <p>
          A.Medical uzskata, ka viens no tā veiksmes stūrakmeņiem ir izcila komanda ar uzkrātām zināšanām medicīnas tehnoloģiju,kā arī industriālo un drošības risinājumu nozarēs.</p>
      </div>
      <div class="column">
        <h3 class="ui header">
          <div class="service-icon icon-second-icon"></div>
        </h3>
        <p>
          Darbiniekiem tiek nodrošinātas visas nepieciešamās apmācības pie iekārtu ražotājiem, tādējādi A.Medical vienmēr spēj ieteiktklientu vēlmēm un vajadzībām atbilstošākos risinājumus.</p>
      </div>
      <div class="column">
        <h3 class="ui header">
          <div class="service-icon icon-third-icon"></div>
        </h3>
        <p>
          A.Medical piedāvā augstvērtīgus medicīnas produktus no pasaulē atzītiem ražotājiem. Mēs lepojamies, ka mūsu klientu vidū irvisas vadošās Latvijas veselības aprūpes iestādes.</p>
      </div>
    </div>
  </div>
</section>
<section class="coo-respose">
  <div class="ui container grid">
    <div class="two column row">
      <div class="right floated column">
        <h2 class="ui left header decored">Korporatīvā sociālā atbildība</h2>
        <p>
          A.Medical rūpējas par apkārtējo vidi un ir sociāli atbildīgs uzņēmums. Realizējot korporatīvās sociālās atbildības politiku,uzņēmums nosaka savu attieksmi pret apkārtējās vides un sabiedrības labklājības uzlabošanu.</p>
        <p>
          Lai nodrošinātu pilnvērtīgu elektrisko un elektronisko iekārtu utilizāciju, A.Medical uzsākusi sadarbību ar Zaļo jostu, kas veicšo procesu atbilstoši valstī noteiktajām prasībām.</p>
        <p>
          Līdz šim uzņēmuma dibinātāji vairāku gadu garumā ir atbalstījuši Latvijas slimnīcām nozīmīgus projektus, kā arī vairākkārtējiir atbalstījuši bāreņu biedrības.</p>
      </div>
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
