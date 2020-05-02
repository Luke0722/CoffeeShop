<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta http-equiv="Content-Language" content="zh-TW">
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> <!--RWD-->
        <title>米羅咖啡 MILO COFFEE</title>
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="general.css"> <!--各頁面通用CSS-->
        <script>
            function GoToMenu(){
                location.href = "menu.php";
            }
        </script>
    </head>
    <body>
        <?php
            //資料庫+資料表連線---------------------------------------------------------------
            header("Content-Type:text/html;charset=utf-8");
            include("connMysql.php");              //連線資料庫、選擇資料庫
            $sql = "SELECT * FROM  `intro`";    //選擇資料表
            $result = mysqli_query($db_link,$sql); 
            $result->data_seek(1);//將記錄指標移到第2筆
            //nav-bar
            include("navigation.php");
        ?>    
        <main>
            <!--頁面內容-->
            <div class="content">
                <div class="Row">
                    <?php
                    for($i=0;$i<=2;$i++){
                        $intro=mysqli_fetch_array($result);   //封面圖的id是1
                        echo '<div class="sell">';
                        echo "\n\t\t\t\t\t\t".'<h3>'.$intro["ititle"].'</h3>';
                        echo "\n\t\t\t\t\t\t".'<img src="'. $intro["ipic"].'" class="pic">';
                        echo "\n\t\t\t\t\t\t".'<p>'.$intro["icontent"].'</p>';
                        echo "\n\t\t\t\t\t".'</div>'."\n\t\t\t\t\t";
                    }
                    ?>
                </div>
                <div>
                    <button class="btindex" onclick="GoToMenu()">See Menu</button>
                </div>
            </div>
            <div class="content">
                <div class="Row">
                    <?php $intro=mysqli_fetch_array($result);  ?>
                    <div class="introphoto">   
                        <img src="<?php echo $intro['ipic']?>" class="pic">
                    </div>
                    <div class="introtext">
                        <h2><?php echo $intro['ititle']?></h2>
                        <p><?php echo $intro['icontent']?></p>
                    </div>
                    <?php $intro=mysqli_fetch_array($result);  ?>
                    <div class="introtext">
                        <h2><?php echo $intro['ititle']?></h2>
                        <p><?php echo $intro['icontent']?></p>
                    </div>
                    <div class="introphoto">
                        <img src="<?php echo $intro['ipic']?>" class="pic">
                    </div>
                </div>
            </div>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>