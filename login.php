<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}
if (isset($_POST['login-submit'])) {
    if ($_POST['input-username'] != "" && $_POST['input-password'] != "") {
        require_once 'includes/db.php';

        $username = mysqli_escape_string($db, $_POST['input-username']);
        $password = mysqli_escape_string($db, $_POST['input-password']);

        $checkloginquery = "SELECT * FROM Users WHERE username = '" . $username . "' AND password = '" . $password . "';";
        $checklogin = mysqli_query($db, $checkloginquery);

        if (mysqli_num_rows($checklogin) != 1) {
            header("Location: login.php"); //To be fixed
        } else {
            $login = mysqli_fetch_assoc($checklogin);
            $_SESSION['user_id'] = $login['id'];
            if ($login['role'] == 2) {
                $_SESSION['admin'] = 1;
            }
            header("Location: profile.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pagetitle = "Login";
    $userid = null;
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
            <h1>Log in</h1>
            <hr>
            <span class="lead">To gain access to <?php if (isset($_GET['target'])) { ?>this page<?php } else { echo "your profile"; } ?>, you need to enter your credentials</span>
            <hr>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="input-username" placeholder="Username" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="password" name="input-password" placeholder="Password" class="form-control" required>
                </div>
                <input type="submit" name="login-submit" value="Log in" class="btn btn-block btn-success">
            </form>
            <hr>
            <p class="text-muted">Don't have an account yet?
                <br><a href="register.php">Register</a>
            </p>
        </div>
    </div>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>