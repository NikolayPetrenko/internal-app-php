# ************************************************************
# Sequel Pro SQL dump
# Версия 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Адрес: localhost (MySQL 5.5.27)
# Схема: lds-site
# Время создания: 2012-11-23 07:49:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `alias` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `name`, `alias`)
VALUES
	(1,'MySQL 5.0','mysql-5-0'),
	(2,'JavaScript','javascript'),
	(3,'PHP 5','php-5');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы levels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `levels`;

CREATE TABLE `levels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `alias` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;

INSERT INTO `levels` (`id`, `name`, `alias`)
VALUES
	(1,'Junior','junior'),
	(2,'Middle','middle'),
	(3,'Senior','senior');

/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы levels_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `levels_categories`;

CREATE TABLE `levels_categories` (
  `level_id` int(11) unsigned DEFAULT NULL,
  `category_id` int(11) unsigned DEFAULT NULL,
  KEY `level_id` (`level_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `levels_categories_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `levels_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `levels_categories` WRITE;
/*!40000 ALTER TABLE `levels_categories` DISABLE KEYS */;

INSERT INTO `levels_categories` (`level_id`, `category_id`)
VALUES
	(1,1),
	(1,2),
	(1,3),
	(2,1),
	(2,2),
	(3,3),
	(2,3),
	(3,1),
	(3,2);

/*!40000 ALTER TABLE `levels_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы question_answer_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_answer_types`;

CREATE TABLE `question_answer_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `question_answer_types_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `question_answer_types` WRITE;
/*!40000 ALTER TABLE `question_answer_types` DISABLE KEYS */;

INSERT INTO `question_answer_types` (`id`, `name`, `category_id`)
VALUES
	(1,'Basic',3),
	(2,'Basic',1),
	(3,'Queries',1);

/*!40000 ALTER TABLE `question_answer_types` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы question_answers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_answers`;

CREATE TABLE `question_answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text,
  `question_id` int(11) unsigned DEFAULT NULL,
  `corrected` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `question_answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `question_answers` WRITE;
/*!40000 ALTER TABLE `question_answers` DISABLE KEYS */;

INSERT INTO `question_answers` (`id`, `text`, `question_id`, `corrected`)
VALUES
	(46,'Yes',68,1),
	(47,'No',68,0),
	(48,'Yes',69,0),
	(49,'No',69,1),
	(50,'Yes',70,0),
	(51,'No',70,1),
	(52,'Yes',71,0),
	(53,'No',71,1),
	(54,'Yes',72,0),
	(55,'No',72,1),
	(56,'Yes',73,0),
	(57,'No',73,1),
	(58,'Yes',74,0),
	(59,'No',74,1),
	(60,'Yes',75,0),
	(61,'No',75,1),
	(62,'Yes',76,0),
	(63,'No',76,1),
	(64,'Yes',77,0),
	(65,'No',77,1),
	(66,'Yes',78,0),
	(67,'No',78,1),
	(68,'Yes',79,0),
	(69,'No',79,1),
	(70,'Yes',80,0),
	(71,'No',80,1),
	(72,'Yes',81,0),
	(73,'No',81,1),
	(74,'Yes',82,0),
	(75,'No',82,1),
	(76,'Yes',83,0),
	(77,'No',83,1),
	(78,'Yes',84,0),
	(79,'No',84,1),
	(80,'Yes',85,0),
	(81,'No',85,1),
	(82,'Yes',86,0),
	(83,'No',86,1),
	(84,'Yes',87,0),
	(85,'No',87,1),
	(86,'YEs',88,1),
	(87,'No',88,0);

/*!40000 ALTER TABLE `question_answers` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned DEFAULT NULL,
  `level_id` int(11) unsigned DEFAULT NULL,
  `text` text,
  `image` varchar(100) DEFAULT NULL,
  `type` enum('checkbox','radio','write') DEFAULT NULL,
  `qestion_answer_type_id` int(11) unsigned DEFAULT NULL,
  `date_created` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `level_id` (`level_id`),
  KEY `qestion_answer_type_id` (`qestion_answer_type_id`),
  CONSTRAINT `questions_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `questions_ibfk_4` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `questions_ibfk_5` FOREIGN KEY (`qestion_answer_type_id`) REFERENCES `question_answer_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;

INSERT INTO `questions` (`id`, `category_id`, `level_id`, `text`, `image`, `type`, `qestion_answer_type_id`, `date_created`)
VALUES
	(68,1,2,'MySQL1?','','radio',2,'1353583829'),
	(69,1,2,'MySQL2?','','radio',2,'1353583877'),
	(70,1,2,'MySQL3?','','radio',2,'1353583884'),
	(71,1,2,'MySQL4?','','radio',2,'1353583888'),
	(72,1,2,'MySQL5?','','radio',2,'1353583892'),
	(73,1,2,'MySQL6?','','radio',2,'1353583898'),
	(74,1,2,'MySQL7?','','radio',2,'1353583902'),
	(75,1,2,'MySQL8?','','radio',2,'1353583926'),
	(76,1,2,'MySQL9?','','radio',2,'1353583930'),
	(77,1,2,'MySQL10?','','radio',2,'1353583936'),
	(78,1,2,'MySQL11?','','radio',2,'1353583940'),
	(79,1,2,'MySQL12?','','radio',2,'1353583944'),
	(80,1,2,'MySQL13?','','radio',2,'1353583946'),
	(81,1,2,'MySQL14?','','radio',2,'1353583950'),
	(82,1,2,'MySQL15?','','radio',2,'1353583955'),
	(83,1,2,'MySQL16?','','radio',2,'1353583959'),
	(84,1,2,'MySQL17?','','radio',2,'1353583962'),
	(85,1,2,'MySQL18?','','radio',2,'1353583966'),
	(86,1,2,'MySQL19?','','radio',2,'1353583970'),
	(87,1,2,'MySQL20?','','radio',2,'1353583973'),
	(88,1,2,'DELETE FROM USERS WHERE id > 0','1353585739.jpeg','radio',2,'1353585774');

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `name`, `description`)
VALUES
	(1,'login','Login privileges, granted after account confirmation'),
	(2,'admin','Administrative user, has access to everything.');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы roles_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles_users`;

CREATE TABLE `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`),
  CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `roles_users` WRITE;
/*!40000 ALTER TABLE `roles_users` DISABLE KEYS */;

INSERT INTO `roles_users` (`user_id`, `role_id`)
VALUES
	(1,1),
	(2,1),
	(3,1),
	(4,1),
	(1,2),
	(2,2),
	(3,2),
	(4,2);

/*!40000 ALTER TABLE `roles_users` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы user_profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_profiles`;

CREATE TABLE `user_profiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` timestamp NULL DEFAULT NULL,
  `phone_mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;

INSERT INTO `user_profiles` (`id`, `first_name`, `last_name`, `dob`, `phone_mobile`, `address`, `gender`, `avatar`)
VALUES
	(1,'Dmitry','Litvyak','0000-00-00 00:00:00','',NULL,'male','1353174588.png'),
	(2,'Alex','Leontev','2011-07-11 21:41:49','',NULL,'male','1353180037.jpg'),
	(3,'Vitaly',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'Andrey','Tereshenko',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы user_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_tokens`;

CREATE TABLE `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`),
  KEY `expires` (`expires`),
  CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `password` varchar(64) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `user_profile_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`),
  UNIQUE KEY `uniq_profile` (`user_profile_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `logins`, `last_login`, `user_profile_id`)
VALUES
	(1,'dmitry@lodoss.com','648548a904a3b0b1ff95fe4cfa17d60c87ab96b750d54451ccd79a7d4558d031',13,1353171650,1),
	(2,'alex@lodoss.com','648548a904a3b0b1ff95fe4cfa17d60c87ab96b750d54451ccd79a7d4558d031',14,1353177426,2),
	(3,'vitaly@lodoss.com','648548a904a3b0b1ff95fe4cfa17d60c87ab96b750d54451ccd79a7d4558d031',0,NULL,3),
	(4,'andrey@lodoss.com','648548a904a3b0b1ff95fe4cfa17d60c87ab96b750d54451ccd79a7d4558d031',1,1352919518,4);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
