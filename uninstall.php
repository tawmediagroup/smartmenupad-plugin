<?php

// Check
defined('ABSPATH') || exit;
defined('WP_UNINSTALL_PLUGIN') || exit;

// Remove options
foreach (wp_load_alloptions() as $option => $value) {
	if (strpos($option, 'smp_') === 0) {
		delete_option($option);
	}
}
