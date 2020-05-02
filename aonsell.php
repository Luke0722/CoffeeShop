<?php
    //資料庫+資料表連線---------------------------------------------------------------
    header("Content-Type:text/html;charset=utf-8");
    include("connMysql.php");                           //連線資料庫、選擇資料庫
    $id = $_GET['id'];                                  //獲取網址的id(也就是分類的cid)
    $sql = "SELECT * FROM `menu` Where `tid` = '$id'";  //選擇資料表並選擇row
    $result = mysqli_query($db_link,$sql); 
    $menu=mysqli_fetch_array($result);             //因為有指定的row
    if($menu[4]==0){
        $sql = "UPDATE `menu`
                SET `tsale`='1'
                WHERE `tid` = '$id'";
    }
    else if($menu[4]==1){
        $sql = "UPDATE `menu`
                SET `tsale`='0'
                WHERE `tid` = '$id'";
    }
    mysqli_query($db_link,$sql);
    header("location:aedit.php");
?>