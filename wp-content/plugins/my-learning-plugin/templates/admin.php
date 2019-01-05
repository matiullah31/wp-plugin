<div class="wrap">
	 <h1>My Learning Plugin</h1>
	 <?php settings_errors();	  ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Mange Settings</a></li>
		<li><a href="#tab-2">Updates</a></li>
		<li><a href="#tab-3">About</a></li>
		
	</ul>

<div class="tab-content">
	<div id="tab-1" class="tab-pane active">
	 <form method="post" action="options.php">
	 	<?php 
	 		settings_fields( 'my_learning_plugin_settings' ); //option_group
	 		do_settings_sections( 'my_learning_plugin' ); // page menu_slug
	 		submit_button();

	 	 ?>
	 	
	 </form>
	</div>

	<div id="tab-2" class="tab-pane">
		<h3>Update Section</h3>
	</div>

	<div id="tab-3" class="tab-pane">
		<h3>About Section</h3>
	</div>

</div>
</div>