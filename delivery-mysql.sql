-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.7.25 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  9.5.0.5284
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 delivery 的数据库结构
CREATE DATABASE IF NOT EXISTS `delivery` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `delivery`;

-- 导出  表 delivery.borrow 结构
CREATE TABLE IF NOT EXISTS `borrow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver` varchar(50) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `tel` char(11) DEFAULT NULL,
  `goods` varchar(100) DEFAULT NULL,
  `number` char(50) DEFAULT '00000000000',
  `order_time` date DEFAULT NULL,
  `status` int(1) unsigned zerofill DEFAULT '0',
  `rangs_id` char(50) DEFAULT NULL,
  `sale` char(50) DEFAULT NULL,
  `specifications` varchar(100) DEFAULT '0',
  `enddate` int(10) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `weight` char(10) DEFAULT NULL,
  `status_special` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- 正在导出表  delivery.borrow 的数据：~3 rows (大约)
DELETE FROM `borrow`;
/*!40000 ALTER TABLE `borrow` DISABLE KEYS */;
INSERT INTO `borrow` (`id`, `receiver`, `site`, `tel`, `goods`, `number`, `order_time`, `status`, `rangs_id`, `sale`, `specifications`, `enddate`, `user_id`, `weight`, `status_special`) VALUES
	(32, '张三', '四川省成都市XXX', '18281625875', '板蓝根颗粒', '100', '2019-04-17', 1, '23', '25000', '10g*20袋/包', 3, 22, '50', 1),
	(33, '李四', '123', '18281625875', '板蓝根颗粒', '100', '2019-04-17', 1, '22', '4000', '10', 2, 22, '10', 0),
	(34, '王麻子', '香港', '15281600000', '测试药品', '100', '2019-04-17', 1, '32', '30000', '10', 5, 22, '10', 0);
/*!40000 ALTER TABLE `borrow` ENABLE KEYS */;

-- 导出  表 delivery.company 结构
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `contacts` varchar(100) DEFAULT NULL,
  `tel` char(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- 正在导出表  delivery.company 的数据：~2 rows (大约)
DELETE FROM `company`;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` (`id`, `name`, `contacts`, `tel`, `address`) VALUES
	(1, 'A公司2', '张三2', '15281601231', '四川成都'),
	(45, 'admin测试公司', 'admin', '15281604123', '四川成都');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;

-- 导出  表 delivery.nexus 结构
CREATE TABLE IF NOT EXISTS `nexus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ranges_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;

-- 正在导出表  delivery.nexus 的数据：~34 rows (大约)
DELETE FROM `nexus`;
/*!40000 ALTER TABLE `nexus` DISABLE KEYS */;
INSERT INTO `nexus` (`id`, `ranges_id`, `company_id`) VALUES
	(120, 34, 1),
	(121, 33, 1),
	(122, 32, 1),
	(123, 31, 1),
	(124, 30, 1),
	(125, 29, 1),
	(126, 28, 1),
	(127, 27, 1),
	(128, 26, 1),
	(129, 25, 1),
	(130, 24, 1),
	(131, 23, 1),
	(132, 22, 1),
	(133, 21, 1),
	(134, 20, 1),
	(135, 19, 1),
	(136, 18, 1),
	(137, 17, 1),
	(138, 16, 1),
	(139, 15, 1),
	(140, 14, 1),
	(141, 13, 1),
	(142, 12, 1),
	(143, 11, 1),
	(144, 10, 1),
	(145, 9, 1),
	(146, 8, 1),
	(147, 7, 1),
	(148, 6, 1),
	(149, 5, 1),
	(150, 4, 1),
	(151, 3, 1),
	(152, 2, 1),
	(153, 1, 1);
/*!40000 ALTER TABLE `nexus` ENABLE KEYS */;

-- 导出  表 delivery.profession 结构
CREATE TABLE IF NOT EXISTS `profession` (
  `id` int(5) NOT NULL,
  `profession` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  delivery.profession 的数据：~2 rows (大约)
DELETE FROM `profession`;
/*!40000 ALTER TABLE `profession` DISABLE KEYS */;
INSERT INTO `profession` (`id`, `profession`) VALUES
	(0, '销售员'),
	(1, '发运科');
/*!40000 ALTER TABLE `profession` ENABLE KEYS */;

-- 导出  表 delivery.ranges 结构
CREATE TABLE IF NOT EXISTS `ranges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- 正在导出表  delivery.ranges 的数据：~31 rows (大约)
DELETE FROM `ranges`;
/*!40000 ALTER TABLE `ranges` DISABLE KEYS */;
INSERT INTO `ranges` (`id`, `region`) VALUES
	(1, '北京市'),
	(2, '天津市'),
	(3, '河北省'),
	(4, '山西省'),
	(5, '内蒙古自治区'),
	(6, '辽宁省'),
	(7, '吉林省'),
	(8, '黑龙江省'),
	(9, '上海市'),
	(10, '江苏省'),
	(11, '浙江省'),
	(12, '安徽省'),
	(13, '福建省'),
	(14, '江西省'),
	(15, '山东省'),
	(16, '河南省'),
	(17, '湖北省'),
	(18, '湖南省'),
	(19, '广东省'),
	(20, '广西壮族自治区'),
	(21, '海南省'),
	(22, '重庆市'),
	(23, '四川省'),
	(24, '贵州省'),
	(25, '云南省'),
	(26, '西藏自治区'),
	(27, '陕西省'),
	(28, '甘肃省'),
	(29, '青海省'),
	(30, '宁夏回族自治区'),
	(31, '新疆维吾尔自治区'),
	(32, '香港'),
	(33, '澳门'),
	(34, '台湾');
/*!40000 ALTER TABLE `ranges` ENABLE KEYS */;

-- 导出  表 delivery.users 结构
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `tel` char(111) NOT NULL,
  `number` char(181) NOT NULL,
  `token` int(5) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `check` int(1) unsigned zerofill DEFAULT '0',
  `remember_token` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- 正在导出表  delivery.users 的数据：~2 rows (大约)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `tel`, `number`, `token`, `password`, `check`, `remember_token`) VALUES
	(22, '超级管理员', '15200000001', '510723000000004400', 2, '$2y$10$JZTf/4l/ZtyoAMs0v/uEE.GbBnIOAngy9ZKDlA1rWVR42hzFX6e4O', 1, 'ok7toS83Hx3MWFfhS9G5beLX306aFdjUrAWCg3AEIvWch6okEXcawbp4wXg0'),
	(28, '销售人员', '15200000000', '510723000000004444', 0, '$2y$10$ZtbTaSsOQOaKrKLkfVAiVeT6yDjrJ69ajWLZTh8bwhgxM7T4/4QWW', 0, '0');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
