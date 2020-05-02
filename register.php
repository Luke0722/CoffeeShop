<?php
    //資料庫+資料表連線---------------------------------------------------------------
    header("Content-Type:text/html;charset=utf-8");
    include("connMysql.php");           //連線資料庫、選擇資料庫
    $sql = "SELECT * FROM  `users`";    //選擇資料表
    $result = mysqli_query($db_link,$sql); 
    session_start();
    $f = rand(1, 50);
    $s = rand(1, 50);
    $answer= $f + $s;
    $error_message="";       
    //判斷post過來的資料是否被提交過來(isset方法--檢測變數是否設定) 
    if(isset($_POST['submit'])){
        $pw1 = $_POST['password1']; 
        $pw2 = $_POST['password2']; 
        //密碼認證
        if($pw1==$pw2){
            $email = $_POST['email'];
            $password = password_hash($pw1, PASSWORD_DEFAULT);
            $name = $_POST['username'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $sql = "INSERT INTO `users` (`email`,`password`,`name`,`phone`,`address`,`authority`) 
                    VALUES ('$email','$password','$name','$phone','$address','0');"; //新增資料
            mysqli_query($db_link,$sql); //寫入資料庫
        }
        else{
            $error_message="密碼不相符";
        }        
    }  
?>

<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta http-equiv="Content-Language" content="zh-TW">
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> <!--RWD-->
        <title>米羅咖啡</title>
        <link rel="stylesheet" href="general.css"> <!--各頁面通用CSS-->
        <link rel="stylesheet" href="index.css">
        <script type="text/javascript">
            function BacktoLogin() {
                location.href = "login.php";
            } 
        </script>
    </head>
    <body>
        <!--nav-bar-->
        <?php include("navigation.php");?>
        <main>
            <!--頁面內容-->
            <div class="content">
                <div class="editbut">
                    <button onclick="BacktoLogin()" >返回登入</button>
                </div>
                <form class= "menuform" method="post"  action=""> 
                    <fieldset class = "menufieldset">
                        <ul>
                            <li><label for="error" id="error"><?php echo $error_message; ?></label></li>
                            <li><label for="mail">E-mail:</label></li>
                            <li><input required type="mail" name="email" autocomplete="off" ></li>
                            <li><label for="password">密碼:</label></li>
                            <li><input required type="password" name="password1"></li>
                            <li><label for="password">確認密碼:</label></li>
                            <li><input required type="password" name="password2"></li>
                            <li><label for="account">會員名稱:</label></li>
                            <li><input required type="text" name="username" autocomplete="off"></li>
                            <li><label for="phone">會員電話:</label></li>
                            <li><input required type="number" name="phone" autocomplete="off" ></li>
                            <li><label for="address">通訊地址:</label></li>
                            <li><input required type="text" name="address" autocomplete="off" ></li>
                            <li class="lisubmit"><input type="submit" name="submit" id="btsubmit" value="Register"></li>
                        </ul>
                    </fieldset>
                </form>
            </div>
        </main>
        <!--footer-->
        <?php include("footer.php");?>
    </body>
</html>