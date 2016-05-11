<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit;
}

require_once 'includes/db.php';

function generateRandomString($db, $first) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    if (checkKey($db, $randomString)) {
        return $randomString;
    } else {
        return generateRandomString($db, false);
    }
}

function checkKey($db, $randomkey) {

    $confirmuniquequery = "SELECT `key` FROM Groups";
    $confirmunique = mysqli_query($db, $confirmuniquequery);
    $found = false;
    while ($key = mysqli_fetch_assoc($confirmunique)) {
        if ($key['key'] == $randomkey) {
            $found = true;
        }
    }
    if ($found) { //not unique
        return false;
    } else { //unique
        return true;
    }
}

$getuserquery = "SELECT * FROM Users WHERE id = " . $userid . ";";
$getuser = mysqli_query($db, $getuserquery);
$user = mysqli_fetch_assoc($getuser);
$group = $user['group_id'];

if (isset($_POST['group-submit'])) {
    $name = mysqli_real_escape_string($db, $_POST['group-name']);

    $key = generateRandomString($db, true);

    $creategroupquery = "INSERT INTO Groups (`key`, `name`, validated, owner_id) VALUES ('" . $key . "', '" . $name . "', 0, " . $user['id'] . ");";
    $creategroup = mysqli_query($db, $creategroupquery);
    if (!$creategroup) {
        die(mysqli_error($db));
    }
    $newgroupid = mysqli_insert_id($db);

    $joingroupquery = "UPDATE Users SET group_id = " . $newgroupid . ", role = 2 WHERE id = " . $user['id'] . ";";
    $joingroup = mysqli_query($db, $joingroupquery);

    header("Location: group.php");
    exit;
}
if (isset($_GET['leave'])) {
    $leavegroupquery = "UPDATE Users SET group_id = null WHERE id = " . $user['id'] . ";";
    $leavegroup = mysqli_query($db, $leavegroupquery);
}

if ($group != null && !isset($_GET['leave']) && !isset($_GET['new'])) {

    if (isset($_POST['input-submit'])) {
        $name = mysqli_real_escape_string($db, $_POST['input-name']);
        $image = mysqli_real_escape_string($db, $_POST['input-image']);

        $createsubjectquery = "INSERT INTO Testsubjects (name, image_url, group_id) VALUES ('" . $name . "', '" . $image . "', " . $group . ");";
        $createsubject = mysqli_query($db, $createsubjectquery);
        if ($createsubject) {
            header("Location: group.php");
            exit;
        } else {
            die(mysqli_error($db));
        }
    }

    if (isset($_GET['deletesubject'])) {
        $subject = mysqli_real_escape_string($db, $_GET['id']);
        $deletesubjectquery = "DELETE FROM Testsubjects WHERE id = " . $subject . ";";
        $deletesubject = mysqli_query($db, $deletesubjectquery);
        if ($deletesubject) {
            header("Location: group.php");
            exit;
        } else {
            die(mysqli_error($db));
        }
    }

    if (isset($_GET['kickmember']) && $_GET['kickmember'] != "") {
        $kickmemberquery = "UPDATE Users SET group_id = null WHERE id = " . mysqli_real_escape_string($db, $_GET['kickmember']) . ";";
        $kickmember = mysqli_query($db, $kickmemberquery);
        if (!$kickmember) {
            die(mysqli_error($db));
        } else {
            header("Location: group.php");
            exit;
        }
    }

    $getgroupquery = "SELECT * FROM Groups WHERE id = " . $group . ";";
    $getgroup = mysqli_query($db, $getgroupquery);
    $group = mysqli_fetch_assoc($getgroup);

    $getmembersquery = "SELECT * FROM Users WHERE group_id = " . $group['id'] . ";";
    $getmembers = mysqli_query($db, $getmembersquery);

    $gettestsubjectsquery = "SELECT * FROM Testsubjects WHERE group_id = " . $group['id'] . ";";
    $gettestsubjects = mysqli_query($db, $gettestsubjectsquery);
    $subjectcount = mysqli_num_rows($gettestsubjects);

    $getclicksquery = "SELECT * FROM Testentries WHERE group_id = " . $group['id'] . " ORDER BY id ASC;";
    $getclicks = mysqli_query($db, $getclicksquery);
    $i = 0;
    while ($click = mysqli_fetch_assoc($getclicks)) {
        $clicks[$i]['id'] = $click['id'];
        $clicks[$i]['datetime'] = $click['datetime'];
        $i++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pagetitle = "My group";
    require_once 'includes/head.php';
    ?>
</head>
<body>
<?php
require_once 'includes/nav.php';
?>
<div class="container">
    <?php if ($group != null && !isset($_GET['leave']) && !isset($_GET['new'])) { ?>
    <h1><?= $group['name'] ?> <small>Group Key: <code class="bg-info"><?= $group['key'] ?></code></small><a class="btn btn-primary pull-right" href="input.php">Add data</a></h1>
    <hr>
    <div class="row">
        <div class="col-sm-6">
            <h3>Stats:</h3>
            <ul>
                <li>This group has <span class="badge"><?= $subjectcount ?></span> test subjects</li>
                <li>This group has received <span class="badge"><?= $i ?></span> clicks in conducted tests!</li>
                <?php if ($i != 0) {
                    $lastclick = end($clicks);
                    ?>
                <li>Their most recent click was from <span class="badge"> <?= $lastclick['datetime'] ?></span></li>
                <?php } ?>
        </div>
        <div class="col-sm-6">
            <h3>Members:</h3>
            <ul>
                <?php
                while ($member = mysqli_fetch_array($getmembers)) {
                    if ($user['role'] != 1 || $user['id'] == $group['owner_id']) {
                        if ($userid != $member['id']) {
                            echo "<li>" . $member['username'] . "<a class='text-danger bg-danger pull-right' href='?kickmember=" . $member['id'] . "'>Kick</a></li>";
                        } else {
                            echo "<li><strong>" . $member['username'] . "</strong><span class='text-muted pull-right'>Can't kick yourself!</span></li>";
                        }
                    } else {
                        if ($userid != $member['id']) {
                            echo "<li>" . $member['username'] . "</li>";
                        } else {
                            echo "<li><strong>" . $member['username'] . "</strong></li>";
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <h3>Test subjects:</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th colspan="2">Image</th>
                <?php if ($user['role'] != 1) { ?><th>Actions</th><?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($subject = mysqli_fetch_array($gettestsubjects)) { ?>
            <tr>
                <td><?= $subject['id'] ?></td>
                <td><?= $subject['name'] ?></td>
                <td><img class="mouse-preview" src="<?= $subject['image_url'] ?>" alt="<?= $subject['name'] ?>"></td>
                <td><?= $subject['image_url'] ?></td>
                <?php if ($user['role'] != 1) { ?><td><a href="?deletesubject&id=<?= $subject['id'] ?>" class="btn btn-danger">Delete</a></td><?php } ?>
            </tr>
        <?php } ?>
        <?php if ($user['role'] != 1 || $user['id'] == $group['owner_id']) { ?><tr>
                <form method="post">
                    <td>#</td>
                    <td><input type="text" placeholder="Name" name="input-name" class="form-control"></td>
                    <td colspan="2"><input type="text" placeholder="Image Url" name="input-image" class="form-control"></td>
                    <td><input type="submit" value="Create" name="input-submit" class="btn btn-success"></td>
                </form>
            </tr><?php } ?>
        </tbody>
    </table>
    <?php } else if (isset($_GET['leave'])) { ?>
        <h1>You have left your group!</h1>
        <hr>
        <span class="lead">Join or create one by going to <a href="profile.php">your profile</a></span>
    <?php } else if (isset($_GET['new']) && $user['group_id'] != null) { ?>
        <h1>You need to leave your current group first!</h1>
        <hr>
        <span class="lead">You can do so on <a href="profile.php">your profile</a></span>
    <?php } else if (isset($_GET['new'])) { ?>
        <div class="col-sm-offset-4 col-sm-4 text-center">
            <h1>Create your group</h1>
            <hr>
            <form method="post" action="group.php" >
                <div class="form-group">
                    <label for="input-name">All we need is your new group's name!</label>
                    <input id="input-name" type="text" name="group-name" placeholder="Company Team #" class="form-control">
                </div>
                <hr>
                <input type="submit" name="group-submit" class="btn btn-success btn-block" value="Create!">
            </form>
        </div>
    <?php } else { ?>
        <h1>You haven't joined a group yet!</h1>
        <hr>
        <span class="lead">Join or create one by going to <a href="profile.php">your profile</a></span>
    <?php } ?>
</div>
<?php
require_once 'includes/scripts.php';
?>
</body>
</html>