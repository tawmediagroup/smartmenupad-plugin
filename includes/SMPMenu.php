<?php 

defined('ABSPATH') || exit;

require_once 'SMPBase.php';
require_once 'SMPTotals.php';

/*
 * Menu List Controller
 */    
 
class SMPMenu extends SMPBase {
	
	public function __construct() {
		parent::__construct();
	}
	public function SMPMenuList() {
		$this->smp_page_access();
		$smp_allmenulist = array();
		$error_message = '';
		$smp_last_synced = 'Never';
		if( $this->smpuser) {
			if(!get_option('smp_allmenulist')) {
				$url = $this->smp_api_url("/api/Menu/GetMenuItemList?userId=".$this->smp_user_id);
				$response = $this->smp_remote_get($url, true);
				if ( is_wp_error( $response ) ) {
					$error_message = $response->get_error_message();
				} else {
					$menulist = json_decode(wp_remote_retrieve_body( $response ), true);  
					$upload_dir =  plugin_dir_path(__SMPFILE__).'assets/img/product';
					$upload_url =  plugin_dir_url(__SMPFILE__).'assets/img/product';
					if(!file_exists($upload_dir)){
						mkdir($upload_dir, 0777, true);
					}
					if(!isset($menulist['message'])) {
						foreach($menulist as $key => $item_images){
							$images_data  = $item_images['imagePath'];
							$file_name = basename($images_data);
							$uploadfile = $upload_dir. '/' .$file_name;
							$contents = file_get_contents($images_data);
							$savefile = fopen($uploadfile, 'w');
							fwrite($savefile, $contents);
							fclose($savefile);
							$menulist[$key]['imagePath'] = $upload_url. '/'.$file_name; 	
						}
						update_option('smp_allmenulist',$menulist); 
						$smp_last_synced = date('Y-m-d H:i:s');
						update_option('smp_last_synced', $smp_last_synced); 
						$smp_allmenulist = get_option('smp_allmenulist');
					} else {
						$error_message = $menulist['message'];
					}
				}
				$obj = new SMPTotals();
				update_option('smp_total_customers', $obj->totals['customers']); 
				update_option('smp_total_orders', $obj->totals['orders']); 
			}
			$smp_allmenulist = get_option('smp_allmenulist');
			if(get_option('smp_last_synced')) {
				$smp_last_synced = date('d M,Y h:ia', strtotime(get_option('smp_last_synced')));
			}
		}
		else {
			if ( wp_redirect( $this->smp_admin_url('smp-connect') ) ) {
				exit;
			}
		}
		include(sprintf("%s/templates/admin/smp_menu_list.php", dirname(__SMPFILE__)));
	}
}