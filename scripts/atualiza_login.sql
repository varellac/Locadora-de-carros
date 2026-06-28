CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('funcionario', 'cliente') NOT NULL,
    id_cliente INT NULL,
    FOREIGN KEY (id_cliente) REFERENCES cliente(cod_cliente) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Senha padrão para todos: 123
INSERT INTO usuarios (email, senha, perfil) 
SELECT 'admin@locadora.com', '$2y$10$7/O5rG6/K1W/XvL8t7N9r.R5z0A5uB/N6z5.Q1O/P8/1O4T0r/vD2', 'funcionario'
WHERE NOT EXISTS (SELECT email FROM usuarios WHERE email = 'admin@locadora.com');

INSERT INTO bairro (bairro) 
SELECT 'Bairro Teste' WHERE NOT EXISTS (SELECT bairro FROM bairro WHERE bairro = 'Bairro Teste');

INSERT INTO cliente (cliente, cpf, bairro_cliente) 
SELECT 'Cliente de Teste', '000.000.000-00', (SELECT cod_bairro FROM bairro WHERE bairro = 'Bairro Teste' LIMIT 1)
WHERE NOT EXISTS (SELECT cliente FROM cliente WHERE cliente = 'Cliente de Teste');

INSERT INTO usuarios (email, senha, perfil, id_cliente) 
SELECT 'cliente@teste.com', '$2y$10$7/O5rG6/K1W/XvL8t7N9r.R5z0A5uB/N6z5.Q1O/P8/1O4T0r/vD2', 'cliente', (SELECT cod_cliente FROM cliente WHERE cliente = 'Cliente de Teste' LIMIT 1)
WHERE NOT EXISTS (SELECT email FROM usuarios WHERE email = 'cliente@teste.com');
