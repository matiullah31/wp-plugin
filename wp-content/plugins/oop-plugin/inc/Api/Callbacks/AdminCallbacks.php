<?php
/**
 * @package oop-plugin
 */

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class AdminCallbacks extends BaseController 
{

	public function adminDashboard(){

		return require_once $this->plugin_path.'templates/admin.php';
		
	}
	public function adminCpt() {

		return require_once $this->plugin_path.'templates/adminCpt.php';
	}
	public function adminTaxonomy() {

		return require_once $this->plugin_path.'templates/adminTaxonomy.php';

	}
	public function adminWidget() {
		
		return require_once $this->plugin_path.'templates/adminWidget.php';

	}

	public function oopPluginOptionGroup( $input ) {

		return $input;
	} 

	public function oopPluginAdminSection() {
		echo "Check this beautiful section";
	}
	public function oopPluginTextExample( $args ) {
		$value = esc_attr( get_option( 'text_example' ) );
		echo '<input type="text" class="regular-text" name="text_example" value="'. $value .'" placeholder="Write someting here!">';
	}
	public function oopPluginFirstName( $args ) {
		$value = esc_attr( get_option( 'first_name' ) );
		echo '<input type="text" class="regular-text" name="first_name" value="'. $value .'" placeholder="Write first name here!">';
	}

}