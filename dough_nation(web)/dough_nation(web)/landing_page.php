<?php
session_start();
include "conn.php"; // adjust path if needed

$error_message = '';

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $res = mysqli_query($conn, "SELECT * FROM customer WHERE username='$username' AND password='$password'");
    if(mysqli_num_rows($res) == 1){
        $user = mysqli_fetch_assoc($res);
        $_SESSION['cust_id'] = $user['cust_id'];
        $_SESSION['cust_name'] = $user['fname'] . ' ' . $user['lname'];
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Power Bakery</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #ffb3b3;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    max-width: 400px;
    width: 100%;
    padding: 20px;
}
.form-container {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    text-align: center;
}
.form-container h2 {
    margin-bottom: 20px;
    color: #d63384;
}
.form-container input {
    margin-bottom: 15px;
}
</style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Satisfy your baked cravings!</h2>
        <form method="POST" action="">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            
            <?php if (!empty($error_message)) { ?>
                <p style="color: red; font-weight: bold;"><?= $error_message ?></p>
            <?php } ?>

            <button type="submit" class="btn btn-primary w-100 mb-2" name="login">Login</button>
            <button type="button" class="btn btn-secondary w-100" onclick="window.location.href='sign-up.php'">Sign Up</button>
        </form>
    </div>
</div>

</body>
</html>
