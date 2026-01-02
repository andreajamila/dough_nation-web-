<?php
session_start();
include "conn.php";

if(!isset($_SESSION['cust_id'])){
    header("Location: landing_page.php");
    exit;
}

$cust_id = $_SESSION['cust_id'];
$user = $conn->query("SELECT * FROM customer WHERE cust_id='$cust_id'")->fetch_assoc();

$error_message = "";
$success_message = "";

if(isset($_POST['submit'])) {
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

    $check_sql = "SELECT * FROM customer WHERE username='$username' AND cust_id!='$cust_id'";
    $result = mysqli_query($conn, $check_sql);

    if(mysqli_num_rows($result) > 0){
        $error_message = "The username is already taken. Please choose another.";
    } else {
        $sql = "UPDATE customer SET 
                    username='$username',
                    password='$password',
                    fname='$fname',
                    mi='$mi',
                    lname='$lname',
                    sex='$sex',
                    mobile_no='$mobile'
                WHERE cust_id='$cust_id'";
        if(mysqli_query($conn, $sql)){
            $_SESSION['cust_name'] = "$fname $lname";
            $success_message = "Profile updated successfully!";
            $user = $conn->query("SELECT * FROM customer WHERE cust_id='$cust_id'")->fetch_assoc();
        } else {
            $error_message = "An error occurred. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Arial', sans-serif;
    background: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container-profile {
    max-width: 450px;
    margin: 50px auto;
    background: #fff;
    border-radius: 12px;
    padding: 30px 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.user-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    font-size: 28px;
    margin: 0 auto 15px auto;
}

h3 {
    text-align: center;
    margin-bottom: 10px;
}

.profile-form input[readonly],
.profile-form select[disabled] {
    background: #e9ecef;
}

button {
    cursor: pointer;
}

.btn-edit {
    display: block;
    margin: 10px auto 20px auto;
}
</style>
</head>
<body>

<div class="container-profile">
    <div class="user-avatar"><?= strtoupper($user['fname'][0] . $user['lname'][0]) ?></div>
    <h3><?= htmlspecialchars($user['fname'] . ' ' . $user['lname']) ?></h3>
    <button class="btn btn-primary btn-edit" onclick="enableEdit()">Edit Profile</button>

    <?php if(!empty($success_message)) echo "<p class='text-success text-center'>$success_message</p>"; ?>
    <?php if(!empty($error_message)) echo "<p class='text-danger text-center'>$error_message</p>"; ?>

    <form method="POST" id="profileForm" class="profile-form">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" readonly class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password" value="<?= htmlspecialchars($user['password']) ?>" readonly class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="fname" value="<?= htmlspecialchars($user['fname']) ?>" readonly class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Middle Initial</label>
            <input type="text" name="mi" value="<?= htmlspecialchars($user['mi']) ?>" readonly class="form-control" maxlength="1">
        </div>
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="lname" value="<?= htmlspecialchars($user['lname']) ?>" readonly class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Sex</label>
            <select name="sex" class="form-control" disabled>
                <option value="">Select Sex</option>
                <option value="Male" <?= $user['sex']=='Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $user['sex']=='Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $user['sex']=='Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Mobile Number</label>
            <input type="text" name="mobile" value="<?= htmlspecialchars($user['mobile_no']) ?>" readonly class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-success w-100" id="saveBtn" style="display:none;">Save Changes</button>
    </form>
</div>

<script>
function enableEdit() {
    const form = document.getElementById('profileForm');
    Array.from(form.elements).forEach(el => {
        if(el.tagName === "INPUT" || el.tagName === "SELECT"){
            el.readOnly = false;
            el.disabled = false;
        }
    });
    document.getElementById('saveBtn').style.display = 'block';
}
</script>

</body>
</html>
