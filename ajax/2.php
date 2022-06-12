<?php
header('Content-Type: text/xml');
header('Cache-Control: no-cache, must-revalidate');
include "connection.php";
echo '<?xml version="1.0" ?>';
echo "<root>";
include("connection.php");
$expr = $dbh->prepare("SELECT ROUND(TIME_TO_SEC(timediff($db.a.time_end, $db.a.time_start))/3600) AS diff 
FROM $db.work a JOIN $db.projects b ON $db.a.FID_Projects=$db.b.ID_Projects WHERE $db.b.name=:project_name");
$expr->execute(['project_name'=>$_GET["project_name"]]);
$res = $expr->fetchAll();

$total_time = 0;
foreach ($res as $num)
    $total_time+=$num[0];
    echo "<row>$total_time</row>";
    echo "</root>";
?>