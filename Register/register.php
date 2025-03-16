<?php
$servername = "localhost";
$db_username = "root";  // Change if needed
$db_password = "";      // Change if needed
$dbname = "testdb";     // Change to your database name

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process Form Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $gender = trim($_POST['gender']);

    // Validation: Check if all fields are filled
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($gender)) {
        echo "<script>alert('All fields are required!'); window.location.href='register.html';</script>";
        exit();
    }

    // Validate Email Format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.location.href='register.html';</script>";
        exit();
    }

    // Check Password Length
    if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters!'); window.location.href='register.html';</script>";
        exit();
    }

    // Check if Passwords Match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location.href='register.html';</script>";
        exit();
    }

    // Validate Gender Selection
    if (!in_array($gender, ['Male', 'Female', 'Other'])) {
        echo "<script>alert('Invalid gender selection!'); window.location.href='register.html';</script>";
        exit();
    }

    // Hash the Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if Username or Email Already Exists
    $checkQuery = "SELECT * FROM users WHERE email=? OR username=?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email already exists!'); window.location.href='register.html';</script>";
    } else {
        // Insert Data into Database
        $query = "INSERT INTO users (username, email, password, gender) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $gender);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Redirecting to login.'); window.location.href='login.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}

$conn->close();
?>
