<?php
    include "../db/DBHelper.php";
    $db = new DBHelper();
    $db->selectDB("FoodOrder");
    $selectSql = "select * from user";
    $results = $db->select($selectSql);
    $personInfo = array();
    for($i = 0, $len =count($results);$i < $len; $i++){
        $selectSql = "select name,price from food where id=".$results[$i]["food_id"];
        $result = $db->select($selectSql);
        $result[0]["userName"] = $results[$i]["name"];
        $personInfo[]=$result[0];
    }
    $callback = $_GET["callback"];
    if($callback){
        echo $callback."(".json_encode($personInfo).")";
    }else{
        echo json_encode($personInfo);
    }
?>
