<div class="wrap">
	 <h1>My Learning Plugin</h1>
	 <?php settings_errors();	  ?>
	 <form method="post" action="options.php">
	 	<?php 
	 		settings_fields( 'my_learning_plugin_option_group' ); //option_group
	 		do_settings_sections( 'my_learning_plugin' ); // page menu_slug
	 		submit_button();

	 	 ?>
	 	
	 </form>
</div>