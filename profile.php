<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
} else {
    $userid = null;
    header("Location: login.php?target=profile");
    exit;
}
require_once 'includes/db.php';

if (isset($_GET['id']) && isset($_SESSION['admin'])) {
    $profileid = mysqli_escape_string($db, $_GET['id']);
    $id = "?id=" . $profileid;
} else {
    $profileid = $userid;
    $id = "";
}

$getprofilequery = "SELECT * FROM Users WHERE id = " . $profileid . ";";
$getprofile = mysqli_query($db, $getprofilequery);
$profile = mysqli_fetch_assoc($getprofile);

if (isset($_POST['profile-submit'])) {
    $username = mysqli_escape_string($db, $_POST['input-username']);
    $password = mysqli_escape_string($db, $_POST['input-password']);
    $groupkey = mysqli_escape_string($db, $_POST['input-group']);
    $getgroupquery = "SELECT * FROM Groups WHERE `key` = '" . $groupkey . "';";
    $getgroup = mysqli_query($db, $getgroupquery);
    $group = mysqli_fetch_assoc($getgroup);
    if ($group == $profile['id']) {
        $role = 2;
    } else {
        $role = 1;
    }
    $changeprofilequery = "UPDATE Users SET username = '" . $username . "', password = '" . $password . "', group_id = " . $group['id'] . ", role = " . $role . " WHERE id = " . $profileid . ";";
    $changeprofile = mysqli_query($db, $changeprofilequery);
    header("Location: profile.php" . $id);
    exit;
}
$getgroupquery = "SELECT `key` FROM Groups WHERE id = '" . $profile['group_id'] . "';";
$getgroup = mysqli_query($db, $getgroupquery);
echo mysqli_error($db);
if (mysqli_num_rows($getgroup) != 0) {
    $group = mysqli_fetch_assoc($getgroup);
} else {
    $group['key'] = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pagetitle = "Profile";
    require_once 'includes/head.php';
    ?>
</head>
<body>
<?php
require_once 'includes/nav.php';
?>
<div class="container">
    <h1>Profile of <?= $profile['username'] ?> <small>(UUID: <?= $profile['id'] ?>)</small> <a class="btn btn-primary pull-right" href="group.php">Group</a></h1>
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <form method="post">
                <div class="form-group">
                    <label for="input-username">Username</label>
                    <input id="input-username" type="text" name="input-username" placeholder="Username" value="<?= $profile['username'] ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="input-password">Password</label>
                    <input id="input-password" type="password" name="input-password" placeholder="********" value="<?= $profile['password'] ?>" class="form-control">
                </div>
                <label for="input-group"><a href="group.php">Group</a> Key <small class="text-muted">Only accepts valid keys</small></label>
                <div class="form-inline">
                    <div class="form-group">
                        <input id="input-group" type="text" name="input-group" placeholder="XXXXXX" value="<?= $group['key'] ?>" class="form-control" style="width: 100px;"> or
                        <a href="group.php?leave" class="btn btn-danger">Leave group</a> or
                        <a href="group.php?new" class="btn btn-info">Create group</a>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="profile-submit" value="Save Changes" class="btn btn-success btn-block">
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>