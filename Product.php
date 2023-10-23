<?php
require 'DB_config.php'; // Include your database configuration
require 'Product.php';
require 'Cart.php';

// Initialize the Cart object
$cart = new Cart($db); // Assuming $db is your database connection

// Check if a product is being added to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Load the product details from the database (assuming you have a Product class for database interaction)
    $product = Product::loadProduct($db, $product_id);

    if ($product) {
        // Add the product to the cart
        $cart->addToCart($product, $quantity);
    }
}

// Get the list of available products
$products = $db->query("SELECT * FROM Products");

// Display the list of products
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Shopping System</title>
</head>
<body>
    <h1>Product List</h1>
    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Quantity to Add</th>
            <th>Action</th>
        </tr>
        <form method="post">
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['Product_Name']; ?></td>
                    <td>$<?php echo $product['Price']; ?></td>
                    <td><?php echo $product['Stock_Quantity']; ?></td>
                    <td>
                        <input type="number" name="quantity" value="1" min="1">
                    </td>
                    <td>
                        <input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
                        <input type="submit" name="add_to_cart" value="Add to Cart">
                    </td>
                </tr>
            <?php endforeach; ?>
        </form>
    </table>
    <h2>Shopping Cart</h2>
    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($cart->getItems() as $cart_item): ?>
            <?php $product = $cart_item['product']; ?>
            <tr>
                <td><?php echo $product->getProductName(); ?></td>
                <td>$<?php echo $product->getPrice(); ?></td>
                <td><?php echo $cart_item['quantity']; ?></td>
                <td>$<?php echo $product->getPrice() * $cart_item['quantity']; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="3">Total:</th>
            <td>$<?php echo $cart->getTotal(); ?></td>
        </tr>
    </table>
</body>
</html>
