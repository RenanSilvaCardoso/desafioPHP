<?php
    if(isset($_POST['submitCategory'])){
        include_once('index.php');
        $categoryName = $_POST['category-name'];
        $taxCategory = $_POST['tax-value'];
        $insert = $myPDO->prepare("INSERT INTO categories VALUES (DEFAULT, :category_name, :tax)");
        $insert->bindParam(':category_name', $categoryName, PDO::PARAM_STR);
        $insert->bindParam(':tax', $taxCategory, PDO::PARAM_INT);
        $insert->execute();
        unset($categoryName, $taxCategory);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/category.css">
    <script src="js/category.js" defer></script>
    <title>Categories</title>
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
            <h1 id="title">Category Registration</h1>
        </div>
        <div class="wrapper">
            <form action="category.php" method="POST" class="wrapper-form" id="form">
                <input class="input" type="text" id="category-name" name="category-name" placeholder="Category name" required autofocus>

                <input class="input" type="number" id="tax-value" name="tax-value" placeholder="Tax" required>
                
                <input class="btn" type="submit" name="submitCategory" value="Add Category" id="addCategory">
            </form>
            <div class="wrapper-table">
                <table class="table" id="table">
                    <tr class="table__columns column">
                        <td><b>Code</b></td>
                        <td class="table__border"><b>Category</b></td>
                        <td class="table__border"><b>Tax</b></td>
                    </tr>
                    <?php 
                        include_once('index.php');
                        $queryTable = $myPDO->query("SELECT * FROM categories");
                        $categories = $queryTable->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categories as $category) {
                        print_r(
                            "<tr>    
                            <td class='table__border'>". $category['code'] . "</td>
                            <td class='table__border'> " . $category['category_name'] . "</td>
                            <td class='table__border'>". $category['tax'] ."%</td>
                            </tr>");
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
