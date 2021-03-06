<?php
/**
 * @package oop-plugin
 */

namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
/**
 * 
 */
class Admin extends BaseController
{
	public $settings;
	public $pages = array();
	public $subpages = array();
	
	public $callbacks;

	public function __construct()
	{  
		//call parent construct or remove constructor function from child class
		parent::__construct();
		$this->callbacks = new AdminCallbacks();
		$this->settings = new SettingsApi();
		$this->pages = [
				[
				'page_title' => 'OOP Plugin',
				'menu_title' => 'OPlugin',
				'capability' => 'manage_options',
				'menu_slug' => 'oop_plugin',
				'callback' => array($this->callbacks,'adminDashboard'),
				'icon_url' => 'dashicons-store',
				'position' => 110

				]
			];

		$this->subpages = [
				[
				'parent_slug' => 'oop_plugin',
				'page_title' => "Custom Post Type",
				'menu_title' => "CPT",
				'capability' => 'manage_options',
				'menu_slug' => 'oop_plugin_cpt',
				'callback' => array($this->callbacks,'adminCpt')

				],
				[
				'parent_slug' => 'oop_plugin',
				'page_title' => "Custom Taxonomies",
				'menu_title' => "Taxonomies",
				'capability' => 'manage_options',
				'menu_slug' => 'oop_plugin_taxonomies',
				'callback' => array($this->callbacks,'adminTaxonomy')

				],
				[
				'parent_slug' => 'oop_plugin',
				'page_title' => "Custom Widget",
				'menu_title' => "Widget",
				'capability' => 'manage_options',
				'menu_slug' => 'oop_plugin_widget',
				'callback' => array($this->callbacks,'adminWidget')

				]
			];
	}

	public function register() {
		$this->setSettings();
		$this->setSections();
		$this->setFields();
		//add_action( 'admin_menu', array( $this, 'add_admin_pages' ));

		$this->settings->addPages( $this->pages )->withSubpage('Dashboard')->addSubPages( $this->subpages )->register();

	}

	public function setSettings(){
		$args = array(
			array(
				'option_group'=>'oop_plugin_option_group',
				'option_name'=>'text_example',
				'callback'=>array($this->callbacks,'oopPluginOptionGroup')

			),
			array(
				'option_group'=>'oop_plugin_option_group',
				'option_name'=>'first_name'
				//'callback'=>array($this->callbacks,'oopPluginOptionGroup')

			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections(){
		$args = array(
			array(
				'id'=>'oop_plugin_admin_index',
				'title'=>'Settings',
				'callback'=>array($this->callbacks,'oopPluginAdminSection'),
				'page'=>'oop_plugin' // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage

			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields(){
		$args = array(
			array(
				'id'=>'text_example', // same as option_name in settings, 
				'title'=>'Text Example',
				'callback'=>array($this->callbacks,'oopPluginTextExample'),
				'page'=>'oop_plugin', // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage
				'section'=>'oop_plugin_admin_index', //section id
				'args'=>array(
						'label_for'=>'text_example',
						'class'=>'example-class'
					)

			),
			array(
				'id'=>'first_name', // same as option_name in settings, 
				'title'=>'First Name',
				'callback'=>array($this->callbacks,'oopPluginFirstName'),
				'page'=>'oop_plugin', // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage
				'section'=>'oop_plugin_admin_index', //section id
				'args'=>array(
						'label_for'=>'first_name',
						'class'=>'example-class'
					)

			)
		);

		$this->settings->setFields( $args );
	}

/*	public function add_admin_pages() {

		add_menu_page( 'Oop Plugin', 'OPlugin', 'manage_options', 'oop_plugin' , array( $this, 'admin_index' ), 'dashicons-store', 110 );

	}
	public function admin_index() {

		//require_once PLUGIN_PATH. 'templates/admin.php';
		require_once $this->plugin_path . 'templates/admin.php';
	}*/

}