<?php

// 1. INICIA A SESSÃO

// Inicia ou recupera a sessão do usuário.
// A sessão permite manter informações do aluno
// enquanto ele navega pelo site.
session_start();

// 2. VERIFICA SE O USUÁRIO ESTÁ LOGADO

// Verifica se existe um ID de usuário armazenado na sessão.
// Se não existir, significa que o aluno não está autenticado.
if (!isset($_SESSION["usuario_id"])) {

    // Redireciona o usuário para a página de login.
    header("Location: ../login.php");

    // Interrompe a execução do código após o redirecionamento.
    exit;
}

// 3. IMPORTA AS CLASSES DO SISTEMA

// Importa a classe responsável pela conexão com o banco MySQL.
require_once "../config/Banco.php";

// Importa a classe responsável pelos dados dos usuários,
// como cadastro, consulta e gerenciamento de XP.
require_once "../classes/Usuario.php";

// Importa a classe que busca as questões de matemática.
require_once "../classes/Questao.php";

// Importa a classe que registra as respostas dos alunos.
require_once "../classes/Resposta.php";

// 4. ESTABELECE A CONEXÃO COM O BANCO DE DADOS

// Cria um objeto da classe Banco.
// O construtor da classe é responsável por iniciar a conexão.
$banco = new Banco();

// Recupera a conexão PDO com o banco de dados.
$db = $banco->getConexao();

// 5. CRIA OS OBJETOS DAS CLASSES

// Cria o objeto responsável pelas operações relacionadas
// aos usuários e envia a conexão com o banco de dados.
$usuarioObj =
    new Usuario($db);

// Cria o objeto responsável por consultar as questões.
$questaoObj =
    new Questao($db);

// Cria o objeto responsável por registrar as respostas.
$respostaObj =
    new Resposta($db);

// 6. RECUPERA O ID DO ALUNO LOGADO

// Obtém o ID do usuário armazenado na sessão.
// O (int) converte o valor para um número inteiro.
$usuarioId =
    (int)$_SESSION["usuario_id"];

// 7. BUSCA AS QUESTÕES DE NÚMEROS INTEIROS

// Chama o método listarPorTema() da classe Questao.
// O método consulta o banco e retorna as questões
// cadastradas com o tema "inteiros".
$questoes =
    $questaoObj->listarPorTema(
        "inteiros"
    );

// Verifica se a consulta não retornou nenhuma questão.
if (!$questoes) {

    // Exibe uma mensagem e encerra a página
    // quando não existem questões disponíveis.
    die("Nenhuma questão encontrada.");
}

// 8. IDENTIFICA A QUESTÃO ATUAL

// Recupera o número da questão a partir da URL.
// Exemplo: inteiros.php?q=0 corresponde à primeira questão.
//
// O operador ?? define 0 como valor padrão caso o parâmetro
// "q" não exista na URL.
// O (int) converte o valor para inteiro.
$numero =
    (int)($_GET["q"] ?? 0);


// Verifica se o índice da questão é inválido.
// O índice não pode ser negativo nem maior ou igual
// à quantidade total de questões.
if (
    $numero < 0 ||
    $numero >= count($questoes)
) {

    // Se o índice for inválido, começa pela primeira questão.
    $numero = 0;
}

// Recupera a questão correspondente ao índice selecionado.
// Os arrays do PHP começam a contagem pelo índice 0.
$questao =
    $questoes[$numero];

// 9. INICIALIZA A VARIÁVEL DO RESULTADO

// Define o resultado inicialmente como null.
// Isso indica que o aluno ainda não respondeu à questão.
$resultado = null;

// 10. PROCESSA A RESPOSTA DO ALUNO

// Verifica se a página recebeu dados enviados pelo método POST.
// Isso acontece quando o aluno envia o formulário.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recupera a resposta digitada pelo aluno.
    // O trim() remove espaços em branco do início e do final.
    // Se o campo não existir, utiliza uma string vazia.
    $resposta =
        trim($_POST["resposta"] ?? "");


    // Compara a resposta digitada com a resposta correta
    // armazenada no banco de dados para a questão atual.
    // O operador === realiza uma comparação estrita.
    // Por isso, diferenças de formato podem fazer com que
    // respostas matematicamente equivalentes sejam rejeitadas.
    $correta =
        $resposta ===
        $questao["resposta"];


    // Define a quantidade de XP que será concedida.
    // Se o aluno acertar, recebe 10 XP.
    // Se errar, recebe 0 XP.
    $xp = $correta ? 10 : 0;

    // Registra a tentativa do aluno no banco de dados.
    // Parâmetros enviados:
    // $usuarioId       = ID do aluno que respondeu;
    // $questao["id"]   = ID da questão respondida;
    // $resposta        = resposta digitada;
    // $correta         = informa se acertou ou errou;
    // $xp              = XP obtido nessa tentativa.
    $respostaObj->registrar(
        $usuarioId,
        $questao["id"],
        $resposta,
        $correta,
        $xp
    );


    // Verifica se a resposta foi correta.
    if ($correta) {

        // Adiciona 10 XP ao usuário no banco de dados.
        // O método adicionarXP() pertence à classe Usuario.
        $usuarioObj->adicionarXP(
            $usuarioId,
            10
        );
    }


    // Guarda os dados que serão utilizados para mostrar
    // o resultado da correção na página.
    $resultado = [

        // Armazena se o aluno acertou ou errou.
        "correta" => $correta,

        // Armazena a resposta correta da questão.
        "resposta" =>
            $questao["resposta"],

        // Armazena a explicação cadastrada no banco.
        "explicacao" =>
            $questao["explicacao"]
    ];
}

?>

<!DOCTYPE html>

<!-- Informa ao navegador que o documento utiliza HTML5. -->
<html lang="pt-BR">

<head>

    <!-- Define a codificação para exibir acentos
    e caracteres especiais corretamente. -->
    <meta charset="UTF-8">

    <!-- Permite que a página se adapte a diferentes telas,
    como computadores, celulares e tablets. -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- Define o título da página exibido na aba do navegador. -->
    <title>Números Inteiros</title>

    <!-- Importa o arquivo CSS que controla a aparência
    da página, incluindo cores, fontes e botões. -->
    <link
        rel="stylesheet"
        href="../css/style.css"
    >

</head>

<body>

<!-- 11. CABEÇALHO DO MATHPLAY-->

<!-- O cabeçalho contém o nome da plataforma
e o link para retornar ao painel do aluno. -->
<header class="topo">

    <!-- Logo textual do MathPlay.
    A tag span permite estilizar "Play" separadamente no CSS. -->
    <div class="logo">
        📚 Math<span>Play</span>
    </div>

    <!-- Link que leva o aluno de volta ao dashboard. -->
    <a href="../dashboard.php">
        ← Dashboard
    </a>

</header>


<!-- 12. CONTEÚDO PRINCIPAL DA ATIVIDADE-->

<!-- Área principal da página de exercícios. -->
<main class="questao-page">

    <!-- Mostra a posição da questão atual e a quantidade total.

    O $numero + 1 é utilizado porque a contagem apresentada
    ao aluno começa em 1, mas os índices do array começam em 0. -->
    <span class="badge">
        Questão <?= $numero + 1 ?>
        de <?= count($questoes) ?>
    </span>


    <!-- Título da atividade de números inteiros. -->
    <h1>
        ➕➖ Números Inteiros
    </h1>


    <!-- Caixa que reúne o enunciado, o formulário,
    o resultado e a explicação da questão. -->
    <div class="questao">

        <!-- Exibe o enunciado da questão atual.

        A função htmlspecialchars() transforma caracteres
        especiais em entidades HTML, ajudando a evitar
        que o texto seja interpretado como código HTML. -->
        <h2>
            <?= htmlspecialchars(
                $questao["enunciado"]
            ) ?>
        </h2>


        <!--13. EXIBE O FORMULÁRIO OU O RESULTADO-->

        <!-- Se o resultado for null, significa que a resposta
        ainda não foi processada nesta exibição da página. -->
        <?php if ($resultado === null): ?>

            <!-- Formulário usado para enviar a resposta.
            O método POST envia os dados para esta mesma página. -->
            <form method="POST">

                <!-- Campo de texto para o aluno digitar a resposta.

                name="resposta" identifica o campo que será
                recuperado pelo PHP usando $_POST["resposta"].

                class="resposta" permite aplicar estilos pelo CSS.

                placeholder mostra uma orientação dentro do campo.

                required impede o envio vazio pelo navegador.

                autofocus posiciona o cursor nesse campo
                quando a página é carregada. -->
                <input
                    type="text"
                    name="resposta"
                    class="resposta"
                    placeholder="Digite sua resposta"
                    required
                    autofocus
                >

                <!-- Botão que envia o formulário para correção. -->
                <button
                    class="btn full"
                    type="submit"
                >
                    Responder 🚀
                </button>

            </form>


        <!-- Se o resultado não for null, significa que a resposta
        foi processada e a página pode exibir a correção. -->
        <?php else: ?>


            <!--14. MOSTRA A MENSAGEM DE ACERTO OU ERRO -->

            <!-- Verifica se a resposta foi considerada correta. -->
            <?php if ($resultado["correta"]): ?>

                <!-- Bloco exibido quando o aluno acerta.
                As classes CSS controlam a aparência visual. -->
                <div class="resultado certo">

                    <!-- Mensagem positiva para o aluno. -->
                    <h2>
                        🎉 Parabéns!
                    </h2>

                    <!-- Informa que a resposta está correta. -->
                    <p>
                        Você acertou!
                    </p>

                    <!-- Mostra os pontos de experiência conquistados. -->
                    <strong>
                        +10 XP ⭐
                    </strong>

                </div>


            <!-- Se a resposta estiver errada, mostra
            a mensagem alternativa abaixo. -->
            <?php else: ?>

                <!-- Bloco visual para uma resposta incorreta. -->
                <div class="resultado errado">

                    <!-- Mensagem que incentiva o aluno
                    a continuar aprendendo. -->
                    <h2>
                        💡 Não foi dessa vez!
                    </h2>

                    <!-- Exibe a resposta correta da questão.

                    htmlspecialchars() protege a saída HTML,
                    evitando a interpretação de caracteres
                    especiais como marcação HTML. -->
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


            <!-- 15. MOSTRA A EXPLICAÇÃO DA RESPOSTA -->

            <!-- Área educativa apresentada depois da correção.
            Ela aparece tanto para acertos quanto para erros. -->
            <div class="explicacao">

                <!-- Título da área de explicação. -->
                <h3>
                    📖 Explicação
                </h3>

                <!-- Exibe a explicação cadastrada no banco de dados.

                Essa explicação pode ensinar como resolver a questão
                e por que determinada resposta está correta.

                htmlspecialchars() ajuda a proteger a saída HTML. -->
                <p>
                    <?= htmlspecialchars(
                        $resultado["explicacao"]
                    ) ?>
                </p>

            </div>


            <!-- 16. AVANÇA PARA A PRÓXIMA QUESTÃO -->

            <!-- Verifica se existe uma questão depois da atual.

            O count($questoes) retorna a quantidade total
            de questões disponíveis. -->
            <?php if (
                $numero + 1 <
                count($questoes)
            ): ?>

                <!-- Se houver outra questão, exibe um link
                que avança para o próximo índice.

                Exemplo:
                ?q=0 abre a primeira questão;
                ?q=1 abre a segunda questão;
                ?q=2 abre a terceira questão. -->
                <a
                    href="?q=<?= $numero + 1 ?>"
                    class="btn full"
                >
                    Próxima questão →
                </a>


            <!-- Se a questão atual for a última,
            apresenta o botão para finalizar a atividade. -->
            <?php else: ?>

                <!-- Retorna o aluno ao painel principal. -->
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