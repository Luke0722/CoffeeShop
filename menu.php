<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta http-equiv="Content-Language" content="zh-TW">
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> <!--RWD-->
        <title>米羅咖啡</title>
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="general.css"> <!--各頁面通用CSS-->
        <script type="text/javascript">
            function BacktoEdit() {
                location.href = "aedit.php";
            };
        </script>
    </head>

    <body>
        <?php
            //資料庫+資料表連線---------------------------------------------------------------
            header("Content-Type:text/html;charset=utf-8");
            include("connMysql.php");           //連線資料庫、選擇資料庫
            $sql1 = "SELECT * FROM  `category`";//選擇資料表
            $sql2 = "SELECT * FROM  `menu`";    //選擇資料表
            $result1 = mysqli_query($db_link,$sql1); 
            $result2 = mysqli_query($db_link,$sql2); 
            //nav-bar
            include("navigation.php");
        ?>
        <main>
            <!--頁面內容-->
            <div class="content">
                <div class="editbut">
                    <?php
                        //必須帳號是管理者(mis)才能編輯商品
                        if(isset($_SESSION['account'])&&$_SESSION['account']=="mis")
                            echo '<button onclick="BacktoEdit()">回商品管理</button>';
                    ?>
                </div>
                <?php 
                    //顯示分類標題
                    while($category=mysqli_fetch_array($result1)){
                        echo '<div class="title">';
                        echo '<h2>'.$category["cname"].'</h2>';
                        echo '</div>';
                        echo '<div class="menuRow">';
                        $result2->data_seek(0);//將記錄指標移到第一筆
                        //顯示分類商品及資訊
                        while($menu=mysqli_fetch_array($result2)){
                            if($category["cname"]==$menu["tcategory"]&&$menu["tsale"]==1)
                            {
                                echo  '<div class="sell">';
                                echo  '<img src="'. $menu["tpic"] . '" / class="pic">';//圖片
                                echo  '<p>'.$menu["tname"].'</p>';            //名稱
                                echo  '<p>'.'$'.$menu["tprice"].'</p>';        //價錢
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                    }                   
                ?>
            </div>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>

