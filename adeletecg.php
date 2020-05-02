<?php
    //資料庫+資料表連線---------------------------------------------------------------
    header("Content-Type:text/html;charset=utf-8");
    include("connMysql.php");           //連線資料庫、選擇資料庫
    $id = $_GET['id'];                  //獲取網址的id(也就是分類的cid)
    $sql = "DELETE FROM `category` where `cid` = '$id'"; //選擇資料表並選擇row
    mysqli_query($db_link,$sql);
    header("location:aedit.php");
?>