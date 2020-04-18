<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . "/../php/ParejasManager.php";

class ParejasManagerTest extends TestCase
{
    //     Delete pareja     //
    /** @test */
    public function testDeletePareja()
    {
        $stub = $this->createMock(DataBaseManager::class);
        $response = TRUE;
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);
        $adminPareja = ParejasManager::getInstance();
        $adminPareja->setDBManager($stub);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length=10;
        $id=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $idMateria=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $this->assertEquals("", $adminPareja->deletePareja($id,$idMateria));
    }

    //     Can't connect to DB when I try to Delete Pareja     //
    /** @test */
    public function testCantConnectToDBWhenDeletePareja()
    {
        $stub = $this->createMock(DataBaseManager::class);
        $response = "Error de conexion: Can't connect to MySQL server";
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);
        $adminPareja = ParejasManager::getInstance();
        $adminPareja->setDBManager($stub);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length=10;
        $id=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $idMateria=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $this->assertEquals("Error de conexion: Can't connect to MySQL server", $adminPareja->deletePareja($id,$idMateria));
    }

    //     Obtener todas las parejas    //
    /** @test */
    public function testGetAllParejasTheMateria()
    {
        $stub = $this->createMock(DataBaseManager::class);
        $response = [array(
            '0' => [array(
                'concepto' => 'concepto1',
                'descripcion' => 'descripcion1'
            )]
        )];;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        $adminPareja = ParejasManager::getInstance();
        $adminPareja->setDBManager($stub);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length=10;
        $idMateria=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $this->assertEquals(json_encode($response), $adminPareja->getAllParejasTheMateria($idMateria));
    }

    //     Obtener todas las parejas, sin embargo, no hay parejas     //
    /** @test */
    public function testNoHayParejasTheMateria()
    {
        $stub = $this->createMock(DataBaseManager::class);
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        $adminPareja = ParejasManager::getInstance();
        $adminPareja->setDBManager($stub);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length=10;
        $idMateria=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $query = "SELECT concepto,descripcion FROM parejas WHERE idmateria = $idMateria";
        $this->assertEquals($query, $adminPareja->getAllParejasTheMateria($idMateria));
    }

    //     Obtener todas las parejas    //
    /** @test */
    public function testGetAllParejas()
    {
        $stub = $this->createMock(DataBaseManager::class);
        $input = [array(
            'id' => '1',
            'idmateria' => '1',
            'concepto' => 'concepto1',
            'descripcion' => 'descripcion1'
        )];
        //Lleva doble corchete por ser una lista de arrays
        $output = [[array(
            'id' => '1',
            'idMatter' => '1',
            'concept' => 'concepto1',
            'definition' => 'descripcion1'
        )]];
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($input);
        $adminPareja = ParejasManager::getInstance();
        $adminPareja->setDBManager($stub);
        $this->assertEquals(json_encode($output), $adminPareja->getAllParejas());
    }

    //     Obtener todas las parejas, sin embargo, no hay parejas    //
    /** @test */
    public function testNoHayGetAllParejas()
    {
        $stub = $this->createMock(DataBaseManager::class);
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        $adminPareja = ParejasManager::getInstance();
        $adminPareja->setDBManager($stub);
        $this->assertEquals("tabla materia vacia", $adminPareja->getAllParejas());
    }

    //     Asigna valores al resultado    //
    /** @test */
    public function testSetValuesToResult()
    {
        $input = [array(
                'id' => '1',
                'idmateria' => '1',
                'concepto' => 'concepto1',
                'descripcion' => 'descripcion1'
        )];
        $output = [array(
            'id' => '1',
            'idMatter' => '1',
            'concept' => 'concepto1',
            'definition' => 'descripcion1'
        )];
        $adminPareja = ParejasManager::getInstance();
        $this->assertEquals($output, $adminPareja->setValuesToResult($input));
    }

    //     Asigna valores al resultado, sin embargo, no hay valores para asignar    //
    /** @test */
    public function testMaloSetValuesToResult()
    {
        $result = array();
        $adminPareja = ParejasManager::getInstance();
        $this->assertEquals($result, $adminPareja->setValuesToResult($result));
    }

}
