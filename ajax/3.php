<?php
include("connection.php");
    $expr = $dbh->prepare("SELECT a.* FROM $db.work a JOIN $db.projects b ON $db.a.FID_Projects=$db.b.ID_Projects 
    WHERE $db.b.name=:project_name AND $db.a.date<=:work_date");
    $expr->execute(['project_name'=>$_GET["project_name2"], 'work_date'=>$_GET["date"]]);
    $res = $expr->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($res);
?>