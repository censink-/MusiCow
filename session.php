<?php
session_start();
?>
<html>
<head>
    <title>Setting session info</title>
</head>
<body>
<?php
if (isset($_GET['user_id']) && $_GET['user_id'] != "") {
    $_SESSION['user_id'] = $_GET['user_id'];
    $userid = $_SESSION['user_id'];
}
if (!isset($_SESSION['user_id'])) {
    $userid = "nothing";
}
?>
<strong>Your session user_id has been set to <?= $userid ?></strong>
<form method="get">
    <input type="text" name="user_id">
    <input type="submit">
</form>
<a href="api.php?action=addrecord&group=1&sound=1">api.php?action=addrecord&group=1&sound=1</a>
<br><a href="api.php?action=getnewrecords&group=1">api.php?action=getnewrecords&group=1</a>
<br><a href="api.php?action=settestsubject&id=1&sound=1">api.php?action=settestsubject&id=1&sound=1</a>
</body>
</html>