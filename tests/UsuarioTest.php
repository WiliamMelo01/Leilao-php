<?php
use app\Lance;
use app\Leilao;
use app\Leiloeiro;
use app\Produto;
use app\Usuario;
use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{

    public function testUsuario()
    {
        $usuario = new Usuario("João");

        $this->assertGreaterThan(10, strlen($usuario->getId()));
        $this->assertIsString($usuario->getId());
        $this->assertEquals("João", $usuario->getNome());
        $this->assertEquals([], $usuario->getLances());
    }

    public function testFazerLance()
    {

        $usuario1 = new Usuario("João");
        $produto1 = new Produto("Iphone 18", 18000, "Celular bacana", "Apple");
        $leiloeiro1 = new Leiloeiro("Carlos");
        $leilao1 = new Leilao($produto1, $leiloeiro1);
        $leilao1->abrir();
        $leilao1->adicionarUsuario($usuario1);
        $usuario1->fazerLance($leilao1, 19000);

        $this->assertCount(1, $usuario1->getLances());
        $this->assertCount(1, $leilao1->getLances());
        $this->expectOutputString("  João fez um lance de R$19.000,00 no produto Iphone 18.");
    }
    public function testFazerLanceComValorABaixoDoProduto()
    {

        $usuario1 = new Usuario("João");
        $produto1 = new Produto("Iphone 18", 18000, "Celular bacana", "Apple");
        $leiloeiro1 = new Leiloeiro("Carlos");
        $leilao1 = new Leilao($produto1, $leiloeiro1);
        $leilao1->abrir();
        try {
            $usuario1->fazerLance($leilao1, 10);
            $this->fail("O valor do lance não pode ser menor que o valor do produto.");
        } catch (\Exception $exc) {
            $this->assertEquals($exc->getMessage(), "O valor do lance não pode ser menor que o valor do produto.");
        }
    }
    public function testFazerLanceEmLeilaoFechado()
    {

        $usuario1 = new Usuario("João");
        $produto1 = new Produto("Iphone 18", 18000, "Celular bacana", "Apple");
        $leiloeiro1 = new Leiloeiro("Carlos");
        $leilao1 = new Leilao($produto1, $leiloeiro1);
        try {
            $usuario1->fazerLance($leilao1, 10);
            $this->fail("Você só pode dar um lance em um leilao aberto.");
        } catch (\Exception $exc) {
            $this->assertEquals($exc->getMessage(), "Você só pode dar um lance em um leilao aberto.");
            $this->assertCount(0, $leilao1->getLances());
        }
    }

    public function testFazerLanceEmLeilaoEncerrado()
    {

        $usuario1 = new Usuario("João");
        $produto1 = new Produto("Iphone 18", 18000, "Celular bacana", "Apple");
        $leiloeiro1 = new Leiloeiro("Carlos");
        $leilao1 = new Leilao($produto1, $leiloeiro1);
        $leilao1->abrir();
        $leilao1->encerrar();
        try {
            $usuario1->fazerLance($leilao1, 10);
            $this->fail("Você só pode dar um lance em um leilao aberto.");
        } catch (\Exception $exc) {
            $this->assertEquals($exc->getMessage(), "Você só pode dar um lance em um leilao aberto.");
            $this->assertCount(0, $leilao1->getLances());
        }
    }

}