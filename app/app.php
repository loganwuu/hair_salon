<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    // Add symfony debug component and turn it on
    use Symfony\Component\Debug\Debug;
    Debug::enable();

    // Initialize application
    $app = new Silex\Application();
    // Set Silex debug mode in $app object
    $app['debug'] = true;

    // Declare server and database
    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    // Enable to use twig files
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // Enable to use _method input
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // Home page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });
        // After saving a stylist function
    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST['name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

        // After running delete one stylist function
    $app->delete("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

        // After running delete all clients function
    $app->post("/delete_clients", function() use ($app) {
        Client::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

        // After running delelte all stylists function
    $app->post("/delete_stylists", function() use($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    // Stylist page
        // After running update a stylist name function
    $app->patch("/stylists/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $stylist = Stylist::find($id);
        $stylist->update($name);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients'=> $stylist->getClients()));
    });

        // After finding the id of a stylist function
    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

        // After adding a client function
    $app->post("/clients", function() use ($app) {
        $name = $_POST['name'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($name, $id = null, $stylist_id);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    // Stylist name edit page
    // Client name edit page



    return $app;
?>
