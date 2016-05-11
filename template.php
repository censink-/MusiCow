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
    </div>
    <?php
    require_once 'includes/scripts.php';
    ?>
</body>
</html>