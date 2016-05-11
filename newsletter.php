<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
} else {
    $userid = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pagetitle = "";
    require_once 'includes/head.php';
    ?>
</head>
<body>
<?php
require_once 'includes/nav.php';
?>
<div class="container">
    <img src="assets/img/newsletter1.jpg" alt="newsletter 1" style="width: 100%; margin-top: -20px;">
    <hr>
    <a class="btn btn-lg btn-block btn-primary" href="./">Check back later, or subscribe on our homepage!</a>
    <br>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>