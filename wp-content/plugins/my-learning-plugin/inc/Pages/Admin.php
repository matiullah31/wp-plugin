<?php
/**
 * @package  my-learning-plugin
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
				'page_title' => 'My Learning Plugin',
				'menu_title' => 'My Plugin',
				'capability' => 'manage_options',
				'menu_slug' => 'my_learning_plugin',
				'callback' => array($this->callbacks,'adminDashboard'),
				'icon_url' => 'dashicons-store',
				'position' => 110

				]
			];

		$this->subpages = [
				[
				'parent_slug' => 'my_learning_plugin',
				'page_title' => "Custom Post Type",
				'menu_title' => "CPT",
				'capability' => 'manage_options',
				'menu_slug' => 'my_learning_plugin_cpt',
				'callback' => array($this->callbacks,'adminCpt')

				],
				[
				'parent_slug' => 'my_learning_plugin',
				'page_title' => "Custom Taxonomies",
				'menu_title' => "Taxonomies",
				'capability' => 'manage_options',
				'menu_slug' => 'my_learning_plugin_taxonomies',
				'callback' => array($this->callbacks,'adminTaxonomy')

				],
				[
				'parent_slug' => 'my_learning_plugin',
				'page_title' => "Custom Widget",
				'menu_title' => "Widget",
				'capability' => 'manage_options',
				'menu_slug' => 'my_learning_plugin_widget',
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
				'option_group'=>'my_learning_plugin_option_group',
				'option_name'=>'text_example',
				'callback'=>array($this->callbacks,'myLearningPluginOptionGroup')

			),
			array(
				'option_group'=>'my_learning_plugin_option_group',
				'option_name'=>'first_name'
				//'callback'=>array($this->callbacks,'myLearningPluginOptionGroup')

			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections(){
		$args = array(
			array(
				'id'=>'my_learning_plugin_admin_index',
				'title'=>'Settings',
				'callback'=>array($this->callbacks,'myLearningPluginAdminSection'),
				'page'=>'my_learning_plugin' // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage

			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields(){
		$args = array(
			array(
				'id'=>'text_example', // same as option_name in settings, 
				'title'=>'Text Example',
				'callback'=>array($this->callbacks,'myLearningPluginTextExample'),
				'page'=>'my_learning_plugin', // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage
				'section'=>'my_learning_plugin_admin_index', //section id
				'args'=>array(
						'label_for'=>'text_example',
						'class'=>'example-class'
					)

			),
			array(
				'id'=>'first_name', // same as option_name in settings, 
				'title'=>'First Name',
				'callback'=>array($this->callbacks,'myLearningPluginFirstName'),
				'page'=>'my_learning_plugin', // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage
				'section'=>'my_learning_plugin_admin_index', //section id
				'args'=>array(
						'label_for'=>'first_name',
						'class'=>'example-class'
					)

			)
		);

		$this->settings->setFields( $args );
	}

/*	public function add_admin_pages() {

		add_menu_page( 'My Learning Plugin', 'My Plugin', 'manage_options', 'my_learning_plugin' , array( $this, 'admin_index' ), 'dashicons-store', 110 );

	}
	public function admin_index() {

		//require_once PLUGIN_PATH. 'templates/admin.php';
		require_once $this->plugin_path . 'templates/admin.php';
	}*/

}