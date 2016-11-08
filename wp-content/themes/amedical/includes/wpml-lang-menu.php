<?php

  function dswp_print_language_menu($ul_class = '')
  {
      if (class_exists('SitePress')) {
        $languages = apply_filters('wpml_active_languages', null, array('skip_missing' => 0, 'orderby' => 'KEY'));
        if (!is_array($languages) || empty($languages)) {
            return '';
        }

        ?>
        <ul class="<?php echo $ul_class; ?>">
            <?php foreach ($languages as $language) : ?>
                <li <?php echo ($language['active']) ? 'class="active"' : ''; ?>>
                    <a href="<?php echo esc_url($language['url']); ?>"><?php print(strtoupper($language['language_code'])); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
      }else{
        echo "Please enable WPML";
      }
  }

?>
