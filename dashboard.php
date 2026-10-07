<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {

    header("Location: login.php");
    exit;
}

require_once "config/Banco.php";
require_once "classes/Usuario.php";
require_once "classes/Questao.php";

$banco = new Banco();

$db = $banco->getConexao();

$usuarioObj =
    new Usuario($db);

$questaoObj =
    new Questao($db);

$usuario =
    $usuarioObj->buscarPorId(
        (int)$_SESSION["usuario_id"]
    );

if (!$usuario) {

    session_destroy();

    header("Location: login.php");

    exit;
}

$inteiros =
    $questaoObj->listarPorTema(
        "inteiros"
    );

$equacoes =
    $questaoObj->listarPorTema(
        "equacoes"
    );

$totalQuestoes =
    count($inteiros) +
    count($equacoes);

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Dashboard - MathPlay</title>

<link
    rel="stylesheet"
    href="css/style.css"
>

</head>

<body>

<header class="topo">

    <div class="logo">
        📚 Math<span>Play</span>
    </div>

    <div>

        Olá,
        <strong>
            <?= htmlspecialchars($usuario["nome"]) ?>
        </strong>

        <a
            href="logout.php"
            class="sair"
        >
            Sair
        </a>

    </div>

</header>

<main class="dashboard">

    <section class="boas-vindas">

        <div>

            <span class="badge">
                Nível <?= $usuario["nivel"] ?>
            </span>

            <h1>
                Olá,
                <?= htmlspecialchars($usuario["nome"]) ?>! 👋
            </h1>

            <p>
                Escolha um desafio para começar.
            </p>

        </div>

        <div class="xp">
            ⭐ <?= $usuario["xp"] ?> XP
        </div>

    </section>

    <section class="estatisticas">

        <div>
            ⭐
            <strong>
                <?= $usuario["xp"] ?>
            </strong>
            <small>
                XP
            </small>
        </div>

        <div>
            🏆
            <strong>
                <?= $usuario["nivel"] ?>
            </strong>
            <small>
                Nível
            </small>
        </div>

        <div>
            🧮
            <strong>
                <?= $totalQuestoes ?>
            </strong>
            <small>
                Questões
            </small>
        </div>

    </section>

    <h2>
        Escolha seu desafio 🎮
    </h2>

    <section class="jogos">

        <a
            href="questoes/inteiros.php"
            class="jogo"
        >

            <div class="icone">
                ➕➖
            </div>

            <h3>
                Números Inteiros
            </h3>

            <p>
                Pratique números positivos
                e negativos.
            </p>

            <strong>
                Começar →
            </strong>

        </a>

        <a
            href="questoes/equacoes.php"
            class="jogo"
        >

            <div class="icone">
                ✏️
            </div>

            <h3>
                Equações
            </h3>

            <p>
                Descubra o valor de X
                resolvendo equações.
            </p>

            <strong>
                Começar →
            </strong>

        </a>

    </section>

</main>

</body>

</html>