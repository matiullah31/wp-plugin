<?php

/**
 * @package oop-plugin
 */
/*
Plugin Name: oop-plugin
Plugin URI: https://akismet.com/
Description: My first oop base plugin.
Version: 1.0.9
Author: Mati ullah
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: oop-plugin
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



if( file_exists( dirname( __FILE__ ). '/vendor/autoload.php' ) ){

	require_once dirname( __FILE__ ). '/vendor/autoload.php';

}

// instead of using constant here good to create base class and define it there
/*define( 'PLUGIN_PATH' , plugin_dir_path( __FILE__ ));
define( 'PLUGIN_URL' , plugin_dir_url( __FILE__ ));
define( 'PLUGIN' , plugin_basename( __FILE__ ));*/

//use Inc\Base\Activate;
//use Inc\Base\Deactivate;


function activate_oop_plugin() {

	Inc\Base\Activate::activate();
}

register_activation_hook( __FILE__, 'activate_oop_plugin');

	 
function deactivate_oop_plugin() {

	Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_oop_plugin');



// remember : Inc is namespace and Init is inside Inc namespace 
if( class_exists( 'Inc\\Init' ) ) {

	Inc\Init::register_services();

}




