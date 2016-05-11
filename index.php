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
    <div class="jumbotron text-center" style="margin-top: -40px; height: 250px; background-image: url('http://www.trafficsteed.com/wp-content/uploads/2013/12/mouse-and-motivation-steals-enormous-cookie.jpg'); background-size:120%; background-position: -150px 400px;; text-shadow: 0 0 5px black; color: white;">
        <h1>Mousical</h1>
        <span class="lead">
            Keep those mice away, without killing them!
        </span>
    </div>
    <div class="row text-center">
        <div class="col-sm-4">
            <div class="well">
                <h3>F.A.Q.</h3>
                <hr>
                <div class="text-center"><i class="glyphicon glyphicon-question-sign" style="font-size: 53pt;"></i></div>
                <br>
                <p>Our frequently-asked-questions are answered on the page below:</p>
                <a href="faq.php" class="btn btn-primary btn-lg btn-block">Click here!</a>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="well">
                <h3>About Us</h3>
                <hr>
                <p>Mousical is a researchtool that allows you to record how animals respond to sound. In order to verify our tool and setup, we have built several cages with pressure plates which are connected to a speaker and our database. A sound will be played and a researcher can easily record which mouse caused it, this way we may recognize certain patterns in their behaviour.</p>
                <a href="about.php" class="btn btn-primary btn-lg btn-block">Read more!</a>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="well">
                <h3>Newsletter</h3>
                <hr>
                <p>We regularly publish a newsletter in which we share our development stories and progress. Subscribe here:</p>
                <form class="form-inline">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="mail@example.com" style="width: 225px;">
                        <input type="submit" class="btn btn-success" value="Subscribe">
                    </div>
                </form>
                <hr>
                <a href="newsletter.php" class="btn btn-primary btn-lg btn-block">View latest issue!</a>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>