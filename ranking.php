<?php

// =====================================================
// RANKING DE ALUNOS - MATHPLAY
// Exibe os alunos com maior pontuação.
// =====================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o aluno está logado.
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Importa a classe de conexão com o banco.
require_once __DIR__ . "/config/banco.php";

// Identifica o aluno conectado.
$usuarioId = (int) $_SESSION["usuario_id"];

// Inicializa as variáveis.
$alunos = [];
$erro = "";

try {

    // Cria a conexão com o banco de dados.
    $banco = new Banco();
    $conexao = $banco->getConexao();

    // Busca os alunos ordenados pela pontuação.
    // Em caso de empate, considera XP e nome.
    $sql = "
        SELECT
            id,
            nome,
            pontos,
            xp
        FROM usuarios
        ORDER BY
            pontos DESC,
            xp DESC,
            nome ASC
        LIMIT 100
    ";

    $consulta = $conexao->prepare($sql);
    $consulta->execute();

    $alunos = $consulta->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    // Registra o erro sem exibir detalhes do banco ao aluno.
    error_log("Erro no ranking MathPlay: " . $e->getMessage());

    $erro = "Não foi possível carregar o ranking. Tente novamente.";

}

// Calcula o nível a partir do XP.
function calcularNivel(int $xp): int
{
    return intdiv(max(0, $xp), 100) + 1;
}

// Localiza a posição do aluno conectado.
$posicaoAluno = null;

foreach ($alunos as $indice => $aluno) {

    if ((int) $aluno["id"] === $usuarioId) {
        $posicaoAluno = $indice + 1;
        break;
    }

}

// Escapa os textos antes de exibi-los no HTML.
function escapar($valor): string
{
    return htmlspecialchars(
        (string) $valor,
        ENT_QUOTES,
        "UTF-8"
    );
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

    <title>Ranking de Alunos | MathPlay</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        /* =========================================
           RANKING MATHPLAY
        ========================================= */

        .ranking-container {
            width: min(1000px, 92%);
            margin: 35px auto;
            padding-bottom: 40px;
        }

        .ranking-cabecalho {
            text-align: center;
            margin-bottom: 30px;
        }

        .ranking-cabecalho h2 {
            font-size: clamp(26px, 5vw, 38px);
            margin-bottom: 10px;
        }

        .ranking-cabecalho p {
            color: #667085;
            line-height: 1.6;
        }

        .ranking-resumo {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .resumo-card {
            padding: 20px 12px;
            text-align: center;
            background: #ffffff;
            border: 1px solid #e4e7ec;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .resumo-card .icone {
            display: block;
            font-size: 30px;
            margin-bottom: 8px;
        }

        .resumo-card strong {
            display: block;
            font-size: 23px;
            color: #5265d8;
            overflow-wrap: anywhere;
        }

        .resumo-card span:last-child {
            display: block;
            margin-top: 5px;
            color: #667085;
            font-size: 13px;
        }

        /* Pódio dos três primeiros colocados */

        .podio {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            align-items: end;
            gap: 12px;
            margin: 30px 0;
        }

        .podio-card {
            min-width: 0;
            padding: 20px 8px;
            text-align: center;
            background: #ffffff;
            border: 2px solid #e4e7ec;
            border-radius: 16px;
            overflow-wrap: anywhere;
        }

        .podio-card.primeiro {
            padding-top: 32px;
            padding-bottom: 32px;
            border-color: #f3c64e;
            background: linear-gradient(
                180deg,
                #fff8dc,
                #ffffff
            );
        }

        .podio-card.segundo {
            border-color: #c8d0dc;
        }

        .podio-card.terceiro {
            border-color: #d9a17d;
        }

        .podio-medalha {
            display: block;
            font-size: 36px;
            margin-bottom: 10px;
        }

        .podio-posicao {
            font-size: 13px;
            color: #667085;
        }

        .podio-nome {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
            overflow-wrap: anywhere;
        }

        .podio-pontos {
            font-size: 20px;
            font-weight: bold;
            color: #5265d8;
        }

        /* Tabela de classificação */

        .ranking-tabela-container {
            overflow-x: auto;
            background: #ffffff;
            border: 1px solid #e4e7ec;
            border-radius: 16px;
        }

        .ranking-titulo-lista {
            padding: 20px;
            margin: 0;
        }

        .ranking-tabela {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .ranking-tabela th,
        .ranking-tabela td {
            padding: 16px 18px;
            border-top: 1px solid #eaecf0;
        }

        .ranking-tabela th {
            background: #f8f9fc;
            color: #475467;
            font-size: 13px;
        }

        .ranking-tabela td {
            font-size: 14px;
        }

        .ranking-tabela tbody tr:hover {
            background: #f8f9ff;
        }

        .ranking-tabela tr.aluno-logado {
            background: #edf0ff;
            font-weight: bold;
        }

        .ranking-tabela tr.aluno-logado td {
            border-top-color: #c8ceff;
        }

        .posicao {
            font-weight: bold;
            white-space: nowrap;
        }

        .nome-aluno {
            font-weight: bold;
            color: #344054;
        }

        .selo-voce {
            display: inline-block;
            margin-left: 6px;
            padding: 4px 7px;
            border-radius: 20px;
            background: #5265d8;
            color: #ffffff;
            font-size: 11px;
            white-space: nowrap;
        }

        .pontos-destaque {
            color: #5265d8;
            font-weight: bold;
            white-space: nowrap;
        }

        .ranking-vazio,
        .ranking-erro {
            padding: 30px 20px;
            text-align: center;
            line-height: 1.7;
        }

        .ranking-erro {
            color: #b42318;
        }

        .ranking-acoes {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 25px;
        }

        .ranking-acoes a {
            text-decoration: none;
        }

        /* Acessibilidade */

        .ranking-container a:focus-visible {
            outline: 3px solid #ffbf47;
            outline-offset: 4px;
        }

        /* Celulares */

        @media (max-width: 600px) {

            .ranking-container {
                width: 94%;
                margin-top: 22px;
            }

            .ranking-resumo {
                gap: 8px;
            }

            .resumo-card {
                padding: 14px 5px;
            }

            .resumo-card .icone {
                font-size: 24px;
            }

            .resumo-card strong {
                font-size: 18px;
            }

            .resumo-card span:last-child {
                font-size: 11px;
            }

            .podio {
                gap: 6px;
            }

            .podio-card {
                padding: 14px 5px;
            }

            .podio-card.primeiro {
                padding-top: 25px;
                padding-bottom: 25px;
            }

            .podio-medalha {
                font-size: 28px;
            }

            .podio-nome {
                font-size: 13px;
            }

            .podio-pontos {
                font-size: 16px;
            }

            .ranking-tabela th,
            .ranking-tabela td {
                padding: 12px 10px;
            }

            .selo-voce {
                margin: 5px 0 0;
            }
        }
    </style>

</head>

<body>

<!-- Cabeçalho -->

<header class="menu">

    <h1>🎮 MathPlay</h1>

    <a href="dashboard.php" class="btn btn-outline">
        ← Voltar ao painel
    </a>

</header>

<main class="ranking-container">

    <section class="ranking-cabecalho">

        <h2>🏆 Ranking MathPlay</h2>

        <p>
            Aprenda, acumule pontos e conquiste seu lugar
            entre os melhores jogadores!
        </p>

    </section>

    <?php if ($erro !== ""): ?>

        <div class="ranking-erro" role="alert">
            <?= escapar($erro) ?>

            <p>
                Confira a conexão com o banco de dados
                e os campos da tabela usuarios.
            </p>
        </div>

    <?php else: ?>

        <?php
        // Identifica o primeiro colocado.
        $primeiro = $alunos[0] ?? null;

        // Calcula a quantidade de alunos retornados.
        $totalAlunos = count($alunos);

        // Soma os pontos de todos os alunos exibidos.
        $totalPontos = 0;

        foreach ($alunos as $aluno) {
            $totalPontos += (int) $aluno["pontos"];
        }
        ?>

        <!-- Resumo do ranking -->

        <section
            class="ranking-resumo"
            aria-label="Resumo do ranking">

            <article class="resumo-card">

                <span class="icone" aria-hidden="true">👥</span>

                <strong><?= $totalAlunos ?></strong>

                <span>Alunos listados</span>

            </article>

            <article class="resumo-card">

                <span class="icone" aria-hidden="true">⭐</span>

                <strong>
                    <?= number_format($totalPontos, 0, ",", ".") ?>
                </strong>

                <span>Pontos somados</span>

            </article>

            <article class="resumo-card">

                <span class="icone" aria-hidden="true">🥇</span>

                <strong>
                    <?= $primeiro !== null
                        ? escapar($primeiro["nome"])
                        : "—" ?>
                </strong>

                <span>Líder do ranking</span>

            </article>

        </section>

        <?php if ($totalAlunos === 0): ?>

            <div class="ranking-vazio">

                <h3>🎯 O ranking está esperando por você!</h3>

                <p>
                    Ainda não existem alunos cadastrados
                    para aparecer nesta classificação.
                </p>

            </div>

        <?php else: ?>

            <!-- Pódio dos três primeiros -->

            <section aria-label="Pódio dos três primeiros colocados">

                <div class="podio">

                    <?php
                    // Exibe o segundo colocado à esquerda,
                    // o primeiro no centro e o terceiro à direita.
                    $indicesPodio = [1, 0, 2];

                    $classesPodio = [
                        0 => "primeiro",
                        1 => "segundo",
                        2 => "terceiro"
                    ];

                    $medalhas = [
                        0 => "🥇",
                        1 => "🥈",
                        2 => "🥉"
                    ];

                    foreach ($indicesPodio as $indice):

                        if (!isset($alunos[$indice])) {
                            continue;
                        }

                        $alunoPodio = $alunos[$indice];
                        $posicaoPodio = $indice + 1;
                    ?>

                        <article class="podio-card <?= $classesPodio[$posicaoPodio - 1] ?>">

                            <span class="podio-medalha" aria-hidden="true">
                                <?= $medalhas[$posicaoPodio - 1] ?>
                            </span>

                            <div class="podio-posicao">
                                <?= $posicaoPodio ?>º lugar
                            </div>

                            <div class="podio-nome">
                                <?= escapar($alunoPodio["nome"]) ?>

                                <?php if ((int) $alunoPodio["id"] === $usuarioId): ?>
                                    <span class="selo-voce">Você</span>
                                <?php endif; ?>
                            </div>

                            <div class="podio-pontos">
                                <?= number_format(
                                    (int) $alunoPodio["pontos"],
                                    0,
                                    ",",
                                    "."
                                ) ?>
                                pts
                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            </section>

            <!-- Tabela completa -->

            <section class="ranking-tabela-container">

                <h3 class="ranking-titulo-lista">
                    📊 Classificação dos alunos
                </h3>

                <table class="ranking-tabela">

                    <thead>
                        <tr>
                            <th scope="col">Posição</th>
                            <th scope="col">Aluno</th>
                            <th scope="col">Nível</th>
                            <th scope="col">XP</th>
                            <th scope="col">Pontos</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($alunos as $indice => $aluno): ?>

                            <?php
                            $posicao = $indice + 1;

                            $ehAlunoLogado =
                                (int) $aluno["id"] === $usuarioId;

                            $nivel = calcularNivel((int) $aluno["xp"]);

                            if ($posicao === 1) {
                                $simbolo = "🥇";
                            } elseif ($posicao === 2) {
                                $simbolo = "🥈";
                            } elseif ($posicao === 3) {
                                $simbolo = "🥉";
                            } else {
                                $simbolo = "#" . $posicao;
                            }
                            ?>

                            <tr class="<?= $ehAlunoLogado ? 'aluno-logado' : '' ?>">

                                <td class="posicao">
                                    <?= $simbolo ?>
                                </td>

                                <td class="nome-aluno">

                                    <?= escapar($aluno["nome"]) ?>

                                    <?php if ($ehAlunoLogado): ?>
                                        <span class="selo-voce">Você</span>
                                    <?php endif; ?>

                                </td>

                                <td>
                                    Nível <?= $nivel ?>
                                </td>

                                <td>
                                    <?= number_format(
                                        (int) $aluno["xp"],
                                        0,
                                        ",",
                                        "."
                                    ) ?>
                                    XP
                                </td>

                                <td class="pontos-destaque">
                                    <?= number_format(
                                        (int) $aluno["pontos"],
                                        0,
                                        ",",
                                        "."
                                    ) ?>
                                    pts
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </section>

        <?php endif; ?>

        <!-- Posição do aluno conectado -->

        <?php if ($posicaoAluno !== null): ?>

            <p style="text-align: center; margin-top: 22px;">

                🎯 Você está na posição
                <strong><?= $posicaoAluno ?>º</strong>
                entre os alunos listados.

            </p>

        <?php else: ?>

            <p style="text-align: center; margin-top: 22px;">

                Sua posição não aparece entre os 100 primeiros
                colocados. Continue estudando para subir no ranking!

            </p>

        <?php endif; ?>

    <?php endif; ?>

    <!-- Botões de navegação -->

    <div class="ranking-acoes">

        <a href="dashboard.php" class="btn">
            🏠 Voltar ao painel
        </a>

        <a href="exercicio.php?tipo=inteiros" class="btn">
            🎮 Jogar e ganhar pontos
        </a>

        <a href="ranking.php" class="btn btn-outline">
            🔄 Atualizar ranking
        </a>

    </div>

</main>

</body>
</html>