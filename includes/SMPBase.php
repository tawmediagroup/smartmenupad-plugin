<?php 

defined('ABSPATH') || exit;

/*
 * Base Controller
 */    
class SMPBase
{
	protected $smpuser;
	protected $smp_user_id; 
	/**
	 * SMP API URL
	 *
	 * @var string
	 */
	private $smp_api = 'https://api.smartmenupad.com';
	
	protected function __construct() {
		$this->smpuser = $this->smp_user();
		$this->smp_user_id = $this->smp_user_id();
	}
	
	/**
	 * Make Call post
	 *
	 * @param $url
	 * @param $data
	 * @param $token
	 * @return array|WP_Error
	 */
	protected function smp_remote_call($url,  $data = array(), $token = false){
	
		$headers = $this->smp_http_headers($token);
		
		$response = wp_remote_post(
			$url, 
			array(
				'method' => 'POST',
				'headers' => $headers,
				'sslverify' => false,
				'httpversion' => '1.0',
				'body' => $data
				// 'body' => json_encode($data)
			)
		);
		return $response;
	}
	
	/**
	 * Make Call get
	 *
	 * @param $url
	 * @param $token
	 * @return array|WP_Error
	 */
	protected function smp_remote_get($url, $token = false) {
		
		$headers = $this->smp_http_headers($token);
		$response = wp_remote_get( 
				esc_url_raw($url),
				array(
					'headers' => $headers,
					'timeout' => 120, 
					'httpversion' => '1.1'
				)
		);
		return $response;
	}
	
	/**
	 * Remote Call Headers
	 *
	 * @param $token
	 * @return array
	 */
	
	private function smp_http_headers($token = false) {
		$headers = array(
				"Accept" => "application/json",
				// "Content-Type" => "application/json"
		);
		if($token) {
			if($access_token = $this->smp_access_token()) {
				$headers["Authorization"] = "Bearer " . $access_token;
			}
		}
		
		return $headers;
	}
	
		
	/**
	 * Get SMP API URL
	 *
	 * @return string
	 */
	protected function smp_api_url($path) {
		return trailingslashit($this->smp_api).$path;
	}
	
	
	/**
	 * Get Plugin files
	 *
	 * @param $file
	 * @return string
	 */
	protected function smp_plugin_url($file) {
		return plugins_url($file, __SMPFILE__);
	}
	
	/**
	 * Admin Plugin Pages
	 *
	 * @param $page
	 * @return string
	 */
	
	protected function smp_admin_url($page) {
		return admin_url( '/admin.php?page=' . $page );
	}
	
	/**
	 * Load the required dependencies for this plugin.
	 *
	 */
	protected function smp_user() {		

		return get_option("smp_connect")??false;

	}
	
	protected function smp_user_id(){
		if($this->smpuser) {
			return $this->smpuser["userId"];
		} else {
			return false;
		}
	}
	
	private function smp_access_token(){
		if($this->smpuser) {
			return $this->smpuser["access_token"];
		} else {
			return false;
		}
	}
	
	
	
	protected function smp_page_access() {
		if(!current_user_can('manage_options')) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
	}
	
	protected function smp_total_orders() {
		if($total = get_option('smp_total_orders')) {
			return $total;
		} else {
			return 0;
		}
	}
	protected function smp_total_customers() {
		if($total = get_option('smp_total_customers')) {
			return $total;
		} else {
			return 0;
		}
	}
	
	protected function smp_count_totals($endPoint, $query) {
		$url = $this->smp_api_url($endPoint.$query);
		$response = $this->smp_remote_get( $url, true );
		if ( !is_wp_error( $response ) ) {
			$data = json_decode(wp_remote_retrieve_body( $response ), true);
			if(is_array($data)) {
		    	return count($data);
			} else {
				return 0;
			}
		}
		return 0;
	}
}
  ?>