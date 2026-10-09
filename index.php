<?php

session_start();

if (isset($_SESSION["usuario_id"])) {

    header("Location: dashboard.php");
    exit;
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

    <title>MathPlay</title>

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

    <nav>

        <a href="login.php">
            Entrar
        </a>

        <a
            href="cadastro.php"
            class="btn pequeno"
        >
            Criar conta
        </a>

    </nav>

</header>

<main class="hero">

    <section>

        <span class="badge">
            🎮 Aprenda matemática brincando
        </span>

        <h1>
            Matemática pode ser
            <span>divertida!</span>
        </h1>

        <p>
            Resolva desafios, ganhe XP,
            suba de nível e aprenda matemática
            de uma maneira mais divertida.
        </p>

        <div class="acoes">

            <a
                href="cadastro.php"
                class="btn"
            >
                Começar agora 🚀
            </a>

            <a
                href="login.php"
                class="btn secundario"
            >
                Entrar
            </a>

        </div>

    </section>

    <section class="home-cards">

        <div class="info-card">
            ➕➖
            <strong>Números Inteiros</strong>
            <small>
                Positivos e negativos.
            </small>
        </div>

        <div class="info-card">
            ✏️
            <strong>Equações</strong>
            <small>
                Descubra o valor de X.
            </small>
        </div>

        <div class="info-card">
            ⭐
            <strong>Ganhe XP</strong>
            <small>
                Acerte questões e suba de nível.
            </small>
        </div>

    </section>

</main>

</body>

</html>