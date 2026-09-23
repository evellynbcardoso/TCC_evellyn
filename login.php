<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="center">
    <div class="form-card">
        <div class="logo">
            🎮 Mathplay
        </div>
        
        <h2>BEM VINDO DE VOLTA! 👋</h2>
        <p>Entre para continuar a sua aventura. </p>
        <?php if(isset($_GET["erro"])): ?>
        <div class="erro">
            ❌ E-mail ou senha incorreta 
        </div>
        <?php endif;?>
        <?php  if(isset($_GET["cadastro"])): ?>
        <div class="sucesso">
            ✅ Cadastro realizado!
            Agora faça o login 
        </div>
        <?php endif;?>
        <form action="autenticar.php" method=""POST>
            <label >
                E-mail
            </label>
            <input type="email"
            name="email"
            placeholder="Seu email"
            require>

            <label>
                Senha
            </label>
            <input type="password"
            name="senha"
            placeholder="Sua senha"
            require>

            <button type="submit" class="btn btn-full">
                Entrar 🎮
            </button>
        </form>

        <p class="link-tex">
            Ainda não possui uma conta?

            <a href="cadastro.php">
                Criar conta
            </a>
        </p>
    </div>
    
</body>
</html>