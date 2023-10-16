<?php

namespace app;

class Leiloeiro
{
    private string $id;
    private string $nome;

    public function __construct(string $nome)
    {
        $this->id = uniqid();
        $this->nome = $nome;
    }

    public function leiloar(string $nomeUsuario, string $nomeProduto, float $valor)
    {
        echo ($nomeUsuario . " fez um lance de R$" . number_format($valor, 2, ",", ".") . " no produto " . $nomeProduto);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

}