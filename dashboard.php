<?php

// PAINEL DO ALUNO
session_start();
require_once "classes/usuario.php";

// Verifica se está logado
if(!isset($_SESSION["usuario_id"])){
    header ("Location: login.php");
    exit;
}

$usuario = new usuario();
$daods = $usuario->buscarPorId(
    $_SESSION["usuario_id"]
);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="menu">
        <h1> 🎮 Mathplay</h1>
        <div>
            <span class="usuario">
                👋 <?=htmlspecialchars($dados["nome"])?>
            </span>
            <a href="logout.php"
            class="btn btn-outline">
                Sair
            </a>
        </div>
    </header>

    <section class="welcome">
        <h2>
            Olá
            <?=htmlspecialchars($dados["nome"])?> !👋
        </h2>
        <p>
            Pronto para aprender Matemática
        </p>
    </section>

    <section class="stats">
        <div class="stat-card">
            <span>⭐</span>
            <div>
                <small>XP</small>
                <strong>
                    <?= $dados["xp"]?>
                </strong>
            </div>
        </div>
        <div class="stat-card">
            <span>🏆</span>
            <div>
                <small>Nivel</small>
                <strong>
                    <?= $dados["nivel"]?>
                </strong>
            </div>
        </div>
    </section>

    <h2 class="section-title">
        Escolha seu desafio 🧠
    </h2>

    <section class="games">
        <a href="exercicio.php?tipo=inteiros" class="game-card">
            <div class="game-ido">
                🔢
            </div>

            <h3>
                Numeros inteiros
            </h3>

            <p>Aprenda trabalhar co numeros possitivos e negativos</p>

            <span>Jogar → </span>
        </a>

        <a href="exercicio.php?tipo=equacoes" class="game-card">
            <div class="game-ido">
                📐
            </div>

            <h3>Equações</h3>

            <p>Resolva desafios e contontre o valor do X</p>

            <span>Jogar → </span>
        </a>
    </section>
</body>
</html>