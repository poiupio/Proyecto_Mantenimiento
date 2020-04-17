<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . "/../php/PuntajesManajer.php";

class PuntajesManajerTest extends TestCase
{
    //     Delete puntaje     //
    //     Permite eliminar el puntaje seleccionado que se encuentren en la base de datos     //
    /** @test */
    public function testDeletePuntaje()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = TRUE;
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length=10;
        $idUsuario=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $idMateria=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $fecha=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $dificultad=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("", $adminPuntaje->deletePuntaje($idUsuario,$idMateria,$fecha,$dificultad));
    }

    //     Can't connect to DB when I try to Delete puntaje     //
    //     Permite eliminar el puntaje seleccionado que se encuentren en la base de datos     //
    /** @test */
    public function testCantConnectToDBWhenDeletePuntaje()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = "Error de conexion: Can't connect to MySQL server";
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length=10;
        $idUsuario=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $idMateria=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $fecha=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $dificultad=substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("Error de conexion: Can't connect to MySQL server", $adminPuntaje->deletePuntaje($idUsuario,$idMateria,$fecha,$dificultad));
    }

    //     Obtener todos los puntajes de un usuario     //
    //     Permite obtener todos los puntajes de un usuario seleccionado que se encuentre en la base de datos     //
    /** @test */
    public function testGetAllPuntajeForUsuario()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = [array(
            '0' => [array(
                'id_usuario' => '1',
                'id_materia' => '1',
                'fecha' => '2020-02-16 10:02:15',
                'dificultad' => 'facil',
                'puntaje' => '9',
                'parejas_encontradas' => '9'
            )]
        )];
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idUsuario=1;
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals(json_encode($response), $adminPuntaje->getAllPuntajeForUsuario($idUsuario));
    }

    //     Obtener todos los puntajes de un usuario, sin embargo, no hay puntajes     //
    //     No se encuentran puntajes del usuario ingresado     //
    /** @test */
    public function testNoHayPuntajeForUsuario()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idUsuario=1;
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("tabla materia vacia", $adminPuntaje->getAllPuntajeForUsuario($idUsuario));
    }

    //     Obtener los puntajes de una materia     //
    //     Permite obtener los puntajes de una materia seleccionada que se encuentre en la base de datos     //
    /** @test */
    public function testGetAllPuntajeForMateria()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = [array(
            '0' => [array(
                'id_usuario' => '1',
                'id_materia' => '1',
                'fecha' => '2020-02-16 10:02:15',
                'dificultad' => 'facil',
                'puntaje' => '9',
                'parejas_encontradas' => '9'
            )]
        )];
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idMateria=1;
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals(json_encode($response), $adminPuntaje->getAllPuntajeForMateria($idMateria));
    }

    //     No hay puntajes para la materia seleccionada     //
    //     Permite obtener los puntajes de una materia seleccionada, sin embargo, no se encuentran registros de esos puntajes en la base de datos     //
    /** @test */
    public function testNoHayPuntajeForMateria()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idMateria=1;
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("tabla materia vacia", $adminPuntaje->getAllPuntajeForMateria($idMateria));
    }

    //     Obtener los puntajes de un usuario en una materia     //
    //     Permite obtener los puntajes de un usuario en una materia que se encuentre en la base de datos     //
    /** @test */
    public function testGetAllPuntajeForUsuarioAndMateria()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = [array(
            '0' => [array(
                'id_usuario' => '1',
                'id_materia' => '1',
                'fecha' => '2020-02-16 10:02:15',
                'dificultad' => 'facil',
                'puntaje' => '9',
                'parejas_encontradas' => '9'
            )]
        )];
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idUsuario=1;
        $idMateria=1;
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals(json_encode($response), $adminPuntaje->getAllPuntajeForUsuarioAndMateria($idUsuario, $idMateria));
    }

    //     Obtener los puntajes de un usuario en una materia     //
    //     Permite obtener los puntajes de un usuario en una materia que se encuentre en la base de datos     //
    /** @test */
    public function testNoHayPuntajeForUsuarioAndMateria()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idUsuario=1;
        $idMateria=1;
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("tabla materia varia", $adminPuntaje->getAllPuntajeForUsuarioAndMateria($idUsuario, $idMateria));
    }

    //     Obtener los puntajes de un usuario en una materia     //
    //     Permite obtener los puntajes de un usuario en una materia que se encuentre en la base de datos     //
    /** @test */
    public function testGetAllPuntajeForMateriaAndDificultad()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = [array(
            '0' => [array(
                'id_usuario' => '1',
                'id_materia' => '1',
                'fecha' => '2020-02-16 10:02:15',
                'dificultad' => 'facil',
                'puntaje' => '9',
                'parejas_encontradas' => '9'
            )]
        )];
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idMateria=1;
        $dificultad=1;
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals(json_encode($response), $adminPuntaje->getAllPuntajeForMateriaAndDificultad($idMateria, $dificultad));
    }

    //     Obtener los puntajes de un usuario en una materia     //
    //     Permite obtener los puntajes de un usuario en una materia que se encuentre en la base de datos     //
    /** @test */
    public function testNoHayPuntajeForMateriaAndDificultad()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idMateria=1;
        $dificultad=1;
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("tabla materia varia", $adminPuntaje->getAllPuntajeForMateriaAndDificultad($idMateria, $dificultad));
    }

    //     Obtener los puntajes de un usuario en una materia     //
    //     Permite obtener los puntajes de un usuario en una materia que se encuentre en la base de datos     //
    /** @test */
    public function testGetAllPuntajeForUsuarioAndMateriaAndDificultad()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = [array(
            '0' => [array(
                'id_usuario' => '1',
                'id_materia' => '1',
                'fecha' => '2020-02-16 10:02:15',
                'dificultad' => 'facil',
                'puntaje' => '9',
                'parejas_encontradas' => '9'
            )]
        )];
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idUsuario=1;
        $idMateria=1;
        $dificultad="facil";
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals(json_encode($response), $adminPuntaje->getAllPuntajeForUsuarioAndMateriaAndDificultad($idUsuario,$idMateria,$dificultad));
    }

    //     Obtener los puntajes de un usuario en una materia     //
    //     Permite obtener los puntajes de un usuario en una materia que se encuentre en la base de datos     //
    /** @test */
    public function testNoHayPuntajeForUsuarioAndMateriaAndDificultad()
    {
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        // Configure the stub.
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);
        //Asignamos el mock en el constructor de PuntajesManajer
        $adminPuntaje = PuntajesManajer::getInstance();
        $adminPuntaje->setDBManager($stub);
        //Creamos strings aleatorios
        $idUsuario=1;
        $idMateria=1;
        $dificultad="facil";
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("tabla materia varia", $adminPuntaje->getAllPuntajeForUsuarioAndMateriaAndDificultad($idUsuario,$idMateria,$dificultad));
    }
}