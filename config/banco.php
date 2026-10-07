<?php

class Banco
{
    private string $host = "localhost";
    private string $usuario = "root";
    private string $senha = "";
    private string $banco = "mathplay";

    private PDO $conexao;

    public function __construct()
    {
        try {

            $this->conexao = new PDO(
                "mysql:host={$this->host};port=3308;dbname={$this->banco};charset=utf8mb4",
                $this->usuario,
                $this->senha
            );

            $this->conexao->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->conexao->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

        } catch (PDOException $e) {

            die(
                "Erro ao conectar ao banco de dados. " .
                "Verifique se o MySQL está ligado e se o banco mathplay existe."
            );
        }
    }

    public function getConexao(): PDO
    {
        return $this->conexao;
    }
}