<?php
use app\Lance;
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

    public function testFazerLance()
    {
        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $leilao = new Leilao($produto, $leiloeiro);
        $usuario = new Usuario("João");
        $lance = new Lance($leilao, $usuario, 19000);

        $leilao->abrir();
        $leilao->fazerLance($lance);

        $this->assertCount(1, $leilao->getLances());
        $this->expectOutputString("João fez um lance de R$19.000,00 no produto Iphone 18");

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

    public function testGetMaioresLances()
    {

        $produto = new Produto("Iphone 18", 18000, "O melhor celular do mundo.", "Apple");
        $leiloeiro = new Leiloeiro("Muçarelo");
        $usuario1 = new Usuario("Carlos");
        $usuario2 = new Usuario("Marcos");
        $usuario3 = new Usuario("André");
        $usuario4 = new Usuario("Lucas");
        $leilao = new Leilao($produto, $leiloeiro);

        $leilao->adicionarUsuario($usuario1);
        $leilao->adicionarUsuario($usuario2);
        $leilao->adicionarUsuario($usuario3);
        $leilao->adicionarUsuario($usuario4);

        $lance1 = new Lance($leilao, $usuario1, 19000);
        $lance2 = new Lance($leilao, $usuario2, 20000);
        $lance3 = new Lance($leilao, $usuario3, 21000);
        $lance4 = new Lance($leilao, $usuario4, 18500);

        $leilao->abrir();

        $leilao->fazerLance($lance1);
        $leilao->fazerLance($lance2);
        $leilao->fazerLance($lance3);
        $leilao->fazerLance($lance4);

        $leilao->encerrar();

        $this->assertCount(3, $leilao->getMaioresLances());
        $this->assertEquals($lance3, $leilao->getMaioresLances()[0]);
        $this->assertEquals($lance2, $leilao->getMaioresLances()[1]);
        $this->assertEquals($lance1, $leilao->getMaioresLances()[2]);

    }

}