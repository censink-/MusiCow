<?php
session_start();

if (!isset($_GET['action']) || $_GET['action'] == "") {
    $d['code'] = 400; //No action defined
} else {
    $action = $_GET['action'];
    $d['action'] = $action;

    if ($action == "addrecord") {
        if (!isset($_GET['group']) || !isset($_GET['sound'])) {
            $d['code'] = 411; //Parameter(s) missing
        } else {
            $group = $_GET['group'];
            $sound = $_GET['sound'];
            if ($group == "" || $sound == "") {
                $d['code'] = 412; //Parameter(s) returned 'null'
            } else {
                $d['code'] = 204; //Success! (No content, Overwritten if shit hits the fan)
                (@include_once ('includes/db.php')) or $d['code'] = 424; //Couldn't include file

                if ($d['code'] == 204) {
                    $addrecordquery = "INSERT INTO Testentries (group_id, sound) VALUES (" . $group . ", " . $sound . ");";
                    $addrecord = mysqli_query($db, $addrecordquery);
                    if (!$addrecord) {
                        $d['code'] = 417; //Couldn't execute query
                    }
                }
            }
        }
    } else if ($action == "getnewrecords") {
        if (!isset($_GET['group'])) {
            $d['code'] = 411; //Parameter(s) missing
        } else {
            $group = $_GET['group'];
            if ($group == "") {
                $d['code'] = 412; //Parameter(s) returned 'null'
            } else {
                $d['code'] = 200; //Success! (Overwritten if shit hits the fan)
                (@include_once ('includes/db.php')) or $d['code'] = 424; //Couldn't include file

                if ($d['code'] == 200) {
                    $d['group'] = $group;
                    $getrecordsquery = "SELECT * FROM Testentries WHERE group_id = " . $group . " AND testsubject_id IS NULL;";
                    $getrecords = mysqli_query($db, $getrecordsquery);
                    if ($getrecords) {
                        $i = 0;
                        while ($record = mysqli_fetch_array($getrecords)) {
                            $d['records'][$i]['id'] = $record['id'];
                            $d['records'][$i]['datetime'] = $record['datetime'];
                            $d['records'][$i]['sound'] = $record['sound'];
                            $i++;
                        }
                        if ($i == 0) {
                            $d['code'] = 204; //Success, but no content
                        }
                    } else {
                        $d['code'] = 417; //Couldn't execute query
                    }

                }

            }
        }
    } else if ($action == "settestsubject") {
        if (!isset($_SESSION['user_id'])) {
            $d['code'] = 401; //No access
        } else {
            if (!isset($_GET['id']) || !isset($_GET['testsubject'])) {
                $d['code'] = 411; //Parameter(s) missing
            } else {
                $id = $_GET['id'];
                $testsubject = $_GET['testsubject'];
                if ($id == "" || $testsubject == "") {
                    $d['code'] = 412; //Parameter(s) returned 'null'
                } else {
                    $d['code'] = 204; //Success! (but no content)
                    //Everything's alright, let's do something
                    (@include_once('includes/db.php')) or $d['code'] = 424; //Couldn't include file

                    if ($d['code'] == 204) {
                        $userid = $_SESSION['user_id'];
                        $groupquery = "SELECT group_id FROM Testentries WHERE id = " . $id . ";";
                        $group = mysqli_query($db, $groupquery);
                        $groupid = mysqli_fetch_assoc($group);
                        $userquery = "SELECT group_id FROM Users WHERE id = " . $_SESSION['user_id'] . ";";
                        $user = mysqli_query($db, $userquery);
                        $userid = mysqli_fetch_assoc($user);
                        if ($groupid['group_id'] == $userid['group_id']) { //is user in group?
                            $subjectquery = "SELECT group_id FROM Testsubjects WHERE id = " . $testsubject . ";";
                            $subject = mysqli_query($db, $subjectquery);
                            $subjectid = mysqli_fetch_assoc($subject);
                            if ($userid['group_id'] == $subjectid['group_id'] || $testsubject == 0) { //is subject in group? 0 is for invalid/unknown testsubject
                                $updaterecordquery = "UPDATE Testentries SET testsubject_id = " . $testsubject . " WHERE id = " . $id . ";";
                                $updaterecord = mysqli_query($db, $updaterecordquery);
                                if (!$updaterecord) {
                                    $d['code'] = 417; //Couldn't execute query
                                }
                            } else {
                                $d['code'] = 406; //Subject doesn't belong to your group
                            }
                        } else {
                            $d['code'] = 403; //Access denied, user isn't in group
                        }
                    }
                }
            }
        }
    } else {
        $d['code'] = 404; //Unknown action
    }
}

switch($d['code']) {
    default:
        $d['code'] = 418;
        $d['error'] = "I'm a teapot (unhandled error!)";
    case 200:
        //case 200 is a successful request, we're not supplying an error
        break;
    case 204:
        $d['error'] = "No content for this request";//case 204 is a successful request with no content
        break;
    case 400:
        $d['error'] = "No action defined";
        break;
    case 401:
        $d['error'] = "You need to sign in!";
        break;
    case 403:
        $d['error'] = "Access denied";
        break;
    case 404:
        $d['error'] = "Unknown action";
        break;
    case 406:
        $d['error'] = "That subject doesn't belong to your group!";
        break;
    case 411:
        $d['error'] = "One or more parameters are missing";
        break;
    case 412:
        $d['error'] = "One or more parameters returned 'null'";
        break;
    case 417:
        $d['error'] = "Couldn't execute database query with these parameters";
        break;
    case 424:
        $d['error'] = "Couldn't include a file";
        break;
    case 503:
        $d['error'] = "Couldn't reach database";
        break;
}

$djson = json_encode($d);
header("Content-type: application/json");
echo $djson;