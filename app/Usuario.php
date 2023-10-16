<?php

namespace app;
class Usuario {

    private string $id;
    private string $nome;
    private array $lances;

    public function __construct(string $nome){
        $this->id = uniqid();
        $this->nome = $nome;
        $this->lances = [];
    }

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getLances(){
        return $this->lances;
    }

    public function fazerLance(Leilao $leilao, float $valor){

        if($leilao->getStatus() != "aberto"){
            throw new \Exception("Você só pode dar um lance em um leilao aberto.");
        }

        if($leilao->getProduto()->getPreco() > $valor){
            throw new \Exception("O valor do lance não pode ser menor que o valor do produto.");
        }

        $lance = new Lance($leilao, $this, $valor);

        array_push($this->lances, $lance);
        $leilao->fazerLance($lance);

    }


}