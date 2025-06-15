<?php
session_start();

$conn = new mysqli("localhost", "root", "", "testdb");

if ($conn->connect_error) {
    die("Connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // ✅ Secure query using prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password); // ss = string, string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["username"] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        echo "Invalid login!";
    }
}
?>
