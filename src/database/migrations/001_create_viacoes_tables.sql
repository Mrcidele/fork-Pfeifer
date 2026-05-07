CREATE TABLE IF NOT EXISTS viacoes (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       nome VARCHAR(150) NOT NULL,
    url VARCHAR(255),
    cidade VARCHAR(100),
    status ENUM('ativo','inativo')
    DEFAULT 'inativo',
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
                                                 nome VARCHAR(150),
    url VARCHAR(255),
    cidade VARCHAR(100),
    status ENUM('ativo','inativo'),
    logo VARCHAR(255),
    acao ENUM(
                 'criado',
                 'editado',
                 'excluido'
             ) NOT NULL,

    data_acao TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP
    );