-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Gru 2020, 01:47
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `online_class_register`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_absence`
--

CREATE TABLE `tbl_absence` (
  `absence_id` int(11) NOT NULL,
  `absence_lesson_number` enum('1','2','3','4','5','6','7','8','9','10') COLLATE utf8_polish_ci NOT NULL,
  `absence_date` date NOT NULL,
  `absence_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `absence_teacher_id` int(11) DEFAULT NULL,
  `absence_student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_absence`
--

INSERT INTO `tbl_absence` (`absence_id`, `absence_lesson_number`, `absence_date`, `absence_created_at`, `absence_teacher_id`, `absence_student_id`) VALUES
(6, '5', '2020-08-18', '2020-08-26 23:08:45', 38, 5),
(7, '5', '2020-08-18', '2020-08-26 22:54:23', 38, 7),
(8, '4', '2020-08-18', '2020-08-26 23:16:41', 33, 19),
(10, '6', '2020-12-15', '2020-12-11 23:41:35', 33, 2),
(13, '1', '2020-12-11', '2020-12-13 23:32:13', 32, 2),
(14, '1', '2020-12-19', '2020-12-19 18:09:58', 37, 12),
(16, '1', '2020-12-11', '2020-12-19 18:27:37', 37, 2),
(17, '7', '2020-12-19', '2020-12-19 19:18:50', 37, 15),
(18, '2', '2020-12-19', '2020-12-19 19:18:59', 37, 18);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_grades`
--

CREATE TABLE `tbl_grades` (
  `grade_id` int(11) NOT NULL,
  `grade_value` enum('1','2','3','4','5','6') COLLATE utf8_polish_ci NOT NULL,
  `grade_comment` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `grade_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade_semester` enum('Semester 1','Semester 2') COLLATE utf8_polish_ci NOT NULL DEFAULT 'Semester 1',
  `grade_category_id` int(11) DEFAULT NULL,
  `grade_student_id` int(11) NOT NULL,
  `grade_teacher_id` int(11) DEFAULT NULL,
  `grade_subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_grades`
--

INSERT INTO `tbl_grades` (`grade_id`, `grade_value`, `grade_comment`, `grade_created_at`, `grade_semester`, `grade_category_id`, `grade_student_id`, `grade_teacher_id`, `grade_subject_id`) VALUES
(8, '3', 'dsad', '2020-08-22 09:43:54', 'Semester 1', 6, 2, 32, 2),
(9, '5', 'asdsadasdasd55', '2020-08-22 23:02:57', 'Semester 2', 5, 6, 33, 11),
(10, '3', 'asdsadasdasd', '2020-08-23 12:59:16', 'Semester 1', 6, 19, 32, 11),
(11, '3', 'asdsadasdasd', '2020-08-24 14:12:36', 'Semester 1', 6, 19, 38, 11),
(12, '3', 'asdsadasdasd', '2020-08-24 14:12:52', 'Semester 1', 6, 19, 32, 11),
(13, '3', 'asdsadasdasd', '2020-08-24 14:26:42', 'Semester 2', 6, 2, 38, 11),
(14, '3', 'asdsadasdasd', '2020-08-24 14:27:32', 'Semester 2', 6, 2, 32, 11),
(15, '3', 'dsadsadasdasd', '2020-08-24 15:21:45', 'Semester 2', 6, 2, 32, 11),
(16, '6', 'Całki', '2020-08-25 16:36:07', 'Semester 1', 6, 19, 38, 2),
(17, '3', 'dsad', '2020-08-26 22:42:18', 'Semester 2', 6, 2, 32, 11),
(18, '3', 'dsad', '2020-08-26 22:42:37', 'Semester 1', 6, 2, 32, 11),
(19, '3', 'asdsadasdasdasdsadasdasdasdsadasdasdasdsadasdasdasdsadasdasdasdsadasdasdasdsadasdas', '2020-08-28 11:18:43', 'Semester 2', 3, 6, 38, 2),
(21, '1', '3', '2020-08-28 11:27:47', 'Semester 1', 3, 2, 37, 5),
(24, '2', 'sadadsadads', '2020-12-13 21:16:11', 'Semester 2', NULL, 4, 37, 5),
(25, '6', 'change', '2020-12-13 21:31:03', 'Semester 2', 6, 19, 37, 3),
(26, '3', 'sadsada', '2020-12-19 19:30:24', 'Semester 1', 15, 9, 37, 7),
(27, '1', 'asdsad', '2020-12-19 19:30:40', 'Semester 2', 3, 2, 37, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_grades_category`
--

CREATE TABLE `tbl_grades_category` (
  `grade_category_id` int(11) NOT NULL,
  `grade_category_name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `grade_category_weight` enum('1','2','3','4','5','6','7','8','9','10') COLLATE utf8_polish_ci NOT NULL,
  `grade_category_color` varchar(20) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_grades_category`
--

INSERT INTO `tbl_grades_category` (`grade_category_id`, `grade_category_name`, `grade_category_weight`, `grade_category_color`) VALUES
(3, 'Odpowiedź22', '6', '#388844'),
(4, 'Praca domowa', '4', '#00D2FF'),
(5, 'Kartkówka', '1', '#f41bca'),
(6, 'Aktywność', '2', '#fff400'),
(7, 'Praca dodatkowa', '2', '#ff8100'),
(8, 'Test', '3', '#b3fdf0'),
(9, 'Przygotowanie do zajęć', '5', '#f5b3fd'),
(10, 'Praca klasowa', '10', '#0b988d'),
(12, 'dasdasdasd1', '5', 'nowy kolor'),
(15, 'sssss', '5', 'sdadsa'),
(17, 'Nowa', '5', 'red'),
(18, 'Updated', '3', 'blue');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_groups`
--

CREATE TABLE `tbl_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `group_short_name` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_stage` enum('Preschool','Elementary school','Middle school','High school','Other') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_groups`
--

INSERT INTO `tbl_groups` (`group_id`, `group_name`, `group_short_name`, `group_level`, `group_stage`) VALUES
(1, 'BRAK PRZYDZIELONEJ KLASY', 'BPK', 0, 'Other'),
(2, 'Technik usług gastronomicznych', 'TUG', 2, 'Middle school'),
(3, 'Technik Rolnik', 'TRo', 1, 'Middle school'),
(4, 'Profil humanistyczny', 'P.H', 1, 'Middle school'),
(5, 'Mechanik', 'Mech', 3, 'Middle school'),
(6, 'Technik Reklamy', 'TRe', 4, 'Middle school'),
(7, 'Podstawówka 1A', '1A', 1, 'Elementary school'),
(8, 'Podstawówka 2C', '2C', 2, 'Elementary school'),
(10, 'nowa2', 'N1', 34, 'Preschool'),
(12, 'test200', 't200', 2, 'Preschool');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_groups_subjects`
--

CREATE TABLE `tbl_groups_subjects` (
  `group_subject_id` int(11) NOT NULL,
  `group_subject_subject_id` int(11) NOT NULL,
  `group_subject_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_groups_subjects`
--

INSERT INTO `tbl_groups_subjects` (`group_subject_id`, `group_subject_subject_id`, `group_subject_group_id`) VALUES
(3, 3, 5),
(5, 3, 7),
(6, 2, 7),
(7, 2, 5),
(8, 3, 4),
(9, 6, 4),
(10, 4, 4),
(11, 10, 4),
(12, 10, 6),
(13, 4, 6),
(14, 5, 6),
(15, 2, 6),
(16, 10, 3),
(17, 8, 3),
(22, 10, 2),
(23, 9, 2),
(26, 2, 2),
(28, 3, 2),
(29, 5, 2),
(31, 7, 2),
(32, 5, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_notes`
--

CREATE TABLE `tbl_notes` (
  `note_id` int(11) NOT NULL,
  `note_comment` text COLLATE utf8_polish_ci NOT NULL,
  `note_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note_teacher_id` int(11) DEFAULT NULL,
  `note_student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_notes`
--

INSERT INTO `tbl_notes` (`note_id`, `note_comment`, `note_created_at`, `note_teacher_id`, `note_student_id`) VALUES
(7, '123', '2020-12-18 23:10:55', 37, 12),
(9, 'asdasdsadasdasdasdsadasdasdasdsa dasdasdasdsadasdasdasdsadasdasdasdsadasd', '2020-12-19 00:21:56', 37, 19),
(11, 'test', '2020-08-26 15:36:53', 37, 19),
(13, 'test2222', '2020-08-24 16:28:19', 32, 12),
(16, 'asdsadsad', '2020-12-13 19:58:19', 33, 2),
(17, 'sadsadasd', '2020-12-13 21:08:27', 37, 5),
(18, 'aaaaaaaaaaaaaa', '2020-12-19 00:12:24', 33, 12),
(20, '123XD', '2020-12-19 17:44:41', 37, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_parents`
--

CREATE TABLE `tbl_parents` (
  `parent_id` int(11) NOT NULL,
  `parent_email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `parent_password` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `parent_is_active` enum('1','0') COLLATE utf8_polish_ci NOT NULL DEFAULT '1',
  `parent_student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_parents`
--

INSERT INTO `tbl_parents` (`parent_id`, `parent_email`, `parent_password`, `parent_is_active`, `parent_student_id`) VALUES
(4, 'rodzic2', '$2y$10$T8Ad13F1srIAx8eqRbLFTOzu7rTcnfGIwR3IsEBDAucY6N0XnmQDq', '1', 3),
(5, 'rodzic23', '$2y$10$sXSEkumOq4anWR60BgPw.u/YsG3miAgliZf31AgAcjqKN4MqMi0Va', '0', 12),
(6, 'rodzic@gmail.com', '$2y$10$saLAcduAj5bjQDOkI2wARur3FeengAhOV0r7E1v0sA4ckkb9CyFHi', '1', 19),
(8, 'sadasd', '$2y$10$nkIUGlKj1q.uGkf4sZMKj.BvgKf2T1IgW6Y/6vmtyBmztVNdZUgNG', '0', 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_students`
--

CREATE TABLE `tbl_students` (
  `student_id` int(11) NOT NULL,
  `student_email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `student_password` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `student_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `student_surname` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `student_is_active` enum('1','0') COLLATE utf8_polish_ci NOT NULL DEFAULT '1',
  `student_group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_students`
--

INSERT INTO `tbl_students` (`student_id`, `student_email`, `student_password`, `student_name`, `student_surname`, `student_is_active`, `student_group_id`) VALUES
(2, 'testBL@gmail.com', '$2y$10$3qayPMRyUNyVGizzLTjDf.AAf1eUw/EzK6tgQd93luuaZnhsHwpuC', 'B', 'B', '1', 2),
(3, 'testCL@gmail.com', 'testA', 'C', 'C', '1', 2),
(4, 'testDL@gmail.com', 'testA', 'D', 'D', '1', 3),
(5, 'testEL@gmail.com', 'testA', 'E', 'E', '1', 4),
(6, 'testFL@gmail.com', 'testA', 'F', 'F', '1', 5),
(7, 'testGL@gmail.com', 'testA', 'G', 'G', '1', 6),
(8, 'testHL@gmail.com', 'testA', 'H', 'H', '1', 7),
(9, 'testIL@gmail.com', 'testA', 'I', 'I', '1', 2),
(10, 'testJL@gmail.com', 'testA', 'J', 'J', '1', 4),
(11, 'testKL@gmail.com', 'testA', 'K', 'K', '1', 5),
(12, 'testL@gmail.com', 'testA', 'L', 'L', '1', 6),
(13, 'wwwwwwwwwwwwwwwwww123w@gmail.com', '$2y$10$6tjWQmENW9alRy9H6eA8weNC0tlUM6uydgJOxqYsZMMKMvZtmfjEC', 'B', 'B', '1', 2),
(15, 'student5133@gmail.com', '$2y$10$WoZpTl7m1uMCcz/gD3fZTO9RZvaTI7yFMRpAnOMyicsKCuZjluoqq', 'ss31', 'ss31', '1', 3),
(17, 'asdasdsasadsaddasd', '$2y$10$P79bmt1/Z3wpyEZo4s12q.z.PQJ/QJ2Zh5EqgOQFVLpbktphHga62', 'sadadsadasd', 'sadasdsad', '0', 1),
(18, 'testwwdz@gmail.com', '$2y$10$aLAgVu/3bdMbOOFWoLCD2OWVrlx/EhUqq4UGai9I4q9iFOGNfbSSm', '1', '1', '1', 3),
(19, 'student@gmail.com', '$2y$10$2QR7zBhr9xlRsjZPFHRZpuvjRPsKxA//OqRH5TqubFUT5M0H/K.7C', 'B', 'B', '1', 2),
(20, 'wwwwwwwwwwwwwwwwwww@gmail.com', '$2y$10$e7oLQ0D8smIIT2po9hidJuz56t2Su2.fos6RfaiWthERJr0f2VXHa', 'B', 'B', '1', 2),
(21, '2', '$2y$10$pnBnRF5gVJfuSDx2Vsyo9.pGKJTBZFBaG8XZ922aj0VZ6qUzwsk6u', '2', '2', '0', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(45) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`subject_id`, `subject_name`) VALUES
(2, 'Matematyka'),
(3, 'Język polski'),
(4, 'Język angielski'),
(5, 'Język niemiecki'),
(6, 'Wiedza o społeczeństwie'),
(7, 'Bezpieczeństwo i higiena pracy'),
(8, 'Geografia'),
(9, 'Biologia'),
(10, 'Fizyka'),
(11, 'Chemia'),
(55, 'wwdz');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_subject_has_teacher`
--

CREATE TABLE `tbl_subject_has_teacher` (
  `subject_has_teacher_id` int(11) NOT NULL,
  `subject_has_teacher_subject_id` int(11) NOT NULL,
  `subject_has_teacher_teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_subject_has_teacher`
--

INSERT INTO `tbl_subject_has_teacher` (`subject_has_teacher_id`, `subject_has_teacher_subject_id`, `subject_has_teacher_teacher_id`) VALUES
(20, 4, 34),
(21, 2, 38),
(22, 2, 38),
(23, 3, 34),
(24, 3, 34),
(25, 5, 37),
(27, 2, 32),
(28, 2, 35),
(29, 7, 37),
(30, 5, 35),
(31, 11, 38),
(32, 55, 32),
(33, 7, 34),
(34, 55, 38),
(35, 5, 34),
(36, 6, 34);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_teachers`
--

CREATE TABLE `tbl_teachers` (
  `teacher_id` int(11) NOT NULL,
  `teacher_email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `teacher_password` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `teacher_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `teacher_surname` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `teacher_is_active` enum('1','0') COLLATE utf8_polish_ci NOT NULL DEFAULT '1',
  `teacher_role` enum('Headmaster','Teacher','Administrator') COLLATE utf8_polish_ci NOT NULL,
  `teacher_group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_teachers`
--

INSERT INTO `tbl_teachers` (`teacher_id`, `teacher_email`, `teacher_password`, `teacher_name`, `teacher_surname`, `teacher_is_active`, `teacher_role`, `teacher_group`) VALUES
(32, 'hakerbonzo3@op.pl', '$2y$10$y1.IBino.iCV6H42F6C3VObgLBi7HR9G28RB7L/Shh9gjBE46fED6', 'sdadasd', 'asdasdasd', '1', 'Administrator', 4),
(33, 'hax1234213@wp.pl', '$2y$10$cPXeDqAFjIr08E/uHw486OMHxPzqULzAWhvQME3px3lIg2vWOupgu', 'hax2', 'or2', '0', 'Administrator', 1),
(34, 'hax1234@wp.pl', '$2y$10$hdQcVcIbZFjHbCu0Mt6uxu3i437CgYGzsYSysiuIKPuui5wYy4uVG', 'hax', 'or', '1', 'Teacher', 1),
(35, 'rtsadsasad@wda', '$2y$10$yIZBHG5tANOmTcGmSTIZD.dG2UQMvovihD9MpfHjNseN2KTCf8idW', 'hax1', 'or1', '1', 'Teacher', 2),
(37, 'nauczyciel@gmail.com', '$2y$10$oQl50tZcu0LC2xeqTPYZOO/NJyDFZMEYr42wS3j/Jex41Ul35ShYa', 'sdadasd', 'asdasdasd', '1', 'Teacher', 4),
(38, 'dyrektor@gmail.com', '$2y$10$nB4fneXoBI0mXmtMi3cezuvGDNcQ.a89abuRZEuVXOPPRPH1qQpGC', 'sdadasd', 'asdasdasd', '1', 'Headmaster', 4),
(39, '1', '$2y$10$6mxetwtRzRVLVy0jsVicdO4UYPBPkIJP7DwYIJddlOBOwfdmvoMwi', '1', '1', '0', 'Headmaster', 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `tbl_absence`
--
ALTER TABLE `tbl_absence`
  ADD PRIMARY KEY (`absence_id`),
  ADD KEY `tbl_absence_ibfk_1` (`absence_student_id`),
  ADD KEY `tbl_absence_ibfk_2` (`absence_teacher_id`);

--
-- Indeksy dla tabeli `tbl_grades`
--
ALTER TABLE `tbl_grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `tbl_grades_ibfk_2` (`grade_student_id`),
  ADD KEY `tbl_grades_ibfk_1` (`grade_category_id`),
  ADD KEY `tbl_grades_ibfk_3` (`grade_teacher_id`),
  ADD KEY `tbl_grades_ibfk_4` (`grade_subject_id`);

--
-- Indeksy dla tabeli `tbl_grades_category`
--
ALTER TABLE `tbl_grades_category`
  ADD PRIMARY KEY (`grade_category_id`);

--
-- Indeksy dla tabeli `tbl_groups`
--
ALTER TABLE `tbl_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indeksy dla tabeli `tbl_groups_subjects`
--
ALTER TABLE `tbl_groups_subjects`
  ADD PRIMARY KEY (`group_subject_id`),
  ADD KEY `tbl_groups_subjects_ibfk_1` (`group_subject_subject_id`),
  ADD KEY `tbl_groups_subjects_ibfk_2` (`group_subject_group_id`);

--
-- Indeksy dla tabeli `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `tbl_notes_ibfk_1` (`note_student_id`),
  ADD KEY `tbl_notes_ibfk_2` (`note_teacher_id`);

--
-- Indeksy dla tabeli `tbl_parents`
--
ALTER TABLE `tbl_parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `tbl_parents_ibfk_1` (`parent_student_id`);

--
-- Indeksy dla tabeli `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `tbl_students_ibfk_1` (`student_group_id`);

--
-- Indeksy dla tabeli `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indeksy dla tabeli `tbl_subject_has_teacher`
--
ALTER TABLE `tbl_subject_has_teacher`
  ADD PRIMARY KEY (`subject_has_teacher_id`),
  ADD KEY `tbl_subject_has_teacher_ibfk_1` (`subject_has_teacher_teacher_id`),
  ADD KEY `tbl_subject_has_teacher_ibfk_2` (`subject_has_teacher_subject_id`);

--
-- Indeksy dla tabeli `tbl_teachers`
--
ALTER TABLE `tbl_teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `tbl_teachers_ibfk_1` (`teacher_group`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `tbl_absence`
--
ALTER TABLE `tbl_absence`
  MODIFY `absence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `tbl_grades`
--
ALTER TABLE `tbl_grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT dla tabeli `tbl_grades_category`
--
ALTER TABLE `tbl_grades_category`
  MODIFY `grade_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `tbl_groups`
--
ALTER TABLE `tbl_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `tbl_groups_subjects`
--
ALTER TABLE `tbl_groups_subjects`
  MODIFY `group_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT dla tabeli `tbl_notes`
--
ALTER TABLE `tbl_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `tbl_parents`
--
ALTER TABLE `tbl_parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT dla tabeli `tbl_subject_has_teacher`
--
ALTER TABLE `tbl_subject_has_teacher`
  MODIFY `subject_has_teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT dla tabeli `tbl_teachers`
--
ALTER TABLE `tbl_teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `tbl_absence`
--
ALTER TABLE `tbl_absence`
  ADD CONSTRAINT `tbl_absence_ibfk_1` FOREIGN KEY (`absence_student_id`) REFERENCES `tbl_students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_absence_ibfk_2` FOREIGN KEY (`absence_teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_grades`
--
ALTER TABLE `tbl_grades`
  ADD CONSTRAINT `tbl_grades_ibfk_1` FOREIGN KEY (`grade_category_id`) REFERENCES `tbl_grades_category` (`grade_category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_grades_ibfk_2` FOREIGN KEY (`grade_student_id`) REFERENCES `tbl_students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_grades_ibfk_3` FOREIGN KEY (`grade_teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_grades_ibfk_4` FOREIGN KEY (`grade_subject_id`) REFERENCES `tbl_subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_groups_subjects`
--
ALTER TABLE `tbl_groups_subjects`
  ADD CONSTRAINT `tbl_groups_subjects_ibfk_1` FOREIGN KEY (`group_subject_subject_id`) REFERENCES `tbl_subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_groups_subjects_ibfk_2` FOREIGN KEY (`group_subject_group_id`) REFERENCES `tbl_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD CONSTRAINT `tbl_notes_ibfk_1` FOREIGN KEY (`note_student_id`) REFERENCES `tbl_students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_notes_ibfk_2` FOREIGN KEY (`note_teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_parents`
--
ALTER TABLE `tbl_parents`
  ADD CONSTRAINT `tbl_parents_ibfk_1` FOREIGN KEY (`parent_student_id`) REFERENCES `tbl_students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD CONSTRAINT `tbl_students_ibfk_1` FOREIGN KEY (`student_group_id`) REFERENCES `tbl_groups` (`group_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_subject_has_teacher`
--
ALTER TABLE `tbl_subject_has_teacher`
  ADD CONSTRAINT `tbl_subject_has_teacher_ibfk_1` FOREIGN KEY (`subject_has_teacher_teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_subject_has_teacher_ibfk_2` FOREIGN KEY (`subject_has_teacher_subject_id`) REFERENCES `tbl_subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_teachers`
--
ALTER TABLE `tbl_teachers`
  ADD CONSTRAINT `tbl_teachers_ibfk_1` FOREIGN KEY (`teacher_group`) REFERENCES `tbl_groups` (`group_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
