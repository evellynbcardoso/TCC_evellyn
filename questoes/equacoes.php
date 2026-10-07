<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../config/Banco.php";
require_once "../classes/Usuario.php";
require_once "../classes/Questao.php";
require_once "../classes/Resposta.php";

$banco = new Banco();
$db = $banco->getConexao();

$usuarioObj = new Usuario($db);
$questaoObj = new Questao($db);
$respostaObj = new Resposta($db);

$usuarioId = (int) $_SESSION["usuario_id"];

$questoes = $questaoObj->listarPorTema("equacoes");

if (!$questoes) {
    die("Nenhuma questão de equações cadastrada.");
}

$numero = (int) ($_GET["q"] ?? 0);

if ($numero < 0 || $numero >= count($questoes)) {
    $numero = 0;
}

$questao = $questoes[$numero];

$resultado = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $resposta = trim($_POST["resposta"] ?? "");

    $correta =
        $resposta === $questao["resposta"];

    $xp = $correta ? 10 : 0;

    $respostaObj->registrar(
        $usuarioId,
        $questao["id"],
        $resposta,
        $correta,
        $xp
    );

    if ($correta) {

        $usuarioObj->adicionarXP(
            $usuarioId,
            10
        );
    }

    $resultado = [
        "correta" => $correta,
        "resposta" => $questao["resposta"],
        "explicacao" => $questao["explicacao"]
    ];
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Equações - MathPlay</title>

<link
    rel="stylesheet"
    href="../css/style.css"
>

</head>

<body>

<header class="topo">

    <div class="logo">
        📚 Math<span>Play</span>
    </div>

    <a href="../dashboard.php">
        ← Dashboard
    </a>

</header>

<main class="questao-page">

    <span class="badge">
        Questão <?= $numero + 1 ?>
        de <?= count($questoes) ?>
    </span>

    <h1>
        ✏️ Equações
    </h1>

    <div class="questao">

        <h2>
            <?= htmlspecialchars(
                $questao["enunciado"]
            ) ?>
        </h2>

        <?php if ($resultado === null): ?>

            <form method="POST">

                <input
                    type="text"
                    name="resposta"
                    class="resposta"
                    placeholder="Digite o valor de x"
                    required
                    autofocus
                >

                <button
                    type="submit"
                    class="btn full"
                >
                    Resolver 🚀
                </button>

            </form>

        <?php else: ?>

            <?php if ($resultado["correta"]): ?>

                <div class="resultado certo">

                    <h2>
                        🎉 Parabéns!
                    </h2>

                    <p>
                        Você resolveu corretamente!
                    </p>

                    <strong>
                        +10 XP ⭐
                    </strong>

                </div>

            <?php else: ?>

                <div class="resultado errado">

                    <h2>
                        💡 Vamos aprender!
                    </h2>

                    <p>
                        A resposta correta é:
                        <strong>
                            <?= htmlspecialchars(
                                $resultado["resposta"]
                            ) ?>
                        </strong>
                    </p>

                </div>

            <?php endif; ?>

            <div class="explicacao">

                <h3>
                    📖 Como resolver?
                </h3>

                <p>
                    <?= htmlspecialchars(
                        $resultado["explicacao"]
                    ) ?>
                </p>

            </div>

            <?php if (
                $numero + 1 <
                count($questoes)
            ): ?>

                <a
                    href="?q=<?= $numero + 1 ?>"
                    class="btn full"
                >
                    Próxima questão →
                </a>

            <?php else: ?>

                <a
                    href="../dashboard.php"
                    class="btn full"
                >
                    Finalizar 🏆
                </a>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</main>

</body>

</html>