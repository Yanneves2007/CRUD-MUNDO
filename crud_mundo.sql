CREATE DATABASE IF NOT EXISTS bd_mundo;
USE bd_mundo;

CREATE TABLE paises (
  id_pais INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  continente VARCHAR(50) NOT NULL,
  populacao BIGINT DEFAULT NULL,
  idioma VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cidades (
  id_cidade INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  populacao BIGINT DEFAULT NULL,
  id_pais INT NOT NULL,
  CONSTRAINT fk_cidade_pais FOREIGN KEY (id_pais)
    REFERENCES paises(id_pais)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO paises (nome, continente, populacao, idioma) VALUES
('Brasil', 'América do Sul', 213993437, 'Português'),
('Estados Unidos', 'América do Norte', 331002651, 'Inglês'),
('Alemanha', 'Europa', 83240525, 'Alemão'),
('Inglaterra', 'Europa', 55980000, 'Inglês'),
('Uruguai', 'América do Sul', 3473730, 'Espanhol'),
('Canadá', 'América do Norte', 37742154, 'Inglês e Francês');

INSERT INTO cidades (nome, populacao, id_pais) VALUES
('São Paulo', 12300000, 1),
('Rio de Janeiro', 6748000, 1),
('Brasília', 3055000, 1),

('Nova York', 8419000, 2),
('Los Angeles', 3980000, 2),
('Chicago', 2716000, 2),

('Berlim', 3645000, 3),
('Hamburgo', 1841000, 3),
('Munique', 1472000, 3),

('Londres', 8982000, 4),
('Manchester', 547600, 4),
('Birmingham', 1145000, 4),

('Montevidéu', 1319000, 5),
('Salto', 104000, 5),
('Paysandú', 76400, 5),

('Toronto', 2930000, 6),
('Vancouver', 675218, 6),
('Montreal', 1780000, 6);
