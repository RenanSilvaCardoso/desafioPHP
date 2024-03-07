<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/history.css">
    <script src="../src/js/history.js" defer></script>
    <title>History</title>
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
            <h1 id="title">History</h1>
        </div>
        <div class="wrapper">
            <div class="wrapper-table">
                <table class="table" id="table-history">
                    <tr class="table__columns column">
                        <td><b>Code</b></td>
                        <td class="table__border"><b>Tax</b></td>
                        <td class="table__border"><b>Total</b></td>
                    </tr>
                    <?php 
                        include_once('index.php');
                        $query = "SELECT * FROM orders";
                        $selectOrders = $myPDO->query($query);
                        $data = $selectOrders->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach($data as $d){
                            print_r("
                            <tr>
                                <td>".$d['code']."</td>
                                <td class='table__border'>".$d['tax']."%</td>
                                <td class='table__border'>$".$d['total']."</td>
                            </tr>
                            ");
                        }
                    ?>
                </table>
            </div>
            <div class="wrapper-details">
                <h2>Purchase Details</h2>
                <table class="table" id="purchase">
                    <tr class="table__columns column">
                        <td ><b>Code</b></td>
                        <td class="table__border"><b>Data</b></td>
                        <td class="table__border"><b>Items</b></td>
                        <td class="table__border"><b>Total</b></td>
                    </tr>
                    <?php 
                        include('index.php');
                        $selectOrderItem = $myPDO->query("SELECT * FROM order_item");
                        $data = $selectOrderItem->fetchAll(PDO::FETCH_ASSOC);
                        foreach($data as $d){?>
                        <tr>
                            <td><?php echo $d['code']?></td>
                            <td class="table__border"><?php echo $d['dt']?></td>
                            <td class="table__border"><?php echo $d['items']?></td>
                            <td class="table__border"><?php echo '$'.$d['total']?></td>
                        </tr>

                        <?php } ?> 
                </table>
            </div>
        </div>
    </main>
</body>
</html>