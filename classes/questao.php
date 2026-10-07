<?php

class Questao
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Lista questões de determinado tema
    public function listarPorTema(
        string $tema
    ): array {

        $sql = "
            SELECT *
            FROM questoes
            WHERE tema = ?
            ORDER BY id
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $tema
        ]);

        return $stmt->fetchAll();
    }

    // Busca uma questão específica
    public function buscarPorId(
        int $id
    ): ?array {

        $sql = "
            SELECT *
            FROM questoes
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $id
        ]);

        $questao = $stmt->fetch();

        return $questao ?: null;
    }
}