<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // TODO: Add further validation and error handling

    // Database connection (You need to set up a MySQL database and provide the credentials)
    $dbHost = 'your_database_host';
    $dbName = 'your_database_name';
    $dbUser = 'your_database_user';
    $dbPass = 'your_database_password';

    try {
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // Insert user data into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Registration failed.";
    }
}
?>
