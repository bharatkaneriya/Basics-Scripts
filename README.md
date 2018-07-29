# WordPress Usefull Hooks

Disable plugins updates notification.
<?php
add_filter('pre_site_transient_update_plugins','__return_null');
?>
