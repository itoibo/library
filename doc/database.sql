SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `author` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `author` (`id`, `first_name`, `last_name`) VALUES
(4, 'William', 'Shakespeare'),
(5, 'Agatha', 'Christie'),
(6, 'Barbara', 'Cartland'),
(7, 'Danielle', 'Steel'),
(8, 'Harold', 'Robbins'),
(9, 'Georges', 'Simenon'),
(10, 'Enid', 'Blyton'),
(11, 'Sidney', 'Sheldon'),
(12, 'J. K.', 'Rowling'),
(13, 'Gilbert', 'Patten'),
(14, 'Leo', 'Tolstoy');

CREATE TABLE `book` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `author_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `book` (`id`, `title`, `description`, `author_id`) VALUES
(1, 'The Hunger Games', 'xxx', 4),
(2, 'Harry Potter and the Order of the Phoenix ', 'xxx', 5),
(3, 'To Kill a Mockingbird', 'xxx', 6),
(4, 'Pride and Prejudice', 'xxx', 7),
(5, '	Twilight', 'xxx', 8),
(6, 'The Book Thief', 'xxx', 9),
(7, '	Animal Farm', 'xxx', 10),
(8, 'The Chronicles of Narnia', 'xxx', 11),
(9, 'The Fault in Our Stars', 'xxx', 12),
(10, '	Gone with the Wind', 'xxx', 13),
(11, 'The Giving Tree', 'xxx', 14),
(12, 'Wuthering Heights', 'xxx', 4),
(13, '	The Da Vinci Code', 'xxx', 5),
(14, 'The Picture of Dorian Gray', 'xxx', 6),
(15, 'Memoirs of a Geisha', 'xxx', 7),
(16, 'Alice\'s Adventures in Wonderland', 'xxx', 8),
(17, 'Les Misérables', 'xxx', 9),
(18, 'Fahrenheit 451', 'xxx', 10),
(19, 'Divergent', 'xxx', 11),
(20, 'Lord of the Flies', 'xxx', 12),
(21, 'The Alchemist', 'xxx', 13),
(22, 'Crime and Punishment', 'xxx', 14),
(23, 'The Great Gatsby', 'xxx', 4),
(24, 'City of Bones', 'xxx', 5),
(25, 'The Help', 'xxx', 6);


ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_ibfk_1` (`author_id`);


ALTER TABLE `author`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `book`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;


ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE;
COMMIT;
