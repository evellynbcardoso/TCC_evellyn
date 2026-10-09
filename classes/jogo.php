<?php

// CLASSE JOGO
// Responsável por funcionalidades relacionadas aos jogos
// e às questões matemáticas do sistema MathPlay.

class Jogo
{
    // Atributo privado que armazena a conexão com o banco
    // de dados MySQL utilizando a classe PDO.
    private PDO $db;

    // CONSTRUTOR DA CLASSE
    // É executado automaticamente quando um objeto Jogo
    // é criado. Recebe a conexão com o banco de dados.
    public function __construct(PDO $db)
    {
        // Armazena a conexão recebida no atributo da classe.
        // O $this->db representa o atributo deste objeto.
        $this->db = $db;
    }

    // MÉTODO TOTAL QUESTÕES
    // Consulta e retorna a quantidade total de questões
    // cadastradas na tabela "questoes" do banco de dados.
    // O ": int" indica que o método deve retornar um
    // número inteiro.
    public function totalQuestoes(): int
    {
        // Comando SQL que conta todos os registros
        // existentes na tabela "questoes".
        $sql = "
            SELECT COUNT(*)
            FROM questoes
        ";

        // Executa a consulta SQL utilizando a conexão PDO.
        // O método query() envia a consulta ao banco.
        // O método fetchColumn() obtém o primeiro valor
        // retornado pela consulta, neste caso, a quantidade
        // total de questões cadastradas.
        // O (int) converte o resultado para um número inteiro.
        // O return devolve o resultado para quem chamou
        // o método totalQuestoes().
        return (int) $this->db
            ->query($sql)
            ->fetchColumn();
    }
}
