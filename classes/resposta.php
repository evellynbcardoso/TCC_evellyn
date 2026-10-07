<?php

class Resposta
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function registrar(
        int $usuarioId,
        int $questaoId,
        string $resposta,
        bool $correta,
        int $xp
    ): void {

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

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $usuarioId,
            $questaoId,
            $resposta,
            $correta ? 1 : 0,
            $xp
        ]);
    }

    public function listarPorUsuario(
        int $usuarioId
    ): array {

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

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $usuarioId
        ]);

        return $stmt->fetchAll();
    }
}