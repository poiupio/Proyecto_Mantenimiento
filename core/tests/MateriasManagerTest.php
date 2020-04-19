<?php

use PHPUnit\Framework\TestCase;

require __DIR__ . "/../php/MateriasManager.php";

class MateriasManagerTest extends TestCase
{
    /**
     * @test
     */
    public function testGetMateria()
    {
        //Given
        $stub = $this->createMock(DataBaseManager::class);

        $response = [
            '0' => [
                'id' => '1',
                'nombre' => 'ciencias'
            ]
        ];

        $json_response = json_encode($response);

        $stub->expects($this->once())->method('realizeQuery')->willReturn($response);

        $materias_manager = MateriasManager::getInstance();

        $materias_manager->setDBManager($stub);

        $idMateria = '1';

        //When
        $result = $materias_manager->getMateria($idMateria);

        //Then
        $this->assertEquals($json_response, $result);
    }

    /**
     * @test
     */
    public function testCanNotGetMateria()
    {
        //Given
        $stub = $this->createMock(DataBaseManager::class);

        $response = null;

        $stub->expects($this->once())->method('realizeQuery')->willReturn($response);

        $materias_manager = MateriasManager::getInstance();

        $materias_manager->setDBManager($stub);

        $idMateria = '1';

        //When
        $result = $materias_manager->getMateria($idMateria);

        //Then
        $this->assertEquals("Tabla de materias esta vacia", $result);
    }

    /**
     * @test
     */
    public function testSetMateria()
    {
        //Given
        $stub = $this->createMock(DataBaseManager::class);

        $response = true;

        $stub->expects($this->once())->method('insertQuery')->with(
            $this->stringContains("INSERT INTO materias (nombre) VALUES('ciencias')")
        )->willReturn($response);

        $materias_manager = MateriasManager::getInstance();

        $materias_manager->setDBManager($stub);

        $nameMateria = 'ciencias';
        $query = "INSERT INTO materias (nombre) VALUES('$nameMateria')";

        //When
        $result = $materias_manager->setMateria($nameMateria);
        //Then
        $this->assertEquals($query, $result);
    }

    /**
     * @test
     */
    public function testCanNotSetMateria()
    {
        //Given
        $stub = $this->createMock(DataBaseManager::class);

        $response = "No se estableció la conexión: los parámetros están incorrectos.";

        $stub->expects($this->once())->method('insertQuery')->with(
            $this->stringContains("INSERT INTO materias (nombre) VALUES('180')")
        )->willReturn($response);

        $materias_manager = MateriasManager::getInstance();

        $materias_manager->setDBManager($stub);

        $nameMateria =  180;

        //When
        $result = $materias_manager->setMateria($nameMateria);

        //Then
        $this->assertEquals($response, $result);
    }

    /**
     * @test
     */
    public function testUpdateMateria()
    {
        //Given
        $stub = $this->createMock(DataBaseManager::class);

        $response = true;

        $stub->expects($this->once())->method('insertQuery')->with(
            $this->stringContains("UPDATE materias set nombre= 'ciencias' WHERE id =3")
        )->willReturn($response);

        $materias_manager = MateriasManager::getInstance();

        $materias_manager->setDBManager($stub);

        $nameMateria = 'ciencias';
        $idMateria = 3;
        $query = "UPDATE materias set nombre= '$nameMateria' WHERE id =".intval($idMateria);

        //When
        $result = $materias_manager->updateMateria($idMateria, $nameMateria);

        //Then
        $this->assertEquals($query, $result);
    }

    /**
     * @test
     */
    public function testCanNotUpdateMateria()
    {
        //Given
        $stub = $this->createMock(DataBaseManager::class);

        $response = "No se estableció la conexión: los parámetros están incorrectos.";

        $stub->expects($this->once())->method('insertQuery')->with(
            $this->stringContains("UPDATE materias set nombre= 'ciencias' WHERE id =2")
        )->willReturn($response);

        $materias_manager = MateriasManager::getInstance();

        $materias_manager->setDBManager($stub);

        $nameMateria = 'ciencias';
        $idMateria = 2;

        //When
        $result = $materias_manager->updateMateria($idMateria, $nameMateria);

        //Then
        $this->assertEquals("No se estableció la conexión: los parámetros están incorrectos.", $result);
    }

    //Pruebas de materiasManager
    /** @test */
    public function testDeleteMaterias()
    {
        $db = $this->createMock(DataBaseManager::class);

        $response = TRUE;

        $db->expects($this->once())->method('insertQuery')->with(
            $this->stringContains("DELETE FROM materias WHERE id")
        )->willReturn($response);

        $adminMateria = MateriasManager::getInstance();
        $adminMateria->setDBManager($db);

        $idMateria = "2";

        $query = "DELETE FROM materias WHERE id = '$idMateria'";
        
        $this->assertEquals($query, $adminMateria->deleteMateria($idMateria));
    }
    //Pruebas de materiasManager
    /** @test */
    public function testCanNotConnectMaterias()
    {

        $stub = $this->createMock(DataBaseManager::class);

        $response = "Error de conexion: Can't connect to MySQL server";
        $stub->expects($this->once())
            ->method('insertQuery')->with(
                $this->stringContains("DELETE FROM materias WHERE id")
            )
            ->willReturn($response);

        $adminMateria = MateriasManager::getInstance();
        $adminMateria->setDBManager($stub);

        $idMateria = 2;

        $this->assertEquals("Error de conexion: Can't connect to MySQL server", $adminMateria->deleteMateria($idMateria));
    }

    //Pruebas de materiasManager
    /** @test */
    public function testGetAllMaterias()
    {
        $db = $this->createMock(DataBaseManager::class);
        $input = [
            '0' => [
                'id' => '2',
                'nombre' => 'Semat'
            ]
        ];;
        $output = [[
            '0' => [
                'id' => '2',
                'name' => 'Semat'
            ]
        ]];
        $db->expects($this->once())->method('realizeQuery')->with(
            $this->stringContains("SELECT * FROM materias")
        )->willReturn($input);
        $adminMateria = MateriasManager::getInstance();
        $adminMateria->setDBManager($db);
        $this->assertEquals(json_encode($output), $adminMateria->getAllMateria());
    }

    //Pruebas de materiasManager
    /** @test */
    public function testCanNotGetAllMaterias()
    {
        $db = $this->createMock(DataBaseManager::class);

        $response = null;

        $db->expects($this->once())->method('realizeQuery')->with(
            $this->stringContains("SELECT * FROM materias")
        )->willReturn($response);
        $adminMateria = MateriasManager::getInstance();
        $adminMateria->setDBManager($db);

        $this->assertEquals("tabla materia vacia", $adminMateria->getAllMateria());
    }
}
