
<?php

// =========================================================
// PROCESSAMENTO DAS RESPOSTAS - ESTUDAÊ
// =========================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/classes/questao.php";
require_once __DIR__ . "/classes/usuario.php";

// =========================================================
// VERIFICAR LOGIN
// =========================================================

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$usuarioId = (int) $_SESSION["usuario_id"];

// =========================================================
// VALIDAR OS DADOS RECEBIDOS
// =========================================================

if (
    !isset($_POST["questao_id"], $_POST["resposta"])
    || !is_scalar($_POST["questao_id"])
    || !is_string($_POST["resposta"])
) {
    header("Location: dashboard.php");
    exit;
}

$questaoId = filter_var(
    $_POST["questao_id"],
    FILTER_VALIDATE_INT
);

$resposta = strtoupper(trim($_POST["resposta"]));

if (
    !$questaoId
    || !in_array($resposta, ["A", "B", "C", "D"], true)
) {
    header("Location: dashboard.php");
    exit;
}

// =========================================================
// BUSCAR A QUESTÃO
// =========================================================

$questoes = new Questao();

$questao = $questoes->buscarPorId((int) $questaoId);

if (!$questao) {
    header("Location: dashboard.php");
    exit;
}

// O tema é obtido do banco, não do formulário.
$tipo = $questao["tipo"] ?? "inteiros";

if (!in_array($tipo, ["inteiros", "equacoes"], true)) {
    $tipo = "inteiros";
}

// =========================================================
// VERIFICAR SE A RESPOSTA ESTÁ CORRETA
// =========================================================

$respostaCorreta = strtoupper(
    trim((string) ($questao["resposta_correta"] ?? ""))
);

$acertou = ($resposta === $respostaCorreta);

// =========================================================
// DEFINIR A PONTUAÇÃO
// =========================================================

$xp = $acertou ? 10 : 0;

// =========================================================
// REGISTRAR RESPOSTA NO BANCO DE DADOS
// =========================================================

$questoes->registrarResposta(
    $usuarioId,
    (int) $questaoId,
    $resposta,
    $acertou,
    $xp
);

// =========================================================
// ADICIONAR XP SE ACERTOU
// =========================================================

if ($acertou) {
    $usuario = new Usuario();

    $usuario->adicionarXP($usuarioId, $xp);
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Resultado - Estudaê</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <main class="center">

        <div class="result-card">

            <?php if ($acertou): ?>

                <div class="result-icon">🎉</div>

                <h1>Muito bem!</h1>

                <p>Você acertou a questão!</p>

                <div class="xp-earned">
                    ⭐ +<?= $xp ?> XP
                </div>

            <?php else: ?>

                <div class="result-icon">💡</div>

                <h1>Quase lá!</h1>

                <p>
                    Não desista! Errar também faz parte
                    do aprendizado.
                </p>

                <div class="explanation">

                    <h3>🧠 Vamos entender:</h3>

                    <p>
                        <?= nl2br(
                            htmlspecialchars(
                                $questao["explicacao"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            )
                        ) ?>
                    </p>

                </div>

            <?php endif; ?>

            <div class="correct-answer">

                <strong>Resposta correta:</strong>

                <?= htmlspecialchars(
                    $respostaCorreta,
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>

            </div>

            <div class="result-buttons">

                <a
                    href="exercicio.php?tipo=<?= urlencode($tipo) ?>"
                    class="btn"
                >
                    Próxima questão 🚀
                </a>

                <a
                    href="dashboard.php"
                    class="btn btn-outline"
                >
                    Voltar ao painel
                </a>

            </div>

        </div>

    </main>

    <?php include_once __DIR__ . "/acessibilidade.php"; ?>

</body>
</html>
