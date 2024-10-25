-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-03-2023 a las 19:02:44
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `catato_hogar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `cod_categoria` int(7) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `estado_categoria` int(1) NOT NULL,
  `nombre_archivoCat` varchar(104) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`cod_categoria`, `nombre_categoria`, `estado_categoria`, `nombre_archivoCat`) VALUES
(1, 'comedor', 0, 'comedor.png'),
(2, 'dormitorio', 0, 'dormitorio.png'),
(3, 'living', 0, 'living.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id` int(7) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `texto` varchar(500) NOT NULL,
  `respondido` tinyint(1) NOT NULL,
  `id_usuario` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id`, `email`, `nombre`, `apellido`, `texto`, `respondido`, `id_usuario`) VALUES
(5, 'eliM@hotmail.com', 'Eli', 'Mandes', 'esta es una consulta de un usuario', 0, 5),
(6, 'martM@hotmail.com', 'martina', 'mendis', 'esta es una consulta de un usuario no registrado', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(10) NOT NULL,
  `precio_unidad` decimal(20,0) NOT NULL,
  `cantidad` int(250) NOT NULL,
  `producto_codigo` varchar(10) DEFAULT NULL,
  `usuario_id` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `precio_unidad`, `cantidad`, `producto_codigo`, `usuario_id`) VALUES
(5, '3099', 1, 'dome2', 5),
(6, '24900', 1, 'lisi6', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo` varchar(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `cod_categoria` int(7) NOT NULL,
  `cod_subcategoria` int(7) NOT NULL,
  `material` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `caracteristicas` varchar(500) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `stock` int(6) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `estado_producto` int(1) NOT NULL,
  `nombre_archivoprod` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `descripcion`, `cod_categoria`, `cod_subcategoria`, `material`, `color`, `caracteristicas`, `marca`, `stock`, `precio`, `estado_producto`, `nombre_archivoprod`) VALUES
('come1', 'mesa nordica escandinava', 1, 1, 'madera', 'blanco y marron', 'ancho: 60,altura: 77', 'stockhoy', 4, '6999.00', 0, 'come1.png'),
('come2', 'mesa comedor escandinava nordica', 1, 1, 'madera', 'blanco y marron', 'ancho: 80,altura: 77', 'nordico muebles', 3, '9698.00', 0, 'come2.png'),
('come3', 'mesa comedor eco laqueada extensible', 1, 1, 'madera', 'blanco', 'ancho: 85,altura: 80', 'living style', 4, '9999.99', 0, 'come3.png'),
('come4', 'mesa comedor escandinava nordica laqueada paraiso', 1, 1, 'madera', 'blanco y marron', 'ancho: 85,altura: 80', 'mesas mp', 4, '9152.00', 0, 'come4.png'),
('come5', 'mesa nordica escandinava comedor', 1, 1, 'madera', 'blanco y negro', 'ancho: 70,altura: 77', 'stockhoy', 4, '8999.00', 0, 'come5.png'),
('come6', 'mesa tulip saarinen', 1, 1, 'madera laqueada', 'blanco', 'ancho: 90,altura: 80', 'emuebles', 4, '6500.00', 0, 'come6.png'),
('cosi1', 'silla eames base nordica moderno', 1, 3, 'madera y polipropileno', 'blanco', 'ancho: 0.35,altura: 1.41', 'eames', 4, '3499.00', 0, 'cosi1.png'),
('cosi2', 'silla de escritorio mobilarg lisy fija', 1, 3, 'metal y cuero sintético', 'negro', 'ancho: 0.35,altura: 1.41', 'mobilarg', 4, '6290.00', 0, 'cosi2.png'),
('cosi3', 'silla fija cromada greta de diseño', 1, 3, 'madera', 'blanco', 'ancho: 30,altura: 100', 'jmi', 4, '8600.00', 0, 'cosi3.png'),
('cosi4', 'silla tulip', 1, 3, 'madera', 'blanco y marron', 'ancho: 30,altura: 100', 'decoto', 4, '7000.00', 0, 'cosi4.png'),
('cosi5', 'silla grace', 1, 3, 'madera', 'negro y marron', 'ancho: 30,altura: 100', 'vernis', 4, '7.00', 0, 'cosi5.png'),
('cosi6', 'silla fija cromada tulip de diseño', 1, 3, 'madera', 'negro', 'ancho: 30,altura: 100', 'jmi', 4, '8600.00', 0, 'cosi6.png'),
('doca2', 'cama repisa estantes porta', 2, 4, 'madera', 'marron', '2 plazas,largo: 210,ancho: 150', 'orlandi', 4, '9999.99', 0, 'doca2.png'),
('doca3', 'cama con 4 cajones', 2, 4, 'madera y eco cuero', 'rosa', '2 plazas,largo: 200,ancho: 160', 'tu mejor sommier', 3, '9999.99', 0, 'doca3.png'),
('doca4', 'cama box sommier 2 plazas con 6 cajones', 2, 4, 'madera', 'marron', '2 plazas,largo: 192,ancho: 143', 'móbica', 4, '9999.99', 0, 'doca4.png'),
('doca5', 'cama box sommier', 2, 4, 'madera', 'negro', '2 plazas,largo: 205,ancho: 160', 'mobilarg', 4, '9999.99', 0, 'doca5.png'),
('doca6', 'box sommier cajonera cama', 2, 4, 'melanina', 'beige', '2 plazas,largo: 200,ancho: 200', 'mari mar', 4, '9999.99', 0, 'doca6.png'),
('doco1', 'colchón cannon espuma tropical', 2, 5, 'tela de algodón', 'blanco', 'ancho: 80cm,largo: 190cm,altura: 18cm', 'cannon', 4, '8472.00', 0, 'doco1.png'),
('doco2', 'colchón cannon espuma exclusive', 2, 5, 'tela de jacquard', 'beige y marron', 'ancho: 140,largo: 190,altura: 29', 'cannon', 3, '9999.99', 1, 'doco2.png'),
('doco3', 'colchón cannon espuma princess', 2, 5, 'tela de jackard', 'blanco', 'ancho: ,largo: ,altura:80 x 190 x 20', 'cannon', 4, '9999.99', 0, 'doco3.png'),
('doco4', 'colchón cannon espuma exclusivele', 2, 5, 'tela de jacquard', 'beige y marron', 'ancho: 80,largo: 190,altura: 29', 'cannon', 4, '9999.99', 0, 'doco4.png'),
('doco5', 'plaza de resortes cannon resortes soñar', 2, 5, 'tela de algodón', 'blanco', 'ancho: 80,largo: 190,altura: 23', 'cannon', 4, '9999.99', 0, 'doco5.png'),
('doco6', 'plaza de resortes piero sonno', 2, 5, 'tela de jackard', 'blanco', 'ancho: 90,largo: 190,altura:26', 'piero', 4, '9999.99', 0, 'doco6.png'),
('dome1', 'mesa de luz 1 cajón', 2, 6, 'madera', 'marron', 'ancho: 47, profundidad: 31, altura: 55', 'mosconi', 4, '4621.00', 0, 'dome1.png'),
('dome2', 'mesa de luz escandinava - vintage', 2, 6, 'melanina', 'marron y blanco', 'ancho: 40, profundidad: 24, altura: 60', 'mjmaderas', 3, '3099.00', 0, 'dome2.png'),
('dome3', 'mesa de luz cajon puerta sajo', 2, 6, 'madera', 'negro', 'ancho: 42,profundidad: 30, altura:60', 'sajo', 3, '2999.00', 0, 'dome3.png'),
('dome4', 'mesa mesita luz flotante con cajon correderan', 2, 6, 'madera pino', 'blanco y marron', 'ancho: 35,profundidad: 29, altura:30', 'su ferretería online', 4, '4300.00', 0, 'dome4.png'),
('dome5', 'mesa de luz mesita con botinero', 2, 6, 'melanina', 'blanco', 'ancho: 38, profundidad: 0.38, altura:71', 'centro estant', 4, '6399.00', 0, 'dome5.png'),
('dome6', 'mesa de luz premium', 2, 6, 'melanina', 'gris', 'ancho: 53, profundidad: 35.5, altura:67', 'orlandi', 3, '6399.00', 0, 'dome6.png'),
('dopl1', 'placard ropero 2 puertas', 2, 7, 'melanina', 'blanco', 'ancho: 60, profundidad: 47,altura: 182', 'mosconi', 4, '9999.99', 0, 'dopl1.png'),
('dopl2', 'placard puertas corredizas', 2, 7, 'madera', 'blanco viejo', 'ancho: 182, profundidad: 53,altura: 184', 'orlandi', 4, '9999.99', 0, 'dopl2.png'),
('dopl3', 'placard wengue mogno', 2, 7, 'madera', 'blanco', 'ancho: 181, profundidad: 47,altura: 184', 'orlandi', 4, '9999.99', 0, 'dopl3.png'),
('dopl4', 'placard vestidor moderno ', 2, 7, 'madera', 'blanco', 'ancho:180,profundidad: 55,altura: 180', 'carpintería rivadavia', 4, '9999.99', 0, 'dopl4.png'),
('dopl5', 'placard ropero 12 puertas 4 cajones', 2, 7, 'madera', 'blanco viejo', 'ancho:212,profundidad: 47,altura: 215', 'orlandi', 4, '9999.99', 0, 'dopl5.png'),
('dopl6', 'ropero placard 2 puertas 4 estantes infantil cubo ', 2, 7, 'madera', 'beige', 'ancho:87,profundidad: 38,altura: 147', 'diseños modernos', 4, '8998.00', 0, 'dopl6.png'),
('lifu1', 'futon rustico', 3, 8, 'madera', 'blanco y marron', 'ancho: 205,altura: 100,profundidad: 140', 'bek', 4, '9999.99', 0, 'lifu1.png'),
('lifu2', 'futon modelo owen', 3, 8, 'madera', 'blanco', 'ancho: 100,altura: 76,profundidad: 100', 'tribeca', 4, '9999.99', 0, 'lifu2.png'),
('lifu3', 'futon 3 cpos cipres', 3, 8, 'madera', 'rosa y marron', 'ancho: 200,altura: 80,profundidad: 100', 'oeste amoblamientos', 4, '9999.99', 0, 'lifu3.png'),
('lifu4', 'futon sillón cama más colchón de tres cuerpos', 3, 8, 'madera', 'blanco y marron', 'ancho: 205,altura: 100,profundidad: 100', 'maderera pino hogar', 4, '9999.99', 0, 'lifu4.png'),
('lifu5', 'sofa cama bed napa lino ', 3, 8, 'madera', 'negro', 'ancho: 180,altura: 80,profundidad: 80', 'living style', 4, '9999.99', 0, 'lifu5.png'),
('lifu6', 'futon napa', 3, 8, 'metal', 'blanco', 'ancho: 179,altura: 79,profundidad: 100', 'tribeca', 4, '9999.99', 0, 'lifu6.png'),
('lisi1', 'sillon escandinavo', 3, 9, 'chenille y madera', 'gris', 'ancho: 160,profundidad: 80,altura: 80', 'dadaa muebles', 4, '9999.99', 0, 'lisi1.png'),
('lisi2', 'sillón 2 cuerpos', 3, 9, 'madera y tela', 'verde', 'ancho: 150,profundidad: 70,altura: 75', 'carbatt', 1, '9999.99', 0, 'lisi2.png'),
('lisi3', 'sillon nordico', 3, 9, 'chenille', 'gris', 'ancho: 180,profundidad: 80,altura: 80', 'dadaa muebles', 4, '9999.99', 0, 'lisi3.png'),
('lisi4', 'sofa basic especial', 3, 9, 'madera', 'negro', 'ancho: 123,profundidad: 73,altura: 81', 'chera', 4, '9999.99', 0, 'lisi4.png'),
('lisi5', 'sillón sofá escandinavo nórdico retro vintage', 3, 9, 'chenille antidesgarros y madera', 'gris', 'ancho: 150,profundidad: 80,altura: 95', 'interliving', 2, '9999.99', 0, 'lisi5.png'),
('lisi6', 'sillon rinconero', 3, 9, 'chenille y madera', 'morado', 'ancho: 180,profundidad: 0.7,altura: 75', 'carbatt', 3, '9999.99', 0, 'lisi6.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `cod_subcategoria` int(7) NOT NULL,
  `nombre_subcategoria` varchar(100) NOT NULL,
  `estado_subcategoria` int(1) NOT NULL,
  `cod_categoria` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`cod_subcategoria`, `nombre_subcategoria`, `estado_subcategoria`, `cod_categoria`) VALUES
(1, 'mesas', 0, 1),
(3, 'sillas', 0, 1),
(4, 'camas', 0, 2),
(5, 'colchones', 0, 2),
(6, 'mesas de luz', 0, 2),
(7, 'placares', 0, 2),
(8, 'futones', 0, 3),
(9, 'sillones', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(7) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `perfil` varchar(2) NOT NULL,
  `nro_dni` varchar(8) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `direccion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre_usuario`, `contrasena`, `perfil`, `nro_dni`, `nombre`, `apellido`, `email`, `provincia`, `ciudad`, `direccion`) VALUES
(1, 'caelenaShar', 'fdad6b495b494cc90228588b56df076b0fb2418b9b8bb25b7761d43cc3304dbe76098147d4b67d61bad429df22c9fc3608d0b716e1caed9a0d86be517eb33b6c', 'U', '41689734', 'caelena', 'shar', 'caeShar@hotmail.com', 'buenos aires', 'bahia blanca', 'avenida alem'),
(2, 'AnaLopez', '4aca528f4f24b158b4bbc6dd78f42f68172a30b419bb9ffbd6f377c5d5017b3a5fd039e541fea65ea316fde97cb10901b60230c101798ae1713f4fd8fedd9ee5', 'E', '12345678', 'Ana', 'Lopez', 'analopez@hotmail.com', 'Buenos Aires', 'Bahia Blanca', 'Calle 1'),
(3, 'RomanRissi', '9a8e90d7125787cd873d7da3121d129fb6c38079246ea964c6c5a3107c2de6f4fb09de26be8305062d2ca73886eaf7f7908705d689244845a530d30802f05c87', 'U', '12345678', 'Roman', 'Rssi', 'romans@hotmail.com', 'Buenos Aires', 'San Fernando', 'Calle 2'),
(4, 'CarlaMamun', '56f1e10945af6f778961ef047807a75af05f3601f051590ab3b4a59996cdab303b88b2a3d891fa332897cf08b2957bd5c7afa35ca9d35d14da9acf07d814bce9', 'E', '12345678', 'Carla', 'Mamun', 'mamunc@hotmail.com', 'Buenos Aires', 'Olavarria', 'Calle 3'),
(5, 'EliMandes', '8cf2a067cf38b7e40ae4b8b633409ef32aa997a859a0d898cc852790e73fefd18e206120fb76b6ddcd74c58543733810b284a0337ee9117676fa500fe36feae0', 'U', '11234567', 'Eli', 'Mandes', 'eliM@hotmail.com', 'buenos aires', 'azul', 'necochea 123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`cod_categoria`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_codigo` (`producto_codigo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_categoria` (`cod_categoria`),
  ADD KEY `cod_subcategoria` (`cod_subcategoria`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`cod_subcategoria`),
  ADD KEY `subcategoria` (`cod_categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `cod_categoria` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `cod_subcategoria` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`producto_codigo`) REFERENCES `producto` (`codigo`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`cod_categoria`) REFERENCES `categoria` (`cod_categoria`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`cod_subcategoria`) REFERENCES `subcategoria` (`cod_subcategoria`);

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `subcategoria` FOREIGN KEY (`cod_categoria`) REFERENCES `categoria` (`cod_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
