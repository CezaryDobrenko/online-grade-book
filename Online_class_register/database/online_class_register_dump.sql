-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 28 Sie 2020, 13:38
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
(8, '4', '2020-08-18', '2020-08-26 23:16:41', 33, 19);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_grades`
--

CREATE TABLE `tbl_grades` (
  `grade_id` int(11) NOT NULL,
  `grade_value` enum('1','2','3','4','5','6') COLLATE utf8_polish_ci NOT NULL,
  `grade_comment` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `grade_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade_semester` enum('Semestr 1','Semestr 2') COLLATE utf8_polish_ci NOT NULL DEFAULT 'Semestr 1',
  `grade_category_id` int(11) DEFAULT NULL,
  `grade_student_id` int(11) NOT NULL,
  `grade_teacher_id` int(11) DEFAULT NULL,
  `grade_subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_grades`
--

INSERT INTO `tbl_grades` (`grade_id`, `grade_value`, `grade_comment`, `grade_created_at`, `grade_semester`, `grade_category_id`, `grade_student_id`, `grade_teacher_id`, `grade_subject_id`) VALUES
(8, '3', 'dsad', '2020-08-22 09:43:54', 'Semestr 2', 6, 2, 32, 11),
(9, '5', 'asdsadasdasd55', '2020-08-22 23:02:57', 'Semestr 1', 5, 6, 33, 13),
(10, '3', 'asdsadasdasd', '2020-08-23 12:59:16', 'Semestr 1', 6, 19, 32, 11),
(11, '3', 'asdsadasdasd', '2020-08-24 14:12:36', 'Semestr 1', 6, 19, 38, 11),
(12, '3', 'asdsadasdasd', '2020-08-24 14:12:52', 'Semestr 1', 6, 19, 32, 11),
(13, '3', 'asdsadasdasd', '2020-08-24 14:26:42', 'Semestr 1', 6, 2, 38, 11),
(14, '3', 'asdsadasdasd', '2020-08-24 14:27:32', 'Semestr 1', 6, 2, 32, 11),
(15, '3', 'dsadsadasdasd', '2020-08-24 15:21:45', 'Semestr 1', 6, 2, 32, 11),
(16, '6', 'Całki', '2020-08-25 16:36:07', 'Semestr 1', 16, 19, 38, 2),
(17, '3', 'dsad', '2020-08-26 22:42:18', 'Semestr 1', 6, 2, 32, 11),
(18, '3', 'dsad', '2020-08-26 22:42:37', 'Semestr 2', 6, 2, 32, 11),
(19, '3', 'asdsadasdasd', '2020-08-28 11:18:43', 'Semestr 1', 3, 6, 38, 2),
(21, '3', '3', '2020-08-28 11:27:47', 'Semestr 2', 4, 7, 38, 10),
(22, '3', '3', '2020-08-28 11:28:07', 'Semestr 2', 4, 7, 38, 10),
(23, '3', '3', '2020-08-28 11:28:39', 'Semestr 2', 4, 7, 38, 10);

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
(3, 'Odpowiedź22<script>', '6', '#388844'),
(4, 'Praca domowa', '4', '#00D2FF'),
(5, 'Kartkówka', '1', '#f41bca'),
(6, 'Aktywność', '2', '#fff400'),
(7, 'Praca dodatkowa', '2', '#ff8100'),
(8, 'Test', '3', '#b3fdf0'),
(9, 'Przygotowanie do zajęć', '5', '#f5b3fd'),
(10, 'Praca klasowa', '10', '#0b988d'),
(12, 'dasdasdasd1', '5', 'nowy kolor'),
(15, 'sssss', '5', 'sdadsa'),
(16, 'Odpowiedź', '6', '#388844');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_groups`
--

CREATE TABLE `tbl_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `group_short_name` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_stage` enum('Podstawowa','Technikum','Liceum','Zawodowa','Inna') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_groups`
--

INSERT INTO `tbl_groups` (`group_id`, `group_name`, `group_short_name`, `group_level`, `group_stage`) VALUES
(1, 'BRAK PRZYDZIELONEJ KLASY', 'BPK', 0, 'Inna'),
(2, 'Technik usług gastronomicznych', 'TUG', 2, 'Technikum'),
(3, 'Technik Rolnik', 'TRo', 1, 'Technikum'),
(4, 'Profil humanistyczny', 'P.H', 1, 'Liceum'),
(5, 'Mechanik', 'Mech', 3, 'Zawodowa'),
(6, 'Technik Reklamy', 'TRe', 4, 'Technikum'),
(7, 'Podstawówka 1A', '1A', 1, 'Podstawowa'),
(8, 'Podstawówka 2C', '2C', 2, 'Podstawowa'),
(10, 'nowa2', 'N1', 34, 'Zawodowa'),
(11, 'Technik usług.', 'TU', 2, 'Technikum');

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
(3, 10, 5),
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
(30, 10, 5);

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
(7, 'test22221', '2020-08-26 15:37:02', 37, 12),
(9, 'asdasdsadasd', '2020-08-26 15:36:57', 37, 19),
(11, 'test', '2020-08-26 15:36:53', 37, 19),
(12, '5', '2020-08-27 11:10:29', 38, 5),
(13, 'test2222', '2020-08-24 16:28:19', 32, 12),
(14, 'test', '2020-08-27 11:03:33', 38, 6);

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
(7, 'rodzic22', '$2y$10$n6v.Bl5aXciYQYojung0VuUE7XCD/AySw.Qd66ycOH84emy.sVtv2', '1', 3);

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
(2, 'testBL@gmail.com', 'testA', 'B', 'B', '1', 2),
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
(16, 'asdasdsadasd', '$2y$10$ZO9uBnzk8RWjJyg73L6Rqeg7FJPaTtXpV4Z5B5LdhsTqVm1pXGd4C', 'sadadsadasd', 'sadasdsad', '1', 1),
(17, 'asdasdsasadsaddasd', '$2y$10$P79bmt1/Z3wpyEZo4s12q.z.PQJ/QJ2Zh5EqgOQFVLpbktphHga62', 'sadadsadasd', 'sadasdsad', '0', 1),
(18, 'testwwdz@gmail.com', '$2y$10$aLAgVu/3bdMbOOFWoLCD2OWVrlx/EhUqq4UGai9I4q9iFOGNfbSSm', '1', '1', '1', 3),
(19, 'student@gmail.com', '$2y$10$2QR7zBhr9xlRsjZPFHRZpuvjRPsKxA//OqRH5TqubFUT5M0H/K.7C', 'B', 'B', '1', 2),
(20, 'wwwwwwwwwwwwwwwwwww@gmail.com', '$2y$10$e7oLQ0D8smIIT2po9hidJuz56t2Su2.fos6RfaiWthERJr0f2VXHa', 'B', 'B', '1', 2);

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
(13, 'Tede2'),
(14, 'wwwwwwww'),
(15, 'aadsadasdasdsadasd'),
(25, '123123drink'),
(26, 'wwdzs'),
(29, 'wwdzssdadsadwwww'),
(30, 'wwdzssdadsadwwwwdadss'),
(31, 'Matematykaó'),
(32, 'Matematykaóźć');

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
(20, 3, 34),
(21, 10, 38),
(22, 2, 38),
(23, 3, 34),
(24, 3, 34),
(25, 3, 34),
(26, 3, 34);

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
  `teacher_role` enum('Dyrektor','Nauczyciel','Administrator') COLLATE utf8_polish_ci NOT NULL,
  `teacher_group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_teachers`
--

INSERT INTO `tbl_teachers` (`teacher_id`, `teacher_email`, `teacher_password`, `teacher_name`, `teacher_surname`, `teacher_is_active`, `teacher_role`, `teacher_group`) VALUES
(32, 'hakerbonzo3@op.pl', '$2y$10$y1.IBino.iCV6H42F6C3VObgLBi7HR9G28RB7L/Shh9gjBE46fED6', 'sdadasd', 'asdasdasd', '1', 'Administrator', 4),
(33, 'hax1234213@wp.pl', '$2y$10$cPXeDqAFjIr08E/uHw486OMHxPzqULzAWhvQME3px3lIg2vWOupgu', 'hax2', 'or2', '0', 'Nauczyciel', 1),
(34, 'hax1234@wp.pl', '$2y$10$hdQcVcIbZFjHbCu0Mt6uxu3i437CgYGzsYSysiuIKPuui5wYy4uVG', 'hax', 'or', '1', 'Nauczyciel', 1),
(35, 'rtsadsasad@wda', '$2y$10$yIZBHG5tANOmTcGmSTIZD.dG2UQMvovihD9MpfHjNseN2KTCf8idW', 'hax1', 'or1', '1', 'Dyrektor', 2),
(36, 'hax123421231233@wp.pl', '$2y$10$DROwJnPkKI59NXn592LUGOgjEPBsgHToMAzC4rfseat.jk0Q1rkM2', 'hax2', 'or2', '0', 'Nauczyciel', 1),
(37, 'nauczyciel@gmail.com', '$2y$10$oQl50tZcu0LC2xeqTPYZOO/NJyDFZMEYr42wS3j/Jex41Ul35ShYa', 'sdadasd', 'asdasdasd', '1', 'Nauczyciel', 4),
(38, 'dyrektor@gmail.com', '$2y$10$nB4fneXoBI0mXmtMi3cezuvGDNcQ.a89abuRZEuVXOPPRPH1qQpGC', 'sdadasd', 'asdasdasd', '1', 'Dyrektor', 4);

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
  MODIFY `absence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `tbl_grades`
--
ALTER TABLE `tbl_grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `tbl_grades_category`
--
ALTER TABLE `tbl_grades_category`
  MODIFY `grade_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `tbl_groups`
--
ALTER TABLE `tbl_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `tbl_groups_subjects`
--
ALTER TABLE `tbl_groups_subjects`
  MODIFY `group_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `tbl_notes`
--
ALTER TABLE `tbl_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `tbl_parents`
--
ALTER TABLE `tbl_parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT dla tabeli `tbl_subject_has_teacher`
--
ALTER TABLE `tbl_subject_has_teacher`
  MODIFY `subject_has_teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `tbl_teachers`
--
ALTER TABLE `tbl_teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
  ADD CONSTRAINT `tbl_grades_ibfk_4` FOREIGN KEY (`grade_subject_id`) REFERENCES `tbl_subjects` (`subject_id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
