<div class="ui breadcrumb hide-for-tablet hide-for-mobile">
  <?php if ( function_exists('yoast_breadcrumb') ){
          $breadcrumbs = yoast_breadcrumb('','',false);
      $breadcrumbs = strip_tags($breadcrumbs,"<a>");
      $breadcrumbs = str_replace('<a ','<a class="section"',$breadcrumbs);
      $breadcrumbs = str_replace('http://','[http]',$breadcrumbs);
      $breadcrumbs = str_replace('https://','[https]',$breadcrumbs);
      $breadcrumbs = str_replace('//','<div class="divider">//</div>',$breadcrumbs);
      $breadcrumbs = str_replace('[https]','https://',$breadcrumbs);
      $breadcrumbs = str_replace('[http]','http://',$breadcrumbs);
      $last = explode("</div>",$breadcrumbs);
      $last = end($last);
      $breadcrumbs = str_replace($last,'<div class="active section">'.$last."</div>",$breadcrumbs);


      print($breadcrumbs);
       }
  ?>
</div>
