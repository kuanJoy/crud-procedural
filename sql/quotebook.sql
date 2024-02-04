-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.51-log - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных quotebook
CREATE DATABASE IF NOT EXISTS `quotebook` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `quotebook`;

-- Дамп структуры для таблица quotebook.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(11) NOT NULL,
  `group_fullname` varchar(70) DEFAULT NULL,
  `year_graduate` int(6) DEFAULT NULL,
  PRIMARY KEY (`id_group`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы quotebook.groups: ~21 rows (приблизительно)
INSERT INTO `groups` (`id_group`, `group_name`, `group_fullname`, `year_graduate`) VALUES
	(1, 'админы', 'Администраторы', 2000),
	(2, 'СИТ-1', 'Специалист интернет технологий', 2024),
	(3, 'СИТ-2', 'Специалист интернет технологий', 2024),
	(4, 'СИТ-К-1', 'Специалист интернет технологий контракт', 2024),
	(5, 'СИТ-К-2', 'Специалист интернет технологий контракт', 2024),
	(6, 'Ч-1', 'Чачтарач', 2024),
	(7, 'Ч-2', 'Чачтарач', 2024),
	(8, 'ММП', 'Младший Менеджер по Продажам', 2024),
	(9, 'СБ', 'Специалист Безопасности', 2024),
	(10, 'СА', 'Системный Администратор', 2024),
	(11, 'КД', 'Компьютерный Дизайн', 2024),
	(12, 'СИТ-1', 'Специалист интернет технологий', 2023),
	(13, 'СИТ-2', 'Специалист интернет технологий', 2023),
	(14, 'СИТ-К-1', 'Специалист интернет технологий контракт', 2023),
	(15, 'СИТ-К-2', 'Специалист интернет технологий контракт', 2023),
	(16, 'Ч-1', 'Чачтарач', 2023),
	(17, 'Ч-2', 'Чачтарач', 2023),
	(18, 'ММП', 'Младший Менеджер по Продажам', 2023),
	(19, 'СБ', 'Специалист Безопасности', 2023),
	(20, 'СА', 'Системный Администратор', 2023),
	(21, 'КД', 'Компьютерный Дизайн', 2023);

-- Дамп структуры для таблица quotebook.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('активен','скрыт') DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `fk_posts_users` (`id_user`),
  CONSTRAINT `fk_posts_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы quotebook.posts: ~28 rows (приблизительно)
INSERT INTO `posts` (`id_post`, `description`, `time`, `status`, `id_user`) VALUES
	(2, 'Если удалить пользователя, то посты будут принимать id_user равное 1 - то бишь удалённый пользователь', '2024-02-01 15:29:26', 'скрыт', 1),
	(6, 'Как же красивы эти звёзды на ночном небе. Они сверкают, и мерцание их словно создаёт магическую атмосферу. Каждая звезда - какое-то маленькое чудо, данное нам наблюдать. Они напоминают нам о том, что существует что-то гораздо большее, чем наша повседневная жизнь. Когда я смотрю на эти звёзды, я чувствую себя таким маленьким и незначительным в этой необъятной вселенной. Но в то же время я понимаю, что каждый из нас имеет своё место в этом мире и что мы все важны. Звёзды - символ надежды и мечты. Они напоминают нам о том, что всегда есть свет в конце тоннеля и что мы можем достичь любых высот, если верим в себя', '2024-02-02 06:00:20', 'активен', 4),
	(7, 'Я готов убить за такой сачок кого-нибудь не больше морковки, но только не пауков — я их боюсь!', '2024-02-03 15:30:28', 'активен', 10),
	(8, 'О, да, конечно, я хотел бы жить в Морском Царстве на всю оставшуюся жизнь, работать на кассе в Красти Краб и выслушивать все эти ваши идиотские шутки', '2024-02-03 15:45:45', 'активен', 8),
	(9, 'Ничто не может погасить мой дух, потому что его уже давно уничтожили', '2024-02-03 15:45:59', 'активен', 8),
	(10, 'Разбуди меня, когда мне будет интересно', '2024-02-03 16:29:35', 'активен', 8),
	(11, 'Губка Боб, я думаю, что Сквидвард зашел слишком далеко. В том последнем снежке был его кларнет', '2024-02-03 16:31:19', 'активен', 10),
	(12, 'Я знал, что мне не следовало вставать сегодня с постели', '2024-02-03 16:31:30', 'активен', 8),
	(13, 'Не всегда важно то, что ты говоришь, иногда важно то, что ты не говоришь', '2024-02-03 16:37:10', 'активен', 11),
	(14, 'Если ты теряешь время, ты теряешь деньги… и это просто отвратительно', '2024-02-03 16:38:44', 'активен', 11),
	(15, 'Если ты веришь в себя и с небольшой щепоткой волшебства, все твои мечты могут стать реальностью', '2024-02-03 16:39:47', 'активен', 5),
	(16, 'Я хочу, чтобы вы знали, что на прошлой неделе я ушиб палец на ноге и плакал всего 20 минут', '2024-02-03 16:40:34', 'активен', 5),
	(17, 'Извините, сэр, но вы сидите на моем теле, которое также является моим лицом', '2024-02-03 16:42:24', 'активен', 5),
	(18, 'У наших друзей из Бикини Боттом не идеальная жизнь, и они не безупречные личности. У каждого из них есть свои причуды, слабости и сильные стороны, которые делают их такими, какие они есть', '2024-02-03 16:45:43', 'активен', 4),
	(19, 'Вам не нужны права, чтобы водить сэндвич', '2024-02-03 16:46:28', 'активен', 5),
	(20, 'Красота не имеет пределов, а стиль - это ваша карта в мир. Дайте своим волосам шанс рассказать о вас историю силы и страсти', '2024-02-04 14:48:58', 'активен', 6),
	(21, 'Стрижка - это не просто инструмент преобразования внешности, это выражение вашей личной мощи и характера, запечатленное в каждой пряди', '2024-02-04 14:49:09', 'активен', 7),
	(22, 'Когда ваши волосы выглядят хорошо, вы чувствуете себя непобедимой. Ведь это не просто стрижка, это ваша корона', '2024-02-04 14:49:39', 'активен', 6),
	(23, 'Хорошая стрижка - это как магия: она не только меняет твой вид, но и твое настроение, делая день ярче и веселее!', '2024-02-04 14:50:19', 'активен', 9),
	(24, 'Когда у тебя стильная стрижка, будто бы ты играешь в жизненную игру на легком уровне сложности - красиво и с улыбкой на лице!', '2024-02-04 14:50:31', 'активен', 6),
	(25, 'Лучше скажи ему, чтоб он не пи*дел, а руль покрепче держал в лапах. А то каждый раз, как он за рулем, мы улетали куда-нибудь, бл*дь, в канаву', '2024-02-04 15:08:06', 'активен', 12),
	(26, 'Вот почему поверженный воин не должен возвращаться. Иначе он однажды увидит, как все его идеалы превращаются в дерьмо.', '2024-02-04 15:08:53', 'активен', 12),
	(27, 'Единственная разница между хорошим и плохим днём - это твоё отношение к нему', '2024-02-04 15:09:55', 'активен', 12),
	(28, 'Никто не ценит того, чего слишком много', '2024-02-04 15:10:12', 'активен', 12),
	(29, 'Мне не стоит того. У меня кроме тебя больше ничего не осталось. Но у тебя всё ещё есть мечта, за которой стоит бороться. Мне нужно, чтобы ты её осуществил. Это моя мечта. Если честно, ничто другое никогда не имело значения', '2024-02-04 15:18:56', 'активен', 13),
	(30, 'I Will Take You To The Moon My Self. I Promise', '2024-02-04 15:20:01', 'активен', 13),
	(31, 'Don’t Make A Name For Yourself As A Cyberpunk By How You Live… Make A Name By How You Die', '2024-02-04 15:24:28', 'активен', 13),
	(32, 'Единственная разница между плохим и хорошим днём - твоё отношение к нему', '2024-02-04 15:30:17', 'активен', 12);

-- Дамп структуры для таблица quotebook.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы quotebook.roles: ~3 rows (приблизительно)
INSERT INTO `roles` (`id_role`, `role_name`) VALUES
	(1, 'админ'),
	(2, 'модератор'),
	(3, 'студент');

-- Дамп структуры для таблица quotebook.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default_ava.jpg',
  `id_group` int(11) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE KEY `unique_email` (`email`),
  KEY `fk_users_groups` (`id_group`) USING BTREE,
  KEY `fk_users_roles` (`id_role`),
  CONSTRAINT `fk_users_groups` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`),
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы quotebook.users: ~12 rows (приблизительно)
INSERT INTO `users` (`id_user`, `name`, `surname`, `email`, `password`, `photo`, `id_group`, `id_role`) VALUES
	(1, 'удалённый', 'пользователь', 'none@none.com', '$2y$10$bx6bK2Qmd5Q.91J.VGCBeOK6naROIvOG5o9DOCuR9YmX/fFDo6O5y', './assets/images/upload/default_ava.jpg', 1, 3),
	(2, 'admin', 'admin', 'admin@admin.com', '$2y$10$l.85PBemH4oCsxWzP2nTne6.lFry9KD1YgIeXmgY.ig/JfVb1jjoW', './assets/images/upload/admin@admin.com65bc82ca71a4a1.71251202.png', 1, 1),
	(4, 'Куанышбек', 'Мыкыев', 'kuanyshmykyev@gmail.com', '$2y$10$o/egMQR6/aQoawvcFG.o/u5.Nt2Oa8P3SPqzCP.TfB0ikKyIAja.6', './assets/images/upload/kuanyshmykyev@gmail.com65bc824059d147.33191273.png', 2, 2),
	(5, 'Губка', 'Боб', 'spongebob@gmail.com', '$2y$10$jHCJcxpeMZapRDTlE2sI8.ZylLeRTXChU62yFvZ1186vL8Jz0xyGC', './assets/images/upload/spongebob@gmail.com65bc8255468b45.96113106.jpg', 8, 3),
	(6, 'Алиса', 'Соколова', 'testgirl@gmail.com', '$2y$10$rcTxhKbKoDAQCIcT3AcBI.59GQHEzF//c3h.V2mJOgVHvTCto.AKe', './assets/images/upload/testgirl@gmail.com65bc826c8f3300.01544962.jpg', 16, 3),
	(7, 'Артём', 'Дроздов', 'test@gmail.com', '$2y$10$4wc2etmuOB.C/CT.yR1k2.a5FHyyn61qpk4n95fo6xs9f2.GDCEBK', './assets/images/upload/test@gmail.com65bc82fa2f7cc4.88102374.png', 16, 3),
	(8, 'Сквидвард', 'Тентаклс', 'skvidvard@sponge.com', '$2y$10$uqHcffXQbqQcbd6oI2UlguIvmXXdkPUjLcIYch9UoNm0agvzS95Be', './assets/images/upload/skvidvard@sponge.com65bc86f33c1ad8.19169285.png', 8, 3),
	(9, 'Дарья', 'Мельникова', 'altititi@gmail.com', '$2y$10$qTQ9hM3GwR4vnd/WfiHNXuCt1gPBVZaMKRZNfuQtTfc6vudGf.Tbm', './assets/images/upload/altititi@gmail.com65bfa59967e935.41046570.jpg', 16, 3),
	(10, 'Патрик', 'Стар', 'patrik@gmail.com', '$2y$10$f3iIPyRF1AQkowAUnJp45.TukQ31.UfW1R7TvYYPd1WtlQKcjOffy', './assets/images/upload/patrik@gmail.com65bc94b46b18b3.45911055.jpg', 8, 3),
	(11, 'Мистер', 'Крабс', 'krabsMr@gmail.com', '$2y$10$kdgnw8du/MH7aEwJONhXJOQDVu3dmoI3c4CH1T6lQBLth/zCoPaP2', './assets/images/upload/krabsMr@gmail.com65be6ba8063504.66167520.jpeg', 8, 3),
	(12, 'Джонни', 'Сильверхенд', 'silverhand@gmail.com', '$2y$10$zVkAcBzkF.dpYiGHMiaLTuuq8cJc2DAGVE4czkPUoG9vmLLGLjUmi', './assets/images/upload/silverhand@gmail.com65bfa8441ff646.83007504.png', 11, 3),
	(13, 'Дэвид', 'Мартинез', 'david_martinez@gmail.com', '$2y$10$7530KvBrwGKD3x42hVN4beZN3eEvMqjx1gtrTS75TIAh4.ECHPMUa', './assets/images/upload/david_martinez@gmail.com65bfa9fc5ddec0.34757043.jpg', 11, 3);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
