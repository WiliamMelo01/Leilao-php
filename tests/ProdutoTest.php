<?php
use app\Produto;
use PHPUnit\Framework\TestCase;

class ProdutoTest extends TestCase{

    function testProduto(){
        $produto = new Produto("Iphone 18", 18000, "Melhor celular do mundo.", "Apple");

        $this->assertEquals($produto->getDescricao(), "Melhor celular do mundo.", "Apple");
        $this->assertEquals($produto->getFabricante(),"Apple");
        $this->assertEquals($produto->getNome(), "Iphone 18");
        $this->assertEquals($produto->getPreco(), 18000);
        $this->assertGreaterThan(10,strlen($produto->getId()));
        $this->assertIsString($produto->getId());
    }

}