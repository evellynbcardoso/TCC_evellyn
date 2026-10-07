<?php

// PROCESSAMENTO DA RESPOSTA
session_start();
require_once "classes/questao.php";
require_once "classes/usuario.php";

// Verifica se o aluno está logado
if(!isset($_SESSION["usuario_id"])){
    header("Location: login.php");
    exit;
}

// Verifica se recebeu os dados
if(
    !isset($_POST["quetao_id"])||
    !isset($_POST["resposta"])
){
    header("Location:dashboard.php");
    exit;
}

$quetaoId = (int) $_POST["questao_id"];
$resposta =  $_POST["resposta"];
$usuarioId = $_SESSION["usuario_id"];

// BUSCA A QUESTÃO
$questoes = new Questao();

$questao = $questoes->buscarPorId($questaoId);

if (!$questao) {

    die("Questão não encontrada.");
}

// VERIFICA SE ACERTOU
