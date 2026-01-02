<?php 
include "conn.php";

$error_message = ""; // Initialize the error message variable

if (isset($_POST["submit"])) {

    function sanitize($data) {
        return htmlspecialchars(trim(stripslashes($data)));
    }

    $username = sanitize($_POST["username"]);
    $password = sanitize($_POST["password"]);
    $fname = sanitize($_POST["fname"]);
    $mi = sanitize($_POST["mi"]);
    $lname = sanitize($_POST["lname"]);
    $sex = $_POST["sex"];
    $mobile = sanitize($_POST["mobile"]);

    // Check if the username already exists
    $check_sql = "SELECT * FROM customer WHERE username = '$username'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Username already exists
        $error_message = "The username is already taken. Please choose another.";
    } else {
        // Insert new user data
        $sql = "INSERT INTO customer (username, password, fname, mi, lname, sex, mobile_no) 
                VALUES ('$username', '$password', '$fname', '$mi', '$lname', '$sex', '$mobile')";
        
        if (mysqli_query($conn, $sql)) {
            // Redirect to index.php on success
            header("location: index.php");
            exit;
        } else {
            $error_message = "An error has occured. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Power Bakery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="landing_styles.css">
    <style>
        body {
    margin: 0;
    font-family: 'Arial', sans-serif;
    background-color: #ffb3b3;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

    </style>
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="password" placeholder="Password" required>
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="mi" placeholder="Middle Initial" maxlength="1">
            <input type="text" name="lname" placeholder="Last Name" required>
            <select name="sex" required>
                <option value="" disabled selected>Select Sex</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <input type="text" name="mobile" placeholder="Mobile Number" required>
            <button type="submit" class="btn btn-primary" name="submit">Sign Up</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='landing_page.php'">Cancel</button>
        </form>
        <!-- Display error message if it exists -->
        <?php 
        if (!empty($error_message)) {
            echo "<p style='color: red; margin-top: 10px;'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
