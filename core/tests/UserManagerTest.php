<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . "/../php/userManager.php";

class UserManagerTest extends TestCase
{
    private $POOL = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $NUM_POOL = '0123456789';
    private $LENGTH = 10;

    private function generateWord(){
        return substr(str_shuffle(str_repeat($this->POOL, 5)), 0, $this->LENGTH);
    }

    private function generateNumber(){
        return substr(str_shuffle(str_repeat($this->NUM_POOL, 5)), 0, $this->LENGTH);
    }

    //     set User     //
    //     Permite guardar un usuario    //
    /** @test */
    public function testSetUser(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        
        // Configure the stub.
        $response = TRUE;
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $setUser = UserManager::getInstance();
        $setUser->setDBManager($stub);

        //Creamos strings aleatorios
        $name=$this->generateWord();
        $password=$this->generateNumber();
        $type=$this->generateWord();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("", $setUser->setUser($name, $password, $type));
    }

    //    No permite crear un usuario sin tipo    //
    /** @test */
    public function testCantSetUser(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        
        // Configure the stub.
        $response = TRUE;
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $setUser = UserManager::getInstance();
        $setUser->setDBManager($stub);

        //Creamos strings aleatorios
        $name=$this->generateWord();
        $password=$this->generateNumber();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("El tipo no puede ser nulo", $setUser->setUser($name, $password, null));
    }

    //     update User     //
    //     Permite cambiar los valores de un usuario     //
    /** @test */
    public function testUpdateUser(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        
        // Configure the stub.
        $response = TRUE;
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $updateUser = UserManager::getInstance();
        $updateUser->setDBManager($stub);

        //Creamos strings aleatorios
        $idUsuario=$this->generateWord();
        $newName=$this->generateWord();
        $password=$this->generateNumber();
        $type=$this->generateWord();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("", $updateUser->updateUser($idUsuario,$newName,$password,$type));
    }

    //    No permite cambiar los valores de un usuario sin tipo    //
    /** @test */
    public function testCantUpdateUser(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);
        
        // Configure the stub.
        $response = TRUE;
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $updateUser = UserManager::getInstance();
        $updateUser->setDBManager($stub);

        //Creamos strings aleatorios
        $idUsuario=$this->generateWord();
        $newName=$this->generateWord();
        $password=$this->generateNumber();

        //comparamos el error
        $this->assertEquals("El tipo no puede ser nulo", $updateUser->updateUser($idUsuario,$newName,$password, null));
    }

    //    Buscar un usuario con su nombre y contraseña     //
    /** @test */
    public function testGetUser(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);

        // Configure the stub.
        $response = [array(
            '0' => ['nombre' => 'Pepe Pecas']
        )];
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $puntajeManajer =  UserManager::getInstance();
        $puntajeManajer->setDBManager($stub);

        //Creamos strings aleatorios
        $name=$this->generateWord();
        $password=$this->generateNumber();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals(json_encode($response), $puntajeManajer->getUser($name, $password));
    }

    //    Buscar un usuario que no existe     //
    /** @test */
    public function testCantGetUser(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);

        // Configure the stub.
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $puntajeManajer =  UserManager::getInstance();
        $puntajeManajer->setDBManager($stub);

        //Creamos strings aleatorios
        $name=$this->generateWord();
        $password=$this->generateNumber();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("Tabla usuario vacia", $puntajeManajer->getUser($name, $password));
    }

    //    Buscar un usuario con su id     //
    /** @test */
    public function testGetUserById(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);

        // Configure the stub.
        $response = [array(
            '0' => ['nombre' => 'Pepe Pecas']
        )];
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $puntajeManajer =  UserManager::getInstance();
        $puntajeManajer->setDBManager($stub);

        //Creamos strings aleatorios
        $id = $this->generateNumber();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals(json_encode($response), $puntajeManajer->getUserById($id));
    }

    //    Buscar un usuario que no existe     //
    /** @test */
    public function testCantGetUserById(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);

        // Configure the stub.
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $puntajeManajer =  UserManager::getInstance();
        $puntajeManajer->setDBManager($stub);

        //Creamos strings aleatorios
        $id = $this->generateNumber();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("Tabla usuario vacia", $puntajeManajer->getUserById($id));
    }

    //    Obtener todos los usuarios    //
    /** @test */
    public function testGetAllUsers(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);

        // Configure the stub.
        $response = [array(
            'id' => '1',
            'nombre' => 'pepe pecas',
            'tipo' => 'facil',
            'clave' => '666'
        )];

        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $puntajeManajer =  UserManager::getInstance();
        $puntajeManajer->setDBManager($stub);

        $response = [array(
            'id' => '1',
            'name' => 'pepe pecas',
            'type' => 'facil',
            'password' => '666'
        )];
        
        $response = array($response);
        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals(json_encode($response), $puntajeManajer->getAllUsers());
    }

    //    No se peuden obtener los usuarios     //
    /** @test */
    public function testCantGetAllUsers(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);

        // Configure the stub.
        $response = null;
        $stub->expects($this->once())
             ->method('realizeQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $puntajeManajer =  UserManager::getInstance();
        $puntajeManajer->setDBManager($stub);

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("Tabla usuario vacia", $puntajeManajer->getAllUsers());
    }

    //    Eliminar un usuario     //
    /** @test */
    public function testDeleteUser(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);

        // Configure the stub.
        $response = true;
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $puntajeManajer =  UserManager::getInstance();
        $puntajeManajer->setDBManager($stub);

        //Creamos strings aleatorios
        $id = $this->generateNumber();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("", $puntajeManajer->deleteUser($id));
    }

    //    Eliminar un usuario que no existe    //
    /** @test */
    public function testCantDeleteUser(){
        // Create a stub for the DataBaseManager class.
        $stub = $this->createMock(DataBaseManager::class);

        // Configure the stub.
        $response = "El ingresado usuario no existe";
        $stub->expects($this->once())
             ->method('insertQuery')
             ->willReturn($response);

        //Asignamos el mock en el constructor de PuntajesManajer
        $puntajeManajer =  UserManager::getInstance();
        $puntajeManajer->setDBManager($stub);

        //Creamos strings aleatorios
        $id = $this->generateNumber();

        //comparamos si la respuesta es vacía (devuelve "" en caso de ser boolean)
        $this->assertEquals("El ingresado usuario no existe", $puntajeManajer->deleteUser($id));
    }
    
}