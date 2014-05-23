<?php 
/**
 * filename:getFoodBySite
 * author:liwei
 * date:2013/12/24
 * function 通过站点id获取其所有菜品信息
 */
	include ("../db/DBHelper.class.php");
	$siteid = $_GET["siteid"];
	if(!$siteid){
		$sql = "select * from food";
	}else{
		$sql = "select * from food where siteid=".$siteid;
	}
	$db =new DBHelper();
	$db->selectDB("FoodOrder");
	$results =$db->select($sql);
	$callback= $_GET["callback"];
	if($callback){
		echo $callback.'('.json_encode($results).')';
	}else{
		echo json_encode($results);
	}
?>
