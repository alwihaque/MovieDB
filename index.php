<html>
<!-- Authored by Alwi Haque Student ID: 20214649 -->
<!-- Detailed Analysis of all features in report -->

<head>
<!-- Importing Bootsrap and relevant style sheets to bootstrap. Please take a look at https://getbootstrap.com/docs/4.3/getting-started/download/ for more info.-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<!-- More imports relating to bootstrap. Plase refer to the website to see exactly how Bootstrap works-->
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
<script src="toggle.js"></script>

<?php
//Importing the Nav Bar. Similar to how a navigation tab would behave in an usual website.
include "NavBar.php";
//Displaying that nav bar. Individual comments regarding the nav bar can be found in the navbar.php file
displayNavBar();
?>
<div class="main-content">
<!-- A bootstrap class. Main-content basically seperates out the central topic of the page from other pages -->
<h2>Search Movie (Deletion will follow)</h2>
<!-- Displaying the Title -->
    <form method="post" action="searchMovie.php">
    <!-- Everything is sent by the post methods. Otherwise URL will get super long -->
        <div class="form-group row">
        <!-- mvTitle with bootstrap stuff to make it look nice  Autocomplete list is turned off to allow my Autocomplete to work properly-->
            <label for="mvTitle" class="col-sm-2 col-form-label">Movie Title:</label>
            <div class="col-sm-10">
                <input type="text" name="mvTitle" class="form-control" id="entryMovie"
                       placeholder="Enter the Name of the Movie" autocomplete="off">
                <div id="autocompleteListMovie"></div>
            </div>
        </div>
        <!--  Basically a div that is handled by JS on the press of a button-->
        <div id="advancedSearch">
            <div class="form-group row">
            <!-- mvPrice Text field. Styled with bootstrap-->
                <label for="mvPrice" class="col-sm-2 col-form-label">Movie Price:</label>
                <div class="col-sm-10">
                    <input type="number" min=0.00 step="0.01" name="mvPrice" class="form-control" id=""mvPrice"
                           placeholder="Enter Movie Price">
                </div>

            </div>
            <div class="form-group row">
             <!-- actName Text field. Styled with bootstrap-->
                <label for="actName" class="col-sm-2 col-form-label">Actor Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="actName" class="form-control" id="entryActor"
                           placeholder="Enter Actor Name" autocomplete="off">
                    <div id="autocompleteListActor"></div>
                </div>

            </div>
            <div class="form-group row">
            <!-- mvYear Text field. Styled with bootstrap-->
                <label for="mvYear" class="col-sm-2 col-form-label">Movie Year:</label>
                <div class="col-sm-10">
                    <input type="number" min="1900" max="2023" name="mvYear" class="form-control" id="mvYear"
                           placeholder="Enter Movie Year">
                </div>
                
                

            </div>
            <fieldset class="form-group">
            <!-- Radio Button Allowing you to choose between exact, < or > year -->
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Date Option</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="yearOption" id="yearOptionOn" value="on" checked>
                            <label class="form-check-label" for="yearOption">
                                ON
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="yearOption" id="yearOptionBefore" value="before">
                            <label class="form-check-label" for="yearOptionBefore">
                                BEFORE
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="yearOption" id="yearOptionAfter" value="after">
                            <label class="form-check-label" for="yearOptionAfter">
                                AFTER
                            </label>
                        </div>

                    </div>
                </div>
            </fieldset>
            <div class="form-group row">
            <!-- mvGenre Text field. Styled with bootstrap-->
                <label for="mvGenre" class="col-sm-2 col-form-label">Movie Genre:</label>
                <div class="col-sm-10">
                    <input type="text" name="mvGenre" class="form-control" id="entryGenre"
                           placeholder="Enter Movie Genre" autocomplete="off">
                    <div id="autocompleteListGenre"></div>
                </div>

            </div>
            <div class="form-group row">
            <!-- mvNumScene Text field. Styled with bootstrap-->
                <label for="mvNumScenes" class="col-sm-2 col-form-label">Scenes in Movie:</label>
                <div class="col-sm-10">
                    <input type="number" min="0" name="mvNumScenes" class="form-control" id="mvNumScenes"
                           placeholder="Enter Number of Scenes in Movie">
                </div>

            </div>

            <fieldset class="form-group">
                <div class="row">
                
                    <legend class="col-form-label col-sm-2 pt-0">Search Option</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                        <!-- Radio Button to Handle Logical AND -->
                            <input class="form-check-input" type="radio" name="switch" id="gridRadios1" value="AND" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Combine Fields When Searching
                            </label>
                        </div>
                        <div class="form-check">
                        <!-- Radio Button to Handle Logical OR -->
                            <input class="form-check-input" type="radio" name="switch" id="gridRadios2" value="OR">
                            <label class="form-check-label" for="gridRadios2">
                                Match With Any One field
                            </label>
                        </div>

                    </div>
                </div>
            </fieldset>

        </div>
        <div class="form-group row">
            <div class="col-sm-10">
            <!-- Button that calls the js function to toggle -->
                <button type="button" class="btn btn-secondary" onclick="toggle()">Advanced Search</button>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <!-- Required only done for fields in DB that could not be bull -->

</div>
</body>
</html>