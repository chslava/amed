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


	$options =array
		(
			'page_title'=>'Footer options',
			'menu_title'=>'Footer options',
			'menu_slug'=>'theme-options-footer',
			'capability'=>'edit_posts',
			'parent_slug'=>'theme-options',
			'position'=>false,
			'icon_url'=>false
		);
	acf_add_options_page($options);

	$options =array
		(
			'page_title'=>'Header options',
			'menu_title'=>'Header options',
			'menu_slug'=>'theme-options-header',
			'capability'=>'edit_posts',
			'parent_slug'=>'theme-options',
			'position'=>false,
			'icon_url'=>false
		);
	acf_add_options_page($options);

	$options =array
		(
			'page_title'=>'Common options',
			'menu_title'=>'Common options',
			'menu_slug'=>'theme-options-common',
			'capability'=>'edit_posts',
			'parent_slug'=>'theme-options',
			'position'=>false,
			'icon_url'=>false
	);
	acf_add_options_page($options);
}
