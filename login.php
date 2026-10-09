<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - MathPlay</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body class="center">

    <div class="form-card">

        <div class="logo">
            🎮 MathPlay
        </div>

        <h2>
            Bem-vindo de volta! 👋
        </h2>

        <p>
            Entre para continuar sua aventura.
        </p>

        <?php if (isset($_GET["erro"])): ?>

            <div class="erro">

                ❌ E-mail ou senha incorretos.

            </div>

        <?php endif; ?>

        <?php if (isset($_GET["cadastro"])): ?>

            <div class="sucesso">

                ✅ Cadastro realizado!
                Agora faça login.

            </div>

        <?php endif; ?>


        <form action="autenticar.php"
              method="POST">

            <label>
                E-mail
            </label>

            <input
                type="email"
                name="email"
                placeholder="Seu e-mail"
                required
            >

            <label>
                Senha
            </label>

            <input
                type="password"
                name="senha"
                placeholder="Sua senha"
                required
            >

            <button
                type="submit"
                class="btn btn-full">

                Entrar 🎮

            </button>

        </form>

        <p class="link-text">

            Ainda não possui uma conta?

            <a href="cadastro.php">
                Criar conta
            </a>

        </p>

    </div>

</body>

</html>