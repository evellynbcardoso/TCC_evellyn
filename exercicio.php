<?php

// TELA DE EXERCÍCIOS
session_start();
require_once "classes/questao.php";

// Verifica login
if(!isset($_SESSION["usuario_id"])){
    header("Location: login.php");
    exit;
}

// Recebe o tipo
$tipo = $_GET["tipo"] ?? "inteiros";

// Só permitimos esses dois tipos
if(
    $tipo !== "inteiros" &&
    $tipo !== "equações"
){
    $tipo = "inteiros"
}

$quetão = new Questão();

// Busca questão aleatória
$dados = $quetao -> buscarQuestão("$tipo");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="menu">
        <a href="dashboard.php" class="btn btn-outline">
            ← Voltar
        </a>
    </header>

    <main class="quetion-container">
        <div class="questio-card">
            <?php if($tipo === "inteiros"): ?>
                <span class="badge">
                    🔢 Numeros inteiros 
                </span>
            <?php else; ?>

            <span class="badge">
                📐 Equações
            </span>

            <?php endif; ?>

            <h2>
                <? htmlspecialchars($dados["pergunta"])?>
            </h2>

            <form action="responder.php" method="POST">
            <!-- Enviamos o ID da questão -->
                <input  
                type="hidden"
                name="questao_id"
                value="<?= $dados["id"] ?>">

                <div class="alternativas ">
                    <label class="alternativas">

                        <input  
                        type="radio"
                        name="resposta"
                        value="A"
                        required>

                        <span>A)</span>

                        <?= htmlspecialchars(
                            $dados["alternativa_a"]
                        ) ?>

                    </label>

                    <label class="alternativas">
                        <input  
                        type="radio"
                        name="resposta"
                        value="B" >

                        <span>B)</span>

                        <?= htmlspecialchars(
                            $dados["alternativa_b"]
                        ) ?>

                    </label>

                     <label class="alternativas">
                        <input  
                        type="radio"
                        name="resposta"
                        value="C" >

                        <span>C)</span>

                        <?= htmlspecialchars(
                            $dados["alternativa_c"]
                        ) ?>
                        
                     </label>

                    <label class="alternativas">
                        <input  
                            type="radio"
                            name="resposta"
                            value="D" >

                        <span>D)</span>

                        <?= htmlspecialchars(
                            $dados["alternativa_d"]
                        ) ?>
                        
                    </label>
                </div>

                <button type="subimt" class="btn btn-full">
                    Responder 🚀
                </button>
            </form>
        </div>
    </main>
</body>
</html>