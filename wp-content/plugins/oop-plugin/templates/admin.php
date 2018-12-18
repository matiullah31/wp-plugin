<div class="wrap">
	 <h1>My First OOP base Plugin</h1>
	 <?php settings_errors();	  ?>
	 <form method="post" action="options.php">
	 	<?php 
	 		settings_fields( 'oop_plugin_option_group' ); //option_group
	 		do_settings_sections( 'oop_plugin' ); // page menu_slug
	 		submit_button();

	 	 ?>
	 	
	 </form>
</div>