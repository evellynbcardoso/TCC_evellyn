<?php

require_once "banco.php";

// CLASSE USUARIO
// Representa um aluno do sistema
class usuario{
    private PDO $banco;

    private int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private int $xp;
    private int $nivel;

 // CONSTRUTOR
    public function __construct(){
    // Criamos nossa conexão
        $conexao = new banco();

        $this->banco = $conexao->getConecxao();
    }

// CADASTRAR USUÁRIO
    public function cadastrar(
        string $nome,
        string $email,
        string $senha
    ); bool{
    // Criptografa a senha
        $senhaSegura = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );
    // SQL para inserir usuário
        $sql = "INSERT INTO usuarios 
        (nome, email, senha)
        VALUES
        (:nome,email,:senha)";

        $comando = $this->banco->prepare($sql);

    // Executa o cadastro
        return $comando->execute([
            ":nome"=> nome,
            ":email"=> email,
            ":senha"=> senha
        ]);
    }
// LOGIN
    public function login(
        string $email,
        string $senha
    ): bool{
        $sql = "SELECT * FROM usuario
        WHERE email = :email";

        $comando = $this->banco->prepare($sql);

        $comando->execute
    }
}