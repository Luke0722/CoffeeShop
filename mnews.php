<?php 
    session_start();
    if (!isset($_SESSION['user_authority']))
        header('Location:login.php');
    else if ($_SESSION['user_authority']!=0)
        header('Location:index.php');
?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta http-equiv="Content-Language" content="zh-TW">
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> <!--RWD-->
        <title>米羅咖啡</title>
        <link rel="stylesheet" href="member.css">
        <link rel="stylesheet" href="general.css"> <!--各頁面通用CSS-->
    </head>
    <body>
        <?php
            //資料庫+資料表連線---------------------------------------------------------------
            header("Content-Type:text/html;charset=utf-8");
            include("connMysql.php");              //連線資料庫、選擇資料庫
            $sql = "SELECT * FROM  `users` WHERE `uid`= '{$_SESSION["user_id"]}'";       //選擇資料表
            $result = mysqli_query($db_link,$sql);
            //nav-bar
            include("navigation.php") ;  
            //aside
            include("aside.php") ;  
        ?>
        <main>
            
            <!--頁面內容-->
            <div class="member">    
                <h3>敬請期待</h3>
            </div>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>
