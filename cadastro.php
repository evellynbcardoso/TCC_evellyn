<?php

// Importa o arquivo usuario.php.
// Ele contém a classe Usuario que será utilizada neste arquivo
require_once "classes/usuario.php";

// Cria uma variável para armazenar mensagens
// que serão mostradas para o usuário.
$mensagem = "";

// Verifica se o formulário foi enviado utilizando o método POST.
if ($_SERVER["REQUEST_METHOD"] === "POST"){

 // Pega o nome digitado no formulário.
    $nome = $_POST["nome"];
// Pega o e-mail digitado no formulário.
    $email = $_POST["email"];
// Pega a senha digitada no formulário.
    $senha = $_POST["senha"];

// Verifica se algum dos campos está vazio.
    if if (empty($nome) || empty($email) || empty($senha)){
    // Se algum campo estiver vazio,
    // mostra uma mensagem para o usuário.
        $mensagem = "Preencha tosdos os campos!";
    }else{
    // Cria um novo objeto da classe Usuario.
    // Os valores digitados pelo usuário são enviados
    // para o construtor da classe Usuario.
        $usuario = new Usuario ($nome, $email, $senha);
    // Depois que o objeto é criado,
    // mostra uma mensagem de sucesso.
        $mensagem = "Cadastro realizado com sucesso!";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro </title>
    <style>

    /* Configurações gerais da página. */
        body{
        /* Define a fonte utilizada. */
            font-family: Arial;
        /* Define a cor de fundo. */
            background: #eef4ff;
        /* Ativa o Flexbox. */
            display:flex;
        /* Centraliza o formulário verticalmente. */
            justify-content:center;
            aling-itens:center;
        /* Faz o body ocupar toda a altura da tela. */
            heigth: 100vh;
        }

        /* Estilização da caixa de cadastro. */
        .cadastro{
            background: white;
        /* Espaçamento interno. */
            padding:30px;
            width: 350px;
        /* Arredonda os cantos. */
            border-radius: 15px ;
        /* Cria uma sombra ao redor da caixa. */
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        /* Estilização do título. */
        h1{
        /* Centraliza o texto. */
            text-aling:center;
        }

        /* Estilização dos campos de entrada. */
        input{
        /* Faz o campo ocupar toda a largura disponível. */
            width: 100%;
            padding: 12;
        /* Espaçamento entre os campos. */
            margin:8px 0;
        /* Faz o padding fazer parte da largura total. */
            box-sizing:border-box;
        /* Define a borda do campo. */
            border:1px solid #ccc;
            border-radius:8px;
        }

        /* Estilização do botão. */
            button {
        /* Faz o botão ocupar toda a largura. */
            width: 100%;
        /* Espaçamento interno. */
            padding: 12px;
        /* Espaçamento superior. */
            margin-top: 10px;
        /* Remove a borda padrão. */
            border: none;
        /* Arredonda os cantos. */
            border-radius: 8px;
        /* Cor de fundo do botão. */
            background: #4f7cff;
        /* Cor do texto. */
            color: white;
        /* Tamanho da fonte. */
            font-size: 16px;
        /* Mostra a mãozinha ao passar o mouse. */
            cursor: pointer;
        }

        /* Estilização da mensagem. */
        .mensagem{
        /* Centraliza o texto. */
            text-aling:center;
        /* Espaçamento abaixo da mensagem. */
            margin-bottom:10px;
        }

    </style>
</head>
<body>

    <!-- Caixa principal do cadastro. -->
    <div class= "cadastro">
        <!-- Título da página. -->
        <h1>🎮 Crie sua conta</h1>

        <!--
            Verifica se existe alguma mensagem.
            Se $mensagem não estiver vazia,
            o conteúdo abaixo será exibido.
        -->
        <?php if($mensagem):?>
            <div class = "mensagem">
            <!--
                Mostra o conteúdo da variável $mensagem.
                Pode aparecer:
                "Preencha todos os campos!" ou
                "Cadastro realizado com sucesso!"
            -->
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <!--
        Formulário de cadastro.
        method="POST" significa que os dados
        serão enviados através do método POST.
        -->
        <form method="POST">
        <!-- Campo para o nome do usuário. -->
            <input
            type = " text "
            name = " nome "
            placeholder = " Nome completo "
            >
        <!-- Campo para o e-mail. -->
            <input
            type = " email "
            name = " email "
            placeholder = " E-mail "
            >
        <!--
        Campo para a senha.
        type="password" faz com que os caracteres
        digitados não sejam exibidos normalmente.
         -->
            <input
            type = " password "
            name = " senha "
            placeholder = " Senha "
            >
        <!-- Botão responsável por enviar o formulário. -->
            <button type="submit">
                Criar conta
            </button>

        </form>    

    </div>
</body>
</html>