<?php
session_start();
include("db.php");

$msg = "";
$popupClass = "";
if (isset($_POST['signup'])) {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $msg = "Email already exists!";
        $popupClass = "error";
    } else {
        if ($conn->query("INSERT INTO users (FullName, email, password) VALUES ('$name','$email','$password')")) {
            $msg = "Signup successful!";
            $popupClass = "success";
        } else {
            $msg = "Something went wrong. Try again!";
            $popupClass = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="createAccount.css">
</head>
<body>
    <div class="container">
        <h3>Create Account</h3>  
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="signup">Signup</button>
        </form>

        <p class="links">
            Already have an account? <a href="index.php">Login here</a>
        </p>
    </div>
    <?php if (!empty($msg)) { ?>
    <div class="popup <?php echo $popupClass; ?>">
        <?php echo $msg; ?>
    </div>
    <script>
        // Auto-hide popup after 4 seconds
        setTimeout(() => {
            const popup = document.querySelector('.popup');
            if (popup) popup.style.display = 'none';
        }, 4000);
    </script>
    <?php } ?>
</body>
</html>