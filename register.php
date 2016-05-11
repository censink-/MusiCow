<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
    header("Location: profile.php");
    exit;
} else {
    $userid = null;
}
if (isset($_POST['register-submit'])) {
    require_once 'includes/db.php';
    $username = mysqli_escape_string($db, $_POST['input-username']);
    $password = mysqli_escape_string($db, $_POST['input-password']);
    $group = mysqli_escape_string($db, $_POST['input-group']);
    if ($group == "") {
        $group = null;
    } else {
        $getgroupquery = "SELECT id FROM Groups WHERE `key` = '" . $group . "'";
        $getgroup = mysqli_query($db, $getgroupquery);
        $group = mysqli_fetch_assoc($getgroup);
        $group = $group['id'];
        if ($group == "") {
            $group = null;
        }
    }

    $registerquery = "INSERT INTO Users (username,password,role,group_id) VALUES ('" . $username . "', '" . $password . "', 1, '" . $group . "');";
    $register = mysqli_query($db, $registerquery);

    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pagetitle = "Register";
    require_once 'includes/head.php';
    ?>
</head>
<body>
<?php
require_once 'includes/nav.php';
?>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 text-center">
            <h1>Register</h1>
            <hr>
            <span class="lead">To use this website's functions, you need to create an account</span>
            <hr>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="input-username" placeholder="Username" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="password" name="input-password" placeholder="Password" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="text" name="input-group" placeholder="Group Key (optional)" class="form-control">
                </div>
                <input type="submit" name="register-submit" value="Register" class="btn btn-block btn-info">
            </form>
            <hr>
            <p class="text-muted">Already have an account?
                <br><a href="login.php">Log in</a>
            </p>
        </div>
    </div>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>