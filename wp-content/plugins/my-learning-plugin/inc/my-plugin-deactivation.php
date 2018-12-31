<?php

/**
 * @package my-learning-plugin
 */

class MyPluginDeactivation 
{
	public static function deactivate() {

		flush_rewrite_rules();

	}





}