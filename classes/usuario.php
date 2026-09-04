<?php

// Criação da classe Usuario.
// A classe representa um usuário/aluno do sistema.
class Usuario{
    // Atributos privados da classe.
    // "private" significa que eles só podem ser acessados diretamente
    // dentro da própria classe.

    private : string $nome;
    private : string $email;
    private : string $senha;
    private : int $nivel;
    private : int $xp;

    // Construtor da classe.
    // É executado automaticamente quando criamos um novo objeto Usuario.
    //
    // Recebe:
    // $nome  -> nome do aluno
    // $email -> e-mail do aluno
    // $senha -> senha informada pelo aluno

    public __contruct(string $nome, string $email,string $senha){
    // Guarda o nome recebido dentro do atributo $nome.
      $this-> nome = $nome;
    // Guarda o e-mail recebido dentro do atributo $email.
      $this-> email = $email;
    // Transforma a senha em um hash antes de armazená-la.
    // Isso evita guardar a senha em texto puro.
      $this-> senha = password_hash($senha, PASSWORD_DEFAULT);
    // Todo novo usuário começa no nível 1.
      $this-> $nivel = 1;
    // Todo novo usuário começa com 0 de XP.
      $this-> xp = 0;
    }

    // Método responsável por retornar o nome do usuário.
    // Como $nome é private, usamos esse método para acessá-lo.
   public function getNome(): string
    {
        return $this->nome;
        
    }

// Método responsável por retornar o e-mail do usuário.
   public function getEmail(): string
    {
        return $this->email;

    }

// Método responsável por retornar o nível atual do usuário.
   public function getNivel(): int
    {
        return $this->nivel;

    }

// Método responsável por retornar a quantidade de XP
// que o usuário possui atualmente.
   public function getXP(): int
    {
        return $this->xp;

    }


// Método responsável por adicionar XP ao usuário.
// $quantidade representa a quantidade de XP recebida.
    public function adicionarXP(int $quantidade): void {
        $this->xp += $quantidade;
        if($this->xp >= 100){
            $this->subirNivel();
        }
    }

// Adiciona a quantidade recebida ao XP atual.
// Exemplo:
// Se o usuário possui 50 XP e ganha 20 XP:
// 50 + 20 = 70 XP.
    public dunction subirNivel(): void{
    // Verifica se o usuário alcançou 100 XP.
        $this->nivel++;
    // Caso tenha alcançado 100 XP ou mais,
    // chama o método responsável por aumentar o nível.
        $this->xp = 0;
    }

// Método responsável por verificar se uma senha está correta.
// Recebe a senha digitada pelo usuário.
// Retorna true (verdadeiro) se estiver correta
// ou false (falso) se estiver incorreta.
    public function verificarSenha(string $senha): bool {
    // password_verify compara a senha digitada
    // com o hash armazenado no atributo $senha.
        return password_verify($senha, $this->senha);
    }
} 