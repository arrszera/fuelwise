DROP DATABASE IF EXISTS `fuelwise`;

CREATE SCHEMA IF NOT EXISTS `fuelwise` DEFAULT CHARACTER SET utf8;
USE `fuelwise`;

CREATE TABLE IF NOT EXISTS `transportadora` (
  `idtransportadora` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(2) NOT NULL,
  `cep` VARCHAR(8) NOT NULL,
  `cnpj` VARCHAR(14) NOT NULL,
  `telefone` VARCHAR(25) NOT NULL,
  `dataCriacao` DATETIME NOT NULL,
  PRIMARY KEY (`idtransportadora`),
  UNIQUE (`cnpj`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `posto` (
  `idposto` INT NOT NULL AUTO_INCREMENT,
  `endereco` VARCHAR(100) NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `latitude` VARCHAR(20) NOT NULL,
  `longitude` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`idposto`)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `nome` VARCHAR(90) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR(45) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `gerente` TINYINT NOT NULL,
  `adm` TINYINT NOT NULL,
  PRIMARY KEY (`idusuario`)
  ) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `veiculo` (
  `idveiculo` INT NOT NULL AUTO_INCREMENT,
  `idtransportadora` INT NOT NULL,
  `placa` VARCHAR(10) NOT NULL,
  `modelo` VARCHAR(45) NOT NULL,
  `eixos` TINYINT NOT NULL,
  `litragem` FLOAT NOT NULL,
  `observacao` VARCHAR(100),
  PRIMARY KEY (`idveiculo`),
  FOREIGN KEY (`idtransportadora`) REFERENCES `transportadora` (`idtransportadora`)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `viagem` (
  `idviagem` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL, 
  `idveiculo` INT NOT NULL,
  `data_inicio` DATETIME NOT NULL,
  `data_termino` DATETIME,
  `endereco_origem` VARCHAR(150),
  `latitude_origem` DECIMAL(10, 7),
  `longitude_origem` DECIMAL(10, 7),
  `endereco_destino` VARCHAR(150),
  `latitude_destino` DECIMAL(10, 7),
  `longitude_destino` DECIMAL(10, 7),
  `latitude_atual` DECIMAL(10, 7),
  `longitude_atual` DECIMAL(10, 7),
  `carga` VARCHAR(100) NOT NULL,
  `peso` FLOAT(10,2) NOT NULL,
  `obs` VARCHAR(100),
  `status` TINYINT NOT NULL,
  PRIMARY KEY (`idviagem`),
  FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
  FOREIGN KEY (`idveiculo`) REFERENCES `veiculo` (`idveiculo`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `combustivel` (
  `idcombustivel` INT NOT NULL AUTO_INCREMENT,
  `idposto` INT NOT NULL,
  `tipo` TINYINT NOT NULL,
  `preco` FLOAT(10,2) NOT NULL,
  PRIMARY KEY (`idcombustivel`),
  FOREIGN KEY (`idposto`) REFERENCES `posto` (`idposto`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `denuncia` (
  `iddenuncia` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `motivo` VARCHAR(250) NOT NULL,
  `titulo` VARCHAR(50) NOT NULL,
  `data_criacao` DATE NOT NULL,
  PRIMARY KEY (`iddenuncia`),
  FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `anexos` (
  `idanexos` INT NOT NULL AUTO_INCREMENT,
  `iddenuncia` INT NOT NULL,
  `path` VARCHAR(100) NOT NULL,
  `nome_arquivo` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idanexos`),
  FOREIGN KEY (`iddenuncia`) REFERENCES `denuncia` (`iddenuncia`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `solicitacao` (
  `idsolicitacao` INT NOT NULL AUTO_INCREMENT,
  `nomeTransportadora` VARCHAR(50) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `cep` VARCHAR(8) NOT NULL,
  `cidade` VARCHAR(20) NOT NULL,
  `estado` VARCHAR(2) NOT NULL,
  `telefoneEmpresa` VARCHAR(45) NOT NULL,
  `cnpj` VARCHAR(14) NOT NULL,
  `nomeUsuario` VARCHAR(45) NOT NULL,
  `sobrenome` VARCHAR(45) NOT NULL,
  `emailUsuario` VARCHAR(45) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `telefoneUsuario` VARCHAR(45) NOT NULL,
  `status` TINYINT NOT NULL,
  PRIMARY KEY (`idsolicitacao`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `transportadora_usuario` (
  `idtransportadora_usuario` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `idtransportadora` INT NOT NULL,
  `datalogin` DATE,
  PRIMARY KEY (`idtransportadora_usuario`),
  FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
  FOREIGN KEY (`idtransportadora`) REFERENCES `transportadora` (`idtransportadora`)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `pagamento` (
  `idpagamento` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `idposto` INT NOT NULL,
  `idviagem` INT NOT NULL,
  `idtransportadora` INT NOT NULL,
  `litragem` DECIMAL(10,2) NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL, 
  `distanciaPercorrida` DECIMAL(10,2) NOT NULL, 
  `dataPagamento` DATETIME NOT NULL, 
  `destinatario` VARCHAR(90) NOT NULL,
  `latitudePagamento` DECIMAL(10, 7) NOT NULL,
  `longitudePagamento` DECIMAL(10, 7) NOT NULL,
  `pathBomba` VARCHAR (100) NOT NULL,
  `pathPosto` VARCHAR (100) NOT NULL,
  `pathPlaca` VARCHAR (100) NOT NULL,
  `cpfPagador` VARCHAR(11) NOT NULL, -- Em caso de exclusao de usuario, mantem seu cpf salvo em caso de necessidade
  PRIMARY KEY (`idpagamento`), -- sem FOREIGN KEYS pois se um posto ou usuario for excluido, não dependencia entre ambos 
  FOREIGN KEY (`idtransportadora`) REFERENCES `transportadora` (`idtransportadora`)
  ) ENGINE=InnoDB;