<?php

// Disable plugins updates notification.
add_filter('pre_site_transient_update_plugins','__return_null'); // Disable plugins updates.


// Disable  Core Updates
add_filter( 'auto_update_core', '__return_false' );

// login with check user meta
function email_verification($user)
{
	if($user->roles[0]!='administrator')
	{
		$email_verify=get_user_meta($user->ID, 'email_verification', true);
		if ($email_verify == '1') {
			return $user;
		}
    	return new WP_Error('email_verification','Email Not Verify');
	}
	else
	{
		return $user;
	}
}
add_filter('wp_authenticate_user', 'email_verification', 10, 1);





//add active main menu
// here example of blog detail page
function wpsites_nav_class($classes, $item)
{
	//var_dump($item);
	if( get_post_type()=='post' && $item->title=='Blog' ){ // Blog is menu sidplay text
		$classes[] = "current_page_item";
 	}
	
	return $classes;
}
add_filter('nav_menu_css_class' , 'wpsites_nav_class' , 10 , 2);




// Remove Slug from custom_post_type project
function na_remove_slug( $post_link, $post, $leavename ) {

    if ( 'project' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'na_remove_slug', 10, 3 );

function na_parse_request( $query ) {

    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array('project') );
    }
}
add_action( 'pre_get_posts', 'na_parse_request' );




// add role capability
function add_role_capability() 
{
   if ( current_user_can( 'wc_product_vendors_manager_vendor' ) ) 
    {
        $GLOBALS['wp_roles']->add_cap( 'wc_product_vendors_manager_vendor','publish_products' );
    }
}
add_action( 'admin_init', 'add_role_capability', 10, 0 );



?>
