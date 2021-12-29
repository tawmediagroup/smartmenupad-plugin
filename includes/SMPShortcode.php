<?php 

defined('ABSPATH') || exit;

require_once 'SMPBase.php';

/*
 * Shortcode Controller
 */    
 
class SMPShortcode extends SMPBase {
	
	private $heading_color = "#000000";
	private $description_color = "#878787";
	private $price_color = "#dd3333";
	private $button_bg_color = "#FFFFF";
	private $button_text_color = "#dd3333";
	private $button_bg_hover_color = "#dd3333";
	private $button_text_hover_color = "#FFFFF";

	public function __construct() {
		add_shortcode(
			'smart_menupad', 
			array($this, 'SMPShortcode')
		);
	}
	public function SMPCreateShortcode() {
		global $wpdb;
		$this->smp_page_access();
		$msg = "";
		$table_name = $wpdb->prefix . 'smp_quick_menu';
		$quickmenuid = "";
		$smp_allmenu = get_option('smp_allmenulist');
		$smp_allmenu_category_wise = [];
		$smp_category = [];
		$default_category = 0;
		foreach ($smp_allmenu as $key => $value) {
			$smp_allmenu_category_wise[$value["categoryId"]][] = $smp_allmenu[$key];
			$smp_category[$value["categoryId"]] = $value["categoryName"];
			$default_category = $value["categoryId"];
		}
		if(isset($_GET['catId']) && !empty($_GET['catId'])) {
			$default_category = $_GET['catId'];
		}
		if(isset($_POST['menuids']) && count($_POST['menuids']) > 0) {
			$data = [ 
				'time' => current_time( 'mysql' ), 
				'title' => $_POST['title'], 
				// 'menu_category' => $_POST['menu_category'], 
				'layout_view' => $_POST['layout_view'], 
				'layout_column' => $_POST['layout_column'],
				'image_border' => implode(",", $_POST['imageborder']), 
				'heading_color' => $_POST['heading_color'], 
				'description_color' => $_POST['description_color'], 
				'price_color' => $_POST['price_color'], 
				'button_bg_color' => $_POST['button_bg_color'], 
				'button_bg_hover_color' => $_POST['button_bg_hover_color'],
				'button_text_color' => $_POST['button_text_color'], 
				'button_text_hover_color' => $_POST['button_text_hover_color'],				
				'button_border' => implode(",", $_POST['orderbtnborder']),
				'text' => 0, 
				'url' => implode(",",$_POST['menuids']), 
			];
			
			if(isset($_POST['add_shortcode'])) {	
				$wpdb->insert( 
					$table_name, 
					$data 
				);
				$msg = "Successfully Created !!!";
			} else if(isset($_POST['update_shortcode']) && isset($_POST['smp_quick_menu_id'])) {		
				$where = [ 'id' => $_POST['smp_quick_menu_id'] ];
				$wpdb->update( 
					$table_name, 
					$data,
					$where
				);
				$msg = "Successfully Updated !!!";
			}
		}
		
		if(isset($_GET['quickmenuid']) && $_GET['quickmenuid'] != "new") {
			$quickmenuid = $_GET['quickmenuid'];
			$one_shortcode_data = $wpdb->get_row("SELECT * FROM $table_name where id = ".$quickmenuid." ");
		} else {
			// New Shortcode and Added List
			$quickmenuid = isset($_GET['quickmenuid'])? "new":"";
			$all_shortcode_data = $wpdb->get_results("SELECT * FROM $table_name ");		
		}
		include(sprintf("%s/templates/admin/smp_create_shortcode.php", dirname(__SMPFILE__)));   
	} 
	
	
	public function SMPShortcode($atts) { 
		if(!isset($atts['id'])) {
			return false;
		}
		global $wpdb;
		ob_start();		
		$table_name = $wpdb->prefix . 'smp_quick_menu';
		$menuGroupId = $atts['id'];	
		$one_shortcode_data = $wpdb->get_row("SELECT * FROM $table_name where id = $menuGroupId "); 
		if(!$one_shortcode_data) {
			return false;
		}
		$layout_column  = $one_shortcode_data->layout_column; 
		$view_layout = $one_shortcode_data->layout_view; 
		$smp_allmenu = get_option('smp_allmenulist');

		if($view_layout == 1){
			include(sprintf("%s/templates/front/view/smp_grid.php", dirname(__SMPFILE__)));
		} else {
			include(sprintf("%s/templates/front/view/smp_list.php", dirname(__SMPFILE__)));
		}
		return ob_get_clean();
	}
}
