-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2024 a las 00:26:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cidenet_employees`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `name`) VALUES
(1, 'Administración'),
(2, 'Financiera'),
(3, 'Compras'),
(4, 'Infraestructura'),
(5, 'Operación'),
(6, 'Talento Humano'),
(7, 'Servicios Varios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `first_surname` varchar(20) NOT NULL,
  `second_surname` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `other_names` varchar(50) DEFAULT NULL,
  `country` varchar(20) NOT NULL,
  `identification_type_id` int(11) NOT NULL,
  `identification_number` varchar(20) NOT NULL,
  `email` varchar(300) NOT NULL,
  `admission_date` date NOT NULL,
  `area_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'Activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id`, `first_surname`, `second_surname`, `first_name`, `other_names`, `country`, `identification_type_id`, `identification_number`, `email`, `admission_date`, `area_id`, `status`, `created_at`) VALUES
(1, 'PEREZ', 'MONTOYA', 'JUAN', 'CARLOS', 'Colombia', 1, '1234567890', 'juan.perez@cidenet.com.co', '2024-11-28', 1, 'Activo', '2024-12-02 17:13:37'),
(2, 'PEREZ', 'MONTOYA', 'DANNA', 'SOFIA', 'Colombia', 3, '1234567890', 'danna.perez@cidenet.com.co', '2024-11-28', 1, 'Activo', '2024-12-02 17:16:06'),
(3, 'ALVAREZ', 'MONTOYA', 'CAMILA', 'SOFIA', 'Colombia', 4, '1234567890', 'camila.alvarez@cidenet.com.co', '2024-11-28', 4, 'Activo', '2024-12-02 18:55:12'),
(4, 'ALVAREZ', 'RIOS', 'CARMEN', 'SOFIA', 'Colombia', 2, '1234567890', 'carmen.alvarez@cidenet.com.co', '2024-11-28', 6, 'Activo', '2024-12-02 20:35:18'),
(6, 'PEREZ', 'MONTOYA', 'CAMILO', 'ANDRES', 'Colombia', 1, '5678934', 'camilo.perez@cidenet.com.co', '2024-12-02', 3, 'Activo', '2024-12-02 22:39:48'),
(16, 'PEREZ', 'MONTOYA', 'JUANA', 'CARMEN', 'Colombia', 1, '132574212', 'juana.perez@cidenet.com.co', '2024-11-28', 1, 'Activo', '2024-12-02 22:50:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee_types`
--

CREATE TABLE `employee_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `employee_types`
--

INSERT INTO `employee_types` (`id`, `name`) VALUES
(1, 'Cédula de Ciudadanía'),
(2, 'Cédula de Extranjería'),
(3, 'Pasaporte'),
(4, 'Permiso Especial');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_identification` (`identification_type_id`,`identification_number`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `area_id` (`area_id`);

--
-- Indices de la tabla `employee_types`
--
ALTER TABLE `employee_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `employee_types`
--
ALTER TABLE `employee_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`identification_type_id`) REFERENCES `employee_types` (`id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
