<?php

class Usuario
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Cadastra um novo usuário
    public function cadastrar(
        string $nome,
        string $email,
        string $senha
    ): bool {

        $senhaHash = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );

        $sql = "
            INSERT INTO usuarios
            (nome, email, senha, xp, nivel)
            VALUES (?, ?, ?, 0, 1)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $nome,
            strtolower($email),
            $senhaHash
        ]);
    }

    // Procura usuário pelo e-mail
    public function buscarPorEmail(string $email): ?array
    {
        $sql = "
            SELECT *
            FROM usuarios
            WHERE email = ?
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            strtolower($email)
        ]);

        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }

    // Procura usuário pelo ID
    public function buscarPorId(int $id): ?array
    {
        $sql = "
            SELECT *
            FROM usuarios
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$id]);

        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }

    // Adiciona XP
    public function adicionarXP(
        int $id,
        int $xp
    ): void {

        $usuario = $this->buscarPorId($id);

        if (!$usuario) {
            return;
        }

        $novoXP = $usuario["xp"] + $xp;

        // A cada 100 XP sobe um nível
        $novoNivel = intdiv(
            $novoXP,
            100
        ) + 1;

        $sql = "
            UPDATE usuarios
            SET xp = ?, nivel = ?
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $novoXP,
            $novoNivel,
            $id
        ]);
    }
}