
<?php
// =====================================================
// ARQUIVO: conexao.php
// OBJETIVO: disponibilizar a conexão com o MySQL
// PROJETO: MathPlay
// =====================================================

// Importa a classe responsável pela conexão.
require_once __DIR__ . "/config/banco.php";

try {

    // Cria o objeto responsável pelo banco.
    $banco = new Banco();

    // Obtém a conexão PDO com o banco MathPlay.
    $conexao = $banco->getConexao();

} catch (PDOException $e) {

    // Registra o erro no log do servidor.
    error_log("Erro na conexão com o banco: " . $e->getMessage());

    // Exibe uma mensagem amigável.
    die("Não foi possível conectar ao banco de dados. Verifique a configuração do MySQL.");
}
?>
