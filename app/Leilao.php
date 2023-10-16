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

    public function adicionarUsuario(Usuario $usuario)
    {
        array_push($this->usuarios, $usuario);
    }

    public function removerUsuario(Usuario $usuario)
    {
        $key = "";
        foreach ($this->usuarios as $chave => $objeto) {
            if ($objeto->getId() === $usuario->getId()) {
                $key = $chave;
                break;
            }
        }

        if ($key !== "") {
            unset($this->usuarios[$key]);
            return;
        }

        throw new \Exception("Você não pode remover um usuario que não faz parte deste leilão.");

    }

    public function fazerLance(Lance $lance)
    {

        if ($this->status === "aberto") {

            $usuarioEncontrado = null;
            foreach ($this->usuarios as $usuario) {
                if ($usuario->getId() == $lance->getUsuario()->getId()) {
                    $usuarioEncontrado = $usuario;
                }
            }

            if ($usuarioEncontrado != null) {
                array_push($this->lances, $lance);
                $this->anunciarLance($lance);
                return;
            }

            throw new \Exception("Para fazer um lance voce precisa fazer parte do leilao.");
        }

        throw new \Exception("Você só pode fazer um lance em um leilao aberto");

    }

    public function anunciarLance(Lance $lance)
    {
        $this->getLeiloeiro()->leiloar($lance->getUsuario()->getNome(), $lance->getLeilao()->getProduto()->getNome(), $lance->getValor());
    }

    public function getMaioresLances()
    {
        if ($this->status === "encerrado") {
            // Ordena os lances em ordem decrescente com base no valor
            usort($this->lances, function ($a, $b) {
                return $b->getValor() - $a->getValor();
            });
            //Se ter 3 ou menos lances retorna todos eles em ordem crescente
            if (count($this->lances) <= 3) {
                return $this->lances;
            }
            // Retorna os 3 maiores lances
            return array_slice($this->lances, 0, 3);
        }

        throw new \Exception("Você só pode obter os maiores lances de um leilão encerrado.");
    }

    public function getMediaLances()
    {
        if (count($this->lances) > 0) {
            $qtdeLances = count($this->lances);
            $valorTotal = 0;
            foreach($this->lances as $lance){
                $valorTotal += $lance->getValor();
            }
            return number_format($valorTotal / $qtdeLances, 2, ",", ".");
        }

        throw new \Exception("Você precisa ter ao menos um lance para calcular a media.");

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