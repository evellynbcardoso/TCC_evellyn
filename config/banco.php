<?php

// CLASSE BANCO
// Responsável por estabelecer e gerenciar a conexão
// entre o sistema MathPlay e o banco de dados MySQL.
class Banco
{
    // Endereço do servidor onde o MySQL está instalado.
    // "localhost" significa que o banco está no próprio
    // computador em que o sistema está sendo executado.
    private string $host = "localhost";

    // Nome do usuário utilizado para acessar o MySQL.
    // Neste exemplo, está sendo utilizado o usuário root.
    private string $usuario = "root";

    // Senha do usuário do banco de dados.
    // A string vazia significa que nenhuma senha foi
    // configurada neste exemplo.
    private string $senha = "";

    // Nome do banco de dados utilizado pelo MathPlay.
    private string $banco = "mathplay";

    // Atributo privado que armazenará o objeto PDO
    // responsável pela conexão com o banco de dados.
    private PDO $conexao;

    // CONSTRUTOR DA CLASSE
    // É executado automaticamente quando um objeto Banco
    // é criado.
    // Sua função é tentar estabelecer a conexão
    // com o banco de dados MySQL.
    public function __construct()
    {
        // Inicia um bloco try para tentar executar
        // a conexão e suas configurações.
        try {

            // Cria a conexão com o banco utilizando PDO.
            // mysql: informa que o banco utilizado é MySQL.
            // host = endereço do servidor.
            // port = porta de conexão do MySQL (3308).
            // dbname = nome do banco de dados.
            // charset = codificação utilizada para suportar
            // caracteres especiais, acentos e outros símbolos.
            // Em seguida, são informados o usuário e a senha.
            $this->conexao = new PDO(
                "mysql:host={$this->host};port=3308;dbname={$this->banco};charset=utf8mb4",
                $this->usuario,
                $this->senha
            );

            // Configura o PDO para lançar exceções
            // quando ocorrer um erro em uma operação
            // com o banco de dados.
            // Isso facilita a identificação de problemas
            // durante a execução das consultas SQL.
            $this->conexao->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            // Define o formato padrão dos resultados
            // retornados pelas consultas SQL.
            // PDO::FETCH_ASSOC faz com que os resultados
            // sejam organizados em arrays associativos,
            // utilizando os nomes das colunas como chaves.
            // Exemplo: $usuario["nome"].
            $this->conexao->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

        // Captura erros de conexão ou de configuração
        // que sejam lançados como PDOException.
        } catch (PDOException $e) {

            // Interrompe a execução do programa e exibe
            // uma mensagem orientando a verificar
            // o funcionamento do MySQL e a existência
            // do banco de dados "mathplay".
            // A variável $e contém os detalhes técnicos
            // da exceção, mas não é exibida nesta mensagem.
            die(
                "Erro ao conectar ao banco de dados. " .
                "Verifique se o MySQL está ligado e se o banco mathplay existe."
            );
        }
    }

    // MÉTODO GET CONEXAO
    // Disponibiliza a conexão PDO para outras classes
    // do sistema, como Usuario, Questao, Resposta e Jogo.
    // O ": PDO" indica que o método retorna um objeto PDO.
    public function getConexao(): PDO
    {
        // Retorna a conexão já estabelecida pelo construtor.
        // Assim, outras classes podem executar consultas
        // sem precisar criar uma nova conexão.
        return $this->conexao;
    }
}