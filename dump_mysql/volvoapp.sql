SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `classificacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `classificacao` ;

CREATE TABLE IF NOT EXISTS `classificacao` (
  `id_classificacao` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NULL,
  PRIMARY KEY (`id_classificacao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `segmento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `segmento` ;

CREATE TABLE IF NOT EXISTS `segmento` (
  `id_segmento` BIGINT NOT NULL AUTO_INCREMENT,
  `segmento` VARCHAR(255) NULL,
  PRIMARY KEY (`id_segmento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cliente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cliente` ;

CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` BIGINT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NULL,
  `telefone` VARCHAR(255) NULL,
  `cep` VARCHAR(9) NULL,
  `endereco` VARCHAR(255) NULL,
  `cidade` VARCHAR(50) NULL,
  `cnpj` VARCHAR(14) NULL,
  `id_classificacao` INT NOT NULL,
  `id_segmento` BIGINT NOT NULL,
  PRIMARY KEY (`id_cliente`, `id_classificacao`, `id_segmento`),
  INDEX `fk_cliente_classificacao_idx` (`id_classificacao` ASC),
  INDEX `fk_cliente_segmento1_idx` (`id_segmento` ASC),
  CONSTRAINT `fk_cliente_classificacao`
    FOREIGN KEY (`id_classificacao`)
    REFERENCES `classificacao` (`id_classificacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_segmento1`
    FOREIGN KEY (`id_segmento`)
    REFERENCES `segmento` (`id_segmento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `funcao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `funcao` ;

CREATE TABLE IF NOT EXISTS `funcao` (
  `id_funcao` BIGINT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NULL,
  PRIMARY KEY (`id_funcao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `contato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `contato` ;

CREATE TABLE IF NOT EXISTS `contato` (
  `id_contato` BIGINT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `cpf` VARCHAR(14) NULL,
  `dt_nasc` DATE NULL,
  `celular` VARCHAR(255) NULL,
  `autoriza_email` CHAR(1) NULL,
  `autoriza_sms` CHAR(1) NULL,
  `ativo` CHAR(1) NULL,
  `id_cliente` BIGINT NOT NULL,
  `id_classificacao` INT NOT NULL,
  `id_segmento` BIGINT NOT NULL,
  `id_funcao` BIGINT NOT NULL,
  PRIMARY KEY (`id_contato`),
  INDEX `fk_contato_cliente1_idx` (`id_cliente` ASC, `id_classificacao` ASC, `id_segmento` ASC),
  INDEX `fk_contato_funcao1_idx` (`id_funcao` ASC),
  CONSTRAINT `fk_contato_cliente1`
    FOREIGN KEY (`id_cliente` , `id_classificacao` , `id_segmento`)
    REFERENCES `cliente` (`id_cliente` , `id_classificacao` , `id_segmento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contato_funcao1`
    FOREIGN KEY (`id_funcao`)
    REFERENCES `funcao` (`id_funcao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tipo_pergunta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tipo_pergunta` ;

CREATE TABLE IF NOT EXISTS `tipo_pergunta` (
  `id_tipo_pergunta` BIGINT NOT NULL AUTO_INCREMENT,
  `pergunta` VARCHAR(255) NULL,
  PRIMARY KEY (`id_tipo_pergunta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `evento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `evento` ;

CREATE TABLE IF NOT EXISTS `evento` (
  `id_evento` BIGINT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NULL,
  `inicio` DATE NULL,
  `fim` DATE NULL,
  PRIMARY KEY (`id_evento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pesquisa_pergunta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pesquisa_pergunta` ;

CREATE TABLE IF NOT EXISTS `pesquisa_pergunta` (
  `id_pesq_pergunta` BIGINT NOT NULL AUTO_INCREMENT,
  `pergunta` VARCHAR(45) NULL,
  `id_tipo_pergunta` BIGINT NOT NULL,
  `id_evento` BIGINT NOT NULL,
  PRIMARY KEY (`id_pesq_pergunta`, `id_tipo_pergunta`),
  INDEX `fk_pesquisa_pergunta_tipo_pergunta1_idx` (`id_tipo_pergunta` ASC),
  INDEX `fk_pesquisa_pergunta_evento1_idx` (`id_evento` ASC),
  CONSTRAINT `fk_pesquisa_pergunta_tipo_pergunta1`
    FOREIGN KEY (`id_tipo_pergunta`)
    REFERENCES `tipo_pergunta` (`id_tipo_pergunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pesquisa_pergunta_evento1`
    FOREIGN KEY (`id_evento`)
    REFERENCES `evento` (`id_evento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pesquisa_resposta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pesquisa_resposta` ;

CREATE TABLE IF NOT EXISTS `pesquisa_resposta` (
  `id_pesq_resposta` BIGINT NOT NULL AUTO_INCREMENT,
  `resposta` VARCHAR(45) NULL,
  `id_pesq_pergunta` BIGINT NOT NULL,
  `id_tipo_pergunta` BIGINT NOT NULL,
  PRIMARY KEY (`id_pesq_resposta`),
  INDEX `fk_pesquisa_resposta_pesquisa_pergunta1_idx` (`id_pesq_pergunta` ASC, `id_tipo_pergunta` ASC),
  CONSTRAINT `fk_pesquisa_resposta_pesquisa_pergunta1`
    FOREIGN KEY (`id_pesq_pergunta` , `id_tipo_pergunta`)
    REFERENCES `pesquisa_pergunta` (`id_pesq_pergunta` , `id_tipo_pergunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cliente_pesquisa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cliente_pesquisa` ;

CREATE TABLE IF NOT EXISTS `cliente_pesquisa` (
  `id_cliente_pesquisa` BIGINT NOT NULL AUTO_INCREMENT,
  `id_pesq_resposta` BIGINT NOT NULL,
  `id_cliente` BIGINT NOT NULL,
  `id_classificacao` INT NOT NULL,
  `id_segmento` BIGINT NOT NULL,
  PRIMARY KEY (`id_cliente_pesquisa`),
  INDEX `fk_cliente_pesquisa_pesquisa_resposta1_idx` (`id_pesq_resposta` ASC),
  INDEX `fk_cliente_pesquisa_cliente1_idx` (`id_cliente` ASC, `id_classificacao` ASC, `id_segmento` ASC),
  CONSTRAINT `fk_cliente_pesquisa_pesquisa_resposta1`
    FOREIGN KEY (`id_pesq_resposta`)
    REFERENCES `pesquisa_resposta` (`id_pesq_resposta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_pesquisa_cliente1`
    FOREIGN KEY (`id_cliente` , `id_classificacao` , `id_segmento`)
    REFERENCES `cliente` (`id_cliente` , `id_classificacao` , `id_segmento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `contato_pesquisa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `contato_pesquisa` ;

CREATE TABLE IF NOT EXISTS `contato_pesquisa` (
  `id_contato_pesquisa` INT NOT NULL,
  `id_pesq_resposta` BIGINT NOT NULL,
  `id_contato` BIGINT NOT NULL,
  PRIMARY KEY (`id_contato_pesquisa`),
  INDEX `fk_contato_pesquisa_pesquisa_resposta1_idx` (`id_pesq_resposta` ASC),
  INDEX `fk_contato_pesquisa_contato1_idx` (`id_contato` ASC),
  CONSTRAINT `fk_contato_pesquisa_pesquisa_resposta1`
    FOREIGN KEY (`id_pesq_resposta`)
    REFERENCES `pesquisa_resposta` (`id_pesq_resposta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contato_pesquisa_contato1`
    FOREIGN KEY (`id_contato`)
    REFERENCES `contato` (`id_contato`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `auditoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auditoria` ;

CREATE TABLE IF NOT EXISTS `auditoria` (
  `id_audutoria` BIGINT NOT NULL AUTO_INCREMENT,
  `data_hota` TIMESTAMP NULL,
  `acao` VARCHAR(45) NULL,
  `mac_address` VARCHAR(45) NULL,
  `serial_number` VARCHAR(45) NULL,
  `sql` VARCHAR(45) NULL,
  PRIMARY KEY (`id_audutoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_financeiro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo_financeiro` ;

CREATE TABLE IF NOT EXISTS `grupo_financeiro` (
  `id_grupo_financeiro` BIGINT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NULL,
  PRIMARY KEY (`id_grupo_financeiro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `concessionaria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `concessionaria` ;

CREATE TABLE IF NOT EXISTS `concessionaria` (
  `id_concessionaria` BIGINT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `cep` VARCHAR(45) NULL,
  `endereco` VARCHAR(45) NULL,
  `cidade` VARCHAR(45) NULL,
  `id_grupo_financeiro` BIGINT NOT NULL,
  PRIMARY KEY (`id_concessionaria`),
  INDEX `fk_concessionaria_grupo_financeiro1_idx` (`id_grupo_financeiro` ASC),
  CONSTRAINT `fk_concessionaria_grupo_financeiro1`
    FOREIGN KEY (`id_grupo_financeiro`)
    REFERENCES `grupo_financeiro` (`id_grupo_financeiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `permissao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `permissao` ;

CREATE TABLE IF NOT EXISTS `permissao` (
  `id_permissao` BIGINT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NULL,
  PRIMARY KEY (`id_permissao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `colaborador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `colaborador` ;

CREATE TABLE IF NOT EXISTS `colaborador` (
  `id_colaborador` BIGINT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `login` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `senha` VARCHAR(45) NULL,
  `moderador` VARCHAR(45) NULL,
  `ativo` VARCHAR(45) NULL,
  `id_concessionaria` BIGINT NOT NULL,
  `id_permissao` BIGINT NOT NULL,
  `id_funcao` BIGINT NOT NULL,
  PRIMARY KEY (`id_colaborador`),
  INDEX `fk_colaborador_concessionaria1_idx` (`id_concessionaria` ASC),
  INDEX `fk_colaborador_permissao1_idx` (`id_permissao` ASC),
  INDEX `fk_colaborador_funcao1_idx` (`id_funcao` ASC),
  CONSTRAINT `fk_colaborador_concessionaria1`
    FOREIGN KEY (`id_concessionaria`)
    REFERENCES `concessionaria` (`id_concessionaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_colaborador_permissao1`
    FOREIGN KEY (`id_permissao`)
    REFERENCES `permissao` (`id_permissao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_colaborador_funcao1`
    FOREIGN KEY (`id_funcao`)
    REFERENCES `funcao` (`id_funcao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ect_pais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ect_pais` ;

CREATE TABLE IF NOT EXISTS `ect_pais` (
  `pai_sg` CHAR(2) NOT NULL,
  `pai_sg_alternativa` CHAR(3) NULL,
  `pai_no_portugues` VARCHAR(72) NULL,
  `pai_no_ingles` VARCHAR(72) NULL,
  `pai_no_frances` VARCHAR(72) NULL,
  `pai_abreviatura` VARCHAR(36) NULL,
  PRIMARY KEY (`pai_sg`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `log_faixa_uf`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `log_faixa_uf` ;

CREATE TABLE IF NOT EXISTS `log_faixa_uf` (
  `ufe_sg` CHAR(2) NOT NULL,
  `ufe_cep_ini` CHAR(8) NOT NULL,
  `ufe_cep_fim` CHAR(8) NULL,
  PRIMARY KEY (`ufe_sg`, `ufe_cep_ini`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedido` ;

CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` BIGINT NOT NULL AUTO_INCREMENT,
  `data_hota` DATETIME NULL,
  PRIMARY KEY (`id_pedido`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
