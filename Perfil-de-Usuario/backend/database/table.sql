USE desafio_sync360;

CREATE TABLE IF NOT EXISTS usuario (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL CHECK (nome <> ''),
  idade INT NOT NULL,
  rua VARCHAR(100) NOT NULL CHECK (rua <> ''),
  bairro VARCHAR(100) NOT NULL CHECK (bairro <> ''),
  estado VARCHAR(50) NOT NULL CHECK (estado <> ''),
  bio TEXT NOT NULL CHECK (bio <> ''),
  imagem TEXT NOT NULL CHECK (imagem <> '')
);

-- Atualiza ID (use com cuidado! Só se necessário e não houver conflito)
-- UPDATE usuario SET id = 1 WHERE id = 2;

INSERT INTO usuario (nome, idade, rua, bairro, estado, bio, imagem)
VALUES (
  'Rodrigo Cesar',
  29,
  'Rua Exemplo',
  'Centro',
  'SP',
  'Desenvolvedor front-end apaixonado por tecnologia.',
  'https://via.placeholder.com/150'
);
