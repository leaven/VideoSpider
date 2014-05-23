<?php
    include "db/DBHelper.php";
    $foodId = $_POST["selectFood"];
    $userName = $_POST["userName"];
    $selectSql ="select * from user where name='".$userName."'";
    $db = new DBHelper;
    $db->selectDB("user");
    if ($db->query($selectSql)){
        echo $userName."同学，您已定过餐";
        return false;
    }
    $insertSql = "insert into user(name,food_id) values('".$userName."',$foodId)";
    $db->selectDB("FoodOrder");
    $db->query($insertSql);
    $db->close();
    echo $userName."同学，订单已收到，请耐心等待。。。。。";
?>
