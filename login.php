<?php
    //資料庫+資料表連線---------------------------------------------------------------
    header("Content-Type:text/html;charset=utf-8");
    include("connMysql.php");           //連線資料庫、選擇資料庫
    //錯誤訊息變數  
    $error_message="";
    //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
    if(isset($_POST['submit'])){
        //接收到使用者端的金鑰   
        $captcha=$_POST['g-recaptcha-response'];
        //伺服器端的金鑰                     
        $secretKey = "6LcZTPsUAAAAAHjgYc5HSs-lMcsKKwHjzZvRs-Gg";
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        // should return JSON with success as true
        if($responseKeys["success"]) {
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
                        echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>'; 
                    else  if($user_data['authority']==1)                 
                        echo '<meta http-equiv=REFRESH CONTENT=0;url=ainfo.php>';      
                }
                else
                    $error_message="帳號或密碼錯誤"; //顯示錯誤提示
            }   
            else
            $error_message="帳號或密碼錯誤"; //顯示錯誤提示
        }
        //代表不是真實的使用者
        else{
            $error_message="請勿使用程式來登入"; //顯示錯誤提示
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("form[name=login]").submit(function(ev){
                    if(grecaptcha.getResponse()!=""){
                        return true;
                    }
                    alert("請勾選 我不是機器人");
                    return false;
                });
            });   
         </script>
    </head>
    <body> 
        <!--nav-bar-->
        <?php include("navigation.php");?>
        <main>
            <!--頁面內容-->
            <div class="content">
                <form name ="login" class="menuform" method="post"  action=""> 
                    <fieldset class = "menufieldset">
                        <ul>
                            <!--顯示錯誤提示-->
                            <li ><label for="error" id="error"><?php echo $error_message ?></label></li>
                            <!--使用者輸入帳號資料-->
                            <li><label for="account"> Email: </label></li>
                            <li><input type="mail" name="email" placeholder="請輸入帳號" autocomplete="off"></li>
                            <li><label for="password"> 密碼: </label></li>
                            <li><input type="password" name="password" placeholder="請輸入密碼"></li>
                            <li class="center"><div class="g-recaptcha" data-sitekey="6LcZTPsUAAAAAKjPMn7ByXht4JohslELnkgLrFxu"></div></li>
                            <li class="center"><input type="submit" name="submit" id="btform" value="Login"></li>
                            <li class="center"><a href="register.php" id="btform">Register</a></li>
                            <!--表單送出時，原本的驗證碼答案一併送出，排除驗證碼不同步問題-->   
                        </ul>
                    </fieldset>
                </form>
            </div> 
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>