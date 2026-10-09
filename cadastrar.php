<?php

// =========================================================
// PROCESSAMENTO DO CADASTRO
// =========================================================

require_once "classes/usuario.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: cadastro.php");
    exit;
}

// Recebe os dados
$nome = trim($_POST["nome"]);
$email = trim($_POST["email"]);
$senha = $_POST["senha"];

// Validação básica
if (
    empty($nome) ||
    empty($email) ||
    empty($senha)
) {

    die("Preencha todos os campos.");
}

try {

    $usuario = new Usuario();

    // Tenta cadastrar
    $usuario->cadastrar(
        $nome,
        $email,
        $senha
    );

    // Depois do cadastro vai para login
    header("Location: login.php?cadastro=sucesso");
    exit;

} catch (PDOException $erro) {

    // Caso o e-mail já exista
    if ($erro->getCode() == 23000) {

        die("Esse e-mail já está cadastrado.");

    }

    die("Erro ao cadastrar usuário.");
}