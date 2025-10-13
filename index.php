<?php
include('db.php');
session_start();
$msg = "";
$popupClass = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($res && $res->num_rows == 1){
        $user = $res->fetch_assoc();
        if($user['email'] == $email && $user['password'] == $password){
            
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['name'] = $user['FullName'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'HR') {
                header("Location: hr_dashboard.php");
                exit();
            }
            else{
                header("Location: employee_dashboard.php");
                exit();
            }
        }
        else{
            $msg = "Invalid password!";
            $popupClass = "error";
        }
    }else{
        $msg = "User not found!";
        $popupClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Welcome to HR Management System</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login" class="login-button">Login</button>
        </form>

        <p class="createAccount">
            <a href="./createAccount.php">Create an Account</a> | 
            <a href="forgetPassword.php">Forgot Password?</a>
    </div>
    <?php if (!empty($msg)) { ?>
    <div class="popup <?php echo $popupClass; ?>">
        <?php echo $msg; ?>
    </div>
    <script>
        setTimeout(() => {
            const popup = document.querySelector('.popup');
            if (popup) popup.style.display = 'none';
        }, 4000);
    </script>
<?php } ?>
</body>
</html>