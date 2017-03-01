-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2017 a las 14:01:10
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `onlinestore`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `idCategory` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `isActive` tinyint(1) DEFAULT NULL,
  `cod` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`idCategory`, `name`, `description`, `isActive`, `cod`) VALUES
(23, 'Iluminación', 'Iluminación para el hogar', 1, 'iluminacion'),
(25, 'Mesas', 'Mesas para la vivienda', 1, 'Mesas'),
(27, 'Armarios', 'Armarios para el hogar', 1, 'Armarios'),
(28, 'electrodomesticos', 'Electrodomesticos para el hogar', 0, 'Electrodomesticos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `featured`
--

CREATE TABLE `featured` (
  `product_idProduct` int(11) NOT NULL,
  `product_category_idCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `featured`
--

INSERT INTO `featured` (`product_idProduct`, `product_category_idCategory`) VALUES
(69, 23),
(73, 23),
(98, 25),
(100, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order`
--

CREATE TABLE `order` (
  `idOrder` int(11) NOT NULL,
  `stay` enum('pendiente','procesado','recibido') DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `orderDate` date DEFAULT NULL,
  `deliveredDate` date DEFAULT NULL,
  `user_idUser` int(11) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `surnames` varchar(80) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `dni` char(9) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `order`
--

INSERT INTO `order` (`idOrder`, `stay`, `quantity`, `price`, `orderDate`, `deliveredDate`, `user_idUser`, `name`, `surnames`, `email`, `dni`, `address`, `cp`) VALUES
(108, 'pendiente', 60, '448.50', '2017-03-01', NULL, 47, 'Pruebas', 'Probando Pruebas', 'Pruebas@hotmail.com', '48929029w', 'Direccion de pruebas', '21105');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orderline`
--

CREATE TABLE `orderline` (
  `product_idProduct` int(11) NOT NULL,
  `order_idOrder` int(11) NOT NULL,
  `quantity` varchar(45) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orderline`
--

INSERT INTO `orderline` (`product_idProduct`, `order_idOrder`, `quantity`, `price`) VALUES
(69, 108, '50', '8.97'),
(71, 108, '10', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `idProduct` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `iva` decimal(5,2) DEFAULT NULL,
  `description` text,
  `stock` int(11) DEFAULT NULL,
  `category_idCategory` int(11) NOT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `cod` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`idProduct`, `name`, `price`, `discount`, `image`, `iva`, `description`, `stock`, `category_idCategory`, `isActive`, `cod`) VALUES
(69, 'Lampan', '2.99', '0.00', 'LampanRed.jpg', '3.00', 'Lampara de mesa roja', 50, 23, 1, 'L1'),
(70, 'Lampan', '2.00', '0.00', 'LampanBlue.jpg', '0.00', NULL, 10, 23, 1, 'L2'),
(71, 'Lampan', '2.00', '0.00', 'LampanBlue.jpg', '0.00', NULL, 0, 23, 1, 'L2'),
(72, 'Lampan', '2.99', '0.00', 'LampanWhite.jpg', '1.00', NULL, 5, 23, 1, 'L3'),
(73, 'Fado', '8.00', '0.00', 'Fado.jpg', '1.00', 'Lampara de mesa blanca', 3, 23, 1, 'L4'),
(74, 'Lampan', '2.99', '0.00', 'LampanWhite.jpg', '1.00', NULL, 5, 23, 1, 'L3'),
(75, 'Fado', '8.00', '0.00', 'Fado.jpg', '1.00', 'Lampara de mesa blanca', 3, 23, 1, 'L4'),
(76, 'Solleftea', '9.99', '0.00', 'Solleftea.jpg', '2.00', 'Lampara blanca', 9, 23, 0, 'L6'),
(77, 'Sinnerlig', '30.00', '0.00', 'Sinnerlig.jpg', '0.00', 'Lampara blanca', 7, 23, 1, 'L6'),
(78, 'Klab', '36.00', '0.00', 'Sinnerlig.jpg', '1.00', 'Lampara', 50, 23, 1, 'L7'),
(79, 'Gavic', '12.00', '0.00', 'Gavic.jpg', '3.00', 'Lampara Gavik', 13, 23, 1, 'L11'),
(80, 'Varv', '50.00', '0.00', 'Varv.jpg', '5.00', 'Lampara cara', 2, 23, 1, 'L12'),
(81, 'Solleftea', '9.99', '0.00', 'Solleftea.jpg', '2.00', 'Lampara blanca', 9, 23, 0, 'L6'),
(82, 'Sinnerlig', '30.00', '0.00', 'Sinnerlig.jpg', '0.00', 'Lampara blanca', 7, 23, 1, 'L6'),
(83, 'Klab', '36.00', '0.00', 'Sinnerlig.jpg', '1.00', 'Lampara', 50, 23, 1, 'L7'),
(84, 'Gavic', '12.00', '0.00', 'Gavic.jpg', '3.00', 'Lampara Gavik', 13, 23, 1, 'L11'),
(85, 'Varv', '50.00', '0.00', 'Varv.jpg', '5.00', 'Lampara cara', 2, 23, 1, 'L12'),
(86, 'Lykta', '13.00', '0.00', 'Lykta.jpg', '0.00', 'Lampara', 5, 23, 1, 'L13'),
(87, 'Riggad', '23.00', '0.00', 'Riggad.jpg', '3.00', 'Otra lampara', 30, 23, 1, 'L15'),
(88, 'Lykta', '13.00', '0.00', 'Lykta.jpg', '0.00', 'Lampara', 5, 23, 1, 'L13'),
(89, 'Riggad', '23.00', '0.00', 'Riggad.jpg', '3.00', 'Otra lampara', 30, 23, 1, 'L15'),
(98, 'Bjursta', '100.00', '0.00', 'Bjursta.jpg', '3.00', 'Mesa de madera', 0, 25, 1, 'M1'),
(99, 'Gamleby', '150.50', '0.00', 'Gamleby.jpg', '3.00', 'Mesa de madera', 70, 25, 1, 'M2'),
(100, 'Bjursnas', '300.00', '0.00', 'Bjursnas.jpg', '2.00', 'Mesa muy cara', 20, 25, 1, 'M3'),
(101, 'Stornas', '31.00', '0.00', 'Stornas.jpg', '3.00', 'Otra mesa', 20, 25, 1, 'M4'),
(102, 'StornasMadera', '300.00', '0.00', 'StornasMadera.jpg', '2.00', 'Otra mesa mas cara', 3, 25, 1, 'M5'),
(103, 'StorasLisa', '300.00', '0.00', 'StorasLisa.jpg', '1.00', 'Una mesa lisa', 300, 25, 1, 'M6'),
(104, 'StornasClon', '300.00', '0.00', 'StornasClon.jpg', '2.00', 'Una mesa muy repetitiva', 0, 23, 1, 'M10'),
(105, 'Ingatorp', '500.00', '0.00', 'Ingatorp.jpg', '3.00', 'Mesa mas elegante', 0, 25, 1, 'M30'),
(106, 'StornasAgain', '350.00', '0.00', 'StornasAgain.jpg', '2.00', 'Otra vez la misma mesa', 10, 25, 1, 'M31'),
(107, 'BjurstaMarron', '321.00', '0.00', 'BjurstaMarron.jpg', '2.00', 'Una mesa mas', 60, 25, 1, 'M35'),
(108, 'StornasClon', '300.00', '0.00', 'StornasClon.jpg', '2.00', 'Una mesa muy repetitiva', 0, 23, 1, 'M10'),
(109, 'Ingatorp', '500.00', '0.00', 'Ingatorp.jpg', '3.00', 'Mesa mas elegante', 0, 25, 1, 'M30'),
(110, 'StornasAgain', '350.00', '0.00', 'StornasAgain.jpg', '2.00', 'Otra vez la misma mesa', 10, 25, 1, 'M31'),
(111, 'BjurstaMarron', '321.00', '0.00', 'BjurstaMarron.jpg', '2.00', 'Una mesa mas', 60, 25, 1, 'M35'),
(112, 'Lagan', '300.00', '0.00', 'Lagan.jpg', '3.00', 'El inalcanzable', 10, 28, 1, 'F1'),
(113, 'Lagan', '300.00', '0.00', 'Lagan.jpg', '3.00', 'El inalcanzable', 10, 28, 1, 'F1'),
(114, 'Detolf', '50.00', '0.00', 'Detolf.jpg', '2.00', 'Una vitrina, la unica', 1, 27, 1, 'A1'),
(115, 'Hemmes', '300.00', '0.00', 'Hemmes.jpg', '3.00', 'Un armario', 3, 27, 1, 'A2'),
(116, 'Liatorp', '35.00', '0.00', 'Liatorp.jpg', '3.00', 'El ultimo armario', 1, 27, 1, 'A3'),
(117, 'Detolf', '50.00', '0.00', 'Detolf.jpg', '2.00', 'Una vitrina, la unica', 1, 27, 1, 'A1'),
(118, 'Hemmes', '300.00', '0.00', 'Hemmes.jpg', '3.00', 'Un armario', 3, 27, 1, 'A2'),
(119, 'Liatorp', '35.00', '0.00', 'Liatorp.jpg', '3.00', 'El ultimo armario', 1, 27, 1, 'A3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `province`
--

CREATE TABLE `province` (
  `idProvince` int(11) NOT NULL,
  `provinceName` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `province`
--

INSERT INTO `province` (`idProvince`, `provinceName`) VALUES
(1, 'Alava'),
(2, 'Albacete'),
(3, 'Alicante'),
(4, 'Almera'),
(5, 'Avila'),
(6, 'Badajoz'),
(7, 'Balears (Illes)'),
(8, 'Barcelona'),
(9, 'Burgos'),
(10, 'Cáceres'),
(11, 'Cádiz'),
(12, 'Castellón'),
(13, 'Ciudad Real'),
(14, 'Córdoba'),
(15, 'Coruña (A)'),
(16, 'Cuenca'),
(17, 'Girona'),
(18, 'Granada'),
(19, 'Guadalajara'),
(20, 'Guipzcoa'),
(21, 'Huelva'),
(22, 'Huesca'),
(23, 'Jaén'),
(24, 'León'),
(25, 'Lleida'),
(26, 'Rioja (La)'),
(27, 'Lugo'),
(28, 'Madrid'),
(29, 'Málaga'),
(30, 'Murcia'),
(31, 'Navarra'),
(32, 'Ourense'),
(33, 'Asturias'),
(34, 'Palencia'),
(35, 'Palmas (Las)'),
(36, 'Pontevedra'),
(37, 'Salamanca'),
(38, 'Santa Cruz de Tenerife'),
(39, 'Cantabria'),
(40, 'Segovia'),
(41, 'Sevilla'),
(42, 'Soria'),
(43, 'Tarragona'),
(44, 'Teruel'),
(45, 'Toledo'),
(46, 'Valencia'),
(47, 'Valladolid'),
(48, 'Vizcaya'),
(49, 'Zamora'),
(50, 'Zaragoza'),
(51, 'Ceuta'),
(52, 'Melilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resetpass`
--

CREATE TABLE `resetpass` (
  `idResetPass` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `user` varchar(15) NOT NULL,
  `token` varchar(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `userName` varchar(80) NOT NULL,
  `pass` char(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `surnames` varchar(80) DEFAULT NULL,
  `dni` char(9) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `province_idProvince` int(11) NOT NULL,
  `rol` enum('admin','user') DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`idUser`, `userName`, `pass`, `email`, `name`, `surnames`, `dni`, `address`, `cp`, `province_idProvince`, `rol`, `isActive`) VALUES
(47, 'Pruebas', '460f786760064a3f6b8821e7177a0b82', 'Pruebas@hotmail.com', 'Pruebas', 'Probando Pruebas', '48929029w', 'Direccion de pruebas', '21105', 1, 'user', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indices de la tabla `featured`
--
ALTER TABLE `featured`
  ADD PRIMARY KEY (`product_idProduct`,`product_category_idCategory`),
  ADD KEY `fk_featured_product1_idx` (`product_idProduct`,`product_category_idCategory`);

--
-- Indices de la tabla `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`idOrder`,`user_idUser`),
  ADD KEY `fk_order_user1_idx` (`user_idUser`);

--
-- Indices de la tabla `orderline`
--
ALTER TABLE `orderline`
  ADD PRIMARY KEY (`product_idProduct`,`order_idOrder`),
  ADD KEY `fk_product_has_order_order1_idx` (`order_idOrder`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idProduct`,`category_idCategory`),
  ADD KEY `fk_product_category_idx` (`category_idCategory`);

--
-- Indices de la tabla `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`idProvince`);

--
-- Indices de la tabla `resetpass`
--
ALTER TABLE `resetpass`
  ADD PRIMARY KEY (`idResetPass`),
  ADD UNIQUE KEY `iduser` (`idUser`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `name_user_UNIQUE` (`userName`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_province1_idx` (`province_idProvince`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `order`
--
ALTER TABLE `order`
  MODIFY `idOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT de la tabla `resetpass`
--
ALTER TABLE `resetpass`
  MODIFY `idResetPass` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `featured`
--
ALTER TABLE `featured`
  ADD CONSTRAINT `fk_featured_product1` FOREIGN KEY (`product_idProduct`,`product_category_idCategory`) REFERENCES `product` (`idProduct`, `category_idCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_user1` FOREIGN KEY (`user_idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orderline`
--
ALTER TABLE `orderline`
  ADD CONSTRAINT `fk_product_has_order_order1` FOREIGN KEY (`order_idOrder`) REFERENCES `order` (`idOrder`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_idCategory`) REFERENCES `category` (`idCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_province1` FOREIGN KEY (`province_idProvince`) REFERENCES `province` (`idProvince`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
