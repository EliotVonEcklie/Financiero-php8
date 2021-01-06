CREATE TABLE `cuentasccpet` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `codigo` VARCHAR(100) NOT NULL , `nombre` VARCHAR(600) NOT NULL , `padre` VARCHAR(100) NOT NULL , `nivel` INT(11) NOT NULL , `version` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `cubarral20201019`.`cuentasingresosccpet` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `codigo` VARCHAR(100) NOT NULL , `nombre` VARCHAR(600) NOT NULL , `padre` VARCHAR(100) NOT NULL , `nivel` INT(11) NOT NULL , `version` INT(11) NOT NULL , `tipo` VARCHAR(1) NOT NULL , `municipio` INT(1) NOT NULL , `departamento` INT(1) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;



ALTER TABLE `tesorecaudotransferenciasgr` ADD `destino` VARCHAR(3) NOT NULL AFTER `tipo_mov`;