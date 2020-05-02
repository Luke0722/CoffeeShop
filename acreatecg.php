<?php
    session_start();
    if (!isset($_SESSION['user_authority']))
        header('Location:login.php');
    else if ($_SESSION['user_authority']!=1)
        header('Location:index.php');
    //資料庫+資料表連線---------------------------------------------------------------
    header("Content-Type:text/html;charset=utf-8");
    include("connMysql.php");               //連線資料庫、選擇資料庫
    //nav-bar
    include("navigation.php");
    $message="";
    //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
    if(isset($_POST['submit'])){
        $cname =  $_POST["cname"]  ;
        $sql = "INSERT INTO `category` (`cname`) VALUES ('$cname');"; //
        if(!mysqli_query($db_link,$sql)==0)
            $message="新增分類成功";    //顯示成功提示
        else
            $message="新增分類失敗";        //顯示錯誤提示
    }
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
            function BacktoEdit() {
                location.href = "aedit.php";
            };
        </script>
    </head>
    <body>  
        <!--nav-bar-->
        <?php include("navigation.php");?> 
        <main>
            <!--頁面內容-->
            <div class="content">
                <div class="editbut">
                    <button onclick="BacktoEdit()" >返回編輯</button>
                </div>
                <form class="menuform" method="post"  action=""> 
                    <fieldset class = "menufieldset">
                        <ul>   
                            <?php if($message!="")
                                echo '<li ><label for="result" id="success">'.$message.'</label></li>'
                            ?>
                            <li ><label for="name"> 種類名稱: </label></li>
                            <li ><input type="text" name="cname" required></li>
                            <li class="lisubmit"><input type="submit" name="submit" id="btsubmit" value="新增種類" ></li>
                        </ul>
                    </fieldset>
                </form>
            </div>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>
