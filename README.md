# WordPress Usefull Hooks

Disable plugins updates notification.

<code>
add_filter('pre_site_transient_update_plugins','__return_null');
</code>


Disable  Core Updates

<code>
add_filter( 'auto_update_core', '__return_false' );
</code>

login with check user meta

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
