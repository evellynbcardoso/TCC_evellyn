-- BANCO DE DADOS DO MATHPLAY
-- Sistema educacional de matemática
CREATE DATABASE mathplay;
USE mathplay;

-- TABELA DE USUÁRIOS
-- Guarda os dados dos alunos
CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR (100) NOT NULL,
    email VARCHAR (150) NOT NULL UNIQUE,
    senha VARCHAR (255) NOT NULL,
    xp INT DEFAULT 0,
    nivel INT DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABELA DE QUESTÕES
-- tipo pode ser:
-- inteiros
-- equacoes
CREATE TABLE  questões(
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR (30) NOT NULL,
    pergunta TEXT NOT NULL,
    alternativa_a VARCHAR (255) NOT NULL,
    alternativa_b VARCHAR (255) NOT NULL,
    alternativa_c VARCHAR (255) NOT NULL,
    alternativa_d VARCHAR (255) NOT NULL,
    resposta_correta CHAR(1) NOT NULL,
    explicacao TEXT NOT NULL,
    dificuldade VARCHAR (20) DEFAULT 'facil'
);

-- TABELA DE RESPOSTAS
-- Guarda o histórico de respostas do aluno
CREATE TABLE respostas(
    id IN AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    quetao_id INT NOT NULL,
    resposta_usuario CHAR (1) NOT NULL,
    acerto BOOLEAN  NOT NULL,
    xp_ganho INT DEFAULT 0,
    respondido_em   TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    FOREING KEY ( usuario_id) REFERENCES usuario_id,
    FOREING KEY (questao_id) REFERENCES questao(id)
);

-- QUESTÕES DE EQUAÇÕES
INSERT INTO questao 
(tipo,pergunta, alternativa_a, alternativa_b, alternativa_c,alternativa_d, resposta_correta,explicacao, dificuldade)
VALUES

(
'equacoes',
'Resolva: 2x + 6 = 14 ?',
'2',
'4',
'6',
'8',
'B',
'Primeiro passamos o 6 para outro lado: 2x = 14 - 6. Então 2x = 8. 
Agora passamos o 2 para o outro lado dividindo entao o x = 4 .',
'facil'
),

(
'equacoes',
'Resolva: x + 9 = 15 ?',
'4',
'5',
'6',
'7',
'C',
'Para acharmos o x precisamos passar o 9 para o outro lado: x = 15 - 9. 
Portanto o x = 6.',
'facil'
),

(
'equacoes',
'Resolva: 3x = 21 ?',
'6',
'7',
'8',
'9',
'B'
'Como 3x significa 3 multiplicado por x. 
Então passamos o 3 para o outro lado dividindo. Assim temos x = 21 ÷ 3 = 7. ',
'facil'
),

(
'equacoes',
'Resolva: 4x - 8 = 16',
'4',
'5',
'6',
'7',
'C'
'Primeiro passamos o 8 para o outro lado: 4x = 16 + 8, que fica 4x = 24. 
Depois passamos o 4 para o outro lado dividindo: x = 24 ÷ 4 , asimm fica x = 6.',
'facil'
),

-- QUESTÕES DE NÚMEROS INTEIROS
INSERT INTO questao 
(tipo,pergunta, alternativa_a, alternativa_b, alternativa_c,alternativa_d, resposta_correta,explicacao, dificuldade)
VALUES

(
'inteiros',
'Quanto é -8 + 13?',
'-21',
'5',
'-5',
'21',
'B',
'Quando somamos -8  com +13, podemos calcular 13 - 8 = 5. 
Pois como o numero positivo e maior, o resultado fica positivo. Portanto o resultado é 5.',
'facil'
),

(
'inteiro',
'Quanto é -7 - 5 ?',
'12',
'-2',
'-12',
'2',
'C',
'Temos -7 - 5. Portanto você devia R$ 7,00 e comprou mais R$5,00. 
Ou seja você junta as duas dividas 7 + 5 = 12, como o resultado é uma divida você continua devendo, 
então colocamos o sinal negativo -12. ',
'facil'
),

(
'inteiro',
'Quanto é (-4) x (-3) ?',
'-12',
'7',
'12',
'-7',
'C',
'Na multiplicação, quando temos dois numeros negativos, fazemos o jogo de sinal  (-) x (-) = +. 
Então o resultado vai ser positivo. Então 4 x 3 = 12.',
'media'
),

(
'inteiro',
'Quanto é 20 ÷ (-4)?',
'5',
'-5',
'16',
'-16',
'B',
'Quando dividimos um numero positivo  por um negativo, o resultado é negativo. Então 20 ÷ (-4) = -5 ',
'medio'
);