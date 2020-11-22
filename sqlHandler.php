<?php
//MySQL particulars to connect to MYSQL database
$host = "mysql.cs.nott.ac.uk";
$username = "psyah7";
$password = "newpassword";
$databaseName = 'psyah7';
$port = 3306;
//try to connect

$connection = mysqli_connect($host, $username, $password, $databaseName, $port);
//If it doesn't work print an error
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
// A function that handles Inserting where it first appends col names after INSERT INTO followed by comma

function INSERT($tableName, $colNames, $values)
{
    $query = "INSERT INTO " . $tableName . " (";

    foreach ($colNames as &$col) {
        $query .= $col;
        if ($colNames[count($colNames) - 1] != $col) {
            $query .= ", ";
        }
    }
    //Inserts values one by one
    $query .= ") VALUES ( ";
    for ($i = 0; $i < count($values); $i++) {
        if (strlen($values[$i]) > 0) {
            $query .= "'" . $values[$i] . "'";
        } else {
            $query .= "NULL";
        }
        if ($i != count($values) - 1) {
            $query .= ", ";
        }
    }
    $query .= ")";
    //$insertIntoSQL = "INSERT INTO " .$tableName. "(actID, mvTitle,mvPrice,mvYear,mvGenre,mvNumScenes) VALUES (" . $actID . "," . $movieName . "," . $mvPrice . ",". $mvYear . "," .$mvGenre . "," .$mvNumScenes.")";
    global $connection;
    if (mysqli_query($connection, $query)) {
        //echo "New record created successfully";
        return $connection->insert_id;
    }
//Runs query
}
//Same thing done for select
function SELECT($colNames, $tableName, $WHERECondition = "")
{
    $query = "SELECT ";
    foreach ($colNames as &$col) {
        $query .= $col;
        if ($colNames[count($colNames) - 1] != $col) {
            $query .= ", ";
        }
    }
    $query .= " FROM " . $tableName;
    if ($WHERECondition != "") {
        $query .= " WHERE " . $WHERECondition;
    }
    //echo "attempting to do a SELECT on the db:   QUERY => " . $query . " <br>";
    global $connection;

    return $connection->query($query);
}
// function to execute a query
function EXECUTE($query)
{
    global $connection;
    return $connection->query($query);
}
//Deleting something

function DELETE($tableName, $idColumn, $idValue)
{
    global $connection;
    $query = "DELETE FROM ${tableName} WHERE ${idColumn} = ${idValue}";
    $connection->query($query);
}


//INSERT("Movie", ["actID", "mvTitle", "mvPrice", "mvYear", "mvGenre", "mvNumScenes"], [5, "Interstellar", 12.99, 2015, "SciFi", ""]);

?>
