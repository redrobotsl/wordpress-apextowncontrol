<?php
/**
 * API for Apex TownControl
 *
 * @package       APIFORAPEX
 * @author        Nolan Perry, LLC
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   API for Apex TownControl
 * Plugin URI:    https://darknebula.world/
 * Description:   Apex
 * Version:       1.0.0
 * Author:        Nolan Perry, LLC
 * Author URI:    https://darknebula.world
 * Text Domain:   api-for-apex-towncontrol
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with API for Apex TownControl. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * HELPER COMMENT START
 * 
 * This file contains the main information about the plugin.
 * It is used to register all components necessary to run the plugin.
 * 
 * The comment above contains all information about the plugin 
 * that are used by WordPress to differenciate the plugin and register it properly.
 * It also contains further PHPDocs parameter for a better documentation
 * 
 * The function APIFORAPEX() is the main function that you will be able to 
 * use throughout your plugin to extend the logic. Further information
 * about that is available within the sub classes.
 * 
 * HELPER COMMENT END
 */

// Plugin name
define( 'APIFORAPEX_NAME',			'API for Apex TownControl' );

// Plugin version
define( 'APIFORAPEX_VERSION',		'1.0.1' );

// Plugin Root File
define( 'APIFORAPEX_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'APIFORAPEX_PLUGIN_BASE',	plugin_basename( APIFORAPEX_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'APIFORAPEX_PLUGIN_DIR',	plugin_dir_path( APIFORAPEX_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'APIFORAPEX_PLUGIN_URL',	plugin_dir_url( APIFORAPEX_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once APIFORAPEX_PLUGIN_DIR . 'core/class-api-for-apex-towncontrol.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Nolan Perry, LLC
 * @since   1.0.0
 * @return  object|Api_For_Apex_Towncontrol
 */
function APIFORAPEX() {
	return Api_For_Apex_Towncontrol::instance();
}

APIFORAPEX();
