<html>
<head>
<!-- importing necessary bootstrap and jquery stuff -->
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
//Displaying nav bar
//Getting everything by post

$mvTitle = $_POST["mvTitle"];
$mvPrice = $_POST["mvPrice"] != "" ? $_POST["mvPrice"] : $_GET["mvPrice"];
$actName = $_POST["actName"] != "" ? $_POST["actName"] : $_GET["actName"];;
$mvYear = $_POST["mvYear"] != "" ? $_POST["mvYear"] : $_GET["mvYear"];
$mvGenre = $_POST["mvGenre"] != "" ? $_POST["mvGenre"] : $_GET["mvGenre"];;
$mvNumScenes = $_POST["mvNumScenes"] != "" ? $_POST["mvNumScenes"] : $_GET["mvNumScenes"];;
$radioSelected = $_POST["switch"];
$mvIDToDelete = $_GET["delete"];
if ($mvIDToDelete != "") {
    DELETE("Movie", "mvID", $mvIDToDelete);
}

//Building query depending on what we got from index.php
function buildQueryCondition()
{
    global $mvTitle, $mvPrice, $mvYear, $mvGenre, $mvNumScenes, $radioSelected, $actorID;
    $parts = [];
    if ($mvPrice != "") {
        $price_part = " mvPrice = ${mvPrice} ";
        array_push($parts, $price_part);
    }
    if ($actorID != "") {
        $actName_part = " actID = ${actorID} ";
        array_push($parts, $actName_part);
    }
    if ($mvYear != "") {

      if ($yearOption == "on") {
          $year_part = " mvYear = ${mvYear} ";
      } else if ($yearOption == "before") {
          $year_part = " mvYear < ${mvYear} ";
      } else {
          $year_part = " mvYear > ${mvYear} ";
      }
      array_push($parts, $year_part);

  }
    if ($mvGenre != "") {
        $genre_part = " mvGenre = '${mvGenre}' ";
        array_push($parts, $genre_part);
    }
    if ($mvNumScenes != "") {
        $numScene_part = " mvNumScenes = ${mvNumScenes} ";
        array_push($parts, $numScene_part);
    }
    if ($mvTitle != "") {
        $title_part = " mvTitle LIKE '%${mvTitle}%'";
        array_push($parts, $title_part);
    }
    $query = "";
    for ($i = 0; $i < count($parts); $i++) {
        if ($i != count($parts) - 1) {
            $query .= $parts[$i];
            $query .= $radioSelected;
        } else {
            $query .= $parts[$i];
        }

    }

    return $query;


}

//Generate the Table of results of Movies that the query found

function generateResultTable($result, $title)
{
    echo "<div class='main-content'>";

        echo "<h2>${title}</h2>";


    echo "<table class=\"table table-hover\">
  <thead>
    <tr>
      <th scope=\"col\">#</th>
      <th scope=\"col\">Movie Title</th>
      <th scope=\"col\">Year</th>
      <th scope=\"col\">Lead Actor</th>
      <th scope=\"col\">Genre</th>
      <th scope=\"col\">Price</th>
      <th scope=\"col\">Number of Scenes</th>
      <th scope=\"col\">Delete</th>
    </tr>
  </thead>
  <tbody>";
    $movieNum = 1;
    while ($rows = mysqli_fetch_assoc($result)) {
        $mvId = $rows["mvID"];
        $actID = $rows["actID"];
        $mvTitle = $rows["mvTitle"];
        $mvPrice = $rows["mvPrice"];
        $mvYear = $rows["mvYear"];
        $mvGenre = $rows["mvGenre"];
        $mvNumScenes = $rows["NumScenes"];
        $actorName = "";

        $actorLookupResult = SELECT(["actName"], "Actor", "actID = ${actID}");
        $actRows = mysqli_fetch_assoc($actorLookupResult);
        $actorName = $actRows["actName"];
        echo "<tr>
      <th scope = \"row\" >${movieNum}</th >
      <td > ${mvTitle}</td >
      <td > <a href='searchMovie.php?mvYear=${mvYear}'>${mvYear}</a></td >
      <td > <a href='searchMovie.php?actName=${actorName}'>${actorName}</a></td >
      <td > <a href='searchMovie.php?mvGenre=${mvGenre}'>${mvGenre}</a></td >
      <td > <a href='searchMovie.php?mvPrice=${mvPrice}'>${mvPrice}</a></td >
      <td > <a href='searchMovie.php?mvNumScenes=${mvNumScenes}'>${mvNumScenes}</a></td >
      <td id='delete-icon-container'>
      <button id='delete-button${movieNum}' data-toggle='modal' data-target='#exampleModal${movieNum}'>
     <a><i id='delete-icon' class='fa fa-trash'></i></a></button>
      </td>
      <div class=\"modal fade\" id=\"exampleModal${movieNum}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel${movieNum}\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel${movieNum}\">Delete Confirmation</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        Are you sure you want to delete ${mvTitle} ?
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
        <a href='searchMovie.php?delete=${mvId}' class='btn btn-danger'>Delete</a>
      </div>
    </div>
  </div>
</div>
    </tr >";
        $movieNum++;
    }
    echo "</tbody>
</table></div>";
}

if (strlen($actName) > 0) {
    $actorIDLookupResult = SELECT(["actID"], "Actor", "actName LIKE '%${actName}%'");
    $actorID = mysqli_fetch_assoc($actorIDLookupResult)["actID"];
}

$whereCondition = buildQueryCondition();

//$query_condition = "mvTitle LIKE '%'${mvTitle}'%' ${radioSelected}";
//echo $query_condition . "<br/>";
$result = SELECT(["*"], "Movie", $whereCondition);
if (mysqli_num_rows($result) > 0) {
    $title = ($mvIDToDelete != "") ? "Movies Currently in the Database:" : "Movies matching your search criteria:";
    generateResultTable($result,$title);
} else {
    echo "Movie ${mvTitle} not found in the database. Maybe you should insert that into our database?";
    echo "<a href= \"index.php\">Click here to go to homepage<a/>";
}


?>
</body>
</html>
