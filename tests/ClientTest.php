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

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getId()
        {
            //Arrange
                //stylist
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

                //client
            $name = "John";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getStylistId()
        {
            //Arrange
                //stylist
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

                //client
            $name = "John";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

            //Act
            $result = $test_client->getStylistId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
                //stylist
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

                //client
            $name = "John";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);

            //Act
            $test_client->save();
            $result = Client::getAll();

            //Assert
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
                //stylist
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

                //client1
            $name = "John";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

                //client2
            $name2 = "Diane";
            $stylist_id = $test_stylist->getId();
            $test_client2 = new Client($name2, $id, $stylist_id);
            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
                //stylist
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

                //client1
            $name = "John";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

                //client2
            $name2 = "Diane";
            $stylist_id = $test_stylist->getId();
            $test_client2 = new Client($name2, $id, $stylist_id);
            $test_client2->save();

            //Act
            Client::deleteAll();

            //Assert
            $result = Client::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
                //stylist
            $name = "Ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

                //client1
            $name = "John";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

                //client2
            $name2 = "Diane";
            $stylist_id = $test_stylist->getId();
            $test_client2 = new Client($name2, $id, $stylist_id);
            $test_client2->save();

            //Act
            $id = $test_client->getId();
            $result = Client::find($id);

            //Assert
            $this->assertEquals($test_client, $result);
        }

        function test_delete()
        {
            //Arrange
                //client1
            $name = "John";
            $id = null;
            $stylist_id = 1;
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

                //client2
            $name2 = "Diane";
            $id = null;
            $stylist_id2 = 1;
            $test_client2 = new Client($name2, $id, $stylist_id2);
            $test_client2->save();

            //Act
            $test_client->delete();

            //Assert
            $this->assertEquals([$test_client2], Client::getAll());

        }
    }
?>
