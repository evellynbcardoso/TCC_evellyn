<?php

class Jogo
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function totalQuestoes(): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM questoes
        ";

        return (int) $this->db
            ->query($sql)
            ->fetchColumn();
    }
}