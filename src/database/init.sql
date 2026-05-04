SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tasks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  is_done TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tasks (title, description, is_done)
VALUES
  ('Estudar roteamento', 'Implementar um Router simples (GET/POST + params).', 0),
  ('Separar camadas', 'Controller → Service → Model → Views.', 0),
  ('Marcar como concluída', 'Editar a task e marcar o checkbox.', 0);

USE tasks;
SELECT * FROM tasks;

CREATE TABLE viacoes (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         nome VARCHAR(150) NOT NULL,
                         url VARCHAR(255),
                         cidade VARCHAR(100),
                         status ENUM('ativo','inativo') DEFAULT 'inativo',
                         logo VARCHAR(255),
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE historico_viacoes (
                                   id INT AUTO_INCREMENT PRIMARY KEY,
                                   viacao_id INT NOT NULL,
                                   nome VARCHAR(150),
                                   url VARCHAR(255),
                                   cidade VARCHAR(100),
                                   status ENUM('ativo','inativo'),
                                   logo VARCHAR(255),
                                   acao ENUM('criado','editado','excluido') NOT NULL,
                                   data_acao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                                   FOREIGN KEY (viacao_id)
                                       REFERENCES viacoes(id)
                                       ON DELETE CASCADE
);

SELECT * FROM viacoes;
SELECT * FROM historico_viacoes;

INSERT INTO viacoes (nome, url, cidade, status, logo)
VALUES
    ('Viação Cometa', 'https://www.viacaocometa.com.br', 'São Paulo', 'ativo', 'cometa.png'),

    ('Expresso do Sul', 'https://www.expressodosul.com.br', 'Curitiba', 'ativo', 'expresso.png'),

    ('Rápido Nordeste', 'https://www.rapidonordeste.com.br', 'Recife', 'ativo', 'nordeste.png'),

    ('Viação Interior', 'https://www.viacaointerior.com.br', 'Campinas', 'inativo', 'interior.png'),

    ('TransBrasil', 'https://www.transbrasil.com.br', 'Rio de Janeiro', 'ativo', 'transbrasil.png');

INSERT INTO historico_viacoes
(viacao_id, nome, url, cidade, status, logo, acao)
VALUES

    (1, 'Viação Cometa', 'https://www.viacaocometa.com.br', 'São Paulo', 'ativo', 'cometa.png', 'criado'),

    (2, 'Expresso do Sul', 'https://www.expressodosul.com.br', 'Curitiba', 'ativo', 'expresso.png', 'criado'),

    (3, 'Rápido Nordeste', 'https://www.rapidonordeste.com.br', 'Recife', 'ativo', 'nordeste.png', 'criado'),

    (4, 'Viação Interior', 'https://www.viacaointerior.com.br', 'Campinas', 'inativo', 'interior.png', 'criado'),

    (5, 'TransBrasil', 'https://www.transbrasil.com.br', 'Rio de Janeiro', 'ativo', 'transbrasil.png', 'criado');