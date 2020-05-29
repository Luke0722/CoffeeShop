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
            function BacktoEdit(){
                location.href = "aedit.php";
            }
        </script>
    </head>

    <body>
        <?php
        //資料庫+資料表連線---------------------------------------------------------------
        header("Content-Type:text/html;charset=utf-8");
        include("connMysql.php");                             //連線資料庫、選擇資料庫
        $id = $_GET['id'];                                    //獲取網址的id(也就是分類的cid)
        $sql1 = "SELECT * FROM `category`";                   //選擇資料表
        $sql2 = "SELECT * FROM `menu` Where `tid` = '$id'";   //選擇資料表並選擇row
        $result1 = mysqli_query($db_link,$sql1); 
        $result2 = mysqli_query($db_link,$sql2); 
        $menu=mysqli_fetch_array($result2);     //因為有指定的row
        //nav-bar
        include("navigation.php");
        ?>    
        <main>
            <!--頁面內容-->
            <div class="content">
                <div class="editbut">
                    <button onclick="BacktoEdit()" >返回編輯</button>
                </div>
                <form  id="loginform" class="menuform"  enctype="multipart/form-data" method="post" action=""> 
                    <fieldset class = "menufieldset">
                        <ul>
                            <li><label for="name">品項名稱:</label></li>
                            <li><input type="text" name="tname" value="<?php echo $menu["tname"]; ?>" required></li>
                            <li><label for="name">品項種類:</label></li>
                            <li>
                                <select name="tcategory">
                                    <?php
                                        while($category=mysqli_fetch_array($result1)){
                                            if($category["cname"]==$menu["tcategory"])
                                                echo  '<option selected value="' . $category["cname"] . '">' . $category["cname"] . '</option>';   
                                            else
                                                echo  '<option value="' . $category["cname"] . '">' . $category["cname"] . '</option>';   
                                        }
                                    ?>  
                                </select>
                            </li>
                            <li ><label for="price">品項價錢:</label></li>
                            <li ><input type="number" name="tprice" value="<?php echo $menu["tprice"]; ?>" required></li>
                            <li ><label for="upfile">檔案上傳:</label></li>
                            <li ><img src="<?php echo $menu["tpic"]; ?>" class="smallpic"></li>
                            <li ><input type="file" name="upfile"> </li>
                            <li class="center"><input type="submit" name="submit" id="btform" value="修改商品" ></li>
                        </ul>        
                    </fieldset>
                </form>
            </div>
            <?php
            //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
            if(isset($_POST['submit'])){
                $new_tname =  $_POST["tname"]  ;
                $tcategory = $_POST["tcategory"];
                $tprice = $_POST["tprice"];
                $filename = $_FILES["upfile"]["name"];
                $filesize = $_FILES["upfile"]["size"];
                $filetype = $_FILES["upfile"]["type"];
                $filetmp_name = $_FILES["upfile"]["tmp_name"];
                //如果有修改圖片
                if ( $filesize > 0 )
                {
                    $file=explode(".",$filename);//分割檔名
                    //echo $file[0];/*主檔名*/
                    //echo $file[1];/*副檔名*/
                    date_default_timezone_set('Asia/Taipei');
                    $new_name=$file[0]."_".date("Ymd_his")."_".rand(0,10).".".$file[1];
                    $fileroute="upload/products/".$new_name;
                    move_uploaded_file($filetmp_name,$fileroute);
                    //更新商品資訊到資料庫
                    $sql = "UPDATE `menu`
                            SET `tname`='$tname',`tcategory`='$tcategory',`tprice`='$tprice',`tpic`='$fileroute'
                            WHERE `tid` = '$id'";
                    if(!mysqli_query($db_link,$sql)==0)
                        mysqli_error($db_link);
                }
                //如果沒修改圖片
                else
                {
                    //更新商品資訊到資料庫
                    $sql = "UPDATE `menu` 
                            SET `tname`='$tname',`tcategory`='$tcategory',`tprice`='$tprice'
                            WHERE `tid`='$id'  ";
                    if(!mysqli_query($db_link,$sql)==0)
                        mysqli_error($db_link);
                }   
                echo '<meta http-equiv="refresh" content="0;URL=amodifyitem.php?id='.$id.'">';//再跳轉一次，不然無法立即更新html上資訊
            }
            ?>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>