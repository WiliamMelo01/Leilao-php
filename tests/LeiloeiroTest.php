<?php
use app\Leiloeiro;
use PHPUnit\Framework\TestCase;

class LeiloeiroTest extends TestCase {

    public function testLeiloeiro(){
        $leiloeiro = new Leiloeiro("João");

        $this->assertEquals("João", $leiloeiro->getNome());
        $this->assertGreaterThan(10,strlen($leiloeiro->getId()));
        $this->assertIsString($leiloeiro->getId());
    }

    public function testLeiloar(){
        $leiloeiro = new Leiloeiro("Carlos");

        $leiloeiro->leiloar("Roberto", "Iphone 18", 19000);

        $this->expectOutputString("  Roberto fez um lance de R$19.000,00 no produto Iphone 18.");
    }

}