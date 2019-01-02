<?php
/**
 * @package  my-learning-plugin
 */

namespace Inc\Base;

/**
 * 
 */

 class BaseController 
 {
 	public $plugin_path;
 	public $plugin_url;
 	public $plugin;
 	public $plugin_basename;

 	public function __construct() {
 		// dirname (Location, level deep in the directory) so we are inc\Base: 2 level

 		$this->plugin_path = plugin_dir_path( dirname( __FILE__ , 2) );
 		$this->plugin_url = plugin_dir_url( dirname( __FILE__ , 2) );
 		//$this->plugin =   plugin_basename( dirname(  __FILE__, 3)). '/my-learning-plugin.php';
 		$this->plugin_basename = plugin_basename( dirname( __FILE__, 3));
 		$this->plugin = $this->plugin_basename . '/' . $this->plugin_basename . '.php';
 		// We can manually assign like this
 		//$this->plugin = ' my-learning-plugin/my-learning-plugin.php';
 	}
 }