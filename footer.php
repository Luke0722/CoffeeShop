        <?php
            $sql_logo = "SELECT * FROM `intro` Where `iid` = '8'";
            $result_logo = mysqli_query($db_link,$sql_logo);
            $logo = mysqli_fetch_array($result_logo);
        ?> 
        <footer>
            <div class="footerinfo">
                <h3>Follow us：</h3>
                <a href="<?php echo $logo['icontent']?>"><img src="<?php echo $logo['ipic']?>" id="btmedia"></a>  
                <p>周一〜周日 11:00~22:00 </p>
                <p>804高雄市鼓山區</p>
                <p>07 - 0000000</p>
            </div>
        </footer>
        <?php mysqli_close($db_link);//關閉資料庫連線>?>