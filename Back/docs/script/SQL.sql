-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

INSERT INTO `album` (`id`, `artist_id`, `user_id`, `name`, `edition`, `release_date`, `created_at`, `updated_at`, `image`) VALUES
(1,	1,	2,	'album 1',	'edition 1',	'1973-03-24',	'2023-06-12 19:24:20',	NULL,	'https://media.senscritique.com/media/000004795486/300/the_dark_side_of_the_moon.jpg'),
(2,	2,	2,	'album 2',	'edition 2',	'1999-01-01',	'2023-06-12 17:24:10',	NULL,	'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133'),
(3,	3,	2,	'album 3 ',	'edition 3',	'2000-01-01',	'2023-06-12 17:24:34',	NULL,	'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133'),
(4,	4,	2,	'album 4',	'edition 4',	'2001-01-01',	'2023-06-12 17:24:57',	NULL,	'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133'),
(5,	5,	2,	'album 5',	'edition 5',	'2002-02-02',	'2023-06-12 17:25:41',	NULL,	'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133');

INSERT INTO `album_style` (`album_id`, `style_id`) VALUES
(1,	1),
(2,	2),
(3,	3),
(4,	4),
(5,	1);

INSERT INTO `album_support` (`album_id`, `support_id`) VALUES
(1,	1),
(2,	2),
(3,	3),
(4,	1),
(5,	2);

INSERT INTO `artist` (`id`, `fullname`) VALUES
(1,	'Artist 1'),
(2,	'Artist 2'),
(3,	'Artist 3'),
(4,	'Artist 4'),
(5,	'Artist 5'),
(6,	'Artist 6'),
(7,	'Artist 7');

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230612125251',	'2023-06-12 14:53:00',	191);



INSERT INTO `review` (`id`, `user_id`, `album_id`, `content`, `created_at`) VALUES
(1,	2,	1,	'très bien',	'2023-06-13 08:22:10');

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

INSERT INTO `style` (`id`, `name`, `image`) VALUES
(1,	'Rock',	'https://images7.alphacoders.com/436/436860.jpg'),
(2,	'Rap',	'https://www.shutterstock.com/image-vector/vector-logo-rap-music-hand-260nw-1365427319.jpg'),
(3,	'Electro',	'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3RybyUyMG11c2ljfGVufDB8fDB8fHww&w=1000&q=80'),
(4,	'Classic',	'https://media.istockphoto.com/id/1131760814/fr/photo/femme-effectuant-sur-un-violon.jpg?s=612x612&w=0&k=20&c=rBMuY9ldE5fuqPP5SFozjMm3I4rv0YMS-zr5--VMeuQ=');

INSERT INTO `support` (`id`, `name`) VALUES
(1,	'CD'),
(2,	'Vinyl'),
(3,	'Cassette');

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `avatar`) VALUES
(1,	'admin@admin.com',	'[\"ROLE_ADMIN\"]',	'$2y$13$ZdKTqUsVIggw9REUVSBTn.nwh.YjS8TKqlTme3sTi96HhziHxOfhO',	'romain',	'gradelet',	NULL),
(2,	'user@user.com',	'[\"ROLE_USER\"]',	'$2y$13$LU7xmAHYLxg9cWqkshuUHOJUBZH7vDHKA/wENstwKu8rtwyUJgBRy',	'user',	'user',	NULL);

-- 2023-06-13 07:30:44