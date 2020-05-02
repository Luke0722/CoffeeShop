-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 
-- 伺服器版本： 10.4.6-MariaDB
-- PHP 版本： 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `teashop`
--

-- --------------------------------------------------------

--
-- 資料表結構 `category`
--

CREATE TABLE `category` (
  `cid` int(11) NOT NULL,
  `cname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `category`
--

INSERT INTO `category` (`cid`, `cname`) VALUES
(1, '冷飲 (Ice Drink)'),
(2, '熱飲 (Hot Drink)'),
(3, '手做蛋糕 (Handmade Castella)');

-- --------------------------------------------------------

--
-- 資料表結構 `intro`
--

CREATE TABLE `intro` (
  `iid` int(11) NOT NULL,
  `ititle` varchar(50) DEFAULT NULL,
  `ipic` varchar(50) NOT NULL,
  `icontent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `intro`
--

INSERT INTO `intro` (`iid`, `ititle`, `ipic`, `icontent`) VALUES
(1, '封面圖', 'upload/introductions/封面圖_20200427_045346_6.jpg', ''),
(2, '銷售第一', 'upload/introductions/銷售第一_20200427_045346_6.jpg', '嚴選冰拿鐵'),
(3, '品牌象徵', 'upload/introductions/品牌象徵_20200427_045346_4.jpg', '錫蘭紅茶'),
(4, '嘗鮮首選', 'upload/introductions/嘗鮮首選_20200427_045346_9.jpg', '鮮榨柳橙汁'),
(5, '關於我們', 'upload/introductions/關於我們_20200430_092507_1.jpg', '米羅咖啡是一間在地經營的飲料店，在這質樸清純的土地上，我們販賣的不只是一杯飲料，更是這塊土地的共同回憶。'),
(6, '天然食材', 'upload/introductions/天然食材_20200430_092507_8.jpg', '精心挑選的咖啡豆，香氣中夾帶著清新的花香，單寧的氣味與果酸巧妙的在口中平衡，高品質的食材把關，讓客人喝進美味與安心。'),
(8, 'FB連結', 'upload/introductions/FB連結_20200430_092758_8.png', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `menu`
--

CREATE TABLE `menu` (
  `tid` int(11) NOT NULL,
  `tname` varchar(50) DEFAULT NULL,
  `tcategory` varchar(50) DEFAULT NULL,
  `tprice` int(11) DEFAULT NULL,
  `tsale` tinyint(1) DEFAULT 1,
  `tpic` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `menu`
--

INSERT INTO `menu` (`tid`, `tname`, `tcategory`, `tprice`, `tsale`, `tpic`) VALUES
(1, '錫蘭紅茶', '冷飲 (Ice Drink)', 30, 1, 'upload/products/Black Tea_20200415_050329_0.jpg'),
(2, '梔香綠茶', '冷飲 (Ice Drink)', 30, 1, 'upload/products/Green Tea_20200415_050523_7.jpg'),
(3, '決明大麥', '冷飲 (Ice Drink)', 25, 1, 'upload/products/Wheat Tea_20200415_050544_6.jpg'),
(4, '嚴選冰拿鐵', '冷飲 (Ice Drink)', 75, 1, 'upload/products/Ice Latte_20200415_053038_7.jpg'),
(5, '宇治抹茶', '冷飲 (Ice Drink)', 70, 1, 'upload/products/Matcha_20200415_050706_3.jpg'),
(6, '嚴選黑咖啡', '熱飲 (Hot Drink)', 65, 1, 'upload/products/coffee2_20200415_051228_9.jpg'),
(7, '柳橙汁', '冷飲 (Ice Drink)', 35, 1, 'upload/products/Orange Juice2_20200415_054300_1.jpg'),
(8, '長崎蛋糕(蜂蜜)', '手做蛋糕 (Handmade Castella)', 40, 1, 'upload/products/Honey Castella_20200415_053100_8.jpg'),
(9, '長崎蛋糕(抹茶)', '手做蛋糕 (Handmade Castella)', 40, 1, 'upload/products/Matcha Castella_20200415_053118_9.jpg'),
(10, '嚴選熱拿鐵', '熱飲 (Hot Drink)', 70, 1, 'upload/products/Hot Latte_20200415_051457_4.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `authority` tinyint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`, `phone`, `address`, `authority`) VALUES
(1, 'Admin', 'Admin', '$2y$10$xAev4n9p4PDvvaxJOwRAVu42qQgcbOPqjfE.iUzXyaTXFH7Mk0iDO', '0900000000', '臺南市東區', 1),
(2, 'Luke', 'u10616007@go.utaipei.edu.tw', '$2y$10$YeHF2f/JMB4d/rYd7.ogPO.DFMJTzpXNtFRJcC0D6.vXhXyY0C3LS', '0912345678', '蓮海路', 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cid`);

--
-- 資料表索引 `intro`
--
ALTER TABLE `intro`
  ADD PRIMARY KEY (`iid`);

--
-- 資料表索引 `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`tid`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `category`
--
ALTER TABLE `category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `intro`
--
ALTER TABLE `intro`
  MODIFY `iid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `menu`
--
ALTER TABLE `menu`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
