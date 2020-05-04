<?php
    $sql_cover = "SELECT * FROM `intro` Where `iid` = '1'";
    $result_cover = mysqli_query($db_link,$sql_cover);
    $cover = mysqli_fetch_array($result_cover);
    $result_cover->data_seek(0);//將記錄指標移到第一筆  
?> 
 <script type="text/javascript">
    function dropdown_show() {
        document.getElementById("drop-menu").style.display="flex";
    };
    function dropdown_hide() {
        document.getElementById("drop-menu").style.display="none";
    };
</script>
<nav>
    <div class="navheader">
        <div class="nav-logo"><a href="index.php">米羅咖啡</a></div>
        <div class="nav-bar" >
            <ul class="nav-bar-ul">
                <?php  if(isset($_SESSION['user_authority'])&&$_SESSION['user_authority']==1): ?>
                    <li><a href="ainfo.php"> 商店資訊管理 </a></li>
                    <li><a href="aedit.php"> 商品管理 </a></li>
                    <li><a href="logout.php">登出</a></li>
                <?php  elseif(isset($_SESSION['user_authority'])&&$_SESSION['user_authority']==0): ?>
                    <li><a href="index.php"> 首頁 </a></li>
                    <li><a href="intro.php"> 經營理念 </a></li>
                    <li><a href="menu.php"> 飲料品項 </a></li>
                    <li class ="dropdown-li" onmouseover="dropdown_show()" onmouseout="dropdown_hide()"> 會員中心 
                        <ul id ="drop-menu">
                            <li><a href="minfo.php">會員資料</a></li>
                            <li><a href="mnews.php">會員消息</a></li>
                            <li><a href="logout.php">登出</a></li>
                        </ul>
                    </li>   
                <?php else: ?>
                    <li><a href="index.php"> 首頁 </a></li>
                    <li><a href="intro.php"> 經營理念 </a></li>
                    <li><a href="menu.php"> 飲料品項 </a></li>
                    <li><a href="login.php"> 會員登入 </a></li>
                <?php endif; ?>
            </ul>
        </div>   
    </div>
    <div class="cover">
        <img src="<?php echo $cover['ipic']?>" class="coverphoto">
    </div> 
</nav>  
  
