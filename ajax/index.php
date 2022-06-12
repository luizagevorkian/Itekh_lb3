<!DOCKTYPE HTML>
<html>
<head>
    <title>Laboratory 5 itech</title>
    <meta charset="utf-8">
    <script>
        var ajax = new XMLHttpRequest();

function ok1() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                console.dir(ajax.responseText);
                document.getElementById("result").innerHTML = ajax.response;
            }
        }
    }
    var chief = document.getElementById("chief").value;
    ajax.open("get", "1.php?chief=" + chief);
    ajax.send();
}

function ok2() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {

                console.dir(ajax);
                let rows = ajax.responseXML.firstChild.children;
                let result = "Total time: ";
                result += rows[0].firstChild.nodeValue
                document.getElementById("result").innerHTML = result;
            }
        }
    }
    var project_name = document.getElementById("project_name").value;
    ajax.open("get", "2.php?project_name=" + project_name);
    ajax.send();
}

function loadData() {
    let rows = JSON.parse(ajax.responseText);
    console.dir(rows);
    if (ajax.readyState === 4) {
        if (ajax.status === 200) {
            console.dir(ajax);
            let result = "<p><table border='1'>";
            result += "<tr><th>FID_Worker</th><th>FID_Projects</th><th>date</th><th>time_start</th><th>time_end</th><th>Project status</th></tr>";
            for (var i = 0; i < rows.length; i++) {
                result += "<tr>";
                result += "<td>" + rows[i].FID_Worker + "</td>";
                result += "<td>" + rows[i].FID_Projects + "</td>";
                result += "<td>" + rows[i].date + "</td>";
                result += "<td>" + rows[i].time_start + "</td>";
                result += "<td>" + rows[i].time_end + "</td>";
                result += "<td>" + rows[i].description + "</td>";
                result += "</tr>";
            }
            document.getElementById("result").innerHTML = result;
        }
    }
}

function ok3() {
    ajax.onreadystatechange = loadData;
    var project_name2 = document.getElementById("project_name2").value;
    var date = document.getElementById("date").value;
    ajax.open("get", "3.php?project_name2=" + project_name2 + "&date="+date);
    ajax.send();
}
    </script>
</head>
<body>
    <?php

    include('connection.php');

        try{
            $dbh = new PDO($dsn, $user, $psw, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            $expr = $dbh->prepare("SELECT chief FROM $db.department");
            $expr->execute();
            $chief_options = $expr->fetchAll();

            $expr = $dbh->prepare("SELECT projects.name FROM  $db.projects");
            $expr->execute();
            $project_options = $expr->fetchAll();            
        }
        catch(PDOException $ex){
            echo $ex->GetMessage();
        }
        $dbh = null;
    ?>
    <p>The number of subordinates of each chief:</p>
    <select name="chief" id="chief">
        <?php foreach ($chief_options as $name): ?>
            <option value="<?=$name["chief"]?>"><?=$name["chief"]?></option>
        <?php endforeach ?>
    </select>
    <button type="submit" onclick="ok1()">Поиск</button><br>
       
        <p>Total time spent on selected project:</p>
        <select name="project_name" id="project_name">
            <?php foreach ($project_options as $project): ?>
                <option value="<?=$project["name"]?>"><?=$project["name"]?></option>
            <?php endforeach ?>
        </select>
        <button type="submit" onclick="ok2()">Поиск</button><br>

        <p>Information of completed tasks for the specified projects on the selected date:</p>
        <select name="project_name2" id="project_name2">
            <?php foreach ($project_options as $project): ?>
                <option value="<?=$project["name"]?>"><?=$project["name"]?></option>
            <?php endforeach ?>
        </select>
        <p><input type="date" name="date" id="date"></p>
        <button type="submit" onclick="ok3()">Поиск</button><br>
    
    <div id="result"></div>
</body> 