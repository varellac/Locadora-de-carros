-- Corrected schema for Locadora M8
CREATE DATABASE IF NOT EXISTS locadora_m8 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE locadora_m8;

CREATE TABLE IF NOT EXISTS bairro (
    cod_bairro INT NOT NULL AUTO_INCREMENT,
    bairro VARCHAR(100) NOT NULL,
    PRIMARY KEY (cod_bairro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tipo (
    cod_tipo INT NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    PRIMARY KEY (cod_tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS montadora (
    cod_montadora INT NOT NULL AUTO_INCREMENT,
    montadora VARCHAR(50) NOT NULL,
    PRIMARY KEY (cod_montadora)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS carro (
    cod_carro INT NOT NULL AUTO_INCREMENT,
    carro VARCHAR(100) NOT NULL,
    tipo_carro INT NOT NULL,
    montadora_carro INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (cod_carro),
    FOREIGN KEY (tipo_carro) REFERENCES tipo(cod_tipo) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (montadora_carro) REFERENCES montadora(cod_montadora) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS cliente (
    cod_cliente INT NOT NULL AUTO_INCREMENT,
    cliente VARCHAR(120) NOT NULL,
    cpf VARCHAR(20) NOT NULL,
    bairro_cliente INT NOT NULL,
    PRIMARY KEY (cod_cliente),
    FOREIGN KEY (bairro_cliente) REFERENCES bairro(cod_bairro) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS locacao (
    cod_locacao INT NOT NULL AUTO_INCREMENT,
    cliente_locacao INT NOT NULL,
    data_locacao DATE NOT NULL,
    data_devolucao DATE DEFAULT NULL,
    PRIMARY KEY (cod_locacao),
    FOREIGN KEY (cliente_locacao) REFERENCES cliente(cod_cliente) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS carros_locacao (
    id INT NOT NULL AUTO_INCREMENT,
    carro_locado INT NOT NULL,
    locacao INT NOT NULL,
    valor DECIMAL(10,2) DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (carro_locado) REFERENCES carro(cod_carro) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (locacao) REFERENCES locacao(cod_locacao) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: indexes
CREATE INDEX idx_carro_tipo ON carro(tipo_carro);
CREATE INDEX idx_carro_montadora ON carro(montadora_carro);
CREATE INDEX idx_locacao_cliente ON locacao(cliente_locacao);
CREATE INDEX idx_carros_locacao_loc ON carros_locacao(locacao);
