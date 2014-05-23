<?php
/**
 * @file:Site.php
 * @author:liwei
 * @date:2013/12/24
 * @function: 站点信息维护类
 */
	include("../db/DBHelper.class.php");
	class Site{
		private $db;
		public function __construct(){
		$this->db = new DBHelper();
			$this->db->selectDB("FoodOrder");
		}	
		public function getAllSite(){
			$sql="select * from site where siteid=198";
			$results = $this->db->select($sql);
			echo json_encode($results);			
		}
	
	
	}
	$site = new Site();
	$site->getAllSite();
	
?>
