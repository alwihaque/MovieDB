<html>
<!-- Get all the Bootstrap stuff and Font Awesome Logo -->
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body class="paddingAroundForm">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
include "sqlHandler.php";
include "NavBar.php";
displayNavBar();
//Display Nav bar and import handler and navbar
?>

<div class="main-content">
    <h2>Search for Actor to Delete</h2>
    <!-- Display Title-->
    <form method="post" action="deleteActor.php">
    <!-- Get Actor Name -->
        <div class="form-group row">
            <label for="acName" class="col-sm-2 col-form-label">Search Actor:</label>
            <div class="col-sm-10">
                <input type="text" name="actName" class="form-control" id="acName"
                       placeholder="Ryan Reynolds">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-2" value="searchActor">Search</button>
    </form>
    <?php
    $actName = $_POST["actName"];
    $actorID = $_GET["delete"];
    // Run the Delete fntn as defined in SQL Handler
    if ($actorID != "") {
        DELETE("Actor", "actID", $actorID);
    }
    function generateResultTable($result)
    {
      //Generate Table with Actor Name and the Movies He clicked in
      // On clicking Delete you will be greeted with a Modal to delete Actor and the movies he acted in


        echo "<table class=\"table table-hover\">
  <thead>
    <tr>
      <th scope=\"col\">#</th>
      <th scope=\"col\">Actor Name</th>
      <th id='delete-header' scope=\"col\">Delete</th>
    </tr>
  </thead>
  <tbody>";
        $actNum = 1;
        $rowID = "accordion" . $actNum;
        while ($rows = mysqli_fetch_assoc($result)) {
            $actorName = $rows["actName"];
            $actID = $rows["actID"];
            $MoviesForActor = SELECT(["mvTitle"],"Movie","ActID = ${actID}");
            $numMovies = 0;
            $movies = "<ul>";
            while ($mvRow = mysqli_fetch_assoc($MoviesForActor)){
                $movies .= "<li>${mvRow['mvTitle']}</li>";
                $numMovies ++;
            }
            $movies.="</u>";
            $moviePrint = ($numMovies == 1) ? "Movie" : "Movies";

            echo "<tr>
   
      <th scope = \"row\" class='expand-button'>${actNum}</th > 
      <td > ${actorName} &nbsp; <span class='badge badge-danger'> ${numMovies} ${moviePrint}</span></td >
      <td id='delete-icon-container'>
      <button id='delete-button${actNum}' data-toggle='modal' data-target='#actDeleteModal${actNum}'>
     <a><i id='delete-icon' class='fa fa-trash'></i></a></button>
      </td>
      <div class=\"modal fade\" id=\"actDeleteModal${actNum}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"actDeleteModalLabel${actNum}\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"actDeleteModalLabel${actNum}\">Delete Confirmation</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        Are you sure you want to delete ${actorName}? All the following movies with this actor will be deleted: ${movies}
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
        <a href='deleteActor.php?delete=${actID}' class='btn btn-danger'>Delete</a>
      </div>
    </div>
  </div>
</div>
    </tr >";
            $actNum++;
        }
        echo "</tbody>
</table>";
    }


    if ($actName != "") {
        $result = SELECT(["actName", "actID"], "Actor", "actName LIKE '%${actName}%'");
        if (mysqli_num_rows($result) > 0) {
            generateResultTable($result);
        } else {
            echo "Actor ${actName} not found in the database. Maybe you should insert it?";
            echo "<a href= \"insertActor.php\">Click here<a/>";
        }
    }
    ?>


</body>
</html>
