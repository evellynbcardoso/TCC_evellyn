<?php

// =========================================================
// TELA DE EXERCÍCIOS - MATHPLAY
// =========================================================

// Inicia a sessão caso ainda não esteja iniciada.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Importa a classe responsável pelas questões.
require_once __DIR__ . "/classes/questao.php";

// =========================================================
// VERIFICAR SE O ALUNO ESTÁ LOGADO
// =========================================================

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// =========================================================
// IDENTIFICAR O ALUNO E O TIPO DE QUESTÃO
// =========================================================

$usuarioId = (int) $_SESSION["usuario_id"];

// Define o tema padrão.
$tipo = $_GET["tipo"] ?? "inteiros";

// Aceita somente os temas permitidos.
if (!in_array($tipo, ["inteiros", "equacoes"], true)) {
    $tipo = "inteiros";
}

// =========================================================
// VERIFICAR SE O ALUNO DESEJA UMA NOVA RODADA
// =========================================================

// Se o aluno clicar em "Começar nova rodada",
// remove o histórico de questões visualizadas desse tema.
// IMPORTANTE: o método limparRodada() precisa existir
// na classe Questao para que esta chamada funcione.

$questao = new Questao();

if (isset($_GET["nova_rodada"]) && $_GET["nova_rodada"] === "1") {

    if (method_exists($questao, "limparRodada")) {
        $questao->limparRodada($tipo, $usuarioId);
    }

}

// =========================================================
// BUSCAR QUESTÃO
// =========================================================

$dados = $questao->buscarQuestao($tipo, $usuarioId);

// =========================================================
// VERIFICAR SE EXISTE QUESTÃO DISPONÍVEL
// =========================================================

$mensagem = "";

if ($dados === null || $dados === false) {
    $dados = null;
    $mensagem = "Você já visualizou todas as questões desta rodada!";
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Desafio - MathPlay</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="menu">

    <h1>🎮 MathPlay</h1>

    <a href="dashboard.php" class="btn btn-outline">
        ← Voltar
    </a>

</header>

<main class="question-container">

    <div class="question-card">

        <?php if ($dados === null): ?>

            <h2>🎉 Parabéns!</h2>

            <p>
                <?= htmlspecialchars($mensagem, ENT_QUOTES, "UTF-8") ?>
            </p>

            <p>
                Você chegou ao final das questões disponíveis
                desta rodada!
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
                    $dados["pergunta"] ?? "",
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>
            </h2>

            <form action="responder.php" method="POST">

                <!-- ID da questão que será respondida -->
                <input
                    type="hidden"
                    name="questao_id"
                    value="<?= (int) $dados["id"] ?>"
                >

                <!-- Tema da questão -->
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

<?php include_once __DIR__ . '/acessibilidade.php'; ?>

</body>
</html>