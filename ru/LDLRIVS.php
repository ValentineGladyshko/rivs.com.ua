<?php
function query_db ($query){
    $mysqli = mysqli_connect("localhost", "ForHack", "kEHf5NAi", "LDLRIVS");
    $mysqli->set_charset("utf8");
    $res = mysqli_query($mysqli, $query);
    $rows = [];
    while($row = $res->fetch_assoc()) {
        $rows[]=$row;
    }
    $res->close();
    $mysqli->close();
    return $rows;
}
?>