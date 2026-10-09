<?php

// =========================================================
// CLASSE BANCO
// Responsável por criar a conexão com o MySQL
// =========================================================

class Banco
{
    // Dados do banco
    private string $porta = "3308";
    private string $host = "localhost";
    private string $usuario = "root";
    private string $senha = "";
    private string $banco = "mathplay";

    // Conexão PDO
    private PDO $conexao;

    // =====================================================
    // CONSTRUTOR
    // Executado automaticamente quando criamos Banco()
    // =====================================================

    public function __construct()
    {
        try {

            // DSN informa ao PHP onde está o banco
            $dsn = "mysql:host={$this->host};
            port={$this->porta};
            dbname={$this->banco};
            charset=utf8mb4";

            // Criamos a conexão usando PDO
            $this->conexao = new PDO(
                $dsn,
                $this->usuario,
                $this->senha
            );

            // Configura o PDO para mostrar erros
            $this->conexao->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $erro) {

            // Caso não consiga conectar
            die("Erro ao conectar com o banco: " . $erro->getMessage());
        }
    }

    // =====================================================
    // RETORNA A CONEXÃO
    // =====================================================

    public function getConexao(): PDO
    {
        return $this->conexao;
    }
}