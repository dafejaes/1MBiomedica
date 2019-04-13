-- MySQL Script generated by MySQL Workbench
-- Sat Apr 13 15:32:36 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema biomedica1m_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema biomedica1m_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `biomedica1m_db` DEFAULT CHARACTER SET utf8 ;
USE `biomedica1m_db` ;

-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_usuarios` (
  `usuarios_id` INT NOT NULL,
  `usuarios_cedula` INT NOT NULL,
  `usuarios_nombres` VARCHAR(45) NULL,
  `usuarios_apellidos` VARCHAR(45) NULL,
  `usuarios_correo` VARCHAR(100) NULL,
  `usuarios_contrasena` VARCHAR(100) NULL,
  `usuarios_nacimiento` DATE NULL,
  `usuarios_ciudad` VARCHAR(45) NULL,
  `usuarios_departamento` VARCHAR(45) NULL,
  `usuarios_direccion` VARCHAR(100) NULL,
  `usuarios_lineacorreo` TINYINT NULL,
  `usuarios_correosespeciales` TINYINT NULL,
  `usuarios_borrado` TINYINT NULL,
  `usuarios_fechamodifi` TINYINT NULL,
  `usuarios_ingeniero` TINYINT NULL,
  PRIMARY KEY (`usuarios_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_tipoequipos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_tipoequipos` (
  `eqt_id` INT NOT NULL,
  `eqt_clase` VARCHAR(50) NULL,
  `eqt_alias` VARCHAR(50) NULL,
  `eqt_marca` VARCHAR(50) NULL,
  `eqt_modelo` VARCHAR(50) NULL,
  `eqt_clasificacion` VARCHAR(50) NULL,
  `eqt_tipo` VARCHAR(50) NULL,
  `eqt_ID2` VARCHAR(50) NULL,
  `eqt_precio` VARCHAR(500) NULL,
  `eqt_actualizado` DATETIME NULL,
  `eqt_borrado` TINYINT NULL,
  `eqt_resena` VARCHAR(2000) NULL,
  PRIMARY KEY (`eqt_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_compras`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_compras` (
  `compras_id` INT NOT NULL,
  `compras_referencia` VARCHAR(500) NOT NULL,
  `biome1m_usuarios_usuarios_id` INT NOT NULL,
  `compras_fecha` DATETIME NULL,
  `compras_borrado` TINYINT NULL,
  PRIMARY KEY (`compras_id`),
  INDEX `fk_biome1m_compras_biome1m_usuarios1_idx` (`biome1m_usuarios_usuarios_id` ASC) VISIBLE,
  CONSTRAINT `fk_biome1m_compras_biome1m_usuarios1`
    FOREIGN KEY (`biome1m_usuarios_usuarios_id`)
    REFERENCES `biomedica1m_db`.`biome1m_usuarios` (`usuarios_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_equipos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_equipos` (
  `eq_id` INT NOT NULL,
  `biome1m_compras_compras_id` INT NOT NULL,
  `biome1m_tipoequipos_eqt_id` INT NOT NULL,
  `eq_bodega` INT NULL,
  `eq_serie` VARCHAR(500) NULL,
  `eq_placa` VARCHAR(500) NULL,
  `eq_codigo` VARCHAR(500) NULL,
  `eq_registroINVIMA` VARCHAR(500) NULL,
  `eq_actualizado` DATETIME NULL,
  `eq_borrado` TINYINT NULL,
  `eq_vendido` TINYINT NULL,
  PRIMARY KEY (`eq_id`),
  INDEX `fk_biome1m_equipos_biome1m_tipoequipos1_idx` (`biome1m_tipoequipos_eqt_id` ASC) VISIBLE,
  INDEX `fk_biome1m_equipos_biome1m_compras1_idx` (`biome1m_compras_compras_id` ASC) VISIBLE,
  CONSTRAINT `fk_biome1m_equipos_biome1m_tipoequipos1`
    FOREIGN KEY (`biome1m_tipoequipos_eqt_id`)
    REFERENCES `biomedica1m_db`.`biome1m_tipoequipos` (`eqt_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_biome1m_equipos_biome1m_compras1`
    FOREIGN KEY (`biome1m_compras_compras_id`)
    REFERENCES `biomedica1m_db`.`biome1m_compras` (`compras_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_msgserclient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_msgserclient` (
  `msgserclient_id` INT NOT NULL,
  `msgserclient_asunto` VARCHAR(200) NULL,
  `msgserclient_correo` VARCHAR(100) NULL,
  `msgserclient_referencia` VARCHAR(200) NULL,
  `msgserclient_archivo` VARCHAR(500) NULL,
  `msgserclient_mensaje` VARCHAR(3000) NULL,
  `msgserclient_fecha` DATETIME NULL,
  PRIMARY KEY (`msgserclient_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_caracteristicas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_caracteristicas` (
  `caract_id` INT NOT NULL,
  `biome1m_tipoequipos_eqt_id` INT NOT NULL,
  `caract_nombre` VARCHAR(100) NULL,
  `caract_valor` VARCHAR(100) NULL,
  `caract_actualizado` DATETIME NULL,
  `caract_borrado` TINYINT NULL,
  PRIMARY KEY (`caract_id`),
  INDEX `fk_biome1m_caracteristicas_biome1m_tipoequipos1_idx` (`biome1m_tipoequipos_eqt_id` ASC) VISIBLE,
  CONSTRAINT `fk_biome1m_caracteristicas_biome1m_tipoequipos1`
    FOREIGN KEY (`biome1m_tipoequipos_eqt_id`)
    REFERENCES `biomedica1m_db`.`biome1m_tipoequipos` (`eqt_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_documentos_eqt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_documentos_eqt` (
  `doceqt_id` INT NOT NULL,
  `biome1m_tipoequipos_eqt_id` INT NOT NULL,
  `doceqt_nombre` VARCHAR(100) NULL,
  `doceqt_actualizado` DATETIME NULL,
  `doceqt_borrado` TINYINT NULL,
  PRIMARY KEY (`doceqt_id`),
  INDEX `fk_biome1m_documentos_eqt_biome1m_tipoequipos1_idx` (`biome1m_tipoequipos_eqt_id` ASC) VISIBLE,
  CONSTRAINT `fk_biome1m_documentos_eqt_biome1m_tipoequipos1`
    FOREIGN KEY (`biome1m_tipoequipos_eqt_id`)
    REFERENCES `biomedica1m_db`.`biome1m_tipoequipos` (`eqt_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_software`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_software` (
  `softw_id` INT NOT NULL,
  `softw_nombre` VARCHAR(100) NULL,
  `softw_archivo` VARCHAR(45) NULL,
  `softw_actualizado` DATETIME NULL,
  `softw_borrado` TINYINT NULL,
  PRIMARY KEY (`softw_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_msgsoftw`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_msgsoftw` (
  `msgsoftw_id` INT NOT NULL,
  `biome1m_software_softw_id` INT NOT NULL,
  `biome1m_usuarios_usuarios_id` INT NULL,
  `msgsoftw_correo` VARCHAR(45) NULL,
  `msgsoftw_mensaje` VARCHAR(3000) NULL,
  `msgsoftw_fecha` DATETIME NULL,
  PRIMARY KEY (`msgsoftw_id`),
  INDEX `fk_biome1m_msgsoftw_biome1m_software1_idx` (`biome1m_software_softw_id` ASC) VISIBLE,
  INDEX `fk_biome1m_msgsoftw_biome1m_usuarios1_idx` (`biome1m_usuarios_usuarios_id` ASC) VISIBLE,
  CONSTRAINT `fk_biome1m_msgsoftw_biome1m_software1`
    FOREIGN KEY (`biome1m_software_softw_id`)
    REFERENCES `biomedica1m_db`.`biome1m_software` (`softw_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_biome1m_msgsoftw_biome1m_usuarios1`
    FOREIGN KEY (`biome1m_usuarios_usuarios_id`)
    REFERENCES `biomedica1m_db`.`biome1m_usuarios` (`usuarios_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_servicios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_servicios` (
  `serv_id` INT NOT NULL,
  `serv_nombre` VARCHAR(45) NULL,
  `serv_archivo` VARCHAR(45) NULL,
  `serv_actualizado` DATETIME NULL,
  `serv_borrado` TINYINT NULL,
  PRIMARY KEY (`serv_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_msgserv`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_msgserv` (
  `msgserv_id` INT NOT NULL,
  `biome1m_servicios_serv_id` INT NOT NULL,
  `biome1m_usuarios_usuarios_id` INT NULL,
  `msgserv_correo` VARCHAR(100) BINARY NULL,
  `msgserv_mensaje` VARCHAR(3000) NULL,
  `msgserv_fecha` DATETIME NULL,
  `biome1m_msgservcol` VARCHAR(45) NULL,
  PRIMARY KEY (`msgserv_id`),
  INDEX `fk_biome1m_msgserv_biome1m_servicios1_idx` (`biome1m_servicios_serv_id` ASC) VISIBLE,
  INDEX `fk_biome1m_msgserv_biome1m_usuarios1_idx` (`biome1m_usuarios_usuarios_id` ASC) VISIBLE,
  UNIQUE INDEX `msgserv_correo_UNIQUE` (`msgserv_correo` ASC) VISIBLE,
  CONSTRAINT `fk_biome1m_msgserv_biome1m_servicios1`
    FOREIGN KEY (`biome1m_servicios_serv_id`)
    REFERENCES `biomedica1m_db`.`biome1m_servicios` (`serv_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_biome1m_msgserv_biome1m_usuarios1`
    FOREIGN KEY (`biome1m_usuarios_usuarios_id`)
    REFERENCES `biomedica1m_db`.`biome1m_usuarios` (`usuarios_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biomedica1m_db`.`biome1m_novedades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biomedica1m_db`.`biome1m_novedades` (
  `nov_id` INT NOT NULL,
  `nov_titulo` VARCHAR(100) NULL,
  `nov_foto` VARCHAR(100) NULL,
  `nov_resena` VARCHAR(5000) NULL,
  `nov_fecha` DATETIME NULL,
  `nov_borrado` TINYINT NULL,
  PRIMARY KEY (`nov_id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
