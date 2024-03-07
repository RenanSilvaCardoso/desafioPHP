<?php 
    include_once('index.php');

    if(isset($_POST['deleteRow'])){
        include_once('index.php');
        $productName = $_POST['product_name'];
        $sql = $myPDO->prepare("DELETE FROM cart WHERE cart.product_name = :product_name");
        $sql->bindParam(':product_name', $productName, PDO::PARAM_STR);
        $sql->execute();
        
        header('Location: home.php');
        exit();
    }
?>