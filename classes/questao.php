
<?php

// =====================================================
// CLASSE QUESTAO
// Busca questões, controla a rodada e registra respostas.
// =====================================================

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
    // GERA A CHAVE DA RODADA
    // Separa as questões por aluno e por tema.
    // =====================================================

    private function obterChaveRodada(
        string $tipo,
        ?int $usuarioId = null
    ): string {

        $idAluno = $usuarioId
            ?? (int) ($_SESSION["usuario_id"] ?? 0);

        $tipoLimpo = preg_replace(
            '/[^a-zA-Z0-9_-]/',
            '',
            $tipo
        );

        return "questoes_exibidas_"
            . $idAluno . "_" . $tipoLimpo;
    }

    // =====================================================
    // BUSCAR QUESTÃO SEM REPETIR NA RODADA
    // =====================================================

    public function buscarQuestao(
        string $tipo,
        ?int $usuarioId = null
    ): ?array {

        $chave = $this->obterChaveRodada(
            $tipo,
            $usuarioId
        );

        if (!isset($_SESSION[$chave])
            || !is_array($_SESSION[$chave])) {
            $_SESSION[$chave] = [];
        }

        $exibidas = array_values(array_unique(array_map(
            'intval',
            $_SESSION[$chave]
        )));

        // Busca somente questões ainda não exibidas.
        $sql = "SELECT *
                FROM questoes
                WHERE tipo = :tipo";

        if (!empty($exibidas)) {
            $marcadores = [];

            foreach ($exibidas as $indice => $id) {
                $marcadores[] = ":id" . $indice;
            }

            $sql .= " AND id NOT IN ("
                . implode(", ", $marcadores) . ")";
        }

        $sql .= " ORDER BY RAND() LIMIT 1";

        $comando = $this->banco->prepare($sql);

        $parametros = [":tipo" => $tipo];

        foreach ($exibidas as $indice => $id) {
            $parametros[":id" . $indice] = $id;
        }

        $comando->execute($parametros);

        $questao = $comando->fetch(PDO::FETCH_ASSOC);

        // Não há mais questões disponíveis nesta rodada.
        if (!$questao) {
            return null;
        }

        // Marca a questão para não repeti-la nesta rodada.
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
        $comando->execute([":id" => $id]);

        $questao = $comando->fetch(PDO::FETCH_ASSOC);

        return $questao ?: null;
    }

    // =====================================================
    // REGISTRAR RESPOSTA NO BANCO
    // =====================================================

    public function registrarResposta(
        int $usuarioId,
        int $questaoId,
        string $resposta,
        bool $acertou,
        int $xp
    ): void {

        $acertouBanco = $acertou ? 1 : 0;
        $xpGanho = $acertou ? max(0, $xp) : 0;

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
            ":xp" => $xpGanho
        ]);
    }

    // =====================================================
    // LIMPAR A RODADA
    // Usado pelo botão "Começar nova rodada".
    // Não apaga respostas nem XP do aluno.
    // =====================================================

    public function limparRodada(
        string $tipo,
        ?int $usuarioId = null
    ): void {

        $chave = $this->obterChaveRodada(
            $tipo,
            $usuarioId
        );

        unset($_SESSION[$chave]);
    }

    // =====================================================
    // COMPATIBILIDADE COM O NOME ANTIGO DO MÉTODO
    // =====================================================

    public function reiniciarRodada(string $tipo): void
    {
        $this->limparRodada($tipo);
    }
}
