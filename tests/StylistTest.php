<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Ben";
            $test_stylist = new Stylist($name);

            //Act
            $result = $test_stylist->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Ben";
            $id = 1;
            $test_stylist = new Stylist($name, $id);

            //Act
            $result = $test_stylist->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Ben";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Ben";
            $name2 = "Jens";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Ben";
            $name2 = "Jens";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            Stylist::deleteAll();
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_Update()
        {
            //Arrange
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            //Act
            $new_name = "Jen";
            $test_stylist->update($new_name);

            //Assert
            $this->assertEquals("Jen", $test_stylist->getName());
        }

        function test_Delete()
        {
            //Arrange
            $name = "Ben";
            $name2 = "Jen";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2, $id);
            $test_stylist2->save();

            //Act
            $test_stylist->delete();

            //Assert
            $this->assertEquals([$test_stylist2], Stylist::getAll());
        }

        function test_GetClients()
        {
            //Arrange
                //stylist
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $test_stylist_id = $test_stylist->getId();

                //clients
            $name = "John";
            $test_client = new Client($name, $id, $test_stylist_id);
            $test_client->save();

            $name2 = "Diane";
            $test_client2 = new Client($name2, $id, $test_stylist_id);
            $test_client2->save()

            //Act
            $result = $test_stylist->getStylists();

            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_DeleteStylistsClients()
        {
            //Arrange
                //stylist
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

                //clients
            $name = "John";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

            //Act
            $test_stylist->delete();

            //Assert
            $this->assertEquals([], Clients::getAll());
        }
    }
?>
