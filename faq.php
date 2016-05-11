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
    <h1>Frequently Asked Questions</h1>
    <hr>
    <dl class="dl-horizontal">
        <dt>
            What is Mousical?
        </dt>
        <dd>
            We are a 2nd year college projectgroup and we created a product that will test if sound can scare away mice and rats. We mainly focus on mice.<br><a href="about.php">Read more about us here</a>
        </dd>
        <hr>
        <dt>
            Wait, can you test on mice?
        </dt>
        <dd>
            Yes, we can. We contacted an expert and he told us everything we needed to know to provide for a safe environment for mice. Yes, we also created that safe environment.
        </dd>
        <hr>
        <dt>
            How does this testing environment look?
        </dt>
        <dd>
            We built 4 mice cages where 3 of them contain a sensor. With that sensor we measure the traffic between all 4 of the cages. When the sensor notices a mice in the cage, it plays a tone. That tone is very important because then we’ll see if mice react to the tones.
        </dd>
        <hr>
        <dt>
            Why would you want to scare mice away with sound?
        </dt>
        <dd>
            It can be annoying and scary to use other methods like a mousetrap. By using a mousetrap you actually kill the mouse, which is not what we want. Therefore we thought of a solution that is all about the use of different tones.
        </dd>
        <hr>
        <dt>
            Are there any testresults that I can see?
        </dt>
        <dd>
            We think that it’s important for people outside the experiment to know what we do and what the results are. So, we created some diagrams consisting of our testresult. You can see them at <a href="results.php">the resultspage</a>.
        </dd>
    </dl>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>