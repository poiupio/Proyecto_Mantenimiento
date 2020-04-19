<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../php/DataBaseManager.php";

class DataBaseManagerTest extends TestCase
{

    /**
     * @test
     */
    public function testInsertQuery()
    {
        //Given
        $stub = $this->createMock(mysqli::class);
        $response = true;

        $stub->expects($this->once())->method('query')->with(
            $this->stringContains("INSERT INTO materias (nombre) VALUES('ciencias')")
        )->willReturn($response);

        $DBM = DataBaseManager::getInstance();
        $DBM->set_msqli($stub);

        $query = "INSERT INTO materias (nombre) VALUES('ciencias')";

        //When
        $result = $DBM->insertQuery($query);

        //Then
        $this->assertEquals(true, $result);

    }

    /**
     * @test
     */
    public function testCanNotInsertQuery()
    {
        //Given
        $stub = $this->createMock(mysqli::class);
        $response = false;

        $stub->expects($this->once())->method('query')->with(
            $this->stringContains("INSERT INTO materias (nombre) VALUES('ciencias')")
        )->willReturn($response);

        $DBM = DataBaseManager::getInstance();
        $DBM->set_msqli($stub);

        $query = "INSERT INTO materias (nombre) VALUES('ciencias')";

        //When
        $result = $DBM->insertQuery($query);
        //Then
        $this->assertEquals(false, $result);
    }

    /**
     * @test
     */
    public function testRealizeQuery()
    {
        //Given
        $stub = $this->createMock(mysqli::class);
        $response = [array(
            '0' => [array(
                'id' => '1',
                'nombre' => '1',
                'tipo' => '2020-02-16 10:02:15',
                'clave' => 'facil'
            )]
        )];;

        $stub->expects($this->once())->method('query')->with(
            $this->stringContains("SELECT * FROM usuario WHERE id = 1")
        )->willReturn($response);

        $DBM = DataBaseManager::getInstance();
        $DBM->set_msqli($stub);
        $id = 1;
        $query = "SELECT * FROM usuario WHERE id = $id";

        //When
        $result = $DBM->insertQuery($query);

        //Then
        $this->assertEquals($response, $result);
    }

    /**
     * @test
     */
    public function testCanNotRealizeQuery()
    {
        //Given
        $stub = $this->createMock(mysqli::class);
        $response = "Error de conexion: Can't connect to MySQL server";

        $stub->expects($this->once())->method('query')->with(
            $this->stringContains("SELECT * FROM usuario WHERE id = 1")
        )->willReturn($response);

        $DBM = DataBaseManager::getInstance();
        $DBM->set_msqli($stub);

        $query = "SELECT * FROM usuario WHERE id = 1";

        //When
        $result = $DBM->insertQuery($query);

        //Then
        $this->assertEquals($response, $result);

    }
}