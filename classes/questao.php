<?php

require_once "banco.php";

// CLASSE QUESTAO
// Responsável pelas questões matemáticas
class questao{
    private PDO $banco;

    public function __construct(){
        $conexao = new banco();
        $this-> banco = $conexao->getConexao();
    }

// BUSCAR UMA QUESTÃO
    public function buscarQuestao(strip $tipo): ?array{
        $sql= "SELECT * FROM  questoes
        WHERE tipo = :tipo
        ORDER BY RAND()
        LIMIT 1";

        $comando = $this->banco->prepare($sql);
        $comando->execute([
            ":id" = $id
        ]);

        $questao = $comando->fetch(PDO :: FETCH_ASSOC);
        return $questao ? : null;
    }

// REGISTRAR RESPOSTA
    public function registrarResposta(
        int $usuarioId,
        int $questaoId,
        string $resposta,
        bool $acertou,
        int $xp
    ): void{
        $sql = "INSERT INTO respostas(
        usuario_id,
        questao_id,
        resposta_usuario,
        acertou,
        xp_guanho )
        VALUES (
        :usuario,
        :questao,
        :resposta,
        :acertou,
        :xp )";

        $comando =$this->banco->prepare($sql);
        $comando->execute([
            ":usuario" => $usuario,
            ":questao" => $questao,
            ":resposta" => $resposta,
            ":acertou" => $acertou
            ":xp" => $xp
        ]);
    }
}