<?php
// Define the Cart and Order classes (as shown in previous responses)

// Create sample products
include("Product.php");
$product1 = new Product(1, 'Nova', 10.00, 100);
$product2 = new Product(2, 'Piattos', 15.50, 50);


// Initialize carts
$carts = [
    new Cart(),
    new Cart(),
    new Cart(),
];

// Add products to each cart (adjust quantities as needed)
$carts[0]->addItem($product1, 2);
$carts[0]->addItem($product2, 3);

$carts[1]->addItem($product3, 1);

// ... Add products to other carts as needed ...

// Process user's choice to check out a cart
if (isset($_POST['checkout_cart'])) {
    $selected_cart_index = $_POST['checkout_cart'];
    
    if (isset($carts[$selected_cart_index])) {
        $selected_cart = $carts[$selected_cart_index];
        $order = new Order($selected_cart);
        $total_fee = $order->getTotalFee();

        echo "You have checked out Cart #$selected_cart_index. Total Fee (including shipping fee): $total_fee pesos";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out Carts</title>
</head>
<body>
    <h1>Check Out Carts</h1>
    <form method="post">
        <table border="1">
            <tr>
                <th>Cart #</th>
                <th>Products</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php foreach ($carts as $index => $cart): ?>
                <tr>
                    <td><?php echo $index; ?></td>
                    <td>
                        <ul>
                            <?php foreach ($cart->getItems() as $cart_item): ?>
                                <?php $product = $cart_item['product']; ?>
                                <li><?php echo $product->getProductName(); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td><?php echo $cart->getTotal(); ?> pesos</td>
                    <td>
                        <input type="radio" name="checkout_cart" value="<?php echo $index; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" name="checkout" value="Check Out">
    </form>
</body>
</html>