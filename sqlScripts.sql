-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-01-2021 a las 23:57:44
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `calendario1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colors`
--

CREATE TABLE `colors` (
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `hex` varchar(6) NOT NULL,
  `whitetext` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `colors`
--

INSERT INTO `colors` (`name`, `hex`, `whitetext`) VALUES
('Amarillo', 'ffe000', b'0'),
('Azul', '00188e', b'1'),
('Naranja', 'ffb100', b'0'),
('Rojo', '9c0000', b'1'),
('Rosa', 'ffc5f5', b'0'),
('Verde', '0a5f00', b'1'),
('Violeta', '8e008a', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `id_course` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id_course`, `name`, `description`, `date_start`, `date_end`, `active`) VALUES
(1, 'Álgebra Lineal', 'Ideal para los martes por la tarde', '2020-12-01', '2021-01-01', 1),
(3, 'Mecanografía', 'A mover esos deditos', '2020-11-27', '2021-07-08', 1),
(5, 'Hands on coffe', 'Para programar bien necesitas café', '2020-11-26', '2021-04-16', 1),
(7, 'Educación Física', 'Muévete miarma', '2020-11-25', '2021-02-25', 0),
(8, 'Herramientas y utilidades', 'Útiles de cada día', '2020-11-04', '2021-03-11', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enrollment`
--

CREATE TABLE `enrollment` (
  `id_enrollment` int(11) NOT NULL,
  `id_student` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `enrollment`
--

INSERT INTO `enrollment` (`id_enrollment`, `id_student`, `id_course`, `status`) VALUES
(1, 3, 5, 1),
(3, 3, 3, 0),
(4, 3, 1, 1),
(5, 3, 7, 1),
(6, 8, 5, 0),
(7, 8, 7, 0),
(8, 8, 1, 1),
(9, 9, 7, 0),
(10, 9, 1, 1),
(12, 14, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exams`
--

CREATE TABLE `exams` (
  `id_exam` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `exams`
--

INSERT INTO `exams` (`id_exam`, `id_class`, `date`, `name`) VALUES
(2, 2, '2021-01-10 15:16:00', 'sadasdasdf'),
(3, 2, '2021-01-17 15:17:00', 'gffdfdfdf'),
(4, 6, '2020-12-31 18:03:00', 'Primer cuatrimestre'),
(5, 6, '2020-12-28 22:30:00', 'Preliminar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exam_marks`
--

CREATE TABLE `exam_marks` (
  `id_exam` int(11) NOT NULL,
  `id_student` int(11) NOT NULL,
  `mark` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `exam_marks`
--

INSERT INTO `exam_marks` (`id_exam`, `id_student`, `mark`) VALUES
(4, 3, 9),
(4, 8, 6),
(4, 14, 4),
(5, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id_notification` int(11) NOT NULL,
  `id_student` int(11) NOT NULL,
  `work` tinyint(1) NOT NULL,
  `exam` tinyint(1) NOT NULL,
  `continuous_assessment` tinyint(1) NOT NULL,
  `final_note` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id_notification`, `id_student`, `work`, `exam`, `continuous_assessment`, `final_note`) VALUES
(2, 3, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `percentage`
--

CREATE TABLE `percentage` (
  `id_percentage` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `continuous_assessment` float NOT NULL,
  `exams` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `percentage`
--

INSERT INTO `percentage` (`id_percentage`, `id_class`, `continuous_assessment`, `exams`) VALUES
(4, 2, 60, 50),
(6, 4, 40, 60),
(7, 3, 40, 60),
(8, 6, 40, 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule`
--

CREATE TABLE `schedule` (
  `id_schedule` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `schedule`
--

INSERT INTO `schedule` (`id_schedule`, `id_class`, `time_start`, `time_end`, `day`) VALUES
(3, 3, '02:37:00', '02:38:00', '2020-11-17'),
(4, 2, '03:04:00', '03:07:00', '2020-11-28'),
(5, 3, '05:31:00', '05:31:00', '2020-11-25'),
(7, 2, '12:31:00', '12:32:00', '2020-11-30'),
(8, 2, '12:30:00', '12:40:00', '2020-12-03'),
(9, 4, '12:30:00', '13:30:00', '2020-12-01'),
(10, 4, '12:30:00', '13:31:00', '2020-12-03'),
(11, 4, '12:30:00', '13:30:00', '2020-12-08'),
(12, 4, '12:30:00', '13:30:00', '2020-12-08'),
(13, 6, '16:30:00', '18:30:00', '2020-12-31'),
(14, 6, '16:28:00', '18:28:00', '2020-12-25'),
(15, 6, '16:29:00', '19:29:00', '2021-01-01'),
(16, 6, '16:31:00', '18:31:00', '2020-12-08'),
(17, 7, '16:42:00', '18:43:00', '2021-01-28'),
(18, 7, '16:43:00', '18:43:00', '2021-01-14'),
(19, 7, '16:43:00', '16:43:00', '2021-02-11'),
(20, 8, '17:40:00', '19:40:00', '2020-12-23'),
(21, 8, '17:40:00', '19:40:00', '2020-12-02'),
(22, 8, '17:40:00', '19:40:00', '2020-12-09'),
(23, 8, '17:40:00', '19:41:00', '2020-12-30'),
(25, 8, '17:41:00', '19:41:00', '2021-01-13'),
(26, 2, '21:33:00', '22:30:00', '2020-11-28'),
(28, 4, '13:26:00', '14:25:00', '2020-12-02'),
(30, 6, '02:21:00', '01:20:00', '2020-12-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `nif` varchar(50) NOT NULL,
  `date_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `username`, `pass`, `email`, `name`, `surname`, `telephone`, `nif`, `date_registered`) VALUES
(2, 'Trancas', '$2y$10$wxTwGA2WkGGmRb9qqZgIVu00ztTLUS7MQLxwbqLoh/c1Hw0nft/S2', 'trancas@gmail.com', 'Luisa', 'Cardenete', '987654321', '87654321A', '2020-11-22 14:48:36'),
(3, 'Petancas', '$2y$10$/pJqG3XiuEVW5H6gYSz0eeVvln150CHkYZadv1ArYW/gD.R3pnGV2', 'petancas@gmail.com', 'Luisa', 'Cardenaso', '123456789sy', '12345678N', '2020-11-22 15:05:36'),
(4, 'cosa', '$2y$10$mF.xJHiS9Dj.JgFDz9sza.hLEUFP/Q.EXiDcWRgwDdrkvTB8pv.Bm', 'cosita@gmail.com', 'cosa', 'loca', '1232133', '12874321', '2020-11-22 23:10:12'),
(5, 'dfgfdggfd', '$2y$10$WasO.mf4UCzjC5QQpPHrSetAd.ypnfs5KUfkZMC4IkcKPxTNPOBfO', 'cositaa@gmail.com', 'sadasd', 'sadasd', '238723891', 'wewqeewq', '2020-11-22 23:12:15'),
(6, 'cosaa', '$2y$10$rklWiBsa6jQtqZa6WLjCD.KjMjK.iGBzMIaYr74lIfaMnavL8yrcS', 'weweqweq@gmail.com', 'asdasd', 'asdsadsa', '2178723', '32112321', '2020-11-22 23:13:27'),
(7, 'manolitopndereta', '$2y$10$lJIqA3sXRN0De6LWQ9O80esDnrIrFNyAaXvDTa0B8/hIbq996mQy2', 'no@tengo.com', 'Manuel', 'Panderetas', '123456789', '123456789', '2020-11-24 20:25:35'),
(8, 'dtoretto', '$2y$10$aM2QtOHCkozncohVNkxik.PCM9n4rku1CvEvI5lA1xwi2ArydNj1S', 'dom@dom.com', 'Dominic', 'Toretto', '612345678', '69', '2020-11-25 17:14:33'),
(9, 'SoyAndres', '$2y$10$CmB9YXX2S3O9/hI9ZBUrFOM16Q3.5O1JwqrIqOGQ7iWniYuKdS8Y2', 'andresito@gmail.com', 'Andrés', 'Lavapiés', '123456789', '147852963F', '2020-11-25 19:59:39'),
(10, 'BorjaMari', '$2y$10$7ax2pbyvvENKL0muRadfaea5bPzLOHRtSNz2MIL3SwolSs3FGrG2S', 'borjita@gmail.com', 'Borja', 'Falcón', '741855236987', '852741963', '2020-11-25 20:36:10'),
(11, 'Gonzalin', '$2y$10$b0SV.FGOKw9B6A2oxY0q..tvBZnSumwNSFTVAhUaChMDs.bLDZRTe', 'gonzalin@gmail.com', 'Gonzalo', 'López', '7418963012', '74103698L', '2020-11-25 20:42:45'),
(12, 'Fernandín', '$2y$10$6UANeyan.MDTD0y.TK3mbu2o.94yifZ3dqgMtvUPYQPzJ1ubWC/KK', 'superlopez@gmail.com', 'Fernando', 'López', '741036985', '74102365H', '2020-11-25 20:48:21'),
(14, 'LuzEstelar', '$2y$10$OgJpTxQbUdpdm4kohI4AzOdwunqFsvez8onthDKGT6gPoQjwNlHqy', 'luzestelar@gmail.com', 'Estela', 'García', '745522138', '896312302L', '2020-11-25 21:01:23'),
(15, 'mpanderetas', '$2y$10$mU9RPpyK7gdy5xhHVkLGHuDv7wfEyS9Wqaus/D2dK7/tWrYZ8P2MO', 'mpanderetas@gmail.com', 'Manolito', 'Panderetas', '12345677', '12345677', '2020-12-09 08:19:01'),
(16, 'dyankee', '$2y$10$u0A/5tiagc5CeIYnIFgyKuZlRJu14xQ.RxWXePGLFV.luImTsURWS', 'dyankee@gmail.com', 'daddy', 'yankee', '12345677', '1234566', '2020-12-09 08:21:15'),
(17, 'arthas', '$2y$10$A4V2RuEj/hOHNAGk.i.Mvep6YSEOgcNBO.Xt42y6t5EA/Ovtqypva', 'amenethil@gmail.com', 'arthas', 'menethil', '12345677', '12345679', '2020-12-09 08:33:02'),
(20, 'mrajoy', '$2y$10$yBwZhUFB06bEZ82LGsagF./p7TrdyUmja.LIWacodWwa5K8rV4TYe', 'mrajoy@onlyfans.com', 'Marianico', 'Rajoy', '1234567', '123456778', '2020-12-09 08:49:22'),
(21, 'Don', '$2y$10$KN1rDm9.1UpqIUwG/odcneIw/7abR85mPEEVpmXhbCAYH2pSZhATS', 'donomar@gmail.com', 'Omar', 'Calvo', '890315648', '89457123L', '2020-12-27 10:14:28'),
(22, 'BadBunny', '$2y$10$PeyizAvfiKIe/dRc3Paame.xl1Vt3N3Iwsku57FTRnrjjkOkWsgN.', 'badbad@gmail.com', 'Clementino', 'Da Silva', '741000003', '78412365P', '2020-12-27 10:18:31'),
(25, 'Manolillo', '$2y$10$LJCTMtgrN8DAAKf8mz06xu0ZzJBvr9bKfH7gftWMb2Kcr.WNy9opq', 'estoescarnaval@gmail.com', 'Manolo', 'Santander', '6668899003', '9870967O', '2020-12-27 11:19:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subjects`
--

CREATE TABLE `subjects` (
  `id_class` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `subjects`
--

INSERT INTO `subjects` (`id_class`, `id_teacher`, `id_course`, `name`, `color`) VALUES
(2, 12, 3, 'Manos veloces', 'Amarillo'),
(3, 4, 5, 'Cafe Quijano', 'Naranja'),
(4, 3, 1, 'Línea arriba, línea abajo', 'Azul'),
(6, 1, 1, 'Burn PHP', 'Violeta'),
(7, 8, 7, 'Cómo ganar la UEL', 'Rojo'),
(8, 9, 7, 'Cómo correr de un jabalí', 'Rosa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teachers`
--

CREATE TABLE `teachers` (
  `id_teacher` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `nif` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `teachers`
--

INSERT INTO `teachers` (`id_teacher`, `username`, `pass`, `name`, `surname`, `telephone`, `nif`, `email`) VALUES
(1, 'vdiesel1', '$2y$10$Uuf.u/GzjM2HO7NUovRqlueMPRT5i2U2kUQtpVS5ONHmRb2nr8zii', 'Vino', 'Diesel Goikoetxea', '6668', '78', 'vin@diesel.com'),
(3, 'cnorris', '$2y$10$wxTwGA2WkGGmRb9qqZgIVu00ztTLUS7MQLxwbqLoh/c1Hw0nft/S2', 'Chuck', 'Norris', '1', '1', 'chuck@yourhome.com'),
(4, 'illanos', '$2y$10$wxTwGA2WkGGmRb9qqZgIVu00ztTLUS7MQLxwbqLoh/c1Hw0nft/S2', 'Ibai', 'Llanos', '123456', '123', 'ibai@g2.com'),
(7, 'msuarez', '$2y$10$wxTwGA2WkGGmRb9qqZgIVu00ztTLUS7MQLxwbqLoh/c1Hw0nft/S2', 'Marina', 'Suárez', '1234567', '1234556', 'soymarina@gmail.com'),
(8, 'jnavas', '$2y$10$wxTwGA2WkGGmRb9qqZgIVu00ztTLUS7MQLxwbqLoh/c1Hw0nft/S2', 'Jesus', 'Navas', '16', '16', 'jnavas@sfc.es'),
(9, 'irakitik', '$2y$10$wxTwGA2WkGGmRb9qqZgIVu00ztTLUS7MQLxwbqLoh/c1Hw0nft/S2', 'Ivan', 'Rakitik', '10100', '10', 'irakitik@depinomontano.es'),
(11, 'bwayne', '$2y$10$wxTwGA2WkGGmRb9qqZgIVu00ztTLUS7MQLxwbqLoh/c1Hw0nft/S2', 'Batman', 'Wayne', '789456123', '789456123G', 'batman@gmail.com'),
(12, 'ehoracio', '$2y$10$wxTwGA2WkGGmRb9qqZgIVu00ztTLUS7MQLxwbqLoh/c1Hw0nft/S2', 'Emilio', 'Horacio', '789456', '741893452b', 'horacio@gmail.com'),
(16, 'Libre', '123', 'Libre', 'Libre', '8907987987', '08723982389g', 'libre@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_admin`
--

CREATE TABLE `users_admin` (
  `id_user_admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users_admin`
--

INSERT INTO `users_admin` (`id_user_admin`, `username`, `name`, `email`, `password`) VALUES
(1, 'administrador', 'Superman', 'superman@dc1.com', '$2y$10$drV7hhNemuqBhp20n/unY.ZMuOMtOy8uw0hTWjD/NYzPjp.gOR.A6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `works`
--

CREATE TABLE `works` (
  `id_work` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `works`
--

INSERT INTO `works` (`id_work`, `id_class`, `date`, `name`) VALUES
(1, 2, '2021-01-03 16:17:00', 'OMG'),
(4, 6, '2020-12-31 19:29:00', 'Producto 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_marks`
--

CREATE TABLE `work_marks` (
  `id_work` int(11) NOT NULL,
  `id_student` int(11) NOT NULL,
  `mark` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `work_marks`
--

INSERT INTO `work_marks` (`id_work`, `id_student`, `mark`) VALUES
(4, 3, 6),
(4, 8, 7),
(4, 9, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id_course`),
  ADD UNIQUE KEY `name` (`name`,`date_start`,`date_end`);

--
-- Indices de la tabla `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`id_enrollment`),
  ADD UNIQUE KEY `id_student` (`id_student`,`id_course`),
  ADD KEY `fk_enrollment_courses` (`id_course`);

--
-- Indices de la tabla `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id_exam`),
  ADD KEY `fk_exams_class` (`id_class`);

--
-- Indices de la tabla `exam_marks`
--
ALTER TABLE `exam_marks`
  ADD PRIMARY KEY (`id_exam`,`id_student`),
  ADD KEY `fk_exam_marks_students` (`id_student`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notification`),
  ADD UNIQUE KEY `id_student` (`id_student`);

--
-- Indices de la tabla `percentage`
--
ALTER TABLE `percentage`
  ADD PRIMARY KEY (`id_percentage`),
  ADD KEY `fk_percentage_subjects` (`id_class`);

--
-- Indices de la tabla `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id_schedule`),
  ADD KEY `fk_schedule_class` (`id_class`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`email`);

--
-- Indices de la tabla `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id_class`),
  ADD KEY `fk_subjects_teacher` (`id_teacher`),
  ADD KEY `fk_subjects_course` (`id_course`),
  ADD KEY `fk_subjects_color` (`color`);

--
-- Indices de la tabla `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id_teacher`);

--
-- Indices de la tabla `users_admin`
--
ALTER TABLE `users_admin`
  ADD PRIMARY KEY (`id_user_admin`);

--
-- Indices de la tabla `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`id_work`),
  ADD KEY `fk_works_class` (`id_class`);

--
-- Indices de la tabla `work_marks`
--
ALTER TABLE `work_marks`
  ADD PRIMARY KEY (`id_work`,`id_student`),
  ADD KEY `fk_work_marks_students` (`id_student`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `courses`
--
ALTER TABLE `courses`
  MODIFY `id_course` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `id_enrollment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `exams`
--
ALTER TABLE `exams`
  MODIFY `id_exam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `percentage`
--
ALTER TABLE `percentage`
  MODIFY `id_percentage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id_schedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id_class` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id_teacher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id_user_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `works`
--
ALTER TABLE `works`
  MODIFY `id_work` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `fk_enrollment_courses` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id_course`),
  ADD CONSTRAINT `fk_enrollment_student` FOREIGN KEY (`id_student`) REFERENCES `students` (`id`);

--
-- Filtros para la tabla `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `fk_exams_class` FOREIGN KEY (`id_class`) REFERENCES `subjects` (`id_class`);

--
-- Filtros para la tabla `exam_marks`
--
ALTER TABLE `exam_marks`
  ADD CONSTRAINT `fk_exam_marks_exam` FOREIGN KEY (`id_exam`) REFERENCES `exams` (`id_exam`),
  ADD CONSTRAINT `fk_exam_marks_students` FOREIGN KEY (`id_student`) REFERENCES `students` (`id`);

--
-- Filtros para la tabla `percentage`
--
ALTER TABLE `percentage`
  ADD CONSTRAINT `fk_percentage_subjects` FOREIGN KEY (`id_class`) REFERENCES `subjects` (`id_class`);

--
-- Filtros para la tabla `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_schedule_class` FOREIGN KEY (`id_class`) REFERENCES `subjects` (`id_class`);

--
-- Filtros para la tabla `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_subjects_color` FOREIGN KEY (`color`) REFERENCES `colors` (`name`),
  ADD CONSTRAINT `fk_subjects_course` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id_course`),
  ADD CONSTRAINT `fk_subjects_teacher` FOREIGN KEY (`id_teacher`) REFERENCES `teachers` (`id_teacher`);

--
-- Filtros para la tabla `works`
--
ALTER TABLE `works`
  ADD CONSTRAINT `fk_works_class` FOREIGN KEY (`id_class`) REFERENCES `subjects` (`id_class`);

--
-- Filtros para la tabla `work_marks`
--
ALTER TABLE `work_marks`
  ADD CONSTRAINT `fk_work_marks_students` FOREIGN KEY (`id_student`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `fk_work_marks_works` FOREIGN KEY (`id_work`) REFERENCES `works` (`id_work`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
