<?php

/**
 * @package my-learning-plugin
 */
/*
Plugin Name: my-learning-plugin
Plugin URI: https://akismet.com/
Description: My first oop base plugin.
Version: 1.0.9
Author: Mati ullah
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: my-learning-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

class MyLearningPlugin 
{

	public function activate(){
		$this->custom_post_type();
		flush_rewrite_rules();
	}

	public function deactivate(){
		flush_rewrite_rules();
	}

	public function custom_post_type(){

		register_post_type( 'book', array( 'public'=>true,'label'=>'Books' ) );
	}


}

if( class_exists( 'MyLearningPlugin' ) ){
	$myLearningPlugin = new MyLearningPlugin();
}

//activation 
register_activation_hook( __FILE__, array($myLearningPlugin,'activate') );
//deactivation
register_activation_hook( __FILE__, array($myLearningPlugin,'deactivate') );
