-- cubarral.uuid_municipios definition

CREATE TABLE `uuid_municipios` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(37) COLLATE utf8mb4_spanish_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `slogan` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid_municipios_un` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
