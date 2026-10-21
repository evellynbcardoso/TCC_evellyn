
<?php

session_start();

// Verifica se o aluno está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Importa a classe Banco
require_once __DIR__ . "/classes/banco.php";

try {
    // Cria a conexão
    $banco = new Banco();
    $conexao = $banco->getConexao();

    // Busca os alunos com mais XP primeiro
    $sql = "SELECT id, nome, xp
            FROM usuarios
            ORDER BY xp DESC, nome ASC
            LIMIT 100";

    $consulta = $conexao->query($sql);
    $alunos = $consulta->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    die("Não foi possível carregar o ranking. Verifique a conexão e as tabelas.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ranking | MathPlay</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        .ranking-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 25px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 5px 20px #00000012;
        }

        .ranking-container h1 {
            text-align: center;
            color: #5145cd;
        }

        .ranking-descricao {
            text-align: center;
            margin-bottom: 25px;
        }

        .ranking-aluno {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            margin: 10px 0;
            background: #f5f6ff;
            border-radius: 12px;
        }

        .ranking-posicao {
            min-width: 45px;
            font-size: 20px;
            font-weight: bold;
        }

        .ranking-nome {
            flex: 1;
            overflow-wrap: anywhere;
            font-weight: bold;
        }

        .ranking-xp {
            color: #5145cd;
            font-weight: bold;
            white-space: nowrap;
        }

        .ranking-voltar {
            display: block;
            width: fit-content;
            margin: 25px auto 0;
            padding: 12px 20px;
            color: white;
            background: #5145cd;
            text-decoration: none;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<main class="ranking-container">

    <h1>🏆 Ranking MathPlay</h1>

    <p class="ranking-descricao">
        Continue estudando e conquiste o primeiro lugar!
    </p>

    <?php if (empty($alunos)): ?>

        <p>Ainda não existem alunos cadastrados no ranking.</p>

    <?php else: ?>

        <?php foreach ($alunos as $indice => $aluno): ?>

            <div class="ranking-aluno">

                <div class="ranking-posicao">
                    <?php
                    if ($indice === 0) {
                        echo "🥇";
                    } elseif ($indice === 1) {
                        echo "🥈";
                    } elseif ($indice === 2) {
                        echo "🥉";
                    } else {
                        echo ($indice + 1) . "º";
                    }
                    ?>
                </div>

                <div class="ranking-nome">
                    <?= htmlspecialchars(
                        $aluno["nome"],
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>
                </div>

                <div class="ranking-xp">
                    ⭐ <?= (int) $aluno["xp"] ?> XP
                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <a href="dashboard.php" class="ranking-voltar">
        ← Voltar ao painel
    </a>

</main>

<?php include_once __DIR__ . '/acessibilidade.php'; ?>

</body>
</html>
