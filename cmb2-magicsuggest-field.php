<?php
/*
Plugin Name: CMB2 Field Type: Magic Suggest
Plugin URI: https://github.com/eliottparis/cmb2-magicsuggest-field
GitHub Plugin URI: https://github.com/eliottparis/cmb2-magicsuggest-field
Description: Magic Suggest Field for CMB2.
Version: 1.0.0
Author: Eliott Paris
Author URI: https://github.com/eliottparis
License: GPLv2+
*/

/**
 * Class EP_CMB2_MagicSuggest_Field
 */
class EP_CMB2_MagicSuggest_Field {

	/**
	 * Current version number
	 */
	const VERSION = '1.0.0';

	/**
	 * Current magicsuggest version
	 */
	const MS_VERSION = '2.1.4';

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public function __construct() {
		add_action( 'cmb2_render_magicsuggest', array( $this, 'render' ), 10, 5 );
		add_action( 'cmb2_sanitize_magicsuggest', array( $this, 'sanitize' ), 10, 2 );
	}

	/**
	 * Render the magicsuggest CMB custom field
	 */
	public function render( $field, $escaped_value, $object_id, $object_type, $field_type ) {

		$this->setup_admin_scripts();

		// Setup our options
		$args = wp_parse_args( (array) $field->options(), array(
			'allow_free_entries'	=> true,
			'expand_on_focus'		=> false,
			'max_selection'			=> 10,
			'value_field'			=> 'id',
			'display_field'			=> 'name',
		) );

		// Setup our attributes
		$attrs = wp_parse_args( (array) $field->attributes(), array(
			'placeholder'			=> '',
			'required'				=> '',
		) );

		// json encode data
		$dropdown_data = $field->options( 'data' ) ? json_encode( (array) $field->options( 'data' ) ) : '[]';

		// json encode value
		$json_value = !empty( $escaped_value ) ? json_encode( $escaped_value ) : '[]';
		$string_value = is_array( $escaped_value ) ? implode(',', $escaped_value) : $escaped_value;

		// Setup magicsuggest component
		$ms_component_id = 'ms-' . $field_type->_name();
		echo '<div id="' . $ms_component_id . '"></div>';

		// Setup magicsuggest value holder hidden field
		echo $field_type->input( array(
			'type'  => 'hidden',
			'class' => 'cmb2-magicsuggest-ids',
			'value' => $string_value,
			'desc'  => '',
		) );

		// Add cmb2 field description
		$field_type->_desc( true, true );

		// Now, set up the script.
		?> <script>
			jQuery(document).ready(function( $ ) {
				var msValueHolder = $('#<?php echo $field_type->_name(); ?>');
				var ms = $('#<?php echo $ms_component_id; ?>').magicSuggest({
		        	data: <?php echo $dropdown_data; ?>,
		        	value: <?php echo $json_value; ?>,
		        	placeholder: <?php echo json_encode($attrs['placeholder']); ?>,
		        	required: <?php echo $attrs['required'] == "required" ? 'true' : 'false'; ?>,
		        	allowFreeEntries: <?php echo $args['allow_free_entries'] ? 'true' : 'false'; ?>,
		        	expandOnFocus: <?php echo $args['expand_on_focus'] ? 'true' : 'false'; ?>,
		        	maxSelection: <?php echo json_encode($args['max_selection']); ?>,
		        	valueField: <?php echo json_encode($args['value_field']); ?>,
		        	displayField: <?php echo json_encode($args['display_field']); ?>,
		    	});
				$(ms).on('selectionchange', function(e, m) {
				  	msValueHolder.val(this.getValue());
				});
			});
		</script> <?php
	}

	/**
	 * Sanitize MagicSuggest field
	 */
	public function sanitize( $sanitized_val, $val ) {

		if ( ! empty( $val ) ) {
			return explode( ',', $val );
		}

		return $sanitized_val;

	}

	/**
	 * Enqueue admin scripts for our MagicSuggest field
	 * (From https://github.com/WebDevStudios/cmb2-attached-posts)
	 */
	protected function setup_admin_scripts() {

		$dir = trailingslashit( dirname( __FILE__ ) );

		if ( 'WIN' === strtoupper( substr( PHP_OS, 0, 3 ) ) ) {
			// Windows
			$content_dir = str_replace( '/', DIRECTORY_SEPARATOR, WP_CONTENT_DIR );
			$content_url = str_replace( $content_dir, WP_CONTENT_URL, $dir );
			$url = str_replace( DIRECTORY_SEPARATOR, '/', $content_url );

		} else {
			$url = str_replace(
				array( WP_CONTENT_DIR, WP_PLUGIN_DIR ),
				array( WP_CONTENT_URL, WP_PLUGIN_URL ),
				$dir
			);
		}

		$url = set_url_scheme( $url );

		$requirements = array(
			'jquery-ui-core',
		);

		wp_enqueue_script( 'magicsuggest', $url . 'assets/magicsuggest/magicsuggest-min.js', $requirements, self::MS_VERSION, true );
		wp_enqueue_style( 'magicsuggest', $url . 'assets/magicsuggest/magicsuggest-min.css', array(), self::MS_VERSION );
		wp_enqueue_style( 'cmb2-magicsuggest-field', $url . 'css/cmb2-magicsuggest-admin.css', array(), self::VERSION );

	}
}
$cmb2_magicsuggest_field = new EP_CMB2_MagicSuggest_Field();
