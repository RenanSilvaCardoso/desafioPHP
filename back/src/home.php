<?php 
    if(isset($_POST['submitProduct'])){
        include_once('index.php');
        $product = $_POST['select-product'];
        $amount = $_POST['amount'];

        $selectProduct = $myPDO->query("SELECT p.product_name, p.price, p.amount, c.tax FROM products as p, categories as c WHERE p.code = '$product' AND p.category_code = c.code");
        $result = $selectProduct->fetchAll(PDO::FETCH_ASSOC);
        $conta = ($result[0]['price'] * $amount ) + (($result[0]['price'] * $amount )*($result[0]['tax']/100));

        if($amount > $result[0]['amount']){
            echo "<script>alert('Produto maior que a quantidade em estoque!');</script>";
        }else {
            $insertProduct = $myPDO->prepare("INSERT INTO cart VALUES (DEFAULT, :product_name, :amount, :price, :tax, :total)");
            $insertProduct->bindParam(':product_name', $result[0]['product_name'], PDO::PARAM_STR);
            $insertProduct->bindParam(':amount', $amount, PDO::PARAM_INT);
            $insertProduct->bindParam(':price', $result[0]['price'], PDO::PARAM_INT);
            $insertProduct->bindParam(':tax', $result[0]['tax'], PDO::PARAM_INT);
            $insertProduct->bindParam(':total', $conta, PDO::PARAM_INT);
            $insertProduct->execute();
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/home.css">
    <script src="js/home.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <title>Home</title>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Suite Store</h1>
        </div>
        <nav>
            <div class="navbar">
            <ul>
                <li class="navbar__item"><a href="home.php">Home</a></li>
                <li class="navbar__item"><a href="products.php">Products</a></li>
                <li class="navbar__item"><a href="category.php">Categories</a></li>
                <li class="navbar__item"><a href="history.php">History</a></li>
            </ul>
            </div>
        </nav>
    </header>
    
    <main>
        <div class="screen-title">
            <h1 id="title">Shopping cart</h1>
        </div>
        <div class="wrapper">
            <form action="home.php" method="POST" class="wrapper__form" id="form">
                
                <select class="wrapper__input wrapper__product" name="select-product" id="select-product" required>
                    <option value="" disabled selected>Product</option>
                    <?php 
                        include_once('index.php');
                        $queryProducts = $myPDO->query('SELECT * FROM products');
                        $products =  $queryProducts->fetchAll(PDO::FETCH_ASSOC);
                        foreach($products as $p){
                            print_r(
                                "<option value =".$p['code'].">".$p['product_name']."</option>"
                            );
                        }
                    ?>
                </select>

                <input class="wrapper__input wrapper__amount" type="number" id="amount" name="amount" placeholder="Amount" min="1" required>

                <input class="wrapper__input wrapper__tax" type="text" id="tax-value" name="tax-value" disabled value="Tax">

                <input class="wrapper__input wrapper__price" type="text" id="unit-price" name="unit-price" value='Price' required disabled>

                <script>
                $(document).ready(function() {
                    $('#select-product').change(function() {
                        let product = $(this).val();
                        if (product) {
                            $.ajax({
                                type: 'GET',
                                url: 'selectAjax.php',
                                data: {
                                    code: product
                                },
                                success: function(data) {
                                    let response = JSON.parse(data);
                                    $('#tax-value').val(response.tax);
                                    $('#unit-price').val(response.price);
                                }
                            })
                        } else {
                            error_log('erro');
                        }
                    })
                })
                </script>

                <input id="addProduct" name="submitProduct" class="wrapper__btn" type="submit" value="Add Product">
            </form>
            
            <div class="table-flex">
                <form action="deleteRow.php" method="POST" class="wrapper__table">
                    <table class="table" id="cart">
                        <tr class="table__columns">
                            <td><b>Product</b></td>
                            <td class="table__border"><b>Price</b></td>
                            <td class="table__border"><b>Amount</b></td>
                            <td class="table__border"><b>Total</b></td>
                        </tr>
                        <?php
                            include_once('index.php');
                            $queryCart = $myPDO->query("SELECT product_name, price, amount, total FROM cart;");
                            $cart = $queryCart->fetchAll(PDO::FETCH_ASSOC);
                            foreach($cart as $c){?>
                                <tr>
                                    <td> <?php echo $c['product_name'] ?> </td>
                                    <td class="table__border"> <?php echo $c['price'] ?> </td>
                                    <td class="table__border"> <?php echo $c['amount'] ?> </td>
                                    <td class="table__border"> <?php echo $c['total'] ?> </td>
                                    <td class="table__border"><input class="btnDelete" type="submit" name="deleteRow" value="Delete"> <input type="hidden" name="product_name" value="<?php echo $c['product_name'] ?>"></td>
                                </tr>
                            <?php } ?>
                    </table>
                    <div class="details">
                        <div class="details__inputs">
                            <div class="inputs">
                                <?php
                                include_once('index.php');
                                $tax = 0;
                                $total = 0;
                                $selectTaxAndTotal = $myPDO->query("SELECT tax, total FROM cart;");
                                $res = $selectTaxAndTotal->fetchAll(PDO::FETCH_ASSOC);
                                if(!empty($res)){
                                    foreach($res as $r){
                                        $tax += $r['tax'];
                                        $total += $r['total'];
                                    }
                                }
                                ?>
                                <label for="tax-fixed">Tax: </label>
                                <input type="text" id="tax-fixed" name="tax-fixed" disabled value="<?php empty($tax) ? print_r('%') : print_r($tax.'%') ?> ">
                            </div>
                
                            <div class="inputs">
                                <label for="total">Total: </label>
                                <input type="text" id="total" name="total" disabled value="<?php empty($total) ? print_r('') : print_r('$'.$total) ?> ">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="wrapper__buttons">
                    <form action="cancelFinish.php" method="POST" >
                        <input type="submit" name="cancelSubmit" value="Cancel" id="btn-cancel" class="btn-cancel">
                        <input type="submit" name="finishSubmit" value="Finish" id="finish" class="btn-finish">
                    </form>
                </div>
            </div>
        </div>
    </main>
    
</body>
</html>