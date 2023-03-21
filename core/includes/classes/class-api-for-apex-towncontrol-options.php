<?php

class Api_for_Apex_Towncontrol_Options {
	private $towncontrol_apikey;
    private $towncontrol_town;
	public function __construct() {
		
	}
public function towncontrol_register_stuff(){
    add_action( 'admin_menu', array( $this, 'towncontrol_add_plugin_page' ) );
	add_action( 'admin_init', array( $this, 'towncontrol_page_init' ) );
}
	public function towncontrol_add_plugin_page() {
		add_options_page(
			'towncontrol', // page_title
			'towncontrol', // menu_title
			'manage_options', // capability
			'towncontrol', // menu_slug
			array( $this, 'towncontrol_create_admin_page' ) // function
		);
	}

	public function towncontrol_create_admin_page() {
		$this->towncontrol_town = get_option( 'rr_apx_townuuid' );
		$this->towncontrol_apikey = get_option('rr_apx_apikey');
		
		?>

		<div class="wrap">
			<h2>TownControl</h2>
			<p>Settings for Virtual Roleplay Solutions API.</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'rr_apx_group' );
					do_settings_sections( 'towncontrol' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function towncontrol_page_init() {
		register_setting(
			'rr_apx_group', // option_group
			'rr_apx_api_key', // option_name
			array( $this, 'towncontrol_sanitize' ) // sanitize_callback
		);
		register_setting(
			'rr_apx_group', // option_group
			'rr_apx_townuuid', // option_name
			array( $this, 'towncontrol_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'rr_apx_settings_section', // id
			'Settings', // title
			array( $this, 'towncontrol_section_info' ), // callback
			'towncontrol' // page
		);
     add_settings_field(
			'rr_apx_api_key', // id
			'rr_apx_api_key', // title
			array( $this, 'rr_apx_api_key_callback' ), // callback
			'towncontrol', // page
			'rr_apx_settings_section' // section
		);

		add_settings_field(
			'rr_apx_townuuid', // id
			'rr_apx_townUUID', // title
			array( $this, 'rr_apx_townuuid_callback' ), // callback
			'towncontrol', // page
			'rr_apx_settings_section' // section
		);
	
	}

	public function towncontrol_sanitize($input) {
return	sanitize_text_field( $input );
	
	}

	public function towncontrol_section_info() {
		echo "Set your API Key and Town UUID Below<br><br>The following shortcodes are available<br>
		
		
		<ul>
		
		<li><b>[show_town_arrests time='720']</b> - This shows all the towns arrests in within the last 30 days by default but can be changed by changing the attribute 'time', which is in hours.  </li>
		<li><b>[show_town_phonebook]</b> - This shows the entirety of citizens registered in your town by their name, address, and the phone number. (hint: this is a solution for the NorPhone.)</li>
		<li><b>[show_town_roster group='police']</b> - This shows all your staff on the roster for the specified group, group can be 'police', 'fire', 'legal','service', 'education', and will default to police if you don't specify</li>
		</ul>

	
		
		<br> <br>
		
		<p>The following command are under development and will be available in a further update:</p>
		
		<ul>
  <li><b>[show_town_warrants]</b> - Shows any Active Warrants.(Be Cautious of this being used IC)</li>
   <li><b>[show_town_laws]</b> - Shows Citizens all of the Laws of the Selected Town. </li>
     <li><b>[show_town_incidents]</b> - A Transparency Function, letting citizens see short narratives of what happened on each incident, let's them know where the taxpayer money is going.</li>
</ul>


		
		";
	}

	public function rr_apx_api_key_callback() {
		printf(
			'<input class="regular-text" type="text" name="rr_apx_api_key" id="rr_apx_api_key" value="%s">',
			isset( $this->towncontrol_apikey ) ? esc_attr( $this->towncontrol_apikey) : ''
		);
	}

	public function rr_apx_townuuid_callback() {
		printf(
			'<input class="regular-text" type="text" name="rr_apx_townuuid" id="rr_apx_townuuid" value="%s">',
			isset( $this->towncontrol_town ) ? esc_attr( $this->towncontrol_town) : ''
		);
	}

}
if ( is_admin() )
	$towncontrol = new Api_for_Apex_Towncontrol_Options();

/* 
 * Retrieve this value with:
 * $towncontrol_options = get_option( 'rr_apx_towncontrol_option_name' ); // Array of All Options
 * $api_key_0 = $towncontrol_options['rr_apx_api_key_0']; // api_key
 * $townuuid_1 = $towncontrol_options['rr_apx_townuuid_1']; // townUUID
 */
