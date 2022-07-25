<?php

// Check
defined('ABSPATH') || exit;
defined('WP_UNINSTALL_PLUGIN') || exit;
global $wpdb;

// Remove options
foreach (wp_load_alloptions() as $option => $value) {
	if (strpos($option, 'smp_') === 0) {
		delete_option($option);
	}
}
$table_name = $wpdb->prefix . "smp_quick_menu";
$sql_delete = "DROP TABLE IF EXISTS $table_name";
$wpdb->query( $sql_delete );