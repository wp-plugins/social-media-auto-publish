<?php

function smap_install()
{
	global $current_user;
	get_currentuserinfo();
	if(get_option('xyz_credit_link')=="")
	{
		add_option("xyz_credit_link", '0');
	}

	add_option('xyz_smap_application_id','');
	add_option('xyz_smap_application_secret', '');
	add_option('xyz_smap_fb_id', '');
	add_option('xyz_smap_message', 'New post added at {BLOG_TITLE} - {POST_TITLE}');
 	add_option('xyz_smap_po_method', '2');
	add_option('xyz_smap_post_permission', '1');
	add_option('xyz_smap_current_appln_token', '');
	add_option('xyz_smap_af', '1'); //authorization flag


	add_option('xyz_smap_twconsumer_secret', '');
	add_option('xyz_smap_twconsumer_id','');
	add_option('xyz_smap_tw_id', '');
	add_option('xyz_smap_current_twappln_token', '');
	add_option('xyz_smap_twpost_permission', '1');
	add_option('xyz_smap_twpost_image_permission', '1');
	add_option('xyz_smap_twaccestok_secret', '');
	add_option('xyz_smap_twmessage', '{POST_TITLE} - {PERMALINK}');

	$version=get_option('xyz_smap_free_version');
	$currentversion=xyz_smap_plugin_get_version();
	if($version=="")
	{
		add_option("xyz_smap_free_version", $currentversion);
	}
	else
	{

		update_option('xyz_smap_free_version', $currentversion);
	}
	add_option('xyz_smap_include_pages', '0');
	add_option('xyz_smap_include_categories', 'All');
	add_option('xyz_smap_include_customposttypes', '');
















}


register_activation_hook(XYZ_SMAP_PLUGIN_FILE,'smap_install');



































?>