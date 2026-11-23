USE brasileirao_db;

CREATE TABLE estadios (
    id_estadio INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade VARCHAR(100),
    estado VARCHAR(2),
    capacidade INT
);

CREATE TABLE clubes (
    id_clube INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sigla VARCHAR(5),
    estado VARCHAR(2),
    cidade VARCHAR(100),
    ano_fundacao INT,
    cores VARCHAR(100),
    apelido VARCHAR(100),
    id_estadio INT,

    FOREIGN KEY (id_estadio)
    REFERENCES estadios(id_estadio)
);

CREATE TABLE competicoes (
    id_competicao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(30),
    abrangencia VARCHAR(30),
    organizacao VARCHAR(100)
);

CREATE TABLE participacoes (
    id_participacao INT AUTO_INCREMENT PRIMARY KEY,
    id_clube INT NOT NULL,
    id_competicao INT NOT NULL,
    qtd_participacoes INT DEFAULT 0,
    titulos INT DEFAULT 0,
    vices INT DEFAULT 0,

    FOREIGN KEY (id_clube)
    REFERENCES clubes(id_clube),

    FOREIGN KEY (id_competicao)
    REFERENCES competicoes(id_competicao),

    UNIQUE (id_clube, id_competicao)
);



