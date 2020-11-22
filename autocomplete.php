<?php
include "sqlHandler.php";

//import the handler
if (isset($_POST["query"])) {
    $value_typed = $_POST["query"];
    $type = $_POST["type"];
   // echo $value_typed;
    if ($type == "actor") {
        //if youre typing in actor set col name as actor name and set table name as Actor
        $colName = "actName";
        $tableName = "Actor";
    } else if ($type == "movie") {
        //if youre typing in Movie set col name as mvTitle name and set table name as Movie
        $colName = "mvTitle";
        $tableName = "Movie";
    } else if ($type == "genre") {
        //if youre typing in Movie set col name as mvGenre name and set table name as Movie
        $colName = "mvGenre";
        $tableName = "Movie";
    }

    if ($type != "genre") {
        //if type is not genre do a a select to get desired results similar to typed input
        $result = SELECT([$colName], $tableName, "${colName} LIKE '%${value_typed}%'");
    } else {
        //otherwise get a unique genre
        $result = EXECUTE("SELECT DISTINCT mvGenre FROM Movie WHERE mvGenre LIKE '%${value_typed}%'");
    }
    //populate output with an unordered list and send that to autocomplete
    $output = '<ul id = "autoComplete" class="list-unstyled">';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<li>' . $row[$colName] . '</li>';
        }
        //otherwise just list not found
    } else {
        $output .= '<li>Not found</li>';
    }
    $output .= '</ul>';
    echo $output;
}