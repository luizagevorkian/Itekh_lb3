<?php 
    include('connection.php');
        $dbh = new PDO($dsn, $user, $psw, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $expr = $dbh->prepare("SELECT COUNT(a.ID_Worker) FROM $db.worker a JOIN $db.department b 
        ON $db.a.FID_Department=$db.b.ID_Department WHERE $db.b.chief=:chief_name");
        $expr->execute(['chief_name'=>$_GET["chief"]]);
        $workers_number = $expr->fetch();
        $workers_number = $workers_number[0];
    echo "Workers number is $workers_number"
?>