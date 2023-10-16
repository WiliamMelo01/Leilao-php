<?php
use app\Lance;
use app\Leilao;
use app\Leiloeiro;
use app\Produto;
use app\Usuario;

use PHPUnit\Framework\TestCase;

class LanceTest extends TestCase {

    public function testLance(){

        $usuario1 = new Usuario("João");
        $produto1 = new Produto("Iphone 18", 18000, "Celular bacana", "Apple");
        $leiloeiro1 = new Leiloeiro("Carlos");
        $leilao1 = new Leilao($produto1, $leiloeiro1);
        $lance1 = new Lance($leilao1, $usuario1, 19000);

        $this->assertEquals($leilao1,$lance1->getLeilao());
        $this->assertEquals($usuario1,$lance1->getUsuario());
        $this->assertEquals(19000,$lance1->getValor());
        $this->assertGreaterThan(10, strlen($lance1->getId()));
        $this->assertIsString($lance1->getId());

    }

}