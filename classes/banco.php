<?php

// CLASSE BANCO
// Responsável por criar a conexão com o MySQL
class Banco{
// Dados do banco
    private string $host = "localhost";
    private string $usuario = "root";
    private string $senha = "";
    private string $banco = "mathplay";

 // Conexão PDO
    private PDO $conexao;

// CONSTRUTOR
// Executado automaticamente quando criamos Banco()
    public function __contruct() {

        try{
        // DSN informa ao PHP onde está o banco
            $dns = "mysql:host={$this->host}; dbname={$this->banco};charset=utf8mb4";

        // Criamos a conexão usando PDO
            $this->conecxao = new PDO(
                $dns,
                $this->usuario,
                $this->senha
            );

        // Configura o PDO para mostrar erros
            $this->conexao->setAtribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXECEPITION
            );
        } catch(PDOException $erro){
        // Caso não consiga conectar
            die("Erro ao conectar com banco:" .$erro->getMessage());
        }
    }
 // RETORNA A CONEXÃO
    public function getConexao(): PDO{
        return $this->conexao;
    }
}
