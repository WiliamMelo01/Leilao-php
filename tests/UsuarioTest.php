<?php
use app\Usuario;
use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase {

    public function testUsuario(){
        $usuario = new Usuario("João");

        $this->assertGreaterThan(10,strlen($usuario->getId()));
        $this->assertIsString($usuario->getId());
        $this->assertEquals("João",$usuario->getNome());
        $this->assertEquals([],$usuario->getLances());

    }

}