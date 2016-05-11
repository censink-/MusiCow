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
    <h1>About Us</h1>
    <hr>
    We are part of class MT2C, Year 2 of the course Media Technology at the CMI Institute of Rotterdam University. Our team consists of:
    <ul>
        <li>Czar Ensink</li>
        <li>Duncan Teegelaar</li>
        <li>Lennart Bank</li>
        <li>Sumiet Singh</li>
    </ul>
    We are "Team 5" of the project "Internet for Nature" and our concept is called 'Mousical'.
    <br>Mousical is a research based on the analysis of responses of mice (and animals in general) to different tones. Observing the behavior of the mice gives us insight and indicates whether it is experienced as pleasant or even unpleasant. We are also looking at the different reactions when different tones are played.
    <br>For an accurate result to get this project was arranged from our research that multiple teams can use this as a tool and then apply in order to carry out the investigation itself. The more results, the more data can be merged. Ultimately, the end result will show a representative picture.
    <hr>
    <span class="lead">If you understand dutch and would like to find out more, you may want to visit <a href="http://project.cmi.hro.nl/2015_2016/mtnll_mt2c_t5/" target="_blank">our blog</a>.</span>
    <hr>
    <a class="btn btn-lg btn-block btn-primary" href="faq.php">Be sure to check out our Frequently Asked Questions page too!</a>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>