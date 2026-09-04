<?php

class jogo{
    private int $id;
    private  string $nome;
    private  string $tema;
    private int $pontuacao;

    public function __construct (
        int $id,
        string $nome,
        string $tema,
    ){
        $this->id = $id;
        $this->nome = $nome;
        $this->tema= $tema;
        $this->pontuacao= 0;
    }

      // Exercícios do jogo

      $this-> exercicio = [
        // EXERCÍCIO 1]
        [
            "pergunta" => "🚀 Sua nave está a 200 metros de altitude e desce 350 metros. Qual será sua nova altitude?",
            "resposta" => -150,
            "explicacao" => "Você começou em +200 metros e desceu 350 metros. A conta é: +200 - 350 = -150. Portanto, a nave ficou 150 metros abaixo do nível de referência."
        ],
        // EXERCÍCIO 2
        [
            "pergunta" => "🌊 Um submarino está a -80 metros de profundidade. Ele sobe 30 metros. Qual será sua nova profundidade?",
            "resposta" => -50,
            "explicacao" =>  "O submarino estava a -80 metros e subiu 30 metros. A conta é: -80 + 30 = -50. Portanto, ele ficou a 50 metros abaixo do nível do mar."
        ],
        // EXERCÍCIO 3
        [
            "pergunta" => "⚖️ Na balança do equilíbrio: x + 8 = 20. Qual é o valor de x?",
            "resposta" => 12,
            "explicacao" => "Para descobrir x, precisamos retirar 8 dos dois lados: x + 8 - 8 = 20 - 8. Portanto, x = 12.",
        ],
        // EXERCÍCIO 4
        [
            "pergunta" => "🔐 Um cofre possui a senha representada pela equação: 2x + 6 = 18. Qual é o valor de x?",
            "resposta" => 6,
            "explicacao" => "Primeiro retiramos 6 dos dois lados: 2x + 6 - 6 = 18 - 6. Temos 2x = 12. Depois dividimos os dois lados por 2: x = 6."
        ]
      ];
}

 // Retorna o nome do jogo
public function getNome(): string{
    return $this->nome;
}

// Retorna o tema do jogo
public function stringTema(): string{
    return $this->tema
}

 // Adiciona pontos ao jogador
public function adicionarPontos(int $pontos):void{
    $this->pontuacao += $pontos;
}

// Retorna a pontuação atual
public function getPontuacao():int{
    return $this-> pontuacao;
}

// Retorna todos os exercícios
public function getExercicios(): array{
    return $this-> exercicios;
}

// Verifica se a resposta do aluno está correta
public function verificarResposta(
    int $numeroExercicio,
    int $respostaAluno
): bool{
    return $respostaAluno == 
    $this->exercicio[$numeroExercicio]["resposta"];
}

// Retorna a explicação do exercício
public function  getExplicacao (int $numeroExercicio): string {
    return $this->exercicios[$numeroExercicio]["explicacao"];
}

// CRIAÇÃO DO JOGO
$jogo = new Jogo(
    1,
    "Desafio Matematico"
)