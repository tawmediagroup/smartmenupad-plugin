<?php 

defined('ABSPATH') || exit;

require_once 'SMPBase.php';

/*
 * Count Total Products/Customers/Orders
 */    
 
class SMPTotals extends SMPBase {
	
	public $totals = array();
	
	public function __construct() {
		parent::__construct();
		$this->totals['orders'] = $this->SMPTotalOrders();
		$this->totals['customers'] = $this->SMPTotalCustomers();
	}
	
	public function SMPTotalOrders() {

		$endPoint = "api/Order/GetOrders";
		$params = "?orderId=0&userId=".$this->smp_user_id."&pageNumber=0&pageSize=0";		
		return $this->smp_count_totals($endPoint, $params);
	}
	
	
	public function SMPTotalCustomers() {

		$endPoint = "api/Customer/GetCustomers";
		$params = "?customerId=0&userId=".$this->smp_user_id."&pageNumber=0&pageSize=0";		
		return $this->smp_count_totals($endPoint, $params);
	}
}