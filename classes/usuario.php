<?php

require_once "Banco.php";

// CLASSE USUARIO
// Representa um aluno do sistema
class Usuario{
    private PDO $banco;

    private int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private int $xp;
    private int $nivel;

    // CONSTRUTOR
    public function __construct()
    {
        // Criamos nossa conexão
        $conexao = new Banco();

        $this->banco = $conexao->getConexao();
    }

    // CADASTRAR USUÁRIO
    public function cadastrar(
        string $nome,
        string $email,
        string $senha
    ): bool {

        // Criptografa a senha
        $senhaSegura = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );

        // SQL para inserir usuário
        $sql = "INSERT INTO usuarios
                (nome, email, senha)
                VALUES
                (:nome, :email, :senha)";

        $comando = $this->banco->prepare($sql);

        // Executa o cadastro
        return $comando->execute([
            ":nome" => $nome,
            ":email" => $email,
            ":senha" => $senhaSegura
        ]);
    }

    // LOGIN
    public function login(
        string $email,
        string $senha
    ): bool {

        $sql = "SELECT * FROM usuarios
                WHERE email = :email";

        $comando = $this->banco->prepare($sql);

        $comando->execute([
            ":email" => $email
        ]);

        $usuario = $comando->fetch(PDO::FETCH_ASSOC);

        // Verifica se encontrou o usuário
        // e se a senha está correta
        if (
            $usuario &&
            password_verify($senha, $usuario["senha"])
        ) {

            // Guarda os dados na sessão
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];

            return true;
        }

        return false;
    }

    // BUSCAR USUÁRIO
    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM usuarios
                WHERE id = :id";

        $comando = $this->banco->prepare($sql);

        $comando->execute([
            ":id" => $id
        ]);

        $usuario = $comando->fetch(PDO::FETCH_ASSOC);

        return $usuario ?: null;
    }

    // ADICIONAR XP
    public function adicionarXP(
        int $id,
        int $xp
    ): void {

        // Primeiro pegamos o usuário
        $usuario = $this->buscarPorId($id);

        if (!$usuario) {
            return;
        }

        // Calculamos o novo XP
        $novoXP = $usuario["xp"] + $xp;

        // Calculamos o nível
        $novoNivel = 1;

        if ($novoXP >= 700) {
            $novoNivel = 5;
        } elseif ($novoXP >= 450) {
            $novoNivel = 4;
        } elseif ($novoXP >= 250) {
            $novoNivel = 3;
        } elseif ($novoXP >= 100) {
            $novoNivel = 2;
        }

        // Atualiza banco
        $sql = "UPDATE usuarios
                SET xp = :xp,
                    nivel = :nivel
                WHERE id = :id";

        $comando = $this->banco->prepare($sql);

        $comando->execute([
            ":xp" => $novoXP,
            ":nivel" => $novoNivel,
            ":id" => $id
        ]);
    }
}