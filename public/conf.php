<?php

defined('ABSPATH') or die( "Bye bye" );

//Check that you have permission to access this page
if (! current_user_can ('manage_options')) wp_die (__ ('You do not have enough permissions to access this page.'));
?>
	<div class="wrap">
		<h2><?php _e( 'Inbbe', 'inbbe' ) ?></h2>
		Welcome to Inbbe configuration
	</div>
<?php
 ?>
