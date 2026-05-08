CREATE TABLE IF NOT EXISTS viacoes (

    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    url VARCHAR(255),
    cidade VARCHAR(100),
    status TINYINT(1) DEFAULT (1),
    logo VARCHAR(255),
    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

    );

CREATE TABLE IF NOT EXISTS historico_viacoes (

    id INT AUTO_INCREMENT PRIMARY KEY,
    viacao_id INT NOT NULL,
    usuario_id INT NOT NULL,
    alteracao TEXT,
    acao ENUM('criado','editado','excluido') NOT NULL,
    data_acao TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP

    );