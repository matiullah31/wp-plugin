<?php 
/**
 * @package  my-learning-plugin
 */
namespace Inc\Api\Callbacks;
use Inc\Base\BaseController;
class ManagerCallbacks extends BaseController
{
	public function checkboxSanitize( $input )
	{

		//var_dump($input);exit;

		$output = array();
		foreach ($this->managers as $key => $value) {
			$output[$key] = ( isset($input[$key]) && !empty($input[$key]) ? true : false );
		}

		return $output;

		// return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
		//return ( isset($input) ? true : false );
	}
	public function adminSectionManager()
	{
		echo 'Manage the Sections and Features of this Plugin by activating the checkboxes from the following list.';
	}
	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );
		$checked = (isset($checkbox[$name]) && !empty($checkbox[$name]) ? true : false);
		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="'.$option_name.'[' . $name .']" value="1" class="' . $classes . '" ' . ($checked ? 'checked' : '') . '><label for="' . $name . '"><div> </div></label></div>';
	}
}