


<?php 

defined('ABSPATH') || exit;

require_once 'SMPBase.php';
require_once 'SMPConnect.php';
require_once 'SMPMenu.php';
require_once 'SMPShortcode.php';

/*
 * Init Controller
 */    
 
class SMPInit extends SMPBase {
	
	public function __construct() {
		
		register_activation_hook( 
				__SMPFILE__,
				array($this, 'SMPActivatePlugin' )
		);
		
		add_action(
				'admin_menu',
				array($this, 'SMPInitPlugin')
		);
		
		add_action( 
				'admin_enqueue_scripts', 
				array($this, 'SMPAdminStyle') 
			);
		add_action( 
				'wp_head', 
				array($this, 'SMPFrontendStyle') 
			);
		add_action(  'plugins_loaded', 
					array($this, 'SMPUpdateversion')
		);
		
	}
	
	public function SMPActivatePlugin() {
		
		global $wpdb;
		global $smp_db_version;

		$table_name = $wpdb->prefix . 'smp_quick_menu';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				time datetime NULL,
				title varchar(255) NOT NULL,
				menu_category varchar(255) NULL,
				layout_view varchar(255) NULL,
				layout_column varchar(255) NULL,
				image_border varchar(255) NULL,
				heading_color varchar(255) NULL,
				description_color varchar(255) NULL,
				price_color varchar(255) NULL,
				button_bg_color varchar(255) NULL,
				button_bg_hover_color varchar(255) NULL,
				button_text_color varchar(255) NULL,
				button_text_hover_color varchar(255) NULL,
				button_border varchar(255) NULL,
				show_order_now INT(11) NULL DEFAULT NULL ,
				text text NULL,
				url varchar(55) DEFAULT '' NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'smp_db_version', $smp_db_version );
	}
	
	public function SMPUpdateversion(){
		global $wpdb;
		global $smp_db_version;
		if( get_site_option('smp_db_version')!= $smp_db_version){
		$table = $wpdb->prefix . 'smp_quick_menu';
		$sql= $wpdb->query("ALTER TABLE `{$table}` ADD show_order_now INT(11) NULL DEFAULT NULL ;");
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		update_option( 'smp_db_version', $smp_db_version );
		}
	}
	
	
	public function SMPInitPlugin() {
		$connect = new SMPConnect();
		$menu = new SMPMenu();
		$shortcode = new SMPShortcode();
		add_menu_page(
				__('Smart Menu Pad', 'smart-menupad'),
				__('Smart Menu Pad', 'smart-menupad'),
				'manage_options',
				'smp-menu-list',
				array($menu, 'SMPMenuList'),
				$this->smp_plugin_url('assets/img/smp-icon.png' ),
				59
		);
		add_submenu_page(
				'',
				__('SMP Connect', 'smart-menupad'),
				__('SMP Connect', 'smart-menupad'),
				'manage_options', 
				'smp-connect', 
				array($connect, 'SMPprocessConnect')
		);
		add_submenu_page(
				'smp-menu-list',
				__('SMP ShortCode', 'smart-menupad'),
				__('SMP ShortCode', 'smart-menupad'),
				'manage_options', 
				'smp-shortcode', 
				array($shortcode, 'SMPCreateShortcode')
		);
	}

	public function SMPAdminStyle($hook) {
		if (strpos($hook, 'smp-') === false ) {
			return;
		}
		wp_enqueue_style( 'smp-bs-style', $this->smp_plugin_url('assets/css/bootstrap.min.css'), [], '5.0.2' );
	    wp_enqueue_style( 'smp-style', $this->smp_plugin_url('assets/css/smp.css'), [], '1.0' );
		wp_enqueue_script('smp-bs-script', $this->smp_plugin_url('assets/js/bootstrap.min.js'), [], '5.1.3');
	    wp_enqueue_script('smp-script', $this->smp_plugin_url('assets/js/custom.js'), array('jquery','wp-color-picker'), '1.0', 1 );
	}
	
	public function SMPFrontendStyle() {
		
	    wp_enqueue_style( 'smp-style', $this->smp_plugin_url('assets/css/smp.css'), [], '1.0' );
	    wp_enqueue_style( 'smp-bs-style', $this->smp_plugin_url('assets/css/bootstrap.min.css'), [], '5.0.2' );
	}
}