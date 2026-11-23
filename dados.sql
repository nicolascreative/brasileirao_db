USE brasileirao_db;

INSERT INTO estadios (id_estadio, nome, cidade, estado, capacidade) VALUES
(1, 'Arena MRV', 'Belo Horizonte', 'MG', NULL),
(2, 'Mineirao', 'Belo Horizonte', 'MG', NULL),
(3, 'Independencia', 'Belo Horizonte', 'MG', NULL),
(4, 'Maracana', 'Rio de Janeiro', 'RJ', NULL),
(5, 'Nilton Santos', 'Rio de Janeiro', 'RJ', NULL),
(6, 'Sao Januario', 'Rio de Janeiro', 'RJ', NULL),
(7, 'Neo Quimica Arena', 'Sao Paulo', 'SP', NULL),
(8, 'Allianz Parque', 'Sao Paulo', 'SP', NULL),
(9, 'Morumbi', 'Sao Paulo', 'SP', NULL),
(10, 'Vila Belmiro', 'Santos', 'SP', NULL),
(11, 'Arena do Gremio', 'Porto Alegre', 'RS', NULL),
(12, 'Beira-Rio', 'Porto Alegre', 'RS', NULL),
(13, 'Arena da Baixada', 'Curitiba', 'PR', NULL),
(14, 'Couto Pereira', 'Curitiba', 'PR', NULL),
(15, 'Arena Fonte Nova', 'Salvador', 'BA', NULL),
(16, 'Barradao', 'Salvador', 'BA', NULL),
(17, 'Ilha do Retiro', 'Recife', 'PE', NULL),
(18, 'Castelao', 'Fortaleza', 'CE', NULL),
(19, 'Mangueirao', 'Belem', 'PA', NULL);

INSERT INTO clubes (id_clube, nome, sigla, estado, cidade, ano_fundacao, cores, apelido, id_estadio) VALUES
(1, 'Atletico Mineiro', 'CAM', 'MG', 'Belo Horizonte', 1908, 'Preto e branco', 'Galo', 1),
(2, 'Cruzeiro', 'CRU', 'MG', 'Belo Horizonte', 1921, 'Azul e branco', 'Raposa', 2),
(3, 'America Mineiro', 'AME', 'MG', 'Belo Horizonte', 1912, 'Verde e branco', 'Coelho', 3),
(4, 'Flamengo', 'FLA', 'RJ', 'Rio de Janeiro', 1895, 'Vermelho e preto', 'Mengao', 4),
(5, 'Fluminense', 'FLU', 'RJ', 'Rio de Janeiro', 1902, 'Verde, branco e grena', 'Tricolor', 4),
(6, 'Botafogo', 'BOT', 'RJ', 'Rio de Janeiro', 1904, 'Preto e branco', 'Glorioso', 5),
(7, 'Vasco da Gama', 'VAS', 'RJ', 'Rio de Janeiro', 1898, 'Preto e branco', 'Gigante da Colina', 6),
(8, 'Corinthians', 'COR', 'SP', 'Sao Paulo', 1910, 'Preto e branco', 'Timao', 7),
(9, 'Palmeiras', 'PAL', 'SP', 'Sao Paulo', 1914, 'Verde e branco', 'Verdao', 8),
(10, 'Sao Paulo', 'SAO', 'SP', 'Sao Paulo', 1930, 'Vermelho, branco e preto', 'Tricolor Paulista', 9),
(11, 'Santos', 'SAN', 'SP', 'Santos', 1912, 'Preto e branco', 'Peixe', 10),
(12, 'Gremio', 'GRE', 'RS', 'Porto Alegre', 1903, 'Azul, preto e branco', 'Imortal', 11),
(13, 'Internacional', 'INT', 'RS', 'Porto Alegre', 1909, 'Vermelho e branco', 'Colorado', 12),
(14, 'Athletico Paranaense', 'CAP', 'PR', 'Curitiba', 1924, 'Vermelho e preto', 'Furacao', 13),
(15, 'Coritiba', 'CFC', 'PR', 'Curitiba', 1909, 'Verde e branco', 'Coxa', 14),
(16, 'Bahia', 'BAH', 'BA', 'Salvador', 1931, 'Azul, vermelho e branco', 'Esquadrao de Aco', 15),
(17, 'Vitoria', 'VIT', 'BA', 'Salvador', 1899, 'Vermelho e preto', 'Leao da Barra', 16),
(18, 'Sport Recife', 'SPO', 'PE', 'Recife', 1905, 'Vermelho e preto', 'Leao', 17),
(19, 'Fortaleza', 'FOR', 'CE', 'Fortaleza', 1918, 'Azul, vermelho e branco', 'Leao do Pici', 18),
(20, 'Paysandu', 'PAY', 'PA', 'Belem', 1914, 'Azul e branco', 'Papao da Curuzu', 19);

INSERT INTO competicoes (id_competicao, nome, categoria, abrangencia, organizacao) VALUES
(1, 'Campeonato Brasileiro Serie A', 'Pontos corridos', 'Nacional', 'CBF'),
(2, 'Copa do Brasil', 'Mata-mata', 'Nacional', 'CBF'),
(3, 'Copa Libertadores', 'Mata-mata', 'Continental', 'CONMEBOL'),
(4, 'Copa Sul-Americana', 'Mata-mata', 'Continental', 'CONMEBOL'),
(5, 'Mundial de Clubes', 'Mata-mata', 'Mundial', 'FIFA');

-- brasileirao serie A
INSERT INTO participacoes (id_clube, id_competicao, qtd_participacoes, titulos, vices) VALUES
(1, 1, 25, 1, 2), -- galo
(2, 1, 23, 3, 1), -- bruzeiro
(3, 1, 8, 0, 0), -- america M
(4, 1, 26, 4, 2), -- flamengo
(5, 1, 26, 2, 0), -- fluminense
(6, 1, 23, 1, 0), -- botafogo
(7, 1, 21, 1, 1), -- vasco
(8, 1, 25, 4, 1), -- corinthians
(9, 1, 24, 4, 3), -- palmeiras
(10, 1, 26, 3, 1), -- sao paulo
(11, 1, 25, 2, 4), -- santos
(12, 1, 24, 0, 3), -- gremio
(13, 1, 25, 0, 5), -- internacional
(14, 1, 24, 1, 1), -- athletico paranaense
(15, 1, 18, 0, 0), -- coritiba
(16, 1, 16, 0, 0), -- bahia
(17, 1, 15, 0, 0), -- vitoria
(18, 1, 14, 0, 0), -- sport
(19, 1, 10, 0, 0), -- fortaleza
(20, 1, 1, 0, 0); -- paysandu
