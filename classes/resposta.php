<?php

// CLASSE RESPOSTA
// Responsável por registrar as respostas dos alunos
// e consultar o histórico de respostas no MathPlay.
class Resposta
{
    // Atributo privado que armazena a conexão com
    // o banco de dados MySQL utilizando PDO.
    private PDO $db;

    // CONSTRUTOR DA CLASSE
    // É executado automaticamente quando um objeto
    // Resposta é criado.
    // Recebe a conexão com o banco de dados.
    public function __construct(PDO $db)
    {
        // Armazena a conexão recebida no atributo da classe.
        // O $this->db permite utilizar essa conexão
        // nos outros métodos desta classe.
        $this->db = $db;
    }

    // MÉTODO REGISTRAR
    // Salva no banco de dados a resposta enviada pelo aluno,
    // informando a questão respondida, se acertou ou errou
    // e quantos pontos de experiência (XP) ganhou.
    // Parâmetros recebidos:
    // $usuarioId = ID do aluno que respondeu.
    // $questaoId = ID da questão respondida.
    // $resposta  = Resposta digitada pelo aluno.
    // $correta   = Informa se a resposta está correta.
    // $xp        = Quantidade de XP ganho na resposta.
    // O ": void" indica que o método não retorna um valor.
    public function registrar(
        int $usuarioId,
        int $questaoId,
        string $resposta,
        bool $correta,
        int $xp
    ): void {

        // Comando SQL que insere um novo registro
        // na tabela "respostas".
        // Cada coluna receberá um valor correspondente
        // ao parâmetro informado pelo método.
        // Os símbolos ? são parâmetros que serão
        // preenchidos na execução da consulta.
        $sql = "
            INSERT INTO respostas
            (
                usuario_id,
                questao_id,
                resposta,
                correta,
                xp_ganho
            )
            VALUES (?, ?, ?, ?, ?)
        ";

        // Prepara o comando SQL antes da execução.
        // O prepare() permite trabalhar com parâmetros
        // de forma mais segura.
        $stmt = $this->db->prepare($sql);

        // Executa o comando SQL e envia os valores
        // para preencher os cinco símbolos ?.
        $stmt->execute([
            $usuarioId,            // ID do aluno.
            $questaoId,             // ID da questão.
            $resposta,              // Resposta enviada.
            $correta ? 1 : 0,       // 1 = correta; 0 = errada.
            $xp                     // XP ganho pelo aluno.
        ]);
    }

    // MÉTODO LISTAR POR USUÁRIO
    // Consulta o histórico de respostas de um aluno.
    // Recebe o ID do aluno e retorna um array contendo
    // os registros encontrados.
    // O ": array" indica que o método retorna um array.
    public function listarPorUsuario(
        int $usuarioId
    ): array {

        // Consulta SQL que busca as respostas do aluno
        // e o enunciado de cada questão respondida.
        // r.* seleciona todas as colunas da tabela
        // "respostas", identificada pelo apelido r.
        // q.enunciado seleciona o enunciado da questão
        // na tabela "questoes", identificada pelo apelido q.
        // Consulta as respostas do aluno e o enunciado
        // correspondente a cada questão respondida.
        $sql = "
            SELECT
                r.*,
                q.enunciado
            FROM respostas r

            INNER JOIN questoes q
                ON q.id = r.questao_id

            WHERE r.usuario_id = ?

            ORDER BY r.id DESC
        ";

        // Prepara a consulta SQL usando a conexão PDO.
        $stmt = $this->db->prepare($sql);

        // Executa a consulta substituindo o ? pelo ID
        // do aluno cujo histórico será consultado.
        $stmt->execute([
            $usuarioId
        ]);

        // Retorna todas as respostas encontradas,
        // incluindo o enunciado de cada questão.
        // O fetchAll() reúne os registros em um array.
        return $stmt->fetchAll();
    }
}
