CREATE DATABASE IF NOT EXISTS votaciones;
USE votaciones;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `elecciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `candidatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eleccion_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `partido` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_eleccion` (`eleccion_id`),
  CONSTRAINT `fk_eleccion` FOREIGN KEY (`eleccion_id`) REFERENCES `elecciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS `votos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `eleccion_id` int(11) NOT NULL,
  `candidato_id` int(11) NOT NULL,
  `fecha_voto` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unico_voto_usuario_eleccion` (`usuario_id`,`eleccion_id`),
  KEY `fk_usuario_voto` (`usuario_id`),
  KEY `fk_eleccion_voto` (`eleccion_id`),
  KEY `fk_candidato_voto` (`candidato_id`),
  CONSTRAINT `fk_usuario_voto` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_eleccion_voto` FOREIGN KEY (`eleccion_id`) REFERENCES `elecciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_candidato_voto` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
