
<?php

// =========================================================
// TELA DE EXERCÍCIOS - ESTUDAÊ
// =========================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/classes/questao.php";

// =========================================================
// VERIFICAR LOGIN
// =========================================================

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$usuarioId = (int) $_SESSION["usuario_id"];

// =========================================================
// IDENTIFICAR O TEMA
// =========================================================

$tipo = $_GET["tipo"] ?? "inteiros";

if (!in_array($tipo, ["inteiros", "equacoes"], true)) {
    $tipo = "inteiros";
}

$questao = new Questao();

// =========================================================
// INICIAR UMA NOVA RODADA
// =========================================================

// Limpa apenas as questões exibidas deste aluno e tema.
// O histórico de respostas e o XP são preservados.

if (isset($_GET["nova_rodada"])
    && $_GET["nova_rodada"] === "1") {

    $questao->limparRodada($tipo, $usuarioId);

    // Redireciona sem o parâmetro de reinicialização.
    header(
        "Location: exercicio.php?tipo="
        . urlencode($tipo)
    );
    exit;
}

// =========================================================
// BUSCAR A PRÓXIMA QUESTÃO
// =========================================================

$dados = $questao->buscarQuestao($tipo, $usuarioId);

// =========================================================
// MENSAGEM QUANDO NÃO HÁ MAIS QUESTÕES
// =========================================================

$mensagem = "";

if ($dados === null) {
    $mensagem = " Que tal praticar novamente e testar mais os seus conhecimentos?";
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Desafio - Estudaê</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="menu">

    <h1><img src="img/logo_estudae.png" 
        alt="Logo do Estudaê" 
        width="100" ></h1>

    <a href="dashboard.php" class="btn btn-outline">
        ← Voltar
    </a>

</header>

<main class="question-container">

    <div class="question-card">

        <?php if ($dados === null): ?>

            <h2>🎉 Rodada finalizada!</h2>

            <p>
                <?= htmlspecialchars(
                    $mensagem,
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>
            </p>

            <a href="dashboard.php" class="btn">
                Voltar ao painel
            </a>

            <a
                href="exercicio.php?tipo=<?= urlencode($tipo) ?>&nova_rodada=1"
                class="btn"
            >
                Começar nova rodada 🔄
            </a>

        <?php else: ?>

            <?php if ($tipo === "inteiros"): ?>

                <span class="badge">
                    🔢 Números Inteiros
                </span>

            <?php else: ?>

                <span class="badge">
                    📐 Equações
                </span>

            <?php endif; ?>

            <h2>
                <?= htmlspecialchars(
                    $dados["pergunta"] ?? $dados["enunciado"] ?? "",
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>
            </h2>

            <form action="responder.php" method="POST">

                <input
                    type="hidden"
                    name="questao_id"
                    value="<?= (int) $dados["id"] ?>"
                >

                <input
                    type="hidden"
                    name="tipo"
                    value="<?= htmlspecialchars(
                        $tipo,
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>"
                >

                <div class="alternativas">

                    <label class="alternativa">
                        <input
                            type="radio"
                            name="resposta"
                            value="A"
                            required
                        >
                        <span>A)</span>
                        <?= htmlspecialchars(
                            $dados["alternativa_a"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>
                    </label>

                    <label class="alternativa">
                        <input
                            type="radio"
                            name="resposta"
                            value="B"
                        >
                        <span>B)</span>
                        <?= htmlspecialchars(
                            $dados["alternativa_b"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>
                    </label>

                    <label class="alternativa">
                        <input
                            type="radio"
                            name="resposta"
                            value="C"
                        >
                        <span>C)</span>
                        <?= htmlspecialchars(
                            $dados["alternativa_c"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>
                    </label>

                    <label class="alternativa">
                        <input
                            type="radio"
                            name="resposta"
                            value="D"
                        >
                        <span>D)</span>
                        <?= htmlspecialchars(
                            $dados["alternativa_d"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>
                    </label>

                </div>

                <button type="submit" class="btn btn-full">
                    Responder 🚀
                </button>

            </form>

        <?php endif; ?>

    </div>

</main>

<?php include_once __DIR__ . "/acessibilidade.php"; ?>

</body>
</html>
