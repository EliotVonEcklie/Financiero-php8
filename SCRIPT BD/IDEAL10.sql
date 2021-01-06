/*OPCIONES ADICIONALES AL MENU*/
INSERT INTO `opciones` (`id_opcion`, `nom_opcion`, `ruta_opcion`, `niv_opcion`, `est_opcion`, `orden`, `modulo`, `especial`, `comando`) VALUES (NULL, 'Reporte Saldos Rps', 'presu-reportesrps.php', '4', '1', '10', '3', '', 'PRJ');
INSERT INTO `opciones` (`id_opcion`, `nom_opcion`, `ruta_opcion`, `niv_opcion`, `est_opcion`, `orden`, `modulo`, `especial`, `comando`) VALUES (NULL, 'Parametros Control de Activos', 'acti-parametrosacti.php', '1', '1', '11', '6', '', 'YAK');

/*MODIFICACIONES TABLA*/
/** OPCIÓN ACTOS ADMINISTRATIVOS CREAR*/
ALTER TABLE `pptoacuerdos` ADD `tipo_acto_adm` INT(1) NOT NULL AFTER `tipo`;

/** OPCIÓN PARAMETROS DE TESORERIA*/
ALTER TABLE `tesoparametros` ADD `notabancariarp` VARCHAR(1) NOT NULL DEFAULT '' AFTER `cuentacajamenor`;

/**OPCIÓN IMPORTAR CUENTAS PRESUPUESTO*/
ALTER TABLE `pptocuentas_his` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;

/**OPCIÓN NOTAS BANCARIAS PRESUPUESTO*/
ALTER TABLE `pptonotasbanppto` ADD `rp` INT(11) NOT NULL AFTER `vigencia`;

ALTER TABLE `tesonotasbancarias_cab` ADD `tipo_mov` VARCHAR(3) NULL DEFAULT NULL AFTER `concepto`, ADD `user` VARCHAR(100) NULL DEFAULT NULL AFTER `tipo_mov`;
ALTER TABLE `tesonotasbancarias_cab` DROP PRIMARY KEY, ADD PRIMARY KEY( `id_notaban`, `tipo_mov`);
ALTER TABLE `tesonotasbancarias_cab` ADD INDEX( `id_notaban`, `tipo_mov`);

ALTER TABLE `tesonotasbancarias_det` ADD `tipo_mov` VARCHAR(3) NULL DEFAULT NULL AFTER `estado`, ADD `user` VARCHAR(100) NULL DEFAULT NULL AFTER `tipo_mov`;
ALTER TABLE `tesonotasbancarias_det` DROP PRIMARY KEY, ADD PRIMARY KEY( `id_notabandet`, `tipo_mov`);
ALTER TABLE `tesonotasbancarias_det` ADD INDEX( `id_notabandet`, `tipo_mov`);
