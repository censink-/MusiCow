<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit;
}

require_once 'includes/db.php';
$getgroupquery = "SELECT group_id FROM Users WHERE id = " . $userid . ";";
$getgroup = mysqli_query($db, $getgroupquery);
$group = mysqli_fetch_assoc($getgroup);
$group = $group['group_id'];

$getmicequery = "SELECT * FROM Testsubjects WHERE group_id = " . $group . ";";
$getmice = mysqli_query($db, $getmicequery);

$i = 0;
while($mouse = mysqli_fetch_assoc($getmice)){
    $mice[$i]['id'] = $mouse['id'];
    $mice[$i]['name'] = $mouse['name'];
    $mice[$i]['image'] = $mouse['image_url'];
    $i++;
}
$mice = json_encode($mice);
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
    <h1>Add new data <small>For <a href="group.php">group <?= $group ?></a></small></h1>
    <hr>
    <span class="lead">
        Observe the testsubjects and keep track of clicks. When a mouse activates a sound, you'll need to enter who did it!
        <br>Once a sound is triggered, it will appear below.
    </span>
    <hr>
    <div class="panel-group" id="recordpanels">

    </div>
</div>
<?php
require_once 'includes/scripts.php';
?>
<script>
    var groupid = <?= $group ?>;
    var mice = <?php echo $mice; ?>;
</script>
<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>