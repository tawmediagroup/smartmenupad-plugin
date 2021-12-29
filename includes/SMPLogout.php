<?php

defined('ABSPATH') || exit;
require_once 'SMPBase.php';

class SMPLogout extends SMPBase
{
   	private $status = array();
	
	public function __construct() {
	   	add_action(
	   		'wp_ajax_smp_logout',
	   		array( $this, 'SMPClear' ) 
	   	);
	}
	
	public function SMPClear() {
		delete_option('smp_connect');
		delete_option('smp_login');
		delete_option('smp_allmenulist');
		delete_option('smp_last_synced');
		delete_option('smp_total_customers');
		delete_option('smp_total_orders');
		$this->status['status'] = 'SUCCESS';
		$this->status['redirect'] = $this->smp_admin_url("smp-connect");
		echo json_encode($this->status);
		wp_die();
	}
}   
