SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `zf2base` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `zf2base` ;

-- -----------------------------------------------------
-- Table `zf2base`.`seg_usuarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zf2base`.`seg_usuarios` (
  `usr_id` INT NOT NULL AUTO_INCREMENT ,
  `usr_nome` VARCHAR(150) NOT NULL ,
  `usr_email` VARCHAR(150) NOT NULL ,
  `usr_telefone` VARCHAR(15) NULL ,
  `usr_usuario` VARCHAR(45) NOT NULL ,
  `usr_senha` VARCHAR(100) NOT NULL ,
  `usr_ativo` TINYINT(1) NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`usr_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zf2base`.`seg_modulos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zf2base`.`seg_modulos` (
  `mod_id` INT NOT NULL AUTO_INCREMENT ,
  `mod_nome` VARCHAR(150) NOT NULL ,
  `mod_descricao` VARCHAR(300) NULL ,
  `mod_icone` VARCHAR(45) NULL DEFAULT 'icon-cog' ,
  `mod_ativo` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`mod_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zf2base`.`seg_perfis`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zf2base`.`seg_perfis` (
  `prf_id` INT NOT NULL AUTO_INCREMENT ,
  `prf_mod_id` INT NOT NULL ,
  `prf_nome` VARCHAR(150) NOT NULL ,
  `prf_descricao` VARCHAR(300) NULL ,
  PRIMARY KEY (`prf_id`) ,
  INDEX `fk_seg_perfis_seg_modulos1` (`prf_mod_id` ASC) ,
  CONSTRAINT `fk_seg_perfis_seg_modulos1`
    FOREIGN KEY (`prf_mod_id` )
    REFERENCES `zf2base`.`seg_modulos` (`mod_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zf2base`.`seg_categorias_recursos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zf2base`.`seg_categorias_recursos` (
  `ctr_id` INT NOT NULL AUTO_INCREMENT ,
  `ctr_nome` VARCHAR(45) NOT NULL ,
  `ctr_descricao` VARCHAR(300) NULL ,
  `ctr_icone` VARCHAR(45) NOT NULL DEFAULT 'icon-bookmark' ,
  PRIMARY KEY (`ctr_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zf2base`.`seg_recursos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zf2base`.`seg_recursos` (
  `rcs_id` INT NOT NULL AUTO_INCREMENT ,
  `rcs_mod_id` INT NOT NULL ,
  `rcs_ctr_id` INT NOT NULL ,
  `rcs_nome` VARCHAR(150) NOT NULL ,
  `rcs_descricao` VARCHAR(300) NULL ,
  `rcs_icone` VARCHAR(45) NULL DEFAULT 'icon-code' ,
  `rcs_ativo` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`rcs_id`) ,
  INDEX `fk_seg_recursos_seg_modulos1` (`rcs_mod_id` ASC) ,
  INDEX `fk_seg_recursos_seg_categorias_recursos1` (`rcs_ctr_id` ASC) ,
  CONSTRAINT `fk_seg_recursos_seg_modulos1`
    FOREIGN KEY (`rcs_mod_id` )
    REFERENCES `zf2base`.`seg_modulos` (`mod_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_seg_recursos_seg_categorias_recursos1`
    FOREIGN KEY (`rcs_ctr_id` )
    REFERENCES `zf2base`.`seg_categorias_recursos` (`ctr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zf2base`.`seg_permissoes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zf2base`.`seg_permissoes` (
  `prm_id` INT NOT NULL AUTO_INCREMENT ,
  `prm_rcs_id` INT NOT NULL ,
  `prm_nome` VARCHAR(45) NOT NULL ,
  `prm_descricao` VARCHAR(300) NULL ,
  PRIMARY KEY (`prm_id`) ,
  INDEX `fk_seg_permissoes_seg_recursos1` (`prm_rcs_id` ASC) ,
  CONSTRAINT `fk_seg_permissoes_seg_recursos1`
    FOREIGN KEY (`prm_rcs_id` )
    REFERENCES `zf2base`.`seg_recursos` (`rcs_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zf2base`.`seg_perfis_usuarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zf2base`.`seg_perfis_usuarios` (
  `pru_prf_id` INT NOT NULL ,
  `pru_usr_id` INT NOT NULL ,
  PRIMARY KEY (`pru_prf_id`, `pru_usr_id`) ,
  INDEX `fk_seg_usuarios_has_seg_perfis_seg_perfis1` (`pru_prf_id` ASC) ,
  INDEX `fk_seg_usuarios_has_seg_perfis_seg_usuarios1` (`pru_usr_id` ASC) ,
  CONSTRAINT `fk_seg_usuarios_has_seg_perfis_seg_usuarios1`
    FOREIGN KEY (`pru_usr_id` )
    REFERENCES `zf2base`.`seg_usuarios` (`usr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_seg_usuarios_has_seg_perfis_seg_perfis1`
    FOREIGN KEY (`pru_prf_id` )
    REFERENCES `zf2base`.`seg_perfis` (`prf_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zf2base`.`seg_perfis_permissoes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zf2base`.`seg_perfis_permissoes` (
  `prp_prf_id` INT NOT NULL ,
  `prp_prm_id` INT NOT NULL ,
  PRIMARY KEY (`prp_prf_id`, `prp_prm_id`) ,
  INDEX `fk_seg_perfis_has_seg_permissoes_seg_permissoes1` (`prp_prm_id` ASC) ,
  INDEX `fk_seg_perfis_has_seg_permissoes_seg_perfis1` (`prp_prf_id` ASC) ,
  CONSTRAINT `fk_seg_perfis_has_seg_permissoes_seg_perfis1`
    FOREIGN KEY (`prp_prf_id` )
    REFERENCES `zf2base`.`seg_perfis` (`prf_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_seg_perfis_has_seg_permissoes_seg_permissoes1`
    FOREIGN KEY (`prp_prm_id` )
    REFERENCES `zf2base`.`seg_permissoes` (`prm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `zf2base`.`seg_usuarios`
-- -----------------------------------------------------
START TRANSACTION;
USE `zf2base`;
INSERT INTO `zf2base`.`seg_usuarios` (`usr_id`, `usr_nome`, `usr_email`, `usr_telefone`, `usr_usuario`, `usr_senha`, `usr_ativo`) VALUES (1, 'Administrador', 'admin@gestor.uemanet.uema.br', '', 'admin', '$2y$14$VVypr584OQBTum6xZrZwbOyfMZckzHgBk7pmMKaywLOnVNu4pvGDq', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `zf2base`.`seg_modulos`
-- -----------------------------------------------------
START TRANSACTION;
USE `zf2base`;
INSERT INTO `zf2base`.`seg_modulos` (`mod_id`, `mod_nome`, `mod_descricao`, `mod_icone`, `mod_ativo`) VALUES (1, 'Admin', 'Módulo de administração do portal', '', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `zf2base`.`seg_perfis`
-- -----------------------------------------------------
START TRANSACTION;
USE `zf2base`;
INSERT INTO `zf2base`.`seg_perfis` (`prf_id`, `prf_mod_id`, `prf_nome`, `prf_descricao`) VALUES (1, 1, 'Administrador', 'Perfil de Administrador');

COMMIT;

-- -----------------------------------------------------
-- Data for table `zf2base`.`seg_perfis_usuarios`
-- -----------------------------------------------------
START TRANSACTION;
USE `zf2base`;
INSERT INTO `zf2base`.`seg_perfis_usuarios` (`pru_prf_id`, `pru_usr_id`) VALUES (1, 1);

COMMIT;
