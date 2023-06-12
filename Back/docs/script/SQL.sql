-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `release_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_39986E43B7970CF8` (`artist_id`),
  KEY `IDX_39986E43A76ED395` (`user_id`),
  CONSTRAINT `FK_39986E43A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_39986E43B7970CF8` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `album` (`id`, `artist_id`, `user_id`, `name`, `edition`, `release_date`, `created_at`, `updated_at`, `image`) VALUES
(1,	1,	2,	'album 1',	'edition 1',	'1973-03-24',	'2023-06-12 19:24:20',	NULL,	'https://media.senscritique.com/media/000004795486/300/the_dark_side_of_the_moon.jpg'),
(2,	2,	2,	'album 2',	'edition 2',	'1999-01-01',	'2023-06-12 17:24:10',	NULL,	'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133'),
(3,	3,	2,	'album 3 ',	'edition 3',	'2000-01-01',	'2023-06-12 17:24:34',	NULL,	'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133'),
(4,	4,	2,	'album 4',	'edition 4',	'2001-01-01',	'2023-06-12 17:24:57',	NULL,	'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133'),
(5,	5,	2,	'album 5',	'edition 5',	'2002-02-02',	'2023-06-12 17:25:41',	NULL,	'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133');

DROP TABLE IF EXISTS `album_style`;
CREATE TABLE `album_style` (
  `album_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  PRIMARY KEY (`album_id`,`style_id`),
  KEY `IDX_4505F24C1137ABCF` (`album_id`),
  KEY `IDX_4505F24CBACD6074` (`style_id`),
  CONSTRAINT `FK_4505F24C1137ABCF` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4505F24CBACD6074` FOREIGN KEY (`style_id`) REFERENCES `style` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `album_style` (`album_id`, `style_id`) VALUES
(1,	1),
(2,	2),
(3,	3),
(4,	4),
(5,	1);

DROP TABLE IF EXISTS `album_support`;
CREATE TABLE `album_support` (
  `album_id` int(11) NOT NULL,
  `support_id` int(11) NOT NULL,
  PRIMARY KEY (`album_id`,`support_id`),
  KEY `IDX_D5D3B6B71137ABCF` (`album_id`),
  KEY `IDX_D5D3B6B7315B405` (`support_id`),
  CONSTRAINT `FK_D5D3B6B71137ABCF` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D5D3B6B7315B405` FOREIGN KEY (`support_id`) REFERENCES `support` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `artist`;
CREATE TABLE `artist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `artist` (`id`, `fullname`) VALUES
(1,	'Artist 1'),
(2,	'Artist 2'),
(3,	'Artist 3'),
(4,	'Artist 4'),
(5,	'Artist 5'),
(6,	'Artist 6'),
(7,	'Artist 7');

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E46960F5A76ED395` (`user_id`),
  KEY `IDX_E46960F51137ABCF` (`album_id`),
  CONSTRAINT `FK_E46960F51137ABCF` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  CONSTRAINT `FK_E46960F5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794381C6A76ED395` (`user_id`),
  KEY `IDX_794381C61137ABCF` (`album_id`),
  CONSTRAINT `FK_794381C61137ABCF` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  CONSTRAINT `FK_794381C6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `song`;
CREATE TABLE `song` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `preview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `track_nb` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_33EDEEA11137ABCF` (`album_id`),
  CONSTRAINT `FK_33EDEEA11137ABCF` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `song` (`id`, `album_id`, `title`, `duration`, `preview`, `track_nb`) VALUES
(1,	1,	'titre 11',	60000,	NULL,	1),
(2,	1,	'titre 12',	51430,	NULL,	2),
(3,	1,	'titre 13',	30000,	NULL,	3),
(4,	1,	'titre 14',	30000,	NULL,	4),
(5,	1,	'titre 15',	30000,	NULL,	5),
(6,	2,	'titre 21',	30000,	NULL,	1),
(7,	2,	'titre 22',	30000,	NULL,	2),
(8,	2,	'titre 23',	30000,	NULL,	3),
(9,	3,	'titre 31',	3300000,	NULL,	1),
(10,	3,	'titre 32',	330000,	NULL,	2),
(11,	3,	'titre 33',	3000000,	NULL,	3),
(12,	4,	'titre 41',	300000,	NULL,	1),
(13,	4,	'titre 42',	4200000,	NULL,	2),
(14,	5,	'titre 51',	30000,	NULL,	1),
(15,	5,	'titre 52',	400000,	NULL,	2);

DROP TABLE IF EXISTS `style`;
CREATE TABLE `style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `style` (`id`, `name`, `image`) VALUES
(1,	'Rock',	NULL),
(2,	'Rap',	NULL),
(3,	'Electro',	NULL),
(4,	'Classic',	NULL);

DROP TABLE IF EXISTS `support`;
CREATE TABLE `support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `support` (`id`, `name`) VALUES
(1,	'CD'),
(2,	'Vinyl'),
(3,	'Cassette');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `avatar`) VALUES
(1,	'admin@admin.com',	'[\"ROLE_ADMIN\"]',	'$2y$13$ZdKTqUsVIggw9REUVSBTn.nwh.YjS8TKqlTme3sTi96HhziHxOfhO',	'romain',	'gradelet',	NULL),
(2,	'user@user.com',	'[\"ROLE_USER\"]',	'$2y$13$LU7xmAHYLxg9cWqkshuUHOJUBZH7vDHKA/wENstwKu8rtwyUJgBRy',	'user',	'user',	NULL);

-- 2023-06-12 17:53:39