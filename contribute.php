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
    <h1>How to contribute <small>Support this project by performing tests</small></h1>
    <hr>
    <span class="lead">So you want to start researching yourself? Good! But there are few things you need to get started.</span>
    <br>
    <br>
    <ol>
        <li>You’ll need to create a group. When doing this we ask for a name. This name corresponds with a random generated key. You will be the only admin in the group when you created the group yourself.</li>
        <li>When you have succesfully created a group, you can start with the physical parts of the experiment. You’ll need a safe house for the animals you are ‘testing’. We highly recommend not to build this safe house too quick since this is a really important part of the test.</li>
        <li>When you’ve created the safe house you can almost start testing! Before actual testing we recommend dummy testing. This is so you get used to our testing interface so you don’t be suprised when you’re testing and something doesn’t work like you think it should.</li>
        <li>This will be all for now, have fun testing!</li>
    </ol>
    <br><br>
    Team Mousical.
    <hr>
    <a class="btn btn-lg btn-block btn-primary" href="faq.php">Be sure to check out our Frequently Asked Questions page too!</a>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>