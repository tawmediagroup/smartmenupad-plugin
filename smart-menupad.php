<?php
/**
 * Plugin Name: SMART MENU PAD
 * Plugin URI:	http://smartmenupad.com
 * Description: SMART MENU PAD
 * Version: 	1.0.0
 * Author: 		SMART MENU PAD
 * Requires at least: 5.2
 * Requires PHP: 7.0
 * Text Domain: smart-menupad
 */

defined('ABSPATH') || exit;

ob_start();
define( '__SMPFILE__', __FILE__ );
global $smp_db_version;
$smp_db_version = '1.0';

require plugin_dir_path( __FILE__ ) . 'includes/SMPInit.php';
new SMPInit();
require plugin_dir_path( __FILE__ ) . 'includes/SMPAjax.php';
new SMPAjax();
if(!is_admin()) {
	$shortcode = new SMPShortcode();
}

require plugin_dir_path( __FILE__ ) . 'includes/SMPLogout.php';
new SMPLogout();

ob_clean();

?>