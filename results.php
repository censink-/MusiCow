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
    $pagetitle = "Results";
    require_once 'includes/head.php';
    require_once 'includes/db.php';

    ?>
</head>
<body>
<?php
require_once 'includes/nav.php';
?>
<div class="container">
    <h1>Results Summary</h1>
    <hr>
    <!--Hey! The results may seem a little bit basic at the moment, but as our research-data flow builds up, we'll be able to go very in-depth with our statistics!
    <hr>-->
    <div class="row">
        <div class="col-sm-8">
            <h3>Recent Activity <small>Amount of clicks per team in recent history</small></h3>
            <hr>
            <canvas id="recentactivity" width="750" height="320"></canvas>
        </div>
        <div class="col-sm-4">
            <h3>Most total clicks</h3>
            <hr>
            <ul class="list-group">
            <?php
            $gettopclicks = mysqli_query($db, "SELECT group_id,COUNT(*) FROM Testentries GROUP BY group_id ORDER BY COUNT(*) DESC") or die(mysqli_error($db));
            while ($row = mysqli_fetch_assoc($gettopclicks)) {
                $getgroupname = mysqli_query($db, "SELECT `name` FROM Groups WHERE id = " . $row['group_id'] . ";");
                $groupname = mysqli_fetch_assoc($getgroupname);
                $row['groupname'] = $groupname['name'];
                ?>
                    <li class="list-group-item"><span class="label label-primary"><?= $row['groupname'] ?></span> with <span class="label label-success"><?= $row['COUNT(*)'] ?></span> clicks</li>
            <?php } ?>
            </ul>
            <hr>
            <h3>Most activated sounds</h3>
            <hr>
            <ul class="list-group">
            <?php
            $gettopsounds = mysqli_query($db, "SELECT sound,COUNT(*) FROM Testentries GROUP BY sound ORDER BY COUNT(*) DESC") or die(mysqli_error($db));
            while ($row = mysqli_fetch_assoc($gettopsounds)) {
                ?>
                <li class="list-group-item"><span class="label label-primary">Sound #<?= $row['sound'] ?></span> with <span class="label label-success"><?= $row['COUNT(*)'] ?></span> clicks</li>
            <?php } ?>
            </ul>
            <hr>
            <h3>Most active mice</h3>
            <hr>
            <ul class="list-group">
                <?php
                $gettopmice = mysqli_query($db, "SELECT testsubject_id,COUNT(*) FROM Testentries WHERE testsubject_id <> 0 GROUP BY testsubject_id ORDER BY COUNT(*) DESC") or die(mysqli_error($db));
                while ($row = mysqli_fetch_assoc($gettopmice)) {
                    $getmousename = mysqli_query($db, "SELECT `name`,group_id FROM Testsubjects WHERE id = " . $row['testsubject_id'] . ";");
                    $mousename = mysqli_fetch_assoc($getmousename);
                    $row['mousename'] = $mousename['name'];
                    $getmousegroup = mysqli_query($db, "SELECT `name` FROM Groups WHERE id = " . $mousename['group_id'] . ";");
                    $mousegroup = mysqli_fetch_assoc($getmousegroup);
                    $row['mousegroup'] = $mousegroup['name'];
                    ?>
                    <li class="list-group-item"><span class="label label-primary"><?= $row['mousename'] ?></span> from <span class="label label-primary"><?= $row['mousegroup'] ?></span> with <span class="label label-success"><?= $row['COUNT(*)'] ?></span> clicks</li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <hr>
    <a class="btn btn-lg btn-block btn-primary" href="input.php">Be sure to perform a lot of research so we got some data to work with and improve our statistics!</a>
    <br>
</div>
<?php

$getresults1 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE datetime BETWEEN '2015-12-01' AND '2015-12-15';");
$results1 = mysqli_fetch_assoc($getresults1);
$getresults2 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE datetime BETWEEN '2015-12-16' AND '2015-12-31';");
$results2 = mysqli_fetch_assoc($getresults2);
$getresults3 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE datetime BETWEEN '2016-01-01' AND '2016-01-15';");
$results3 = mysqli_fetch_assoc($getresults3);
$getresults4 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE datetime BETWEEN '2016-01-16' AND '2016-01-31';");
$results4 = mysqli_fetch_assoc($getresults4);

$getresults1_1 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE group_id = 1 AND datetime BETWEEN '2015-12-01' AND '2015-12-15';");
$results1_1 = mysqli_fetch_assoc($getresults1_1);
$getresults1_2 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE group_id = 2 AND datetime BETWEEN '2015-12-01' AND '2015-12-15';");
$results1_2 = mysqli_fetch_assoc($getresults1_2);
$getresults2_1 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE group_id = 1 AND datetime BETWEEN '2015-12-16' AND '2015-12-31';");
$results2_1 = mysqli_fetch_assoc($getresults2_1);
$getresults2_2 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE group_id = 2 AND datetime BETWEEN '2015-12-16' AND '2015-12-31';");
$results2_2 = mysqli_fetch_assoc($getresults2_2);
$getresults3_1 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE group_id = 1 AND datetime BETWEEN '2016-01-01' AND '2016-01-15';");
$results3_1 = mysqli_fetch_assoc($getresults3_1);
$getresults3_2 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE group_id = 2 AND datetime BETWEEN '2016-01-01' AND '2016-01-15';");
$results3_2 = mysqli_fetch_assoc($getresults3_2);
$getresults4_1 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE group_id = 1 AND datetime BETWEEN '2016-01-16' AND '2016-01-31';");
$results4_1 = mysqli_fetch_assoc($getresults4_1);
$getresults4_2 = mysqli_query($db, "SELECT COUNT(*) FROM Testentries WHERE group_id = 2 AND datetime BETWEEN '2016-01-16' AND '2016-01-31';");
$results4_2 = mysqli_fetch_assoc($getresults4_2);

require_once 'includes/scripts.php';
?>
<script type="text/javascript" src="assets/js/chart.min.js"></script>
<script type="text/javascript">
    Chart.defaults.global = {
        // Boolean - Whether to animate the chart
        animation: true,

        // Number - Number of animation steps
        animationSteps: 50,

        // String - Animation easing effect
        // Possible effects are:
        // [easeInOutQuart, linear, easeOutBounce, easeInBack, easeInOutQuad,
        //  easeOutQuart, easeOutQuad, easeInOutBounce, easeOutSine, easeInOutCubic,
        //  easeInExpo, easeInOutBack, easeInCirc, easeInOutElastic, easeOutBack,
        //  easeInQuad, easeInOutExpo, easeInQuart, easeOutQuint, easeInOutCirc,
        //  easeInSine, easeOutExpo, easeOutCirc, easeOutCubic, easeInQuint,
        //  easeInElastic, easeInOutSine, easeInOutQuint, easeInBounce,
        //  easeOutElastic, easeInCubic]
        animationEasing: "easeOutQuart",

        // Boolean - If we should show the scale at all
        showScale: true,

        // Boolean - If we want to override with a hard coded scale
        scaleOverride: false,

        // ** Required if scaleOverride is true **
        // Number - The number of steps in a hard coded scale
        scaleSteps: null,
        // Number - The value jump in the hard coded scale
        scaleStepWidth: null,
        // Number - The scale starting value
        scaleStartValue: null,

        // String - Colour of the scale line
        scaleLineColor: "rgba(0,0,0,.1)",

        // Number - Pixel width of the scale line
        scaleLineWidth: 1,

        // Boolean - Whether to show labels on the scale
        scaleShowLabels: true,

        // Interpolated JS string - can access value
        scaleLabel: "<%=value%>",

        // Boolean - Whether the scale should stick to integers, not floats even if drawing space is there
        scaleIntegersOnly: true,

        // Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: false,

        // String - Scale label font declaration for the scale label
        scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

        // Number - Scale label font size in pixels
        scaleFontSize: 12,

        // String - Scale label font weight style
        scaleFontStyle: "normal",

        // String - Scale label font colour
        scaleFontColor: "#666",

        // Boolean - whether or not the chart should be responsive and resize when the browser does.
        responsive: false,

        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,

        // Boolean - Determines whether to draw tooltips on the canvas or not
        showTooltips: true,

        // Function - Determines whether to execute the customTooltips function instead of drawing the built in tooltips (See [Advanced - External Tooltips](#advanced-usage-custom-tooltips))
        customTooltips: false,

        // Array - Array of string names to attach tooltip events
        tooltipEvents: ["mousemove", "touchstart", "touchmove"],

        // String - Tooltip background colour
        tooltipFillColor: "rgba(0,0,0,0.8)",

        // String - Tooltip label font declaration for the scale label
        tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

        // Number - Tooltip label font size in pixels
        tooltipFontSize: 14,

        // String - Tooltip font weight style
        tooltipFontStyle: "normal",

        // String - Tooltip label font colour
        tooltipFontColor: "#fff",

        // String - Tooltip title font declaration for the scale label
        tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

        // Number - Tooltip title font size in pixels
        tooltipTitleFontSize: 14,

        // String - Tooltip title font weight style
        tooltipTitleFontStyle: "bold",

        // String - Tooltip title font colour
        tooltipTitleFontColor: "#fff",

        // Number - pixel width of padding around tooltip text
        tooltipYPadding: 6,

        // Number - pixel width of padding around tooltip text
        tooltipXPadding: 6,

        // Number - Size of the caret on the tooltip
        tooltipCaretSize: 8,

        // Number - Pixel radius of the tooltip border
        tooltipCornerRadius: 6,

        // Number - Pixel offset from point x to tooltip edge
        tooltipXOffset: 10,

        // String - Template string for single tooltips
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",

        // String - Template string for multiple tooltips
        multiTooltipTemplate: "<%= value %>",

    }
    var activityContext = $('#recentactivity').get(0).getContext('2d'),
        activityOptions = {
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
        };
    var activityData = {
            labels: ['01-12-2015', '16-12-2016', '01-01-2016', '16-01-2016'],
            datasets: [
                {
                    label: 'Total: ',
                    fillColor: 'rgba(0,0,0,0.08)',
                    strokeColor: 'rgba(0,0,0,1)',
                    pointColor: 'rgba(0,0,0,1)',
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [<?= $results1['COUNT(*)'] ?>, <?= $results2['COUNT(*)'] ?>, <?= $results3['COUNT(*)'] ?>, <?= $results4['COUNT(*)'] ?>]
                },
                {
                    label: 'Group 1: ',
                    fillColor: 'rgba(10,100,200,0.5)',
                    strokeColor: 'rgba(10,100,200,1)',
                    pointColor: 'rgba(10,100,200,1)',
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [<?= $results1_1['COUNT(*)'] ?>, <?= $results2_1['COUNT(*)'] ?>, <?= $results3_1['COUNT(*)'] ?>, <?= $results4_1['COUNT(*)'] ?>]
                },
                {
                    label: 'Group 2: ',
                    fillColor: 'rgba(100,100,250,0.5)',
                    strokeColor: 'rgba(100,100,250,1)',
                    pointColor: 'rgba(100,100,250,1)',
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [<?= $results1_2['COUNT(*)'] ?>, <?= $results2_2['COUNT(*)'] ?>, <?= $results3_2['COUNT(*)'] ?>, <?= $results4_2['COUNT(*)'] ?>]
                }
            ]
        },
        activityChart = new Chart(activityContext).Line(activityData, activityOptions);
</script>
</body>
</html>