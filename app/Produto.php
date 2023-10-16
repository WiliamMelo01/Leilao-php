<?php

namespace app;

class Produto
{
    
    private string $id;
    private string $nome;
    private float $preco;
    private string $descricao;
    private string $fabricante;

    public function __construct($nome, $preco, $descricao, $fabricante){
        $this->id = uniqid();
        $this->nome = $nome;
        $this->preco = $preco;
        $this->descricao = $descricao;
        $this->fabricante = $fabricante;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function getFabricante(): string {
        return $this->fabricante;
    }

}