<?php 
    session_start();
    if (!isset($_SESSION['user_authority']))
        header('Location:login.php');
    else if ($_SESSION['user_authority']!=0)
        header('Location:index.php');
    //資料庫+資料表連線---------------------------------------------------------------
    header("Content-Type:text/html;charset=utf-8");
    include("connMysql.php");           //連線資料庫、選擇資料庫
    $sql = "SELECT * FROM  `users` WHERE `uid`= '{$_SESSION["user_id"]}'";       //選擇資料表
    $result = mysqli_query($db_link,$sql);
    //nav-bar
    include("navigation.php") ;  
    //aside
    include("aside.php") ;  
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
        <main>
            <!--頁面內容-->
            <div class="member">    
                <form class = "memberform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER["PHP_SELF"] ;?>"> 
                    <fieldset class=memberfieldset>
                        <?php 
                            $user_data=mysqli_fetch_array($result);  
                        ?>
                            <h3>會員資料</h3>
                            <li><label>會員姓名：</label></li>
                            <li><input type="text" name="username" value="<?php echo $user_data['name'] ?>" required></li>
                            <li><label>E-mail：</label></li>
                            <li><input type="text" name="email" value="<?php echo $user_data['email'] ?>" required></li>
                            <li><label>電話：</label></li>
                            <li><input type="text" name="phone" value="<?php echo $user_data['phone'] ?>" ></li>
                            <li><label>通訊地址：</label></li>
                            <li><input type="text" name="address" value="<?php echo $user_data['address'] ?>" ></li>   
                            <li class="center"><input type="submit" name="submit" id="btform" value="確定修改" ><li>
                        </ul>          
                    </fieldset>
                </form>
            </div>
            <?php
            //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
            if(isset($_POST['submit'])){  
                $name = $_POST['username'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                //更新商品資訊到資料庫
                $sql = "UPDATE `users`
                        SET `email`='$email',`name`='$name',`phone`='$phone',`address`='$address'
                WHERE `uid` =  '{$_SESSION["user_id"]}'";
                if(!mysqli_query($db_link,$sql)==0)
                    mysqli_error($db_link);   
                 echo '<meta http-equiv="refresh" content="0;URL=minfo.php">';//再跳轉一次
            }  
            ?>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>
