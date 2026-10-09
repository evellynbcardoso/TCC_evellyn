<?php

// CLASSE QUESTAO
// Responsável por consultar e buscar questões matemáticas
// cadastradas no banco de dados do sistema MathPlay.

class Questao
{
    // Atributo privado que armazena a conexão com o banco
    // de dados MySQL utilizando a classe PDO.
    private PDO $db;

    // CONSTRUTOR DA CLASSE
    // É executado automaticamente quando um objeto Questao
    // é criado. Recebe a conexão com o banco de dados.
    public function __construct(PDO $db)
    {
        // Guarda a conexão recebida no atributo da classe.
        // O $this->db permite utilizar essa conexão
        // nos outros métodos desta classe.
        $this->db = $db;
    }

    // MÉTODO LISTAR POR TEMA
    // Lista todas as questões que pertencem a determinado
    // tema, como "Números inteiros" ou "Equações".
    // Recebe o tema como texto (string).
    // Retorna uma lista de questões em formato de array.
    public function listarPorTema(
        string $tema
    ): array {

        // Consulta SQL que seleciona todas as colunas
        // da tabela "questoes" para o tema informado.
        // O símbolo ? é um parâmetro que será preenchido
        // posteriormente com o valor recebido no método.
        // ORDER BY id organiza as questões pelo ID,
        // do menor para o maior.
        $sql = "
            SELECT *
            FROM questoes
            WHERE tema = ?
            ORDER BY id
        ";

        // Prepara a consulta SQL antes de executá-la.
        // Isso permite utilizar parâmetros com segurança.
        $stmt = $this->db->prepare($sql);

        // Executa a consulta substituindo o ? pelo tema
        // recebido, por exemplo, "Equações".
        $stmt->execute([
            $tema
        ]);

        // Retorna todas as questões encontradas.
        // O fetchAll() reúne os registros em um array.
        return $stmt->fetchAll();
    }

    // MÉTODO BUSCAR POR ID
    // Busca uma questão específica pelo seu identificador
    // (ID) na tabela "questoes".
    // Recebe o ID como número inteiro (int).
    // Retorna um array com os dados da questão encontrada
    // ou null caso nenhuma questão seja encontrada.
    public function buscarPorId(
        int $id
    ): ?array {

        // Consulta SQL que seleciona todas as colunas
        // da questão cujo ID corresponde ao valor informado.
        // O ? será substituído pelo ID na execução.
        $sql = "
            SELECT *
            FROM questoes
            WHERE id = ?
        ";

        // Prepara a consulta SQL usando a conexão PDO.
        $stmt = $this->db->prepare($sql);

        // Executa a consulta utilizando o ID recebido.
        // Por exemplo, se o ID for 5, busca a questão 5.
        $stmt->execute([
            $id
        ]);

        // Recupera apenas o primeiro registro encontrado.
        // O fetch() retorna os dados da questão ou false
        // quando não existe um registro correspondente.
        $questao = $stmt->fetch();

        // Se encontrou a questão, retorna seu array de dados.
        // Caso contrário, retorna null.
        // O operador ?: verifica se $questao possui um valor
        // válido; se não possuir, utiliza null.
        return $questao ?: null;
    }
}