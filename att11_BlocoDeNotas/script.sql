/*
CREATE DATABASE notas_dupla_johann_mateus;
USE notas_dupla_johann_mateus;

CREATE TABLE usuario(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome_usuario VARCHAR(45)
);

CREATE TABLE notas (
	id INT PRIMARY KEY AUTO_INCREMENT,
    titulo_nota VARCHAR(255) NOT NULL,
    texto_nota TEXT
);
