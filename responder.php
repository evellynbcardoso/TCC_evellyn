<?php

// =========================================================
// PROCESSAMENTO DA RESPOSTA
// =========================================================

session_start();

require_once "classes/questao.php";
require_once "classes/usuario.php";

// Verifica se o aluno está logado
if (!isset($_SESSION["usuario_id"])) {

    header("Location: login.php");
    exit;
}

// Verifica se recebeu os dados
if (
    !isset($_POST["questao_id"]) ||
    !isset($_POST["resposta"])
) {

    header("Location: dashboard.php");
    exit;
}

$questaoId = (int) $_POST["questao_id"];

$resposta = $_POST["resposta"];

$usuarioId = $_SESSION["usuario_id"];


// =========================================================
// BUSCA A QUESTÃO
// =========================================================

$questoes = new Questao();

$questao = $questoes->buscarPorId($questaoId);

if (!$questao) {

    die("Questão não encontrada.");
}


// =========================================================
// VERIFICA SE ACERTOU
// =========================================================

$acertou =
    strtoupper($resposta)
    === strtoupper($questao["resposta_correta"]);


// =========================================================
// DEFINE O XP
// =========================================================

if ($acertou) {

    $xp = 10;

} else {

    $xp = 0;
}


// =========================================================
// REGISTRA A RESPOSTA
// =========================================================

$questoes->registrarResposta(
    $usuarioId,
    $questaoId,
    $resposta,
    $acertou,
    $xp
);


// =========================================================
// ADICIONA XP AO ALUNO
// =========================================================

if ($acertou) {

    $usuario = new Usuario();

    $usuario->adicionarXP(
        $usuarioId,
        $xp
    );
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Resultado - MathPlay</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body>

    <main class="center">

        <div class="result-card">

            <?php if ($acertou): ?>

                <!-- ======================================
                     RESPOSTA CORRETA
                     ====================================== -->

                <div class="result-icon">
                    🎉
                </div>

                <h1>
                    Muito bem!
                </h1>

                <p>
                    Você acertou a questão!
                </p>

                <div class="xp-earned">

                    ⭐ +10 XP

                </div>


            <?php else: ?>

                <!-- ======================================
                     RESPOSTA ERRADA
                     ====================================== -->

                <div class="result-icon">
                    💡
                </div>

                <h1>
                    Quase lá!
                </h1>

                <p>
                    Não desista! Errar também
                    faz parte do aprendizado.
                </p>

                <div class="explanation">

                    <h3>
                        🧠 Vamos entender:
                    </h3>

                    <p>
                        <?= nl2br(
                            htmlspecialchars(
                                $questao["explicacao"]
                            )
                        ) ?>
                    </p>

                </div>

            <?php endif; ?>


            <div class="correct-answer">

                <strong>
                    Resposta correta:
                </strong>

                <?= htmlspecialchars(
                    $questao["resposta_correta"]
                ) ?>

            </div>


            <div class="result-buttons">

                <a
                    href="exercicio.php?tipo=<?= $questao["tipo"] ?>"
                    class="btn">

                    Próxima questão 🚀

                </a>

                <a
                    href="dashboard.php"
                    class="btn btn-outline">

                    Voltar ao painel

                </a>

            </div>

        </div>

    </main>

    <?php include_once __DIR__ . '/acessibilidade.php'; ?>

</body>

</html>