<?php 

defined('ABSPATH') || exit;

require_once 'SMPBase.php';
require_once 'SMPTotals.php';

/*
 * Ajax Controller
 */    
 
class SMPAjax extends SMPBase {

	public function __construct() {
		parent::__construct();
		add_action( 
				"wp_ajax_update_menu", 
				array($this, "SMPUpdateMenu" )
		);
		add_action( 
				"wp_ajax_nopriv_update_menu", 
				array($this, "SMPUpdateMenu" )
		);
	}
	public function SMPUpdateMenu() {
		$status['status'] = 'SUCCESS';
		$status['message'] = '';
		$url = $this->smp_api_url("/api/Menu/GetMenuItemList?userId=".$this->smp_user_id);
		$response = $this->smp_remote_get($url, true);
		if ( !is_wp_error( $response ) ) {
			$menulist = json_decode(wp_remote_retrieve_body( $response ), true);
			if(!isset($menulist['message'])) {
				update_option('smp_allmenulist', $menulist); 
				$updated_at = date('Y-m-d H:i:s');
				update_option('smp_last_synced', $updated_at); 
				$obj = new SMPTotals();
				update_option('smp_total_customers', $obj->totals['customers']); 
				update_option('smp_total_orders', $obj->totals['orders']); 
			} else {
				$status['status'] = 'ERROR';
				$status['message'] = $menulist['message'];
			}
			
		} else {
			$status['status'] = 'ERROR';
			$status['message'] = $response->get_error_message();
		}
		echo json_encode($status);
		wp_die();
	}
}
