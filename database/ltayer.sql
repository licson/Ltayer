SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE TABLE IF NOT EXISTS `app` (`id` int(20) NOT NULL AUTO_INCREMENT,`app_key` varchar(40) DEFAULT NULL,`name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,`canvas_url` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,`logo` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,`perms` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PERMISSON_NONE',`is_system_app` tinyint(1) NOT NULL,`pos` int(3) DEFAULT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `file` (`filename` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,`real_location` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,`user` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `notepad` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_name` varchar(30) NOT NULL,`name` text NOT NULL,`content` text NOT NULL,`created_at` datetime NOT NULL,`updated_at` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
CREATE TABLE IF NOT EXISTS `setting` (`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,`value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,PRIMARY KEY (`name`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `user` (`id` int(10) NOT NULL AUTO_INCREMENT,`username` varchar(30) NOT NULL,`email` varchar(30) NOT NULL,`password` tinytext NOT NULL,`admin` varchar(30) NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `app` (`id`, `app_key`, `name`, `canvas_url`, `logo`, `perms`, `is_system_app`, `pos`) VALUES(1, NULL, '雲端硬碟', 'apps/file/index.php', 'img/icons/filemaneger.png', 'PERMISSON_NONE', 1, 1),(2, NULL, '計算機', 'apps/calculator/index.html', 'img/icons/calculator.png', 'PERMISSON_NONE', 0, 2),(3, NULL, '照相機', 'apps/webcam/photobooth.php', 'img/icons/webcam.png', 'PERMISSON_NONE', 0, 3),(4, NULL, '小畫家', 'apps/drawpad/index.php', 'img/icons/drawpad.png', 'PERMISSON_NONE', 0, 4),(5, NULL, '網路電台', 'apps/radio/index.html', 'img/icons/radio.png', 'PERMISSON_NONE', 0, 5),(6, NULL, '記事本', 'apps/notepad/index.php', 'img/icons/notepad.png', 'PERMISSON_NONE', 0, 6),(7, NULL, '控制台', 'admin/index.php', 'img/icons/setting.png', 'PERMISSON_CHANGE_SETTINGS', 1, 7),(8, NULL, 'Ltayer Store', 'store/', 'img/icons/store.png', 'PERMISSON_NONE', 0, 8);
INSERT INTO `setting` (`name`, `value`) VALUES('system_name', 'Ltayer'),('bg', ''),('dock', 'false');