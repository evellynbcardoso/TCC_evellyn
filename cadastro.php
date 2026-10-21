<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Criar conta - MathPlay</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body class="center">

    <div class="form-card">

        <div class="logo">
            🎮 MathPlay
        </div>

        <h2>
            Criar sua conta 🚀
        </h2>

        <p>
            Comece sua aventura matemática!
        </p>

        <form action="cadastrar.php"
              method="POST">

            <label>
                Nome
            </label>

            <input
                type="text"
                name="nome"
                placeholder="Digite seu nome"
                required
            >

            <label>
                E-mail
            </label>

            <input
                type="email"
                name="email"
                placeholder="Digite seu e-mail"
                required
            >

            <label>
                Senha
            </label>

            <input
                type="password"
                name="senha"
                placeholder="Digite sua senha"
                required
            >

            <button
                type="submit"
                class="btn btn-full">

                Criar minha conta ✨

            </button>

        </form>

        <p class="link-text">

            Já possui uma conta?

            <a href="login.php">
                Fazer login
            </a>

        </p>

    </div>

    <?php include_once __DIR__ . '/acessibilidade.php'; ?>

</body>

</html>