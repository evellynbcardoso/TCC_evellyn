<?php

// =========================================================
// ENCERRA A SESSÃO DO ALUNO
// =========================================================

session_start();

// Apaga todas as informações da sessão
session_unset();

// Destrói a sessão
session_destroy();

// Volta para a página inicial
header("Location: index.php");

exit;