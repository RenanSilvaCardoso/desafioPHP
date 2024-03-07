<?php 
    if(isset($_POST['submitProducts'])){
        include_once('index.php');
        $productName = $_POST['product-name'];
        $amount = $_POST['amount'];
        $price = $_POST['unit-price'];
        $category = $_POST['select-category'];
        $insert = $myPDO->prepare("INSERT INTO products VALUES (DEFAULT, :product_name, :amount, :price, :category)");
        $insert->bindParam(':product_name', $productName, PDO::PARAM_STR);
        $insert->bindParam(':amount', $amount, PDO::PARAM_INT);
        $insert->bindParam(':price', $price, PDO::PARAM_INT);
        $insert->bindParam(':category', $category, PDO::PARAM_STR);
        $insert->execute();
        unset($productName, $amount, $price, $category);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/productsRegistration.css">
    <script src="src/js/products.js" defer></script>
    <title>Products</title>
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
        <div class="welcome">
            <h1 id="title">Products Registration</h1>
        </div>
        <div class="wrapper">
            <form action="products.php" method="POST" class="wrapper__form" id="form">
                <input class="input input__product" type="text" id="product-name" name="product-name" placeholder="Product" required autofocus>

                <input class="input input__amount" type="number" id="amount" name="amount" placeholder="Amount" min="1" required>

                <input class="input input__price" type="number" id="unit-price" name="unit-price"  placeholder="Price" required>
                
                <select class="input input__category" name="select-category" id="select-category" required>
                    <option value="" disabled selected> Category</option>
                    <?php 
                        include_once('index.php');
                        $queryCategories = $myPDO->query('SELECT * FROM categories');
                        $categories =  $queryCategories->fetchAll(PDO::FETCH_ASSOC);
                        foreach($categories as $category){
                            print_r(
                                "<option value =".$category['code'].">".$category['category_name']."</option>"
                            );
                        }
                    ?>
                </select>

                <input class="btn" type="submit" name="submitProducts" value="Add Product" id="addProduct">
            </form>
            <div class="wrapper-table">
                <table class="table" id="table">
                    <tr class="table__columns column">
                        <td><b>Code</b></td>
                        <td class="table__border"><b>Product</b></td>
                        <td class="table__border"><b>Amount</b></td>
                        <td class="table__border"><b>Price</b></td>
                        <td class="table__border"><b>Category</b></td>
                    </tr>
                    <?php 
                        include_once('index.php');
                        $queryProducts = $myPDO->query("SELECT p.code, p.product_name, p.amount, p.price, c.category_name FROM products as p, categories as c WHERE p.category_code = c.code");
                        $products = $queryProducts->fetchAll(PDO::FETCH_ASSOC);
                        foreach($products as $product){
                            print_r(
                                "
                                <tr>
                                    <td class='table__border'>".$product['code']."</td>
                                    <td class='table__border'>".$product['product_name']."</td>
                                    <td class='table__border'>".$product['amount']."</td>
                                    <td class='table__border'>".$product['price']."</td>
                                    <td class='table__border'>".$product['category_name']."</td>
                                </tr>
                                "
                            );
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>