<?php 
    if(isset($_POST['cancelSubmit'])){
        include_once('index.php');
        $deleteCart = $myPDO->prepare("DELETE FROM cart");
        $deleteCart->execute();
        header('Location: home.php');
        exit();
    }
    if(isset($_POST['finishSubmit'])){
        include_once('index.php');
        $query = "SELECT total, tax FROM cart";
        $selectCart = $myPDO->query($query);
        $data = $selectCart->fetchAll(PDO::FETCH_ASSOC);
        $tax = 0;
        $total = 0;
        foreach($data as $d){
            $tax += $d['tax'];
            $total += $d['total'];
        }
        $insert = $myPDO->prepare("INSERT INTO orders VALUES (DEFAULT, :tax, :total)");
        $insert->bindParam(':tax', $tax, PDO::PARAM_INT);
        $insert->bindParam(':total', $total, PDO::PARAM_INT);
        $insert->execute();
        

        $queryCart = $myPDO->query("SELECT c.product_name as product_name_cart, c.amount as amount_cart, p.product_name as product_name_products, p.amount as amount_products FROM cart as c, products as p WHERE c.product_name = p.product_name");
        $res = $queryCart->fetchAll(PDO::FETCH_ASSOC);
        foreach($res as $r){
            $newAmount = $r['amount_products'] - $r['amount_cart'];
            $productName = $r['product_name_cart'];
            $update = $myPDO->prepare("UPDATE products SET amount = :new_amount WHERE product_name = :product_name");
            $update->bindParam(':new_amount', $newAmount, PDO::PARAM_INT);
            $update->bindParam(':product_name', $productName, PDO::PARAM_STR);
            $update->execute();
        }
        

        $date = date('Y/m/d');
        $selectCount = $myPDO->query("SELECT COUNT(code) FROM CART");
        $data = $selectCount->fetch(PDO::FETCH_ASSOC);
        $count = $data['count'];

        $insertDetails = $myPDO->prepare("INSERT INTO order_item VALUES (DEFAULT, :date_order, :count_items,:total)");
        $insertDetails->bindParam(':date_order', $date, PDO::PARAM_STR);
        $insertDetails->bindParam(':count_items', $count, PDO::PARAM_INT);
        $insertDetails->bindParam(':total', $total, PDO::PARAM_INT);
        $insertDetails->execute();


        $deleteCart = $myPDO->prepare("DELETE FROM cart");
        $deleteCart->execute();
        header  ('Location: home.php');
        exit();
        }

?>