<html>
<head>
<!-- Getting all the bootstrap things !-->
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

<?php
//Importing the SQL Handler
include "sqlHandler.php";
include "NavBar.php";
//Displaying Nav bar
displayNavBar();


?>
<div class="main-content">
<h2>Add Actor to Database</h2>
<!-- Displaying Title !-->
<form method="post" action="insertActor.php">
    <div class="form-group row">
        <label for="acName" class="col-sm-2 col-form-label">Add actor:</label>
        <!-- Text input for Actor -->
        <div class="col-sm-10">
            <input type="text" name="actName" class="form-control" id="acName"
                   placeholder="Ryan Reynolds">
        </div>

    </div>

    <button type="submit" class="btn btn-primary mb-2" value="Insert Actor">Add Actor</button>
    <!-- Form submit button -->
</form>
    <?php
    $actName = $_POST["actName"];
//If actName is not null try to insert. If you find it return an error.
    if ($actName != "") {

        $id = INSERT("Actor", ["actName"], [$actName]);
        if ($id) {
            echo '<div class="alert alert-success" role="alert"> Actor inserted successfully</div>';
        } else {
            echo "<div class=\"alert alert-danger\" role=\"alert\"> Actor ${actName} already exists!</div>";
        }
    }
    ?>
</div>
</body>
</html>