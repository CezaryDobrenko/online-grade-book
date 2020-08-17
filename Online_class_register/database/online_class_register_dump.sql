-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Sie 2020, 14:29
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
  `absence_teacher_id` int(11) NOT NULL,
  `absence_student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_grades`
--

CREATE TABLE `tbl_grades` (
  `grade_id` int(11) NOT NULL,
  `grade_value` enum('1','2','3','4','5','6') COLLATE utf8_polish_ci NOT NULL,
  `grade_comment` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `grade_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade_category_id` int(11) NOT NULL,
  `grade_student_id` int(11) NOT NULL,
  `grade_teacher_id` int(11) NOT NULL,
  `grade_subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_grades_category`
--

CREATE TABLE `tbl_grades_category` (
  `grade_category_id` int(11) NOT NULL,
  `grade_category_name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `grade_category_weight` enum('1','2','3','4','5','6','7','8','9','10') COLLATE utf8_polish_ci NOT NULL,
  `grade_category_color` varchar(10) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_grades_category`
--

INSERT INTO `tbl_grades_category` (`grade_category_id`, `grade_category_name`, `grade_category_weight`, `grade_category_color`) VALUES
(1, 'Praca klasowa', '10', '#ff6666'),
(2, 'Sprawdzian', '7', '#1BF440'),
(3, 'Odpowiedź', '6', '#388844'),
(4, 'Praca domowa', '4', '#00D2FF'),
(5, 'Kartkówka', '1', '#f41bca'),
(6, 'Aktywność', '2', '#fff400'),
(7, 'Praca dodatkowa', '2', '#ff8100'),
(8, 'Test', '3', '#b3fdf0'),
(9, 'Przygotowanie do zajęć', '5', '#f5b3fd'),
(10, 'Praca klasowa', '10', '#0b988d');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_groups`
--

CREATE TABLE `tbl_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `group_short_name` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_stage` enum('Podstawowa','Technikum','Liceum','Zawodowa') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_groups`
--

INSERT INTO `tbl_groups` (`group_id`, `group_name`, `group_short_name`, `group_level`, `group_stage`) VALUES
(1, 'Technikum informatyczne', 'TI', 1, 'Technikum'),
(2, 'Technik usług gastronomicznych', 'TUG', 2, 'Technikum'),
(3, 'Technik Rolnik', 'TRo', 1, 'Technikum'),
(4, 'Profil humanistyczny', 'P.H', 1, 'Liceum'),
(5, 'Mechanik', 'Mech', 3, 'Zawodowa'),
(6, 'Technik Reklamy', 'TRe', 4, 'Technikum'),
(7, 'Podstawówka 1A', '1A', 1, 'Podstawowa'),
(8, 'Podstawówka 2C', '2C', 2, 'Podstawowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_groups_subjects`
--

CREATE TABLE `tbl_groups_subjects` (
  `group_subject_id` int(11) NOT NULL,
  `group_subject_subject` int(11) NOT NULL,
  `group_subject_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_groups_subjects`
--

INSERT INTO `tbl_groups_subjects` (`group_subject_id`, `group_subject_subject`, `group_subject_group`) VALUES
(1, 7, 5),
(2, 9, 5),
(3, 10, 5),
(4, 1, 7),
(5, 3, 7),
(6, 2, 7),
(7, 2, 5),
(8, 3, 4),
(9, 6, 4),
(10, 4, 4),
(11, 8, 4),
(12, 3, 6),
(13, 4, 6),
(14, 5, 6),
(15, 2, 6),
(16, 3, 3),
(17, 8, 3),
(18, 1, 3),
(19, 10, 1),
(20, 4, 1),
(21, 3, 1),
(22, 11, 2),
(23, 9, 2),
(24, 2, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_notes`
--

CREATE TABLE `tbl_notes` (
  `note_id` int(11) NOT NULL,
  `note_comment` text COLLATE utf8_polish_ci NOT NULL,
  `note_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note_teacher_id` int(11) NOT NULL,
  `note_student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_parents`
--

CREATE TABLE `tbl_parents` (
  `parent_id` int(11) NOT NULL,
  `parent_email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `parent_password` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `parent_student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

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
  `student_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_students`
--

INSERT INTO `tbl_students` (`student_id`, `student_email`, `student_password`, `student_name`, `student_surname`, `student_group`) VALUES
(1, 'testA@gmail.com', 'testA', 'A', 'A', 3),
(2, 'testBL@gmail.com', 'testA', 'B', 'B', 1),
(3, 'testCL@gmail.com', 'testA', 'C', 'C', 2),
(4, 'testDL@gmail.com', 'testA', 'D', 'D', 3),
(5, 'testEL@gmail.com', 'testA', 'E', 'E', 4),
(6, 'testFL@gmail.com', 'testA', 'F', 'F', 5),
(7, 'testGL@gmail.com', 'testA', 'G', 'G', 6),
(8, 'testHL@gmail.com', 'testA', 'H', 'H', 1),
(9, 'testIL@gmail.com', 'testA', 'I', 'I', 2),
(10, 'testJL@gmail.com', 'testA', 'J', 'J', 4),
(11, 'testKL@gmail.com', 'testA', 'K', 'K', 5),
(12, 'testL@gmail.com', 'testA', 'L', 'L', 6);

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
(1, 'Przyroda'),
(2, 'Matematyka'),
(3, 'Język polski'),
(4, 'Język angielski'),
(5, 'Język niemiecki'),
(6, 'Wiedza o społeczeństwie'),
(7, 'Bezpieczeństwo i higiena pracy'),
(8, 'Geografia'),
(9, 'Biologia'),
(10, 'Fizyka'),
(11, 'Chemia');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_subject_has_teacher`
--

CREATE TABLE `tbl_subject_has_teacher` (
  `subject_has_teacher_id` int(11) NOT NULL,
  `subject_has_teacher_subject` int(11) NOT NULL,
  `subject_has_teacher_teacher` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_subject_has_teacher`
--

INSERT INTO `tbl_subject_has_teacher` (`subject_has_teacher_id`, `subject_has_teacher_subject`, `subject_has_teacher_teacher`) VALUES
(1, 7, 1),
(2, 9, 2),
(3, 6, 1),
(4, 11, 2),
(5, 5, 3),
(6, 8, 4),
(7, 2, 5),
(8, 1, 7),
(9, 9, 5),
(10, 8, 6),
(11, 11, 4),
(12, 4, 3),
(13, 7, 5),
(14, 6, 7),
(15, 3, 1);

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
  `teacher_role` enum('Dyrektor','Nauczyciel','Administrator') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tbl_teachers`
--

INSERT INTO `tbl_teachers` (`teacher_id`, `teacher_email`, `teacher_password`, `teacher_name`, `teacher_surname`, `teacher_role`) VALUES
(1, 'c.konto1@gmail.com', 'testpasswd123', 'Cezary', 'Dobreńko', 'Nauczyciel'),
(2, 'c.konto1@gmail.com', 'testpasswd123', 'Mateusz', 'Grzesikiewicz', 'Nauczyciel'),
(3, 'c.konto2@gmail.com', 'testpasswd123', 'Dawid', 'Grzelecki', 'Nauczyciel'),
(4, 'c.konto3@gmail.com', 'testpasswd123', 'Artur', 'Dymkowski', 'Nauczyciel'),
(5, 'c.konto4@gmail.com', 'testpasswd123', 'Paweł', 'Bartko', 'Dyrektor'),
(6, 'c.konto5@gmail.com', 'testpasswd123', 'Łukasz', 'Stanisławowski', 'Dyrektor'),
(7, 'c.konto6@gmail.com', 'testpasswd123', 'Wiktor', 'Dereń', 'Administrator');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `tbl_absence`
--
ALTER TABLE `tbl_absence`
  ADD PRIMARY KEY (`absence_id`),
  ADD KEY `absence_student_id` (`absence_student_id`),
  ADD KEY `absence_teacher_id` (`absence_teacher_id`);

--
-- Indeksy dla tabeli `tbl_grades`
--
ALTER TABLE `tbl_grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `grade_category_id` (`grade_category_id`),
  ADD KEY `grade_teacher_id` (`grade_teacher_id`),
  ADD KEY `grade_subject_id` (`grade_subject_id`),
  ADD KEY `grade_student_id` (`grade_student_id`);

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
  ADD KEY `group_subject_group` (`group_subject_group`),
  ADD KEY `tbl_groups_subjects_ibfk_1` (`group_subject_subject`);

--
-- Indeksy dla tabeli `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `note_student_id` (`note_student_id`),
  ADD KEY `note_teacher_id` (`note_teacher_id`);

--
-- Indeksy dla tabeli `tbl_parents`
--
ALTER TABLE `tbl_parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `parent_student_id` (`parent_student_id`);

--
-- Indeksy dla tabeli `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `student_group` (`student_group`);

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
  ADD KEY `subject_has_teacher_teacher` (`subject_has_teacher_teacher`),
  ADD KEY `subject_has_teacher_subject` (`subject_has_teacher_subject`);

--
-- Indeksy dla tabeli `tbl_teachers`
--
ALTER TABLE `tbl_teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `tbl_absence`
--
ALTER TABLE `tbl_absence`
  MODIFY `absence_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `tbl_grades`
--
ALTER TABLE `tbl_grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `tbl_grades_category`
--
ALTER TABLE `tbl_grades_category`
  MODIFY `grade_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `tbl_groups`
--
ALTER TABLE `tbl_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `tbl_groups_subjects`
--
ALTER TABLE `tbl_groups_subjects`
  MODIFY `group_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT dla tabeli `tbl_notes`
--
ALTER TABLE `tbl_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `tbl_parents`
--
ALTER TABLE `tbl_parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `tbl_subject_has_teacher`
--
ALTER TABLE `tbl_subject_has_teacher`
  MODIFY `subject_has_teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `tbl_teachers`
--
ALTER TABLE `tbl_teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `tbl_absence`
--
ALTER TABLE `tbl_absence`
  ADD CONSTRAINT `tbl_absence_ibfk_1` FOREIGN KEY (`absence_student_id`) REFERENCES `tbl_students` (`student_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_absence_ibfk_2` FOREIGN KEY (`absence_teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_grades`
--
ALTER TABLE `tbl_grades`
  ADD CONSTRAINT `tbl_grades_ibfk_1` FOREIGN KEY (`grade_category_id`) REFERENCES `tbl_grades_category` (`grade_category_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_grades_ibfk_2` FOREIGN KEY (`grade_teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_grades_ibfk_3` FOREIGN KEY (`grade_subject_id`) REFERENCES `tbl_subjects` (`subject_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_grades_ibfk_4` FOREIGN KEY (`grade_student_id`) REFERENCES `tbl_students` (`student_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_groups_subjects`
--
ALTER TABLE `tbl_groups_subjects`
  ADD CONSTRAINT `tbl_groups_subjects_ibfk_1` FOREIGN KEY (`group_subject_subject`) REFERENCES `tbl_subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_groups_subjects_ibfk_2` FOREIGN KEY (`group_subject_group`) REFERENCES `tbl_groups` (`group_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD CONSTRAINT `tbl_notes_ibfk_1` FOREIGN KEY (`note_student_id`) REFERENCES `tbl_students` (`student_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_notes_ibfk_2` FOREIGN KEY (`note_teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_parents`
--
ALTER TABLE `tbl_parents`
  ADD CONSTRAINT `tbl_parents_ibfk_1` FOREIGN KEY (`parent_student_id`) REFERENCES `tbl_students` (`student_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD CONSTRAINT `tbl_students_ibfk_1` FOREIGN KEY (`student_group`) REFERENCES `tbl_groups` (`group_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tbl_subject_has_teacher`
--
ALTER TABLE `tbl_subject_has_teacher`
  ADD CONSTRAINT `tbl_subject_has_teacher_ibfk_1` FOREIGN KEY (`subject_has_teacher_teacher`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_subject_has_teacher_ibfk_2` FOREIGN KEY (`subject_has_teacher_subject`) REFERENCES `tbl_subjects` (`subject_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
