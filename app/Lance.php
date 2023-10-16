<?php

namespace app;

use app\Leilao;
use app\Usuario;

class Lance {

    private string $id;

    private Leilao $leilao;

    private Usuario $usuario;

    private float $valor;

    public function __construct(Leilao $leilao, Usuario $usuario, float $valor){
        $this->id = uniqid();
        $this->leilao = $leilao;
        $this->usuario = $usuario;
        $this->valor = $valor;
    }

    public function getId(){
        return $this->id;
    }
    public function getLeilao(){
        return $this->leilao;
    }
    public function getUsuario(){
        return $this->usuario;
    }
    public function getValor(){
        return $this->valor;
    }

}

