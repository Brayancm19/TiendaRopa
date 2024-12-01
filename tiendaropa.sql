-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-10-2024 a las 17:12:34
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
-- Base de datos: `tiendaropa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(3, 'Puma');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `marcasconventas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `marcasconventas` (
`nombre` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas`
--

CREATE TABLE `prendas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `talla` varchar(5) DEFAULT NULL,
  `cantidad_stock` int(11) DEFAULT NULL,
  `marca_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prendas`
--

INSERT INTO `prendas` (`id`, `nombre`, `talla`, `cantidad_stock`, `marca_id`) VALUES
(1, 'Camiseta Nike', 'M', 40, 1),
(2, 'Camiseta Adidas', 'L', 30, 2),
(3, 'Pantalón Puma', 'S', 20, 3);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `prendasvendidas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `prendasvendidas` (
`nombre` varchar(100)
,`cantidad_vendida` decimal(32,0)
,`cantidad_stock` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `top5marcas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `top5marcas` (
`nombre` varchar(100)
,`total_ventas` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `prenda_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `prenda_id`, `cantidad`, `fecha`) VALUES
(1, 1, 10, '2024-10-01'),
(2, 2, 5, '2024-10-02'),
(3, 3, 3, '2024-10-03');

-- --------------------------------------------------------

--
-- Estructura para la vista `marcasconventas`
--
DROP TABLE IF EXISTS `marcasconventas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `marcasconventas`  AS SELECT DISTINCT `marcas`.`nombre` AS `nombre` FROM ((`marcas` join `prendas` on(`marcas`.`id` = `prendas`.`marca_id`)) join `ventas` on(`prendas`.`id` = `ventas`.`prenda_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `prendasvendidas`
--
DROP TABLE IF EXISTS `prendasvendidas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prendasvendidas`  AS SELECT `prendas`.`nombre` AS `nombre`, sum(`ventas`.`cantidad`) AS `cantidad_vendida`, `prendas`.`cantidad_stock` AS `cantidad_stock` FROM (`prendas` join `ventas` on(`prendas`.`id` = `ventas`.`prenda_id`)) GROUP BY `prendas`.`id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `top5marcas`
--
DROP TABLE IF EXISTS `top5marcas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `top5marcas`  AS SELECT `marcas`.`nombre` AS `nombre`, sum(`ventas`.`cantidad`) AS `total_ventas` FROM ((`marcas` join `prendas` on(`marcas`.`id` = `prendas`.`marca_id`)) join `ventas` on(`prendas`.`id` = `ventas`.`prenda_id`)) GROUP BY `marcas`.`id` ORDER BY sum(`ventas`.`cantidad`) DESC LIMIT 0, 5 ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prenda_id` (`prenda_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prendas`
--
ALTER TABLE `prendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD CONSTRAINT `prendas_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`prenda_id`) REFERENCES `prendas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
