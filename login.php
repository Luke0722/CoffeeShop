<?php
    //資料庫+資料表連線---------------------------------------------------------------
    header("Content-Type:text/html;charset=utf-8");
    include("connMysql.php");           //連線資料庫、選擇資料庫
    //驗證碼亂數
    $n1 = rand(1, 50);
    $n2 = rand(1, 50);
    //錯誤訊息變數  
    $error_message="";

    //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
    if(isset($_POST['submit'])){
        $answer = $_POST['answer'];         //正確驗證碼答案
        $checkcode = $_POST['checkcode'];   //使用者輸入答案
        //驗證碼認證
        if($answer == $checkcode){
            $email =  $_POST['email'];
            $password =  $_POST['password']; 
            //確認有此會員信箱
            $sql = "SELECT * FROM  `users` WHERE `email`='$email'";  
            $result = mysqli_query($db_link,$sql); 
            //該列資料大於等於1
            if(mysqli_num_rows($result)>=1){  
                $user_data=mysqli_fetch_array($result);
                //驗證密碼
                if(password_verify($password,$user_data['password'])){
                    session_start();
                    $_SESSION['user_id'] = $user_data['uid'];
                    $_SESSION['user_name'] = $user_data['name'];
                    $_SESSION['user_authority'] = $user_data['authority'];   
                    if($user_data['authority']==0)                 
                        echo '<meta http-equiv=REFRESH CONTENT=0;url=minfo.php>'; 
                    else  if($user_data['authority']==1)                 
                        echo '<meta http-equiv=REFRESH CONTENT=0;url=ainfo.php>';      
                }
                else
                    $error_message="帳號或密碼錯誤"; //顯示錯誤提示
            }   
            else
            $error_message="帳號或密碼錯誤"; //顯示錯誤提示
        }
        //驗證碼輸入錯誤
        else{
            $error_message="驗證碼錯誤"; //顯示錯誤提示
        }
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
    </head>
    <body> 
        <!--nav-bar-->
        <?php include("navigation.php");?>
        <main>
            <!--頁面內容-->
            <div class="content">
                <form class="menuform" method="post"  action=""> 
                    <fieldset class = "menufieldset">
                        <ul>
                            <!--顯示錯誤提示-->
                            <li ><label for="error" id="error"><?php echo $error_message ?></label></li>
                            <!--使用者輸入帳號資料-->
                            <li><label for="account"> Email: </label></li>
                            <li><input type="mail" name="email" placeholder="請輸入帳號" autocomplete="off"></li>
                            <li><label for="password"> 密碼: </label></li>
                            <li><input type="password" name="password" placeholder="請輸入密碼"></li>
                            <li><label for="check"> 驗證碼：<?php echo $n1."+".$n2; ?></label></li>
                            <li><input type="text" name="checkcode" autocomplete="off"></li>
                            <li class="lisubmit"><input type="submit" name="submit" id="btsubmit" value="Login"></li>
                            <!--表單送出時，原本的驗證碼答案一併送出，排除驗證碼不同步問題-->
                            <li><input type="hidden" name="answer"  value="<?php echo $n1+$n2;?>"></li>
                            <li><a href="register.php" id="registerbt">註冊帳號</a></li>
                        </ul>
                    </fieldset>
                </form>
            </div> 
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>