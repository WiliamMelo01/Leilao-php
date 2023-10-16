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


}