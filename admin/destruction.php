<?php


function smap_destroy()
{
	global $wpdb;
	
	if(get_option('xyz_credit_link')=="smap")
	{
		update_option("xyz_credit_link", '0');
	}
	
	delete_option('xyz_smap_application_id');
	delete_option('xyz_smap_application_secret');
	delete_option('xyz_smap_fb_id');
	delete_option('xyz_smap_message');
	delete_option('xyz_smap_po_method');
	delete_option('xyz_smap_post_permission');
	delete_option('xyz_smap_current_appln_token');
	delete_option('xyz_smap_af');
	
	
	delete_option('xyz_smap_twconsumer_secret');
	delete_option('xyz_smap_twconsumer_id');
	delete_option('xyz_smap_tw_id');
	delete_option('xyz_smap_current_twappln_token');
	delete_option('xyz_smap_twpost_permission');
	delete_option('xyz_smap_twpost_image_permission');
	delete_option('xyz_smap_twaccestok_secret');
	delete_option('xyz_smap_twmessage');
	
	delete_option('xyz_smap_free_version');
	
	delete_option('xyz_smap_include_pages');
	delete_option('xyz_smap_include_categories');
	delete_option('xyz_smap_include_customposttypes');
	
}

register_uninstall_hook(XYZ_SMAP_PLUGIN_FILE,'smap_destroy');


?>