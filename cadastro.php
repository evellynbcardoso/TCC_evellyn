<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="center">
    <div class="form-card">
        <div class="logo">
            <h1>🎮 MathPlay</h1>
        </div>
        <h2>
            Crie a sua conta  🚀
        </h2>
        <p>
            Comece a sua aventura matemática!
        </p>
        <form action="cadastrar.php" method="POST">
            <label> Nome </label>
            <input type="text"
            name="nome"
            placeholder="Digite o seu nome"
            required >

            <label >
                E-mail
            </label>
             <input type="text"
             name="e-mail"
             placeholder="Digite o seu email"
             required >
            
            <label >
                Senha
            </label>
            <input type="text"
            name="senha"
            placeholder="Digite a sua senha "
            required >
        </form>
    </div>
</body>
</html>