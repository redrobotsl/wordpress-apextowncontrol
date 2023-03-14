<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * HELPER COMMENT START
 * 
 * This class is used to bring your plugin to life. 
 * All the other registered classed bring features which are
 * controlled and managed by this class.
 * 
 * Within the add_hooks() function, you can register all of 
 * your WordPress related actions and filters as followed:
 * 
 * add_action( 'my_action_hook_to_call', array( $this, 'the_action_hook_callback', 10, 1 ) );
 * or
 * add_filter( 'my_filter_hook_to_call', array( $this, 'the_filter_hook_callback', 10, 1 ) );
 * or
 * add_shortcode( 'my_shortcode_tag', array( $this, 'the_shortcode_callback', 10 ) );
 * 
 * Once added, you can create the callback function, within this class, as followed: 
 * 
 * public function the_action_hook_callback( $some_variable ){}
 * or
 * public function the_filter_hook_callback( $some_variable ){}
 * or
 * public function the_shortcode_callback( $attributes = array(), $content = '' ){}
 * 
 * 
 * HELPER COMMENT END
 */

/**
 * Class RR_APX_Shortcodes_Arrests
 *
 * Thats where we bring the plugin to life
 *
 * @package		APIFORAPEX
 * @subpackage	Classes/RR_APX_Shortcodes_Arrests
 * @author		Nolan Perry, LLC
 * @since		1.0.0
 */
class RR_APX_Shortcodes_Arrests{

	/**
	 * Our RR_APX_Shortcodes_Arrests constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	add_shortcode( 'show_town_arrests', array( $this, 'create_show_town_arrests_shortcode' ));
    add_action( 'wp_enqueue_scripts', array( $this, 'rr_apx_requirements' ) );

	
	}
	public function rr_apx_requirements(){
		    wp_enqueue_style( 'datatables-apex', 	APIFORAPEX_PLUGIN_URL .  'assets/jquery.dataTables.min.css', false, '1.1', 'all');
wp_enqueue_script( 'datatables-script-apex', APIFORAPEX_PLUGIN_URL .  'assets/jquery.dataTables.min.js', array( 'jquery' ), 1.1 );
	    
	}
	
	public function create_show_town_arrests_shortcode( $atts = array(), $content = '' ) {


	// Attributes
	$atts = shortcode_atts(
		array(
			'time' => '720',
		),
		$atts
	);
 
$api_key_0 = get_option( 'rr_apx_api_key' ); // Array of All Options
$townuuid_1 = get_option( 'rr_apx_townuuid' );

$theurltouse = 'http://www.apexdesignssl.com/api/towncontrol/Arrest/List/' . $townuuid_1 . '/' . $atts['time'];
$args = array(
    'headers' => array(
        'token' => $api_key_0
    )
);
$response = wp_remote_get( $theurltouse, $args );

$bodyofchrist =  wp_remote_retrieve_body( $response );
$d1 = json_decode($bodyofchrist);
$results = "";
foreach ($d1 as $query)
{
$charges1 = "";
if (isset($query->released)){
    $query->status = "Released";
    $releasedate = date_create($query->releaseDate);
    $releasedate = date_format($releasedate,"Y/m/d H:i:s");
}
else{
    
$query->releaseDate = "N/A";
}

foreach ($query->charges as $charge)
{
$data2 = $charge->remarks . "<br>";
$charges1 .= $data2;
}

$arrestdate = date_create($query->arrestDate);
$data1 = "<tr><td>" . $query->fullName . "(". $query->slUsername  .")</td><td>" . $query->status  ."</td><td>" . $charges1  ."</td><td>" . date_format($arrestdate,"Y/m/d H:i:s")  ."</td><td>" . $query->releaseDate  ."</td></tr>";
$results .= $data1;
}

$output = '

<table id="apexArrests">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Charges</th>
            <th>Arrest Date</th>
            <th>Release Date</th>
        </tr>
    </thead>
    <tbody>
       '.
       $results
       
       .'
       
    </tbody>
</table>
<script>
let table = new DataTable("#apexArrests");
</script>

';
return $output;
}


	

}



