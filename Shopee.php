<?php
require 'DB_config.php';
require 'Product.php';
// require 'Cart.php';


// Initialize the Cart object
$carts = new Cart($database);

// Check if a product is being added to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $product = new Product($database);
    $product->loadProduct($product_id);
    
    // Add the product to the cart
    $carts->addToCart($product, $quantity);
}

// Get the list of available products
$products = $db->query("SELECT * FROM Products");

// Display the list of products
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Page</title>
</head>
<body>
    <h2>Products for Sale</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product): ?>
    <tr>
        <td><?php echo $product['Product_Name']; ?></td>
        <td><?php echo $product['Price']; ?></td>
        <td><?php echo $product['Stock_Quantity']; ?></td>
        <td>
        <td>
    <form method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['Stock_Quantity']; ?>">
        <input type="submit" name="add_to_cart" value="Add to Cart">
    </form>
</td>

            </form>
        </td>
    </tr>
<?php endforeach; ?>

                <td>
            </tr>
        <!-- -->
    </table>
</body>
</html>
