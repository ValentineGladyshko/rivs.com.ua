<?php
function query_db ($query){
    $mysqli = mysqli_connect("localhost", "root", "", "rivs");
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