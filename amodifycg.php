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
        <title>米羅咖啡 MILO COFFEE</title>
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="general.css"> <!--各頁面通用CSS-->
        <script type="text/javascript">
            function success(msg){
                document.getElementById("success").innerHTML = msg;
            }
            function BacktoEdit() {
                location.href = "aedit.php";
            }
        </script>
    </head>

    <body>
        <?php
            //資料庫+資料表連線---------------------------------------------------------------
            header("Content-Type:text/html;charset=utf-8");
            include("connMysql.php");   //連線資料庫、選擇資料庫
            $id = $_GET['id'];          //獲取網址的id(也就是分類的cid)
            $sql = "SELECT * FROM `category` Where `cid` = '$id'";
            $result = mysqli_query($db_link,$sql);
            $category=mysqli_fetch_array($result);
            //nav-bar
            include("navigation.php");
        ?>   
        <main>
            <!--頁面內容-->
            <div class="content">
                <div class="editbut">
                    <button onclick="BacktoEdit()" >返回編輯</button>
                </div>
                <form class="menuform" enctype="multipart/form-data" method="post" action=""> 
                    <fieldset class="menufieldset">
                        <ul>
                            <li ><label for="name"> 種類名稱: </label></li>
                            <li ><input type="text" name="cname" value="<?php echo $category[1]; ?>"></li>
                            <li class="lisubmit"><input type="submit" name="submit" id="btsubmit" value="修改種類" ></li>
                        </ul>
                    </fieldset>
                </form>
            </div>
            <?php
            //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
            if(isset($_POST['submit'])){
                $cname =  $_POST["cname"]  ;
                //更新資料到資料庫(更新menu同名稱的品項與category名稱)
                $sql = "UPDATE  `menu`
                        SET     `tcategory` ='$cname'
                        WHERE   `tcategory` =  '$category[1]'";
                $sql2 = "UPDATE `category`
                        SET     `cname` ='$cname'
                        WHERE   `cid` ='$id'";
                //將圖片檔案資料寫入資料庫
                if(!mysqli_query($db_link,$sql)==0)
                if(!mysqli_query($db_link,$sql2)==0)
                header("location:amodifycg.php?id=" . $id); //再跳轉一次，不然無法立即更新html上資訊
            }
            ?>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>