<nav class="navbar navbar-static-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">Mousical</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php if ($userid == null) { ?>
                <li><a href="contribute.php">How to contribute</a></li>
                <?php } else { ?>
                <li><a href="input.php">Add new data</a></li>
                <?php } ?>
                <li><a href="results.php">Test results</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="about.php">About Mousical</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <?php if ($userid != null) { require_once 'includes/db.php'; $getuserquery = "SELECT * FROM users WHERE id = " . $userid . ";"; $getuser = mysqli_query($db, $getuserquery); $user = mysqli_fetch_assoc($getuser); echo "(" . $user['username'] . ")"; } ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if ($userid == null) { ?>
                            <li><a href="login.php">Log in</a></li>
                            <li class="divider"></li>
                            <li><a href="register.php">Register</a></li>
                        <?php } else { ?>
                            <li><a href="profile.php">My Profile</a></li>
                            <li><a href="group.php">My group</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php">Log out</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>