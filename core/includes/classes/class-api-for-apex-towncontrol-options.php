<?php

class Api_for_Apex_Towncontrol_Options {
	private $towncontrol_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'towncontrol_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'towncontrol_page_init' ) );
	}

	public function towncontrol_add_plugin_page() {
		add_options_page(
			'TownControl', // page_title
			'TownControl', // menu_title
			'manage_options', // capability
			'towncontrol', // menu_slug
			array( $this, 'towncontrol_create_admin_page' ) // function
		);
	}

	public function towncontrol_create_admin_page() {
		$this->towncontrol_options = get_option( 'towncontrol_option_name' ); ?>

		<div class="wrap">
			<h2>TownControl</h2>
			<p>Settings for Virtual Roleplay Solutions API.</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'towncontrol_option_group' );
					do_settings_sections( 'towncontrol-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function towncontrol_page_init() {
		register_setting(
			'towncontrol_option_group', // option_group
			'towncontrol_option_name', // option_name
			array( $this, 'towncontrol_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'towncontrol_setting_section', // id
			'Settings', // title
			array( $this, 'towncontrol_section_info' ), // callback
			'towncontrol-admin' // page
		);

		add_settings_field(
			'rr_apx_api_key_0', // id
			'rr_apx_api_key', // title
			array( $this, 'rr_apx_api_key_0_callback' ), // callback
			'towncontrol-admin', // page
			'towncontrol_setting_section' // section
		);

		add_settings_field(
			'rr_apx_townuuid_1', // id
			'rr_apx_townUUID', // title
			array( $this, 'rr_apx_townuuid_1_callback' ), // callback
			'towncontrol-admin', // page
			'towncontrol_setting_section' // section
		);
	}

	public function towncontrol_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['rr_apx_api_key_0'] ) ) {
			$sanitary_values['rr_apx_api_key_0'] = sanitize_text_field( $input['rr_apx_api_key_0'] );
		}

		if ( isset( $input['rr_apx_townuuid_1'] ) ) {
			$sanitary_values['rr_apx_townuuid_1'] = sanitize_text_field( $input['rr_apx_townuuid_1'] );
		}

		return $sanitary_values;
	}

	public function towncontrol_section_info() {
		
	}

	public function rr_apx_api_key_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="towncontrol_option_name[rr_apx_api_key_0]" id="rr_apx_api_key_0" value="%s">',
			isset( $this->towncontrol_options['rr_apx_api_key_0'] ) ? esc_attr( $this->towncontrol_options['rr_apx_api_key_0']) : ''
		);
	}

	public function rr_apx_townuuid_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="towncontrol_option_name[rr_apx_townuuid_1]" id="rr_apx_townuuid_1" value="%s">',
			isset( $this->towncontrol_options['rr_apx_townuuid_1'] ) ? esc_attr( $this->towncontrol_options['rr_apx_townuuid_1']) : ''
		);
	}

}
if ( is_admin() )
	$towncontrol = new Api_for_Apex_Towncontrol_Options();

/* 
 * Retrieve this value with:
 * $towncontrol_options = get_option( 'towncontrol_option_name' ); // Array of All Options
 * $api_key_0 = $towncontrol_options['api_key_0']; // api_key
 * $townuuid_1 = $towncontrol_options['townuuid_1']; // townUUID
 */
