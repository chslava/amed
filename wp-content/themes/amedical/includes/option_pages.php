<?Php


if (function_exists('acf_add_options_page'))
{
	$options =array
		(
			'page_title'=>'Theme Options',
			'menu_title'=>'Theme Options',
			'menu_slug'=>'theme-options',
			'capability'=>'edit_posts',
			'parent_slug'=>'',
			'position'=>false,
			'icon_url'=>false
		);
	acf_add_options_page($options);

}
