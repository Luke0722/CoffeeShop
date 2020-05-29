<?php 
	//資料庫主機設定
	$db_host = "localhost";
	$db_username = "mis";
	$db_password = "999";
	// 建立資料庫連線 (加上 @ 可以在連線錯誤時忽略系統錯誤訊息)
	$db_link = @mysqli_connect($db_host, $db_username, $db_password);
	if (!$db_link) die("資料連結失敗！");
	//設定字元集與連線校對
	mysqli_set_charset($db_link, "utf8");   //避免中文上傳資料庫變亂碼
	mysqli_select_db($db_link, "teashop");  //選擇資料庫
?>
        