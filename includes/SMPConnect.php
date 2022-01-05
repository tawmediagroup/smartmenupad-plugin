<?php 

defined('ABSPATH') || exit;

require_once 'SMPBase.php';

/*
 * Connect Controller
 */    
 
class SMPConnect extends SMPBase {
	
	public function SMPprocessConnect() {
		
		$this->smp_page_access();
		global $wpdb;
		$errorMsg = '';
		$error = false;
		$grant_type = '';
		$username = '';
		$password = '';
		if(get_option('smp_login')) {
			$smp_login = get_option('smp_login');
			$grant_type = $smp_login['grant_type'];
			$username = $smp_login['username'];
			$password = $smp_login['password'];
		} else if(isset($_POST["connect_smp"])) {
			$grant_type = sanitize_text_field($_POST['grant_type']);
			$username = sanitize_email($_POST['username']);
			$password = $_POST['password'];
		}
		
		if(!empty($grant_type) && !empty($username) && !empty($password)) {
			$data = array(
				'grant_type' => $grant_type,
				'username' => $username, 
				'password' => $password
			);
			
			$response = $this->smp_remote_call($this->smp_api_url('token'), $data);
			if ( is_wp_error( $response ) ) {
				$errorMsg = $response->get_error_message();
				$error = true;
			} 
			else {
				$resp = json_decode(wp_remote_retrieve_body( $response ), true);
				if(isset($resp['access_token'])) {
					if(get_option('smp_login')) {
						$smp_login_details = get_option('smp_login');
						if($smp_login_details['username'] != $username) {
							$table_name = $wpdb->prefix . 'smp_quick_menu';
							$wpdb->query("TRUNCATE TABLE $table_name ");
						}
					}
					update_option('smp_login', $data);
					update_option('smp_connect',$resp);
				} else {
					$errorMsg = isset($resp["error_description"])?$resp["error_description"]:"Please contact to Admin";
					$error = true;
				}
			}
			if(!$error) {
				if ( wp_redirect( $this->smp_admin_url('smp-menu-list') ) ) {
					exit;
				}
			}
		}
		include(sprintf("%s/templates/admin/smp_connect.php", dirname(__SMPFILE__)));
	}
}