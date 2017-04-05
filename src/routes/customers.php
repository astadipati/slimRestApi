<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

// get all customers
$app->get('/api/customers', function(Request $request, Response $response){
    // echo 'Customers';
    $sql = "select * from customers";

    try{
        // get db objek
        $db = new db();
        // koneksi
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// get single customers
$app->get('/api/customers/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "select * from customers where id = $id";

    try{
        // get db objek
        $db = new db();
        // koneksi
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customer);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// add customers
// method POST
// http://slimapp/api/customers/add
// tambahkan header Content-Type:application/json
// {
// 	"first_name":"Hore",
//     "last_name": "bisa",
//     "phone":"222-555-54",
//     "email":"hore@gmail.com",
//     "address":"tuban indah",
//     "city":"Tuban",
//     "state":"Tbn"

// }

$app->post('/api/customers/add', function(Request $request, Response $response){
    
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state) VALUES
                                  (:first_name,:last_name,:phone,:email,:address,:city,:state)";

    try{
        // get db objek
        $db = new db();
        // koneksi
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Added" }';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// update
// http://slimapp/api/customers/update/1
// method PUT
// Header Content-Type:application/json_decode
// {
// 	"first_name":"kamu",
//     "last_name": "ganteng pertamax",
//     "phone":"222-222-66",
//     "email":"hore@gmail.com",
//     "address":"tuban oke",
//     "city":"Tuban",
//     "state":"Tbn"

// }


$app->put('/api/customers/update/{id}', function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "UPDATE customers SET
                    first_name  = :first_name,
                    last_name   = :last_name,
                    phone       = :phone,
                    email       = :email,
                    address     = :address,
                    city        = :city,
                    state       = :state
                    WHERE id = $id";

    try{
        // get db objek
        $db = new db();
        // koneksi
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Updated" }';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// delete
$app->delete('/api/customers/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE from customers where id = $id";

    try{
        // get db objek
        $db = new db();
        // koneksi
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
         echo '{"notice": {"text": "Customer Deleted" }';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
