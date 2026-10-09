
<?php

require_once __DIR__ . "/banco.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Questao
{
    private PDO $banco;

    public function __construct()
    {
        $conexao = new Banco();
        $this->banco = $conexao->getConexao();
    }

    // =====================================================
    // BUSCAR QUESTÃO SEM REPETIR NA RODADA
    // =====================================================

    public function buscarQuestao(
        string $tipo,
        ?int $usuarioId = null
    ): ?array {

        // Identifica as questões já exibidas nesta sessão
        // para cada tipo de exercício e aluno.
        $idAluno = $usuarioId ?? (int) ($_SESSION["usuario_id"] ?? 0);

        $chave = "questoes_exibidas_" .
                 $idAluno . "_" .
                 preg_replace('/[^a-zA-Z0-9_-]/', '', $tipo);

        if (!isset($_SESSION[$chave])) {
            $_SESSION[$chave] = [];
        }

        $exibidas = array_map(
            'intval',
            $_SESSION[$chave]
        );

        // Monta a consulta para ignorar as questões exibidas.
        $sql = "SELECT *
                FROM questoes
                WHERE tipo = :tipo";

        if (!empty($exibidas)) {
            $marcadores = [];

            foreach ($exibidas as $indice => $id) {
                $marcadores[] = ":id" . $indice;
            }

            $sql .= " AND id NOT IN (" .
                    implode(", ", $marcadores) . ")";
        }

        $sql .= " ORDER BY RAND() LIMIT 1";

        $comando = $this->banco->prepare($sql);

        $parametros = [
            ":tipo" => $tipo
        ];

        foreach ($exibidas as $indice => $id) {
            $parametros[":id" . $indice] = $id;
        }

        $comando->execute($parametros);

        $questao = $comando->fetch(PDO::FETCH_ASSOC);

        // Se todas já foram exibidas, encerra a rodada.
        if (!$questao) {
            return null;
        }

        // Marca a questão como exibida imediatamente.
        $_SESSION[$chave][] = (int) $questao["id"];

        return $questao;
    }

    // =====================================================
    // BUSCAR QUESTÃO PELO ID
    // =====================================================

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT *
                FROM questoes
                WHERE id = :id
                LIMIT 1";

        $comando = $this->banco->prepare($sql);

        $comando->execute([
            ":id" => $id
        ]);

        $questao = $comando->fetch(PDO::FETCH_ASSOC);

        return $questao ?: null;
    }

    // =====================================================
    // REGISTRAR RESPOSTA
    // =====================================================

    public function registrarResposta(
        int $usuarioId,
        int $questaoId,
        string $resposta,
        bool $acertou,
        int $xp
    ): void {

        $acertouBanco = $acertou ? 1 : 0;
        $xp = $acertouBanco === 1 ? max(0, $xp) : 0;

        $sql = "INSERT INTO respostas
                (
                    usuario_id,
                    questao_id,
                    resposta_usuario,
                    acertou,
                    xp_ganho
                )
                VALUES
                (
                    :usuario,
                    :questao,
                    :resposta,
                    :acertou,
                    :xp
                )";

        $comando = $this->banco->prepare($sql);

        $comando->execute([
            ":usuario" => $usuarioId,
            ":questao" => $questaoId,
            ":resposta" => $resposta,
            ":acertou" => $acertouBanco,
            ":xp" => $xp
        ]);
    }

    // =====================================================
    // REINICIAR RODADA DE UM TIPO DE QUESTÃO
    // Chame somente quando quiser começar uma nova rodada.
    // =====================================================

    public function reiniciarRodada(string $tipo): void
    {
        $idAluno = (int) ($_SESSION["usuario_id"] ?? 0);

        $tipoLimpo = preg_replace(
            '/[^a-zA-Z0-9_-]/',
            '',
            $tipo
        );

        $chave = "questoes_exibidas_" .
                 $idAluno . "_" . $tipoLimpo;

        unset($_SESSION[$chave]);
    }
}