<?php
// error_log('Sou um log');

$host = "pgsql_desafio";
$db = "applicationphp";
$user = "root";
$pw = "root";

try {
    $myPDO = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
        $myPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

// // exemplo de insert
// $statement = $myPDO->prepare("INSERT INTO mytable (DESCRIPTION) VALUES ('TEST PHP')");
// $statement->execute();

// // exemplo de fetch
// $statement1 = $myPDO->query("SELECT * FROM mytable");
// $data = $statement1->fetch();

// echo "<br>";
// print_r($data);

// // exemplo de fetch2
// $statement2 = $myPDO->query("SELECT * FROM mytable");
// $data2 = $statement2->fetchALL();

// echo "<br>";
// print_r($data2);

$uri = $_SERVER['REQUEST_URI'];
$dir = '/';

switch ($uri) {
    case '':
    case '/':
        require __DIR__ . $dir . 'home.php';
        break;
        
    case '/products':
        require __DIR__ . $dir . 'products.php';
        break;

    case '/category':
        require __DIR__ . $dir . 'category.php';
        break;

    case '/history':
        require __DIR__ . $dir . 'history.php';
        break;

    // default:
    //     require __DIR__ . $dir . 'home.php';
    //     break;
    //     if(str_contains($request, 'details/')){
    //             require __DIR__ . $dir . 'details.php';
    //             break;
    //     }
    //     http_response_code(404);
    //     require __DIR__ . $pageDir . '404.php';
}
?>