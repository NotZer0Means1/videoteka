-- Videoteka Database Backup
-- Generated on: 2025-08-21 13:42:54

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `created_at`) VALUES
('1', '1', 'login', 'Administrator login', '2025-08-06 21:30:24'),
('22', '5', 'register', 'User registered successfully', '2025-08-19 00:31:45'),
('23', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-19 00:31:52'),
('24', '5', 'logout', 'User logged out', '2025-08-19 00:31:54'),
('25', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-19 00:32:09'),
('26', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-19 21:06:12'),
('27', '5', 'logout', 'User logged out', '2025-08-19 21:10:05'),
('28', NULL, 'failed_login', 'Failed login: admin', '2025-08-19 21:10:15'),
('29', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-19 21:10:18'),
('30', '5', 'add_movie_omdb', 'Added movie from OMDB: Interstellar', '2025-08-19 21:19:01'),
('31', '5', 'add_movie_omdb', 'Added movie from OMDB: Fight Club', '2025-08-19 21:19:48'),
('32', '5', 'add_movie_omdb', 'Added movie from OMDB: The Dark Knight', '2025-08-19 21:21:00'),
('33', '5', 'logout', 'User logged out', '2025-08-19 21:21:26'),
('34', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-19 21:22:02'),
('35', '5', 'delete_movie', 'Deleted movie: The Dark Knight', '2025-08-19 21:26:48'),
('36', '5', 'delete_movie', 'Deleted movie: Inception', '2025-08-19 21:26:50'),
('37', '5', 'delete_movie', 'Deleted movie: Forrest Gump', '2025-08-19 21:26:51'),
('38', '5', 'delete_movie', 'Deleted movie: Jaws', '2025-08-19 21:26:54'),
('39', '5', 'delete_movie', 'Deleted movie: Pulp Fiction', '2025-08-19 21:26:55'),
('40', '5', 'delete_movie', 'Deleted movie: The Godfather', '2025-08-19 21:26:58'),
('41', '5', 'delete_movie', 'Deleted movie: The Matrix', '2025-08-19 21:27:00'),
('42', '5', 'delete_movie', 'Deleted movie: The Shawshank Redemption', '2025-08-19 21:27:02'),
('43', '5', 'delete_movie', 'Deleted movie: Titanic', '2025-08-19 21:27:04'),
('44', '5', 'delete_movie', 'Deleted movie: Toy Story', '2025-08-19 21:27:06'),
('45', '5', 'logout', 'User logged out', '2025-08-19 22:32:41'),
('46', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-19 22:33:24'),
('47', '5', 'add_movie_omdb', 'Added movie from OMDB: Need for Speed', '2025-08-19 22:37:03'),
('48', '5', 'add_movie_omdb', 'Added movie from OMDB: The Green Mile', '2025-08-19 22:37:48'),
('49', '5', 'add_movie_omdb', 'Added movie from OMDB: Transformers', '2025-08-19 22:38:07'),
('50', '5', 'add_movie_omdb', 'Added movie from OMDB: Transformers: Dark of the Moon', '2025-08-19 22:38:14'),
('51', '5', 'add_movie_omdb', 'Added movie from OMDB: Transformers: Revenge of the Fallen', '2025-08-19 22:38:23'),
('52', '5', 'add_movie_omdb', 'Added movie from OMDB: The Theory of Everything', '2025-08-19 22:39:03'),
('53', '5', 'add_movie_omdb', 'Added movie from OMDB: Pirates of the Caribbean: The Curse of the Black Pearl', '2025-08-19 22:39:16'),
('54', '5', 'add_movie_omdb', 'Added movie from OMDB: Pirates of the Caribbean: Dead Man\'s Chest', '2025-08-19 22:39:23'),
('55', '5', 'add_movie_omdb', 'Added movie from OMDB: Pirates of the Caribbean: At World\'s End', '2025-08-19 22:39:28'),
('56', '5', 'add_movie_omdb', 'Added movie from OMDB: Pirates of the Caribbean: On Stranger Tides', '2025-08-19 22:39:35'),
('57', '5', 'add_movie_omdb', 'Added movie from OMDB: Pirates of the Caribbean: Dead Men Tell No Tales', '2025-08-19 22:39:41'),
('58', '5', 'logout', 'User logged out', '2025-08-19 23:43:32'),
('59', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-20 00:23:58'),
('60', '5', 'logout', 'User logged out', '2025-08-20 00:51:58'),
('61', NULL, 'failed_login', 'Failed login: Vlad', '2025-08-20 00:52:02'),
('62', NULL, 'failed_login', 'Failed login: Vlad', '2025-08-20 00:52:05'),
('63', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-20 00:59:10'),
('64', '5', 'admin_user_status', 'Changed user 2 status to inactive', '2025-08-20 01:05:58'),
('65', '5', 'admin_user_status', 'Changed user 2 status to active', '2025-08-20 01:06:00'),
('66', '5', 'admin_user_status', 'Changed user 2 status to inactive', '2025-08-20 01:06:08'),
('67', '5', 'admin_user_status', 'Changed user 2 status to active', '2025-08-20 01:06:21'),
('68', '5', 'logout', 'User logged out', '2025-08-20 01:07:38'),
('69', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-20 01:16:46'),
('70', '5', 'rent_movie', 'Rented movie: Fight Club', '2025-08-20 01:24:39'),
('71', '5', 'return_movie', 'Returned movie: Fight Club', '2025-08-20 01:24:56'),
('72', '5', 'rent_movie', 'Rented movie: Fight Club', '2025-08-20 01:25:07'),
('73', '5', 'logout', 'User logged out', '2025-08-20 01:25:11'),
('74', '6', 'register', 'User registered successfully', '2025-08-20 01:25:40'),
('75', '6', 'login', 'User logged in with reCAPTCHA', '2025-08-20 01:25:51'),
('76', '6', 'rent_movie', 'Rented movie: The Dark Knight', '2025-08-20 01:26:01'),
('77', '6', 'logout', 'User logged out', '2025-08-20 01:26:04'),
('78', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-20 01:26:07'),
('79', '5', 'logout', 'User logged out', '2025-08-20 01:28:20'),
('80', '6', 'login', 'User logged in with reCAPTCHA', '2025-08-20 01:28:23'),
('81', '6', 'rent_movie', 'Rented movie: Interstellar', '2025-08-20 01:28:30'),
('82', '6', 'logout', 'User logged out', '2025-08-20 01:28:37'),
('83', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-20 01:28:40'),
('84', '5', 'admin_user_status', 'Changed user 2 status to inactive', '2025-08-20 01:29:16'),
('85', '5', 'admin_user_status', 'Changed user 2 status to active', '2025-08-20 01:29:17'),
('86', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-21 00:18:15'),
('87', '5', 'admin_user_status', 'Changed user 6 status to inactive', '2025-08-21 00:18:25'),
('88', '5', 'logout', 'User logged out', '2025-08-21 00:18:50'),
('89', NULL, 'failed_login', 'Failed login: Bodya123', '2025-08-21 00:18:55'),
('90', NULL, 'failed_login', 'Failed login: BogomDan', '2025-08-21 00:18:58'),
('91', NULL, 'failed_login', 'Failed login: Bodya123', '2025-08-21 00:19:28'),
('92', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-21 00:19:40'),
('93', '5', 'admin_user_status', 'Changed user 6 status to active', '2025-08-21 00:19:50'),
('94', '5', 'admin_user_status', 'Changed user 6 status to inactive', '2025-08-21 00:19:54'),
('95', '5', 'admin_user_status', 'Changed user 6 status to active', '2025-08-21 00:19:56'),
('96', '5', 'logout', 'User logged out', '2025-08-21 00:19:59'),
('97', '6', 'login', 'User logged in with reCAPTCHA', '2025-08-21 00:20:02'),
('98', '6', 'logout', 'User logged out', '2025-08-21 00:23:18'),
('99', '5', 'login', 'User logged in with reCAPTCHA', '2025-08-21 00:23:22'),
('100', '5', 'logout', 'User logged out', '2025-08-21 00:32:03'),
('101', '6', 'failed_login', 'Failed login attempt #1', '2025-08-21 00:32:08'),
('102', '6', 'failed_login', 'Failed login attempt #2', '2025-08-21 00:32:38'),
('103', '6', 'account_deactivated', 'Account deactivated after 3 failed attempts', '2025-08-21 00:32:57'),
('104', '5', 'login', 'User logged in successfully', '2025-08-21 00:48:56'),
('105', '5', 'admin_update_user', 'Updated user: Bodya12', '2025-08-21 00:49:37'),
('106', '5', 'login', 'User logged in successfully', '2025-08-21 02:00:19'),
('107', '5', 'login', 'User logged in successfully', '2025-08-21 02:04:07'),
('108', '5', 'logout', 'User logged out', '2025-08-21 02:08:33'),
('109', '5', 'login', 'User logged in successfully', '2025-08-21 02:08:36'),
('110', '5', 'logout', 'User logged out', '2025-08-21 02:08:37'),
('111', '5', 'login', 'User logged in successfully', '2025-08-21 02:12:19'),
('112', '5', 'logout', 'User logged out', '2025-08-21 02:12:37'),
('113', NULL, 'failed_login', 'Failed login attempt for username: Bodya123', '2025-08-21 02:16:53'),
('114', '5', 'login', 'User logged in successfully', '2025-08-21 02:17:03'),
('115', '5', 'logout', 'User logged out', '2025-08-21 02:18:14'),
('116', '5', 'login', 'User logged in successfully', '2025-08-21 02:24:27'),
('117', '5', 'login', 'User logged in successfully', '2025-08-21 02:32:50'),
('118', '5', 'login', 'User logged in successfully', '2025-08-21 02:34:45'),
('119', '5', 'admin_update_user', 'Updated user: Bodya12', '2025-08-21 02:48:50'),
('120', '5', 'logout', 'User logged out', '2025-08-21 04:45:40'),
('121', '7', 'register', 'User registered successfully', '2025-08-21 04:46:01'),
('122', '5', 'login', 'User logged in successfully', '2025-08-21 13:41:18');

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES
('1', 'Marko Marić', 'marko@example.com', 'Upit o filmovima', 'Pozdrav, zanima me kada će biti dostupan novi film Avengers. Hvala!', '0', '2025-08-06 21:30:24');

DROP TABLE IF EXISTS `genres`;
CREATE TABLE `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `genres` (`id`, `name`) VALUES
('1', 'Action'),
('10', 'Adventure'),
('8', 'Animation'),
('11', 'Biography'),
('2', 'Comedy'),
('9', 'Crime'),
('3', 'Drama'),
('4', 'Horror'),
('5', 'Romance'),
('6', 'Sci-Fi'),
('7', 'Thriller');

DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `director` varchar(255) DEFAULT NULL,
  `actors` text DEFAULT NULL,
  `plot` text DEFAULT NULL,
  `poster_url` varchar(500) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `imdb_id` varchar(20) DEFAULT NULL,
  `runtime` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `genre_id` (`genre_id`),
  KEY `idx_imdb_id` (`imdb_id`),
  FULLTEXT KEY `title` (`title`,`director`,`actors`),
  CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `movies` (`id`, `title`, `year`, `director`, `actors`, `plot`, `poster_url`, `rating`, `genre_id`, `is_available`, `created_at`, `imdb_id`, `runtime`) VALUES
('11', 'Interstellar', '2014', 'Christopher Nolan', 'Matthew McConaughey, Anne Hathaway, Jessica Chastain', 'Earth\'s future has been riddled by disasters, famines, and droughts. There is only one way to ensure mankind\'s survival: Interstellar travel. A newly discovered wormhole in the far reaches of our solar system allows a team of astronauts to go where no man has gone before, a planet that may have the right environment to sustain human life.', 'https://m.media-amazon.com/images/M/MV5BYzdjMDAxZGItMjI2My00ODA1LTlkNzItOWFjMDU5ZDJlYWY3XkEyXkFqcGc@._V1_SX300.jpg', '8.7', '10', '0', '2025-08-19 21:19:01', 'tt0816692', '169 min'),
('12', 'Fight Club', '1999', 'David Fincher', 'Brad Pitt, Edward Norton, Meat Loaf', 'A nameless first person narrator (Edward Norton) attends support groups in attempt to subdue his emotional state and relieve his insomniac state. When he meets Marla (Helena Bonham Carter), another fake attendee of support groups, his life seems to become a little more bearable. However when he associates himself with Tyler (Brad Pitt) he is dragged into an underground fight club and soap making scheme. Together the two men spiral out of control and engage in competitive rivalry for love and power.', 'https://m.media-amazon.com/images/M/MV5BOTgyOGQ1NDItNGU3Ny00MjU3LTg2YWEtNmEyYjBiMjI1Y2M5XkEyXkFqcGc@._V1_SX300.jpg', '8.8', '9', '0', '2025-08-19 21:19:48', 'tt0137523', '139 min'),
('13', 'The Dark Knight', '2008', 'Christopher Nolan', 'Christian Bale, Heath Ledger, Aaron Eckhart', 'Set within a year after the events of Batman Begins (2005), Batman, Lieutenant James Gordon, and new District Attorney Harvey Dent successfully begin to round up the criminals that plague Gotham City, until a mysterious and sadistic criminal mastermind known only as \"The Joker\" appears in Gotham, creating a new wave of chaos. Batman\'s struggle against The Joker becomes deeply personal, forcing him to \"confront everything he believes\" and improve his technology to stop him. A love triangle develops between Bruce Wayne, Dent, and Rachel Dawes.', 'https://m.media-amazon.com/images/M/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_SX300.jpg', '9.1', '1', '0', '2025-08-19 21:21:00', 'tt0468569', '152 min'),
('14', 'Need for Speed', '2014', 'Scott Waugh', 'Aaron Paul, Dominic Cooper, Imogen Poots', 'Framed by an ex-partner for a murder he did not commit, Tobey Marshall, a financially struggling custom-car builder and street-racer, spends two years in jail thinking about one moment. Fresh out of prison he reacquires the fastest car his workshop ever built and sold, and seeks to enter a secretive and extremely high-stakes race known as The DeLeon. His purpose; redemption, recognition from the world of racing and to solve his problems. Yet all this fades in comparison to his driving reason. Revenge. Above all, revenge. This is a story about love, redemption, revenge and motor oil all swirled together', 'https://m.media-amazon.com/images/M/MV5BMTQ3ODY4NzYzOF5BMl5BanBnXkFtZTgwNjI3OTE4MDE@._V1_SX300.jpg', '6.4', '1', '1', '2025-08-19 22:37:03', 'tt2369135', '132 min'),
('15', 'The Green Mile', '1999', 'Frank Darabont', 'Tom Hanks, Michael Clarke Duncan, David Morse', 'Death Row guards at a penitentiary, in the 1930\'s, have a moral dilemma with their job when they discover one of their prisoners, a convicted murderer, has a special gift.', 'https://m.media-amazon.com/images/M/MV5BMTUxMzQyNjA5MF5BMl5BanBnXkFtZTYwOTU2NTY3._V1_SX300.jpg', '8.6', '9', '1', '2025-08-19 22:37:48', 'tt0120689', '189 min'),
('16', 'Transformers', '2007', 'Michael Bay', 'Shia LaBeouf, Megan Fox, Josh Duhamel', 'High-school student Sam Witwicky buys his first car, who is actually the Autobot Bumblebee. Bumblebee defends Sam and his girlfriend Mikaela Banes from the Decepticon Barricade, before the other Autobots arrive on Earth. They are searching for the Allspark, and the war on Earth heats up as the Decepticons attack a United States military base in Qatar. Sam and Mikaela are taken by the top-secret agency Sector 7 to help stop the Decepticons, but when they learn the agency also intends to destroy the Autobots, they formulate their own plan to save the world.', 'https://m.media-amazon.com/images/M/MV5BZjM3ZDA2YmItMzhiMi00ZGI3LTg3ZGQtOTk3Nzk0MDY0ZDZhXkEyXkFqcGc@._V1_SX300.jpg', '7.1', '1', '1', '2025-08-19 22:38:07', 'tt0418279', '144 min'),
('17', 'Transformers: Dark of the Moon', '2011', 'Michael Bay', 'Shia LaBeouf, Rosie Huntington-Whiteley, Tyrese Gibson', 'Autobots Bumblebee, Ratchet, Ironhide, Mirage (aka Dino), Wheeljack (aka Que) and Sideswipe led by Optimus Prime, are back in action taking on the evil Decepticons, who are eager to avenge their recent defeat. The Autobots and Decepticons become involved in a perilous space race between the United States and Russia to reach a hidden Cybertronian spacecraft on the moon and learn its secrets, and once again Sam Witwicky has to go to the aid of his robot friends. The new villain Shockwave is on the scene while the Autobots and Decepticons continue to battle it out on Earth.', 'https://m.media-amazon.com/images/M/MV5BMTkwOTY0MTc1NV5BMl5BanBnXkFtZTcwMDQwNjA2NQ@@._V1_SX300.jpg', '6.2', '1', '1', '2025-08-19 22:38:14', 'tt1399103', '154 min'),
('18', 'Transformers: Revenge of the Fallen', '2009', 'Michael Bay', 'Shia LaBeouf, Megan Fox, Josh Duhamel', 'A youth chooses manhood. The week Sam Witwicky starts college, the Decepticons make trouble in Shanghai. A presidential envoy believes it\'s because the Autobots are around; he wants them gone. He\'s wrong: the Decepticons need access to Sam\'s mind to see some glyphs imprinted there that will lead them to a fragile object that, when inserted in an alien machine hidden in Egypt for centuries, will give them the power to blow out the sun. Sam, his girlfriend Mikaela Banes, and Sam\'s parents are in danger. Optimus Prime and Bumblebee are Sam\'s principal protectors. If one of them goes down, what becomes of Sam?', 'https://m.media-amazon.com/images/M/MV5BNjk4OTczOTk0NF5BMl5BanBnXkFtZTcwNjQ0NzMzMw@@._V1_SX300.jpg', '6.0', '1', '1', '2025-08-19 22:38:23', 'tt1055369', '149 min'),
('19', 'The Theory of Everything', '2014', 'James Marsh', 'Eddie Redmayne, Felicity Jones, Tom Prior', 'The Theory of Everything is the story of the most brilliant and celebrated physicist of our time, Stephen Hawking, and Jane Wilde, the arts student he fell in love with while studying at Cambridge in the 1960s. Little was expected from Hawking, a bright but shiftless student of cosmology, after he was given just two years to live following the diagnosis of a fatal illness (ALS) at 21 years of age. He became galvanized, however, by the love Jane Wilde, and went on to be called the \"successor to Einstein,\" as well as a husband and father to their three children. Over the course of their marriage, however, as Stephen\'s body collapsed and his academic renown soared, fault lines were exposed that tested the resolve of their relationship and dramatically altered the course of both of their lives.', 'https://m.media-amazon.com/images/M/MV5BMTAwMTU4MDA3NDNeQTJeQWpwZ15BbWU4MDk4NTMxNTIx._V1_SX300.jpg', '7.7', '11', '1', '2025-08-19 22:39:03', 'tt2980516', '123 min'),
('20', 'Pirates of the Caribbean: The Curse of the Black Pearl', '2003', 'Gore Verbinski', 'Johnny Depp, Geoffrey Rush, Orlando Bloom', 'This swash-buckling tale follows the quest of Captain Jack Sparrow, a savvy pirate, and Will Turner, a resourceful blacksmith, as they search for Elizabeth Swann. Elizabeth, the daughter of the governor and the love of Will\'s life, has been kidnapped by the feared Captain Barbossa. Little do they know, but the fierce and clever Barbossa has been cursed. He, along with his large crew, are under an ancient curse, doomed for eternity to neither live, nor die. That is, unless a blood sacrifice is made.', 'https://m.media-amazon.com/images/M/MV5BNDhlMzEyNzItMTA5Mi00YWRhLThlNTktYTQyMTA0MDIyNDEyXkEyXkFqcGc@._V1_SX300.jpg', '8.1', '1', '1', '2025-08-19 22:39:16', 'tt0325980', '143 min'),
('21', 'Pirates of the Caribbean: Dead Man\'s Chest', '2006', 'Gore Verbinski', 'Johnny Depp, Orlando Bloom, Keira Knightley', 'Once again we\'re plunged into the world of sword fights and \"savvy\" pirates. Captain Jack Sparrow is reminded he owes a debt to Davy Jones, who captains the flying Dutchman, a ghostly ship, with a crew from hell. Facing the \"locker\" Jack must find the heart of Davy Jones but to save himself he must get the help of quick-witted Will Turner and Elizabeth Swan. If that\'s not complicated enough, Will and Elizabeth are sentenced to hang, unless Will can get Lord Cutler Beckett Jack\'s compass. Will is forced to join another crazy adventure with Jack.', 'https://m.media-amazon.com/images/M/MV5BMTcwODc1MTMxM15BMl5BanBnXkFtZTYwMDg1NzY3._V1_SX300.jpg', '7.4', '1', '1', '2025-08-19 22:39:23', 'tt0383574', '151 min'),
('22', 'Pirates of the Caribbean: At World\'s End', '2007', 'Gore Verbinski', 'Johnny Depp, Orlando Bloom, Keira Knightley', 'After Elizabeth, Will, and Captain Barbossa rescue Captain Jack Sparrow from the land of the dead, they must face their foes, Davy Jones and Lord Cutler Beckett. Beckett, now with control of Jones\' heart, forms a dark alliance with him in order to rule the seas and wipe out the last of the Pirates. Now, Jack, Barbossa, Will, Elizabeth, Tia Dalma, and crew must call the Pirate Lords from the four corners of the globe, including the infamous Sao Feng, to gathering. The Pirate Lords want to release the goddess Calypso, Davy Jones\'s damned lover, from the trap they sent her to out of fear, in which the Pirate Lords must combine the 9 pieces that bound her by ritual to undo it and release her in hopes that she will help them fight. With this, all pirates will stand together and will make their final stand for freedom against Beckett, Jones, Norrington, the Flying Dutchman, and the entire East India Trading Company.', 'https://m.media-amazon.com/images/M/MV5BMjIyNjkxNzEyMl5BMl5BanBnXkFtZTYwMjc3MDE3._V1_SX300.jpg', '7.1', '1', '1', '2025-08-19 22:39:28', 'tt0449088', '169 min'),
('23', 'Pirates of the Caribbean: On Stranger Tides', '2011', 'Rob Marshall', 'Johnny Depp, Penélope Cruz, Ian McShane', 'Captain Jack Sparrow (Johnny Depp) crosses paths with a woman from his past, Angelica (Penélope Cruz), and he\'s not sure if it\'s love, or if she\'s a ruthless con artist who\'s using him to find the fabled Fountain of Youth. When she forces him aboard the Queen Anne\'s Revenge, the ship of the formidable pirate Blackbeard (Ian McShane), Jack finds himself on an unexpected adventure in which he doesn\'t know who to fear more: Blackbeard or the woman from his past.', 'https://m.media-amazon.com/images/M/MV5BMjE5MjkwODI3Nl5BMl5BanBnXkFtZTcwNjcwMDk4NA@@._V1_SX300.jpg', '6.6', '1', '1', '2025-08-19 22:39:35', 'tt1298650', '136 min'),
('24', 'Pirates of the Caribbean: Dead Men Tell No Tales', '2017', 'Joachim Rønning, Espen Sandberg', 'Johnny Depp, Geoffrey Rush, Javier Bardem', 'Captain Jack Sparrow (Johnny Depp) finds the winds of ill-fortune blowing even more strongly when deadly ghost pirates led by his old nemesis, the terrifying Captain Salazar (Javier Bardem), escape from the Devil\'s Triangle, determined to kill every pirate at sea...including him. Captain Jack\'s only hope of survival lies in seeking out the legendary Trident of Poseidon, a powerful artifact that bestows upon its possessor total control over the seas.', 'https://m.media-amazon.com/images/M/MV5BMTYyMTcxNzc5M15BMl5BanBnXkFtZTgwOTg2ODE2MTI@._V1_SX300.jpg', '6.5', '1', '1', '2025-08-19 22:39:41', 'tt1790809', '129 min');

DROP TABLE IF EXISTS `rentals`;
CREATE TABLE `rentals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `rental_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` timestamp NULL DEFAULT NULL,
  `return_date` timestamp NULL DEFAULT NULL,
  `status` enum('active','returned','overdue') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rentals` (`id`, `user_id`, `movie_id`, `rental_date`, `due_date`, `return_date`, `status`) VALUES
('1', '5', '12', '2025-08-20 01:24:39', '2025-08-27 01:24:39', '2025-08-20 01:24:56', 'returned'),
('2', '5', '12', '2025-08-20 01:25:07', '2025-08-27 01:25:07', NULL, 'active'),
('3', '6', '13', '2025-08-20 01:26:01', '2025-08-27 01:26:01', NULL, 'active'),
('4', '6', '11', '2025-08-20 01:28:30', '2025-08-27 01:28:30', NULL, 'active');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','inactive','pending') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `failed_attempts` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `role`, `status`, `created_at`, `failed_attempts`) VALUES
('1', 'admin', 'admin@videoteka.com', 'admin123', 'Admin', 'User', 'admin', 'active', '2025-08-06 21:30:24', '0'),
('2', 'testuser', 'user@test.com', 'user123', 'Test', 'User', 'user', 'active', '2025-08-06 21:30:24', '0'),
('5', 'Vlad', 'vovashevalev@gmail.com', '$2y$10$Tstr7pXiWjX03.a.CfAVeuPwZ0IMV7MYEEN8e2mjd5CA6RbCpTNJy', 'Vladimir', 'Shevalev', 'admin', 'active', '2025-08-19 00:31:45', '0'),
('6', 'Bodya12', 'bodya123@gmail.com', '$2y$10$LX6INiog2jFXRXUPTOCZMO/0Zy7Ig2Qq2OcGzctrKM0tOC1b03.te', 'Bog', 'Dan', 'user', 'active', '2025-08-20 01:25:40', '3'),
('7', 'user', 'user@gmail.com', '$2y$10$.YrmYW4Wi6Yi23QV3ocBvuAHO/zkezdoWUDL8O8sEvgLwwsppLzCW', 'user', 'user', 'user', 'active', '2025-08-21 04:46:01', '0');

SET FOREIGN_KEY_CHECKS = 1;
