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
            $sql = "SELECT * FROM  `category`";    //選擇資料表
            $result = mysqli_query($db_link,$sql); 
            //nav-bar
            include("navigation.php");
        ?>    
        <main>
            <!--頁面內容-->
            <div class="content">
                <div class="editbut">
                    <button onclick="BacktoEdit()" >返回編輯</button>
                </div>
                <form id="loginform" class = "menuform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER["PHP_SELF"] ;?>"> 
                    <fieldset class = "menufieldset">
                        <ul>
                            <li ><label for="name">品項名稱:</label></li>
                            <li ><input type="text" name="tname" required></li>
                            <li ><label for="type">品項種類:</label></li>
                            <li ><select name="tcategory">
                                <?php
                                    //顯示所有分類到下拉選單中
                                    while($category=mysqli_fetch_array($result)){
                                        //value值如果有空格，要加上\文字\，但是在php反斜線會跳開，所以用""
                                        echo '<option value="'.$category[1].'">'.$category[1].'</option>';   
                                    }
                                ?>                                 
                            </select></li>
                            <li ><label for="price">品項價錢:</label></li>
                            <li ><input type="number" name="tprice" required ></li>
                            <li ><label for="sale">銷售狀況:</label></li>
                            <li ><select name="tsale">
                                <option value=1>上架中</option>'
                                <option value=0>下架中</option>'            
                            </select></li>
                            <li ><label for="upfile">檔案上傳:</label></li>
                            <li ><input type="file" name="upfile" required > </li>
                            <li class="center"><input type="submit" name="submit" id="btform" value="新增商品" ></li>
                        </ul>
                    </fieldset>
                </form>
            </div>
            <?php
            //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
            if(isset($_POST['submit'])){
                $tname =  $_POST["tname"]  ;
              
                $tcategory = $_POST["tcategory"];
                echo  $tcategory;
                $tprice = $_POST["tprice"];
                $tsale =  $_POST["tsale"];
                $filename = $_FILES["upfile"]["name"];
                $filesize = $_FILES["upfile"]["size"];
                $filetype = $_FILES["upfile"]["type"];
                $filetmp_name = $_FILES["upfile"]["tmp_name"];
                if ($filesize > 0 ) 
                {   
                  
                    $file=explode(".",$filename);//分割檔名
                    //echo $file[0];/*主檔名*/
                    //echo $file[1];/*副檔名*/
                    date_default_timezone_set('Asia/Taipei');
                    $new_name=$file[0]."_".date("Ymd_his")."_".rand(0,10).".".$file[1];
                    $fileroute="upload/products/".$new_name;
                    move_uploaded_file($filetmp_name,$fileroute);
                       
                    $sql = "INSERT INTO `menu` (`tname`,`tcategory`,`tprice`,`tsale`,`tpic`) 
                            VALUES ('$tname','$tcategory','$tprice','$tsale','$fileroute');";
                    //將圖片檔案資料寫入資料庫
                    if(!mysqli_query($db_link,$sql)==0)
                        echo "<script> success('新增商品成功'); </script>";      //顯示成功提示
                    else
                        echo "<script> success('新增商品失敗'); </script>";      //顯示錯誤提示
                }
                else
                    echo "圖片上傳失敗";
            }
            ?>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>
