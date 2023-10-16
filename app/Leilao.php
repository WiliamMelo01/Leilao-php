<?php

namespace app;

class Leilao
{
    private string $id;
    private Produto $produto;
    /**
     * default - fechado
     * aberto
     * encerrado
     */
    private string $status;
    private array $usuarios;
    private array $lances;

    private Leiloeiro $leiloeiro;


    public function __construct(Produto $produto, Leiloeiro $leiloeiro)
    {
        $this->id = uniqid();
        $this->produto = $produto;
        $this->leiloeiro = $leiloeiro;
        $this->status = "fechado";
        $this->lances = [];
        $this->usuarios = [];
    }

    public function abrir()
    {
        if ($this->status === "fechado") {
            $this->status = "aberto";
            return;
        }

        throw new \Exception("Você não pode abrir um leilão que já foi encerrado.");

    }

    public function encerrar()
    {

        if ($this->status === "aberto") {
            $this->status = "encerrado";
            return;
        }

        throw new \Exception("Você não pode encerrar um leilão que nao foi iniciado.");

    }

    public function adicionarUsuario(Usuario $usuario){
        array_push($this->usuarios, $usuario);
    }

    public function removerUsuario(Usuario $usuario){
        $key = "";
        foreach ($this->usuarios as $chave => $objeto) {
            if ($objeto->getId() === $usuario->getId()) {
                $key = $chave;
                break;
            }
        }

        if($key !== ""){
            unset($this->usuarios[$key]);
            return;
        }

        throw new \Exception("Você não pode remover um usuario que não faz parte deste leilão.");

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProduto(): Produto
    {
        return $this->produto;
    }

    public function getLeiloeiro(): Leiloeiro
    {
        return $this->leiloeiro;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getLances(): array
    {
        return $this->lances;
    }

    public function getUsuarios(): array
    {
        return $this->usuarios;
    }

}