<?php

session_start();

require_once "config/Banco.php";
require_once "classes/Usuario.php";

$banco = new Banco();

$db = $banco->getConexao();

$usuario = new Usuario($db);

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if (
        $nome === "" ||
        $email === "" ||
        $senha === ""
    ) {

        $erro = "Preencha todos os campos.";

    } elseif (
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $erro = "Digite um e-mail válido.";

    } elseif (
        strlen($senha) < 6
    ) {

        $erro =
            "A senha precisa ter pelo menos 6 caracteres.";

    } elseif (
        $usuario->buscarPorEmail($email)
    ) {

        $erro =
            "Este e-mail já está cadastrado.";

    } else {

        $usuario->cadastrar(
            $nome,
            $email,
            $senha
        );

        header(
            "Location: login.php?cadastro=ok"
        );

        exit;
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

<title>Criar conta - MathPlay</title>

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
        Criar sua conta 🚀
    </h1>

    <p>
        Comece sua jornada matemática.
    </p>

    <?php if ($erro): ?>

        <div class="erro">
            <?= htmlspecialchars($erro) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>
            Nome
        </label>

        <input
            type="text"
            name="nome"
            placeholder="Digite seu nome"
            required
        >

        <label>
            E-mail
        </label>

        <input
            type="email"
            name="email"
            placeholder="Digite seu e-mail"
            required
        >

        <label>
            Senha
        </label>

        <input
            type="password"
            name="senha"
            placeholder="Mínimo 6 caracteres"
            required
        >

        <button
            type="submit"
            class="btn full"
        >
            Criar conta 🚀
        </button>

    </form>

    <p class="centralizado">

        Já possui uma conta?

        <a href="login.php">
            Entrar
        </a>

    </p>

</div>

</body>

</html>