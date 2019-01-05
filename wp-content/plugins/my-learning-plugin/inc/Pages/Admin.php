<?php
/**
 * @package  my-learning-plugin
 */

namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

/**
 * 
 */
class Admin extends BaseController
{
	public $settings;
	public $pages = array();
	public $subpages = array();
	
	public $callbacks;
	public $callbacks_mngr;

	public function __construct()
	{  
		//call parent construct or remove constructor function from child class
		parent::__construct();
		$this->callbacks = new AdminCallbacks();
		$this->callbacks_mngr = new ManagerCallbacks();

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

		$args = array();
		foreach($this->managers as $key => $manager){
			$args[] = array(
				'option_group' => 'my_learning_plugin_settings',
				'option_name' => $key,
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			);
		}
		// $args = array(
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'cpt_manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	),
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'taxonomy_manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	),
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'media_widget',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	),
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'gallery_manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	),
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'testimonial_manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	),
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'templates_manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	),
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'login_manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	),
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'membership_manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	),
		// 	array(
		// 		'option_group' => 'my_learning_plugin_settings',
		// 		'option_name' => 'chat_manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
		// 	)
		// );
		$this->settings->setSettings( $args );

		// $args = array(
		// 	array(
		// 		'option_group'=>'my_learning_plugin_settings',
		// 		'option_name'=>'text_example',
		// 		'callback'=>array($this->callbacks,'myLearningPluginOptionGroup')

		// 	),
		// 	array(
		// 		'option_group'=>'my_learning_plugin_settings',
		// 		'option_name'=>'first_name'
		// 		//'callback'=>array($this->callbacks,'myLearningPluginOptionGroup')

		// 	)
		// );

		// $this->settings->setSettings( $args );

	}

	public function setSections(){
		$args = array(
			array(
				'id' => 'my_learning_plugin_admin_index',
				'title' => 'Settings Manager',
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'my_learning_plugin'
			)
		);
		$this->settings->setSections( $args );

		// $args = array(
		// 	array(
		// 		'id'=>'my_learning_plugin_admin_index',
		// 		'title'=>'Settings',
		// 		'callback'=>array($this->callbacks,'myLearningPluginAdminSection'),
		// 		'page'=>'my_learning_plugin' // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage

		// 	)
		// );

		// $this->settings->setSections( $args );
	}

	public function setFields(){

		$args = array();
		foreach($this->managers as $key => $title ){
			$args[] = array(
				'id' => $key,
				'title' => $title,
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'my_learning_plugin',
				'section' => 'my_learning_plugin_admin_index',
				'args' => array(
					'label_for' => $key,
					'class' => 'ui-toggle'
				)
			);
		}

		// $args = array(
		// 	array(
		// 		'id' => 'cpt_manager',
		// 		'title' => 'Activate CPT Manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'cpt_manager',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	),
		// 	array(
		// 		'id' => 'taxonomy_manager',
		// 		'title' => 'Activate Taxonomy Manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'taxonomy_manager',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	),
		// 	array(
		// 		'id' => 'media_widget',
		// 		'title' => 'Activate Media Widget',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'media_widget',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	),
		// 	array(
		// 		'id' => 'gallery_manager',
		// 		'title' => 'Activate Gallery Manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'gallery_manager',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	),
		// 	array(
		// 		'id' => 'testimonial_manager',
		// 		'title' => 'Activate Testimonial Manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'testimonial_manager',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	),
		// 	array(
		// 		'id' => 'templates_manager',
		// 		'title' => 'Activate Templates Manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'templates_manager',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	),
		// 	array(
		// 		'id' => 'login_manager',
		// 		'title' => 'Activate Ajax Login/Signup',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'login_manager',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	),
		// 	array(
		// 		'id' => 'membership_manager',
		// 		'title' => 'Activate Membership Manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'membership_manager',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	),
		// 	array(
		// 		'id' => 'chat_manager',
		// 		'title' => 'Activate Chat Manager',
		// 		'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
		// 		'page' => 'my_learning_plugin',
		// 		'section' => 'my_learning_plugin_admin_index',
		// 		'args' => array(
		// 			'label_for' => 'chat_manager',
		// 			'class' => 'ui-toggle'
		// 		)
		// 	)
		// );
		$this->settings->setFields( $args );
	

		// $args = array(
		// 	array(
		// 		'id'=>'text_example', // same as option_name in settings, 
		// 		'title'=>'Text Example',
		// 		'callback'=>array($this->callbacks,'myLearningPluginTextExample'),
		// 		'page'=>'my_learning_plugin', // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage
		// 		'section'=>'my_learning_plugin_admin_index', //section id
		// 		'args'=>array(
		// 				'label_for'=>'text_example',
		// 				'class'=>'example-class'
		// 			)

		// 	),
		// 	array(
		// 		'id'=>'first_name', // same as option_name in settings, 
		// 		'title'=>'First Name',
		// 		'callback'=>array($this->callbacks,'myLearningPluginFirstName'),
		// 		'page'=>'my_learning_plugin', // menu_slug of the main page, if you want settings of sub page menu_slug of the subpage
		// 		'section'=>'my_learning_plugin_admin_index', //section id
		// 		'args'=>array(
		// 				'label_for'=>'first_name',
		// 				'class'=>'example-class'
		// 			)

		// 	)
		// );

		// $this->settings->setFields( $args );
	}

/*	public function add_admin_pages() {

		add_menu_page( 'My Learning Plugin', 'My Plugin', 'manage_options', 'my_learning_plugin' , array( $this, 'admin_index' ), 'dashicons-store', 110 );

	}
	public function admin_index() {

		//require_once PLUGIN_PATH. 'templates/admin.php';
		require_once $this->plugin_path . 'templates/admin.php';
	}*/

}