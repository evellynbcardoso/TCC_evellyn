<?php

// CLASSE USUARIO
// Responsável pelo cadastro, busca e gerenciamento
// dos usuários, incluindo XP e níveis no MathPlay.

class Usuario
{
    // Atributo privado que armazena a conexão com
    // o banco de dados MySQL por meio do PDO.
    private PDO $db;

    // CONSTRUTOR DA CLASSE
    // É executado automaticamente ao criar um objeto
    // da classe Usuario.
    // Recebe a conexão com o banco de dados.
    public function __construct(PDO $db)
    {
        // Armazena a conexão recebida para que os
        // métodos da classe possam acessar o banco.
        $this->db = $db;
    }

    // MÉTODO CADASTRAR
    // Cadastra um novo usuário no banco de dados.
    // Parâmetros:
    // $nome  = Nome do usuário.
    // $email = E-mail do usuário.
    // $senha = Senha informada no cadastro.
    // Retorna true se o comando for executado com sucesso
    // ou false se a execução falhar.
    public function cadastrar(
        string $nome,
        string $email,
        string $senha
    ): bool {

        // Transforma a senha em um hash seguro.
        // Assim, a senha original não é armazenada
        // diretamente no banco de dados.
        $senhaHash = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );

        // Comando SQL que insere um novo usuário
        // na tabela "usuarios".
        // Os campos XP e nível começam com os valores:
        // XP = 0 e nível = 1.
        // Os símbolos ? são parâmetros que receberão
        // os valores durante a execução do comando.
        $sql = "
            INSERT INTO usuarios
            (nome, email, senha, xp, nivel)
            VALUES (?, ?, ?, 0, 1)
        ";

        // Prepara o comando SQL antes de executá-lo.
        // O prepare() permite trabalhar com parâmetros.
        $stmt = $this->db->prepare($sql);

        // Executa o cadastro com os dados informados.
        // strtolower($email) converte o e-mail para
        // letras minúsculas para padronizar o cadastro.
        // A senha enviada ao banco é o hash gerado,
        // e não a senha original.
        return $stmt->execute([
            $nome,
            strtolower($email),
            $senhaHash
        ]);
    }

    // MÉTODO BUSCAR POR E-MAIL
    // Procura um usuário utilizando seu endereço de e-mail.
    // Recebe o e-mail como texto (string).
    // Retorna um array com os dados encontrados
    // ou null se o usuário não existir.
    public function buscarPorEmail(string $email): ?array
    {
        // Consulta SQL que busca os dados do usuário
        // cujo e-mail corresponde ao valor informado.
        $sql = "
            SELECT *
            FROM usuarios
            WHERE email = ?
        ";

        // Prepara a consulta SQL utilizando PDO.
        $stmt = $this->db->prepare($sql);

        // Executa a consulta com o e-mail convertido
        // para letras minúsculas.
        $stmt->execute([
            strtolower($email)
        ]);

        // Recupera o primeiro registro encontrado.
        // O fetch() retorna os dados ou false
        // quando nenhum usuário é encontrado.
        $usuario = $stmt->fetch();

        // Se encontrou o usuário, retorna seus dados.
        // Caso contrário, retorna null.
        return $usuario ?: null;
    }

    // MÉTODO BUSCAR POR ID
    // Procura um usuário pelo seu identificador (ID).
    // Recebe o ID como número inteiro (int).
    // Retorna os dados do usuário em um array
    // ou null se nenhum registro for encontrado.
    public function buscarPorId(int $id): ?array
    {
        // Consulta SQL que seleciona os dados
        // do usuário que possui o ID informado.
        $sql = "
            SELECT *
            FROM usuarios
            WHERE id = ?
        ";

        // Prepara a consulta SQL antes da execução.
        $stmt = $this->db->prepare($sql);

        // Executa a consulta substituindo o ? pelo ID.
        $stmt->execute([$id]);

        // Recupera os dados do usuário encontrado.
        $usuario = $stmt->fetch();

        // Retorna o registro encontrado ou null
        // se não existir um usuário com esse ID.
        return $usuario ?: null;
    }

    // MÉTODO ADICIONAR XP
    // Adiciona pontos de experiência (XP) ao usuário
    // e calcula seu nível com base no total acumulado.
    // Parâmetros:
    // $id = ID do usuário que receberá os pontos.
    // $xp = Quantidade de XP que será adicionada.
    // O ": void" indica que o método não retorna valor.
    public function adicionarXP(
        int $id,
        int $xp
    ): void {

        // Busca os dados do usuário pelo ID informado.
        $usuario = $this->buscarPorId($id);

        // Verifica se o usuário foi encontrado.
        // Se não existir, encerra o método sem atualizar.
        if (!$usuario) {
            return;
        }

        // Soma o XP atual do usuário com os novos pontos.
        $novoXP = $usuario["xp"] + $xp;

        // Calcula o nível com base no XP acumulado.
        // A função intdiv() realiza uma divisão inteira.
        // A cada 100 XP acumulados, o usuário avança
        // para o próximo nível.
        // Exemplos:
        // 0 a 99 XP   = nível 1
        // 100 a 199 XP = nível 2
        // 200 a 299 XP = nível 3
        $novoNivel = intdiv(
            $novoXP,
            100
        ) + 1;

        // Comando SQL que atualiza o XP e o nível
        // do usuário na tabela "usuarios".
        // A atualização é feita usando o ID do usuário.
        $sql = "
            UPDATE usuarios
            SET xp = ?, nivel = ?
            WHERE id = ?
        ";

        // Prepara o comando SQL de atualização.
        $stmt = $this->db->prepare($sql);

        // Executa a atualização com os novos valores:
        // 1º parâmetro = novo total de XP.
        // 2º parâmetro = novo nível calculado.
        // 3º parâmetro = ID do usuário atualizado.
        $stmt->execute([
            $novoXP,
            $novoNivel,
            $id
        ]);
    }
}
