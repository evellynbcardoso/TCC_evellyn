<?php

// PROCESSAMENTO DO LOGIN
session_start();

require_once "classes/usuario.php";

// Verifica se veio por POST
if($_SERVER["REQUEST_METHOD"]! == "POST"){
    header("Location: login.php");
    exit;
}
$email = trim($_POST["email"]);
$senha = $_POST["senha"];

// Tenta fazer login
if($usuario->login($email,$senha)){
// Login realizado
    header ("Location: dashboard.php");
    exit;
}else{
// Login incorreto
    header("Location: login.php?erro=1");
    exit;
}