<?php
/**
 * @package oop-plugin
 */

namespace Inc;

/**
 *  defined as final to avoid extentions
 */
final class Init
{
	/**
	 *  Store all the classes inside an array
	 * 
	 * Pages\Admin::class will output full class name with namespace
	 *  @return array Full list of classes
	 */

	public static function get_services() {
		return [
			Pages\Admin::class,
			Base\Enqueue::class,
			Base\SettingsLinks::class
			];
	}

	/**
	 *  
	 * Loop through the classes, initialize them,
	 * And call the register() method if it exists
	 *  @return
	 */
	public static function register_services() 
	{
		foreach (self::get_services() as  $class) {
			$service = self::instantiate( $class );
			if( method_exists( $service, 'register') ) {

				$service->register();

			}
		}

	}

	/**
	 *  Initalize the class
	 * @param class $class class from the services array
	 * 
	 *  @return class instance new instance of the class
	 */
	private static function instantiate( $class ) {
		//return new $class(); or 
		$service = new $class();
		return $service;

	}

}