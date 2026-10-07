<?php

session_start();

require_once "config/Banco.php";
require_once "classes/Usuario.php";

if (isset($_SESSION["usuario_id"])) {

    header("Location: dashboard.php");
    exit;
}

$banco = new Banco();

$db = $banco->getConexao();

$usuario = new Usuario($db);

$erro = "";

$sucesso = "";

if (isset($_GET["cadastro"])) {

    $sucesso =
        "Conta criada com sucesso! Faça login.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    $dados =
        $usuario->buscarPorEmail($email);

    if (
        $dados &&
        password_verify(
            $senha,
            $dados["senha"]
        )
    ) {

        $_SESSION["usuario_id"] =
            $dados["id"];

        $_SESSION["usuario_nome"] =
            $dados["nome"];

        header(
            "Location: dashboard.php"
        );

        exit;

    } else {

        $erro =
            "E-mail ou senha incorretos.";
    }
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

<title>Login - MathPlay</title>

<link
    rel="stylesheet"
    href="css/style.css"
>

</head>

<body class="pagina-form">

<div class="formulario">

    <a href="index.php">
        ← Voltar
    </a>

    <div class="logo">
        📚 Math<span>Play</span>
    </div>

    <h1>
        Bem-vindo de volta! 👋
    </h1>

    <?php if ($sucesso): ?>

        <div class="sucesso">
            <?= htmlspecialchars($sucesso) ?>
        </div>

    <?php endif; ?>

    <?php if ($erro): ?>

        <div class="erro">
            <?= htmlspecialchars($erro) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>
            E-mail
        </label>

        <input
            type="email"
            name="email"
            required
        >

        <label>
            Senha
        </label>

        <input
            type="password"
            name="senha"
            required
        >

        <button
            type="submit"
            class="btn full"
        >
            Entrar 🎮
        </button>

    </form>

    <p class="centralizado">

        Ainda não tem conta?

        <a href="cadastro.php">
            Criar sua conta
        </a>

    </p>

</div>

</body>

</html>