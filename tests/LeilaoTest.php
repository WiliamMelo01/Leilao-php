<?php
use app\Leilao;
use app\Leiloeiro;
use app\Produto;
use app\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{

    public function testLeilao()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $leilao = new Leilao($produto, $leiloeiro);

        $this->assertGreaterThan(10, strlen($leilao->getId()));
        $this->assertIsString($leilao->getId());
        $this->assertEquals([], $leilao->getLances());
        $this->assertEquals($leiloeiro, $leilao->getLeiloeiro());
        $this->assertEquals($produto, $leilao->getProduto());
        $this->assertEquals([], $leilao->getUsuarios());
        $this->assertEquals("fechado", $leilao->getStatus());
    }

    public function testeAbrir()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $leilao = new Leilao($produto, $leiloeiro);

        $this->assertEquals("fechado", $leilao->getStatus());
        $leilao->abrir();
        $this->assertEquals("aberto", $leilao->getStatus());
    }

    public function testeAbrirLeilaoJaEncerrado()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $leilao = new Leilao($produto, $leiloeiro);

        $this->assertEquals("fechado", $leilao->getStatus());
        $leilao->abrir();
        $leilao->encerrar();
        try {
            $leilao->abrir();
            $this->fail("Você não pode abrir um leilão que já foi encerrado.");
        } catch (\Throwable $err) {
            $this->assertEquals("Você não pode abrir um leilão que já foi encerrado.", $err->getMessage());
        }

    }

    public function testeFechar()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $leilao = new Leilao($produto, $leiloeiro);

        $this->assertEquals("fechado", $leilao->getStatus());
        $leilao->abrir();
        $leilao->encerrar();
        $this->assertEquals("encerrado", $leilao->getStatus());
    }

    public function testeFecharLeilaoNaoIniciado()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $leilao = new Leilao($produto, $leiloeiro);

        $this->assertEquals("fechado", $leilao->getStatus());
        try {
            $leilao->encerrar();
            $this->fail("Você não pode encerrar um leilão que nao foi iniciado.");
        } catch (\Throwable $err) {
            $this->assertEquals("Você não pode encerrar um leilão que nao foi iniciado.", $err->getMessage());
        }
    }

    public function testAdicionarUsuario()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $usuario = new Usuario("Roberto");
        $leilao = new Leilao($produto, $leiloeiro);

        $leilao->adicionarUsuario($usuario);

        $this->assertEquals([$usuario], $leilao->getUsuarios());
    }

    public function testRemoverUsuario()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $usuario = new Usuario("Roberto");
        $usuario2 = new Usuario("Carlos");
        $leilao = new Leilao($produto, $leiloeiro);

        $leilao->adicionarUsuario($usuario);
        $leilao->adicionarUsuario($usuario2);

        $leilao->removerUsuario($usuario2);

        $this->assertEquals(["0" => $usuario], $leilao->getUsuarios());
    }

    public function testRemoverUsuarioInexistente()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $usuario = new Usuario("Roberto");
        $usuario2 = new Usuario("Carlos");
        $leilao = new Leilao($produto, $leiloeiro);

        $leilao->adicionarUsuario($usuario);

        try {
            $leilao->removerUsuario($usuario2);
            $this->fail("Você não pode remover um usuario que não faz parte deste leilão.");
        } catch (\Throwable $th) {
            $this->assertEquals("Você não pode remover um usuario que não faz parte deste leilão.", $th->getMessage());
        }

        $this->assertEquals(["0" => $usuario], $leilao->getUsuarios());
    }

}