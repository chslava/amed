<div class="ui breadcrumb">
  <?php if ( function_exists('yoast_breadcrumb') ){
          $breadcrumbs = yoast_breadcrumb('','',false);
      $breadcrumbs = strip_tags($breadcrumbs,"<a>");
      $breadcrumbs = str_replace('<a ','<a class="section"',$breadcrumbs);
      $breadcrumbs = str_replace('http://','[http]',$breadcrumbs);
      $breadcrumbs = str_replace('https://','[https]',$breadcrumbs);
      $breadcrumbs = str_replace('//','<div class="divider">//</div><div class="active section">&nbsp;',$breadcrumbs);
      $breadcrumbs = str_replace('[https]','https://',$breadcrumbs);
      $breadcrumbs = str_replace('[http]','http://',$breadcrumbs);
      $breadcrumbs.= '</div>';

            print($breadcrumbs);
       }
  ?>
</div>
