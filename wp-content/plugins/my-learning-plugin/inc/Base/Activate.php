<?php
/**
 * @package  my-learning-plugin
 */

namespace Inc\Base;

/**
 * 
 */
class Activate
{
	
	public static function activate() 
	{
		flush_rewrite_rules();
	}

}