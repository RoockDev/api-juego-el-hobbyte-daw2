-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2025 a las 18:42:10
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
-- Base de datos: `juego_hobbit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `tablero` varchar(5000) NOT NULL,
  `heroes` varchar(500) NOT NULL,
  `contador_casillas_destapadas` int(11) DEFAULT 0,
  `contador_fallos_seguidos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidas`
--

INSERT INTO `partidas` (`id`, `usuario_id`, `estado`, `tablero`, `heroes`, `contador_casillas_destapadas`, `contador_fallos_seguidos`) VALUES
(8, 4, 'en curso', '[{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":45},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":30},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":35},\"destapada\":false},{\"pr', '{\"Gandalf\":50,\"Thorin\":50,\"Bilbo\":50}', 0, 0),
(40, 1, 'rendido', '[{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":45},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":50},\"destapada\":true},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":20},\"destapada\":false}]', '{\"Gandalf\":50,\"Thorin\":0,\"Bilbo\":50}', 1, 0),
(41, 1, 'en curso', '[{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":50},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":30},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":30},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":20},\"destapada\":false}]', '{\"Gandalf\":50,\"Thorin\":50,\"Bilbo\":50}', 0, 0),
(42, 1, 'rendido', '[{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":5},\"destapada\":true},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":45},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":30},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":15},\"destapada\":true},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":35},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":45},\"destapada\":false}]', '{\"Gandalf\":50,\"Thorin\":35,\"Bilbo\":45}', 2, 0),
(43, 4, 'rendido', '[{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":5},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":35},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":40},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":35},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":25},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":10},\"destapada\":false},{\"prueba\":{\"tipo\":\"fuerza\",\"esfuerzo\":35},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":15},\"destapada\":false},{\"prueba\":{\"tipo\":\"habilidad\",\"esfuerzo\":20},\"destapada\":false},{\"prueba\":{\"tipo\":\"magia\",\"esfuerzo\":5},\"destapada\":false}]', '{\"Gandalf\":50,\"Thorin\":50,\"Bilbo\":50}', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'gamer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `dni` varchar(25) NOT NULL DEFAULT '',
  `clave` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `dni`, `clave`, `email`, `rol_id`, `nombre`) VALUES
(1, '12345678A', 'admin123', 'admin@test.com', 1, 'Administrador Test'),
(4, '11111111C', 'gamer123', 'frodo@shire.com', 2, 'Frodo Bolsón Samm'),
(9, '66666666H', 'rey123', 'aragorn@gondor.com', 2, 'Aragorn hijo de Arathorn'),
(10, '77777777I', 'test123', 'admin@elhobbyte.com', 2, 'Test Duplicado'),
(11, '77777737I', 'ZgmMNWSp', 'sergiodaw2026@gmail.com', 2, 'Test Duplicado'),
(12, '77277737I', 'V0vOKDz4', 'juanypotupoposi@gmail.com', 2, 'Test Duplicado'),
(13, '44444224F', 'arcoElfico999', 'legolas@bosqueverde.com', 2, 'Legolas Hojaverde - Príncipe del Bosque Negro'),
(14, '88888888H', 'U2oiDC8K', 'alvarodaw2024@gmail.com', 2, 'Nunca Pies'),
(15, '14444224F', 'arcoElfico999', 'legolas@bosueverde.com', 2, 'Legolas Hojaverde - Príncipe del Bosque Negro'),
(17, '14444221Z', 'dondeEstaBucky', 'Steve@rogers.es', 2, 'Steve Rogers - El capitan america'),
(18, '14444221S', 'padme', 'Anakin@lord.es', 2, 'Anakin Skywalker - The chosen one');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `dni_2` (`dni`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `partidas`
--
ALTER TABLE `partidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
