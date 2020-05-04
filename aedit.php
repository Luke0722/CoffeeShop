<?php 
    session_start();
    if (!isset($_SESSION['user_authority']))
        header('Location:login.php');
    else if ($_SESSION['user_authority']!=1)
        header('Location:index.php');
?>
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
            function BackToMenu() {
                location.href = "menu.php";
            };
            function GoToCreate() {
                location.href = "acreateitem.php";
            };
            function GoToNewCategory() {
                location.href = "acreatecg.php";
            };
        </script>
    </head>
    <body>
        <?php
            //資料庫+資料表連線---------------------------------------------------------------
            header("Content-Type:text/html;charset=utf-8");
            include("connMysql.php");             //連線資料庫、選擇資料庫
            $sql1 = "SELECT * FROM  `category`";  //選擇資料表
            $sql2 = "SELECT * FROM  `menu`";      //選擇資料表
            $result1 = mysqli_query($db_link,$sql1); 
            $result2 = mysqli_query($db_link,$sql2);
            include("navigation.php");
        ?>   
        <main>
            <!--頁面內容-->
            <div class="content">
                <div class="editbut">
                    <button class="editbt" onclick="GoToCreate()"> 新增商品 </button>
                    <button class="editbt" onclick="GoToNewCategory()"> 新增分類 </button>
                    <button class="editbt" onclick="BackToMenu()"> 預覽菜單 </button>
                </div>
                <?php   
                    //顯示分類標題
                    while($category=mysqli_fetch_array($result1)){
                        echo '<div class="title">';
                        echo '<h2>'.$category[1].'</h2>';
                        echo '<a href="adeletecg.php?id=' . $category[0] . '" / class="aonsell" style="background:red;">刪除</a>'; 
                        echo '<a href="amodifycg.php?id=' . $category[0] . '" / class="aonsell" style="background:blue;">修改</a>'; 
                        echo '</div>';
                        echo '<div class="menuRow">';
                        $result2->data_seek(0);//將記錄指標移到第一筆
                        //顯示分類商品及資訊
                        while($menu=mysqli_fetch_array($result2)){
                            if($category[1]==$menu[2])
                            {
                                echo  '<div class="sell">';
                                echo  '<img src="'. $menu[5] . '" / class="pic">';//圖片
                                echo  '<p>'.$menu[1].'</p>';            //名稱
                                echo  '<p>'.'$'.$menu[3].'</p>';        //價錢
                                if($menu[4]==1)
                                    echo  '<p>'.'上架中'.'</p>';       
                                else
                                    echo  '<p>'.'下架中'.'</p>';        
                                    
                                echo  '<div class="crud">';
                                echo  '<a href="aonsell.php?id=' . $menu[0] . '" / class="aonsell" style="background:green;">上架</a>'; 
                                echo  '<a href="aonsell.php?id=' . $menu[0] . '" / class="aonsell" style="background:green;">下架</a>';
                                echo  '</div>'; 
                                echo  '<div class="crud">';
                                echo  '<a href="adeleteitem.php?id=' . $menu[0] . '" / class="aonsell" style="background:red;">刪除</a>'; 
                                echo  '<a href="amodifyitem.php?id=' . $menu[0] . '" / class="aonsell" style="background:blue;">修改</a>';
                                echo  '</div>'; 
                                echo  '</div>'; 
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