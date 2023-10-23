<?php
class Cart {
    private $items = [];

    public function addItem(Product $product, $quantity) {
        $productID = $product->getProductID();

        if (isset($this->items[$productID])) {
            // Product already in the cart, update the quantity
            $this->items[$productID]['quantity'] += $quantity;
        } else {
            // Add a new item to the cart
            $this->items[$productID] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }

    public function getItems() {
        return $this->items;
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];
            $total += $product->getPrice() * $quantity;
        }
        return $total;
    }
}

// Create sample products
$product1 = new Product(1, 'Nova', 10.00, 100);
$product2 = new Product(2, 'Piattos', 15.50, 50);
$product3 = new Product(3, 'Mikmik', 7.25, 75);

// Initialize the cart
$cart = new Cart();

// Handle adding products to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);
    $product_to_add = null;

    // Find the selected product
    foreach ([$product1, $product2, $product3] as $product) {
        if ($product->getProductID() == $product_id) {
            $product_to_add = $product;
            break;
        }
    }

    if ($product_to_add) {
        $cart->addItem($product_to_add, $quantity);
    }
}
?>