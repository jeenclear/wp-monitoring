<?php

/**
 * @author edjeen capillanes
 * @copyright 2016-2017
 */

$userdata = get_userdata( get_current_user_id() );

?>

<div id="wp-mvc__wrap">
	
	<div class="wp-managelist__pad wrap">
		<?php
			echo input::form_open( array( 'method' => 'post' ) );
		?>
		<?php
			echo ( form::wp_monitoring_help() );
		?>
		<?php
			echo input::form_close(true);
		?>
	</div>
	
</div>

