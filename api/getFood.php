<?php
    include "../db/DBHelper.php";
    $db = new DBHelper;
    $db->selectDB("FoodOrder");
    $selectSql = "select * from food";
    $result = $db->select($selectSql);
    $db->close();
   $callback = $_GET["callback"];
    if ($callback){
        echo $callback."(".json_encode($result).")";
    }else{
        echo json_encode($result);
    }
?>
