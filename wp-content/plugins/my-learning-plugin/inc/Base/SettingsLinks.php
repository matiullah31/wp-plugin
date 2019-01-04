<?php
/**
 * @package  my-learning-plugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;

/**
 * 
 */
class SettingsLinks extends BaseController
{
	

	public function __construct() {

		parent::__construct();

	}

	public function register() 
	{
		//TODO:
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link') );


	}

	public function settings_link( $links ) {
		
		$settings_link = '<a href="admin.php?page=my_learning_plugin">Settings</a>';

		array_push($links, $settings_link);

		return $links;

	}
}