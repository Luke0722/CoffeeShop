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
            function success(msg){
                document.getElementById("success").innerHTML = msg;
            }
            function BacktoEdit() {
                location.href = "aedit.php";
            };
        </script>
    </head>
    <body>
        <?php
            //資料庫+資料表連線---------------------------------------------------------------
            header("Content-Type:text/html;charset=utf-8");
            include("connMysql.php");              //連線資料庫、選擇資料庫
            $sql = "SELECT * FROM  `intro`";       //選擇資料表
            $result = mysqli_query($db_link,$sql); 
            //nav-bar
            include("navigation.php") 
        ?>    
        <main>
            <!--頁面內容-->
            <div class="content">
                <form class = "introform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER["PHP_SELF"] ;?>"> 
                    <fieldset class=introfieldset>
                        <ul>
                            <li><h3>資訊標題</h3></li>
                            <li><h3>資訊圖片</h3></li>
                            <li></li>
                            <li><h3>資訊內容</h3></li>
                        </ul>
                        <?php 
                            $result->data_seek(0);//將記錄指標移到第一筆
                            while($intro=mysqli_fetch_array($result)){
                                echo '<ul>';
                                echo ' <li ><input type="text" name="ititle'.$intro[0].'" value="'.$intro[1].'" required></li>';
                                echo ' <li ><img src="'. $intro[2] . '" / class="smallpic">';//圖片
                                echo ' <li ><input type="file" name="upfile'. $intro[0] . '"> </li>';
                                echo ' <li ><textarea name="icontent'.$intro[0].'" >'.$intro[3].'</textarea></li>';
                                echo '</ul>';                   
                            }
                        ?>
                        <input type="submit" name="submit" id="btform" value="確定修改" >
                    </fieldset>
                </form>
            </div>
            <?php
            //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
            if(isset($_POST['submit'])){
                $result->data_seek(0);//將記錄指標移到第一筆
                while($intro=mysqli_fetch_array($result)){
                    $iid = $intro[0];
                    $new_ititle =  $_POST["ititle".$intro[0]]  ;
                    $new_icontent = $_POST["icontent".$intro[0]];
                   
                    $filename = $_FILES["upfile".$intro[0]]["name"];
                    $filesize = $_FILES["upfile".$intro[0]]["size"];
                    $filetype = $_FILES["upfile".$intro[0]]["type"];
                    $filetmp_name = $_FILES["upfile".$intro[0]]["tmp_name"];
                   
                    if ($new_ititle!=$intro["ititle"])
                    {
                        $sql = "UPDATE `intro` SET `ititle`='$new_ititle' WHERE `iid` = '$iid'";
                        if(!mysqli_query($db_link,$sql)==0)
                            mysqli_error($db_link);
                    }
                    if ($new_icontent!=$intro["icontent"])
                    {
                        $sql = "UPDATE `intro` SET `icontent`='$new_icontent' WHERE `iid` = '$iid'";
                        if(!mysqli_query($db_link,$sql)==0)
                            mysqli_error($db_link);
                    }
                    if ($filesize > 0 )
                    {
                        $file=explode(".",$filename);//分割檔名
                        //echo $file[0];/*主檔名*/
                        //echo $file[1];/*副檔名*/
                        date_default_timezone_set('Asia/Taipei');
                        $new_name=$new_ititle."_".date("Ymd_his")."_".rand(0,10).".".$file[1];
                        $fileroute="upload/introductions/".$new_name;
                        move_uploaded_file($filetmp_name,$fileroute);
                        //更新商品資訊到資料庫
                        $sql = "UPDATE `intro` SET `ipic`='$fileroute' WHERE `iid` = '$iid'";
                        if(!mysqli_query($db_link,$sql)==0)
                            mysqli_error($db_link);
                    }    
                }
                //再跳轉一次，不然無法立即更新html上資訊，若用LOCATION可能會跳錯
                echo '<meta http-equiv="refresh" content="0;URL=ainfo.php">';  
            }
            ?>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>
