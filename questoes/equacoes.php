<?php

// 1. INICIA A SESSÃO

// Permite acessar os dados do usuário que estão armazenados
// na sessão, como o ID de quem está conectado.
session_start();

// 2. VERIFICA SE O USUÁRIO ESTÁ LOGADO

// Verifica se a variável "usuario_id" existe na sessão.
// Se não existir, significa que o usuário não está logado.
if (!isset($_SESSION["usuario_id"])) {

    // Redireciona o usuário para a página de login.
    header("Location: ../login.php");

    // Interrompe a execução do código para impedir
    // que a página continue sendo carregada.
    exit;
}

// 3. IMPORTA AS CLASSES NECESSÁRIAS

// Importa a classe responsável pela conexão com o banco.
require_once "../config/Banco.php";

// Importa a classe que gerencia os dados dos usuários,
// incluindo o cadastro e o aumento de XP.
require_once "../classes/Usuario.php";

// Importa a classe responsável por buscar as questões.
require_once "../classes/Questao.php";

// Importa a classe responsável por registrar as respostas.
require_once "../classes/Resposta.php";

// 4. CRIA A CONEXÃO COM O BANCO DE DADOS

// Cria um objeto da classe Banco.
// O construtor dessa classe realiza a conexão com o MySQL.
$banco = new Banco();

// Obtém a conexão PDO com o banco de dados.
$db = $banco->getConexao();

// 5. CRIA OS OBJETOS DAS CLASSES

// Cria um objeto Usuario e entrega a conexão PDO para ele.
$usuarioObj = new Usuario($db);

// Cria um objeto Questao para buscar os exercícios.
$questaoObj = new Questao($db);

// Cria um objeto Resposta para salvar as respostas dos alunos.
$respostaObj = new Resposta($db);

// 6. OBTÉM O ID DO USUÁRIO LOGADO

// Recupera o ID do usuário armazenado na sessão.
// O (int) converte o valor para um número inteiro.
$usuarioId = (int) $_SESSION["usuario_id"];

// 7. BUSCA AS QUESTÕES DE EQUAÇÕES

// Chama o método listarPorTema() da classe Questao.
// O método retorna as questões cujo tema é "equacoes".
$questoes = $questaoObj->listarPorTema("equacoes");

// Verifica se nenhuma questão foi encontrada.
if (!$questoes) {

    // Exibe uma mensagem e encerra a execução
    // caso não existam questões de equações cadastradas.
    die("Nenhuma questão de equações cadastrada.");
}

// 8. IDENTIFICA A QUESTÃO QUE SERÁ EXIBIDA

// Obtém o número da questão pela URL, usando o parâmetro "q".
// Exemplo: equacoes.php?q=0 representa a primeira questão.
// O operador ?? define 0 como valor padrão caso "q" não exista.
// O (int) converte o valor para inteiro.
$numero = (int) ($_GET["q"] ?? 0);


// Verifica se o número recebido é inválido.
// Como os índices de arrays começam em 0, o primeiro índice
// é 0 e o último é count($questoes) - 1.
if ($numero < 0 || $numero >= count($questoes)) {

    // Se o índice for inválido, volta para a primeira questão.
    $numero = 0;
}

// Recupera a questão correspondente ao índice selecionado.
$questao = $questoes[$numero];

// 9. PREPARA A VARIÁVEL DO RESULTADO

// Inicializa a variável como null.
// Isso significa que ainda não existe um resultado para mostrar.
$resultado = null;

// 10. PROCESSA A RESPOSTA ENVIADA PELO ALUNO

// Verifica se a página recebeu um formulário pelo método POST.
// Isso acontece quando o aluno clica no botão "Resolver".
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recupera a resposta digitada no formulário.
    // O trim() remove espaços em branco no começo e no final.
    // Se o campo não existir, utiliza uma string vazia.
    $resposta = trim($_POST["resposta"] ?? "");


    // Compara a resposta digitada com a resposta cadastrada
    // no banco de dados para a questão atual.
    // O operador === faz uma comparação estrita.
    // Portanto, espaços extras são removidos, mas diferenças
    // de formato ou de tipo ainda podem afetar a comparação.
    $correta = $resposta === $questao["resposta"];


    // Se a resposta estiver correta, o aluno ganha 10 XP.
    // Caso contrário, recebe 0 XP.
    $xp = $correta ? 10 : 0;


    // Registra a resposta no banco de dados.
    // São enviados:
    // $usuarioId       = ID do aluno;
    // $questao["id"]   = ID da questão respondida;
    // $resposta        = resposta digitada;
    // $correta         = informa se acertou ou errou;
    // $xp              = quantidade de XP conquistada.
    $respostaObj->registrar(
        $usuarioId,
        $questao["id"],
        $resposta,
        $correta,
        $xp
    );


    // Verifica se o aluno acertou a questão.
    if ($correta) {

        // Adiciona 10 pontos de experiência ao usuário.
        // O método pertence à classe Usuario.
        $usuarioObj->adicionarXP(
            $usuarioId,
            10
        );
    }


    // Armazena as informações que serão utilizadas
    // para apresentar o resultado ao aluno.
    $resultado = [

        // Informa se a resposta está correta ou incorreta.
        "correta" => $correta,

        // Guarda a resposta correta cadastrada no banco.
        "resposta" => $questao["resposta"],

        // Guarda a explicação de como resolver a questão.
        "explicacao" => $questao["explicacao"]
    ];
}

?>

<!DOCTYPE html>

<!-- Define que o documento utiliza HTML5. -->
<html lang="pt-BR">

<head>

    <!-- Permite exibir corretamente caracteres especiais,
    como acentos e cedilha. -->
    <meta charset="UTF-8">

    <!-- Faz a página se adaptar a celulares, tablets
    e computadores. -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- Define o título exibido na aba do navegador. -->
    <title>Equações - MathPlay</title>

    <!-- Importa o arquivo CSS responsável pela aparência
    da página, como cores, botões, espaços e fontes. -->
    <link
        rel="stylesheet"
        href="../css/style.css"
    >

</head>

<body>

<!-- 11. CABEÇALHO DA PÁGINA -->

<header class="topo">

    <!-- Nome e identidade visual da plataforma MathPlay. -->
    <div class="logo">
        📚 Math<span>Play</span>
    </div>

    <!-- Link para voltar ao painel principal do aluno. -->
    <a href="../dashboard.php">
        ← Dashboard
    </a>

</header>


<!--  12. CONTEÚDO PRINCIPAL DA PÁGINA -->

<main class="questao-page">

    <!-- Mostra o número da questão atual e a quantidade
    total de questões disponíveis.

    O $numero + 1 é utilizado porque a contagem exibida
    começa em 1, embora o índice do array comece em 0. -->
    <span class="badge">
        Questão <?= $numero + 1 ?>
        de <?= count($questoes) ?>
    </span>


    <!-- Título da atividade de matemática. -->
    <h1>
        ✏️ Equações
    </h1>


    <!-- Caixa que contém o enunciado, o formulário
    e o resultado da questão. -->
    <div class="questao">

        <!-- Exibe o enunciado da questão atual.

        htmlspecialchars() protege a saída HTML,
        evitando que caracteres especiais presentes
        no texto sejam interpretados como código HTML. -->
        <h2>
            <?= htmlspecialchars(
                $questao["enunciado"]
            ) ?>
        </h2>


        <!--  13. VERIFICA SE A QUESTÃO JÁ FOI RESPONDIDA -->

        <!-- Se $resultado for null, o aluno ainda não enviou
        uma resposta nesta exibição da página. -->
        <?php if ($resultado === null): ?>

            <!-- Formulário utilizado para enviar a resposta.
            O método POST envia os dados para esta mesma página. -->
            <form method="POST">

                <!-- Campo no qual o aluno digita sua resposta.

                name="resposta" é o nome utilizado pelo PHP
                para recuperar o valor com $_POST["resposta"].

                required impede o envio vazio pelo navegador.

                autofocus coloca o cursor nesse campo
                quando a página é carregada. -->
                <input
                    type="text"
                    name="resposta"
                    class="resposta"
                    placeholder="Digite o valor de x"
                    required
                    autofocus
                >

                <!-- Botão que envia o formulário para correção. -->
                <button
                    type="submit"
                    class="btn full"
                >
                    Resolver 🚀
                </button>

            </form>


        <!-- Se já existe um resultado, mostra a correção. -->
        <?php else: ?>


            <!--  14. MOSTRA SE O ALUNO ACERTOU OU ERROU -->

            <!-- Verifica se o resultado armazenado indica
            que a resposta está correta. -->
            <?php if ($resultado["correta"]): ?>

                <!-- Bloco visual exibido quando o aluno acerta.
                As classes "resultado" e "certo" são estilizadas
                pelo arquivo CSS. -->
                <div class="resultado certo">

                    <!-- Mensagem de comemoração. -->
                    <h2>
                        🎉 Parabéns!
                    </h2>

                    <!-- Mensagem informando que o aluno acertou. -->
                    <p>
                        Você resolveu corretamente!
                    </p>

                    <!-- Informa a quantidade de XP conquistada. -->
                    <strong>
                        +10 XP ⭐
                    </strong>

                </div>


            <!-- Se a resposta estiver incorreta, executa
            este bloco alternativo. -->
            <?php else: ?>

                <!-- Bloco visual para respostas incorretas. -->
                <div class="resultado errado">

                    <!-- Incentiva o aluno a aprender com o erro. -->
                    <h2>
                        💡 Vamos aprender!
                    </h2>

                    <!-- Mostra a resposta correta cadastrada
                    no banco de dados.

                    htmlspecialchars() protege a saída HTML. -->
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


            <!--  15. EXIBE A EXPLICAÇÃO DA QUESTÃO -->

            <!-- Essa área é mostrada tanto quando o aluno
            acerta quanto quando erra. -->
            <div class="explicacao">

                <!-- Título da explicação educativa. -->
                <h3>
                    📖 Como resolver?
                </h3>

                <!-- Exibe a explicação cadastrada no banco.

                O conteúdo pode ensinar o procedimento correto
                para resolver a equação.
                
                htmlspecialchars() protege a saída HTML. -->
                <p>
                    <?= htmlspecialchars(
                        $resultado["explicacao"]
                    ) ?>
                </p>

            </div>


            <!--16. DECIDE PARA ONDE O ALUNO VAI -->

            <!-- Verifica se existe uma próxima questão.
            Como $numero começa em 0, $numero + 1 representa
            a posição da próxima questão na contagem exibida. -->
            <?php if (
                $numero + 1 <
                count($questoes)
            ): ?>

                <!-- Se ainda houver questões, cria um link
                para abrir a próxima.-->
                <!--O parâmetro q recebe o índice seguinte.
                Exemplo: ?q=1 abre a segunda questão. -->
                <a
                    href="?q=<?= $numero + 1 ?>"
                    class="btn full"
                >
                    Próxima questão →
                </a>


            <!-- Se não houver outra questão, encerra
            a atividade e volta ao painel do aluno. -->
            <?php else: ?>

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
```
