<?php 
include_once './index.php';

$id = $_GET['code'];
if(!empty($id)){
    $select = "SELECT c.tax, p.price FROM products as p, categories as c WHERE p.category_code = c.code AND p.code = $id";
    $result = $myPDO->prepare($select);
    $result->execute();

    if($result){
        $data = $result->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data);
    }
}
?>