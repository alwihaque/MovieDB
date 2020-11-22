<html>
<head>
<!-- Once again all the bootstrap elements are imported -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src = "toggle.js"></script>

<?php
//importing the handler to run all the necessary sql commands
include "sqlHandler.php";
// importing and displaying the nav bar
include "NavBar.php";
displayNavBar();
?>
<div class="main-content">
<!-- Displaying the Title -->
<h2>Add a Movie To Our Database</h2>
<!-- Sending everything by post to hide insert results from easy viewing -->
    <form method="post">
    <!-- Movie Title search filled. Styled with Bootstrap. Auto complete turned off to allow my Drop down to work -->
        <div class="form-group row">
            <label for="mvTitle" class="col-sm-2 col-form-label">Movie Title:</label>
            <div class="col-sm-10">
                <input type="text" name="mvTitle" class="form-control" id="entryMovie"
                       placeholder="Enter the Name of the Movie" autocomplete="off" required>
                <div id="autocompleteListMovie"></div>
            </div>
        </div>
        <div>
            <div class="form-group row">
                <label for="mvPrice" class="col-sm-2 col-form-label">Movie Price:</label>
                <!-- Movie Price search filled. Styled with Bootstrap.-->
                <div class="col-sm-10">
                    <input type="number" min=0.00 step="0.01" name="mvPrice" class="form-control" id="mvPrice"
                           placeholder="Enter Movie Price" required>
                </div>

            </div>
            <div class="form-group row">
                <label for="actName" class="col-sm-2 col-form-label">Actor Name:</label>
                <!-- actName search filled. Styled with Bootstrap.-->
                <div class="col-sm-10">
                    <input type="text" name="actName" class="form-control" id="entryActor"
                           placeholder="Enter Actor Name" autocomplete="off" required>
                    <div id="autocompleteListActor"></div>
                </div>

            </div>
            <div class="form-group row">
                <label for="mvYear" class="col-sm-2 col-form-label">Movie Year:</label>
                <!-- Movie Year search filled. Styled with Bootstrap.-->
                <div class="col-sm-10">
                    <input type="number" min="1900" max="2023" name="mvYear" class="form-control" id="mvYear"
                           placeholder="Enter Movie Year">
                </div>
            </div>
            <div class="form-group row">
                <label for="mvGenre" class="col-sm-2 col-form-label">Movie Genre:</label>
                <!-- Movie Genre search filled. Styled with Bootstrap.-->
                <div class="col-sm-10">
                    <input type="text" name="mvGenre" class="form-control" id="entryGenre"
                           placeholder="Enter Movie Genre" autocomplete="off">
                    <div id="autocompleteListGenre"></div>
                </div>

            </div>
            <div class="form-group row">
                <label for="mvNumScenes" class="col-sm-2 col-form-label">Scenes in Movie:</label>
                <!-- Movie Num Scenes search filled. Styled with Bootstrap.-->
                <div class="col-sm-10">
                    <input type="number" min="0" name="mvNumScenes" class="form-control" id="mvNumScenes"
                           placeholder="Enter Number of Scenes in Movie">
                </div>

            </div>

        </div>
        <div class="form-group row">
            <div class="col-sm-10">
            <!-- Submit Button !-->
                <button type="submit" class="btn btn-primary">Insert</button>
            </div>
        </div>
    </form>

<?php
$movieName = $_POST["mvTitle"];
$actorName = $_POST["actName"];
$mvPrice = $_POST["mvPrice"];
$mvYear = $_POST["mvYear"];
$mvGenre = $_POST["mvGenre"];
$mvNumScenes = $_POST["mvNumScenes"];
//Setting up variables with the Post results
//Getting the actId from Actname
//$setupSql = "SELECT actID FROM Actor WHERE actName = " . $actorName;
if ($actorName != "") {
    $result = SELECT(["actID"], "Actor", "actName = '${actorName}'");
}

if (mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
        $actID = $rows["actID"];
    }
} 
//Otherwise putting the actor into the Actor Table before proceeding
else {
    if ($actorName != "") {
        $actID = INSERT("Actor", ["actName"], [$actorName]);
    }
}
//Putting the Movie in
if ($movieName != "") {
    $id = INSERT("Movie", ["actID", "mvTitle", "mvPrice", "mvYear", "mvGenre", "mvNumScenes"], [$actID, $movieName, $mvPrice, $mvYear, $mvGenre, $mvNumScenes]);
    if ($id) {
        echo '<div class="alert alert-success" role="alert"> Movie inserted successfully</div>';
    } 
    //Otherwise giving an error. Which is also styled using Bootstrap
    else {
        echo "<div class=\"alert alert-danger\" role=\"alert\"> Something went wrong! Please check your values and try again.</div>";
    }
}
//$insertIntoSQL = "INSERT INTO Movie (actID, mvTitle,mvPrice,mvYear,mvGenre,mvNumScenes) VALUES (" . $actID . "," . $movieName . "," . $mvPrice . ",". $mvYear . "," .$mvGenre . "," .$mvNumScenes.")";


?>
</div>
