<?php
    /* Using `session_start()` to facilitate access to variables in "updateRecord.php" and "deleteRecord.php" indicating whether 
    MovieFlix CRUD user has input valid "Record ID" value in "Enter Record ID" input field in `<form>` elements linked to each
    respective PHP file: */
    session_start();
?>

<!DOCTYPE html>

<!-- MovieFlix: a CRUD application that allows visitors to create, read, update, and delete records in a database of films. -->

<html>
    <head>
        <!-- Accessing jQuery for use in "script.js": -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <title>MovieFlix CRUD Application</title>
        <!-- Obtaining "Roboto" font: -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Vesper+Libre:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="main-div">
            <h1>MovieFlix CRUD</h1>
            <!-- Connecting to "localhost" server to read records in "movieFlix_userCreatedTable" table within "movieFlix_userCreatedDB" 
            (if said table and database exist on "localhost" server): -->
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
        
                /* Attempting connection to "localhost" server: */
                $connection = mysqli_connect($servername, $username, $password);
        
                /* Verifying attempted connection to "localhost" server: */
                if(!$connection){
                    /* If connection attempt unsuccessful, terminate connection attempt and output 
                    "Connection unsuccessful: " with error information concatenated to said string 
                    (more information on `die()` available from https://www.w3schools.com/php/func_misc_die.asp): */
                    die("<br>"."Connection unsuccessful: ".mysqli_connect_error());
                /* PHP code "`echo`-ing out" connection success commented-out following successful testing; retained for documentation 
                purposes: */
                }; // else{
                        // echo "<br>"."Connection successful.";
                    // };
        
                /* Creating "movieFlix_userCreatedDB" database for use by new, first-time visitors to MovieFlix CRUD if said database not 
                already extant: */
                $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS movieFlix_userCreatedDB";
                $createDBQuery = mysqli_query($connection, $sqlCreateDB);
        
                /* Six lines of comments/code immediately following this comment commented-out following successful testing; retained 
                for documentation purposes: */
                /* Verifying `CREATE DATABASE` query's success: */
                // if($createDBQuery){
                    // echo "<br>"."`CREATE DATABASE` query successful.";
                // }else{
                    // echo "<br>"."`CREATE DATABASE` query unsuccessful: ".mysqli_error($connection);
                // };
        
                /* Creating "movieFlix_userCreatedTable" table for use by new, first-time visitors to MovieFlix CRUD if said table not 
                already extant: */
                $sqlCreateTable = "CREATE TABLE IF NOT EXISTS movieFlix_userCreatedDB.movieFlix_userCreatedTable (
                    movie_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                    movie_title VARCHAR(100) NOT NULL, 
                    movie_genre VARCHAR(100) NOT NULL, 
                    movie_director VARCHAR(100) NOT NULL
                    )";
                $createTableQuery = mysqli_query($connection, $sqlCreateTable);
        
                /* Six lines of comments/code immediately following this comment commented-out following successful testing; retained 
                for documentation purposes: */
                /* Verifying `CREATE TABLE` query's success: */
                // if($createTableQuery){
                    // echo "<br>"."`CREATE TABLE` query successful.";
                // }else{
                    // echo "<br>"."`CREATE TABLE` query unsuccessful: ".mysqli_error($connection);
                // };

                /* Querying "movieFlix_userCreatedTable" table for its contents: */
                $sql = "SELECT * FROM movieFlix_userCreatedDB.movieFlix_userCreatedTable";
                $result = mysqli_query($connection, $sql);
                $rowCount = mysqli_num_rows($result);
                if($rowCount <= 0){
                    echo "<br>".'No movies to show. Click the "Create Record" button to add your favorite films to MovieFlix!'."<br>"."<br>"."<br>";
                    /* Hiding "Update Record", "Delete Record", and "Delete All Records" buttons - and resizing "Create Record" button - if 
                    "movieFlix_userCreatedTable" table is empty: */ ?>
                    <style>
                        #update-record-button, #delete-record-button, #delete-all-records-button {
                            display: none;
                        }

                        #create-record-button {
                            width: 210px;
                            height: 46.875px;
                            border-radius: 10px;
                            border: 1.5px solid black;
                            letter-spacing: 2px;
                            cursor: pointer;
                        }
                    </style>
            <!-- Rendering "column headers" for MovieFlix CRUD "contents" table when exactly one record found in "movieFlix_userCreatedTable" table: -->
            <?php
                }elseif($rowCount == 1){
                    /* Structuring on-page `<table>` element containing single record from "movieFlix_records_table" table: */
                    echo "
                        <table>
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Movie Title</th>
                                    <th>Movie Genre</th>
                                    <th>Movie Director</th>
                                </tr>
                            </thead>
                    ";
                    /* Hiding "Delete All Records" button if "movieFlix_userCreatedTable" table only contains one record: */ ?>
                    <style>
                        #delete-all-records-button {
                            display: none;
                        }
                    </style>
            <!-- Rendering "column headers" for MovieFlix CRUD "contents" table when more than one record found in "movieFlix_userCreatedTable" 
            table: -->
            <?php
                }else{
                    /* Structuring on-page `<table>` element containing records from "movieFlix_records_table" table: */
                    echo "
                        <table>
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Movie Title</th>
                                    <th>Movie Genre</th>
                                    <th>Movie Director</th>
                                </tr>
                            </thead>
                    ";
                };
            ?>
            <?php
                /* Iterating through each record in "movieFlix_records_table" table and outputting contents to MovieFlix front-end as new row in 
                `<table>` element opened on line 130: */
                while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["movie_id"] ?></td>
                        <td><?php echo $row["movie_title"] ?></td>
                        <td><?php echo $row["movie_genre"] ?></td>
                        <td><?php echo $row["movie_director"] ?></td>
                    </tr>
                <!-- Declaring `endwhile` to guard against infinite-loop scenario: -->
                <?php endwhile ?>
                        </table>
            <!-- Structuring forms and buttons: -->
            <button id="create-record-button">Create Record</button>
            <button id="update-record-button">Update Record</button>
            <button id="delete-record-button">Delete Record</button>
            <form action="createRecord.php" method="POST" id="create-record-form">
                <input type="text" placeholder="Enter Movie Title" name="create-record-movie-title" required><br>
                <label for="select-genre-drop-down">Select Movie Genre:</label>
                <select name="create-record-movie-genre" id="select-genre-drop-down" form="create-record-form" required>
                    <!-- Film genres referenced in below `<option>` elements obtained from https://en.wikipedia.org/wiki/Film_genre: -->
                    <option value="Action">
                        Action
                    </option>
                    <option value="Adventure">
                        Adventure
                    </option>
                    <option value="Animated">
                        Animated
                    </option>
                    <option value="Comedy">
                        Comedy
                    </option>
                    <option value="Drama">
                        Drama
                    </option>
                    <option value="Fantasy">
                        Fantasy
                    </option>
                    <option value="Historical">
                        Historical
                    </option>
                    <option value="Horror">
                        Horror
                    </option>
                    <option value="Musical">
                        Musical
                    </option>
                    <option value="Noir">
                        Noir
                    </option>
                    <option value="Romance">
                        Romance
                    </option>
                    <option value="Science Fiction">
                        Science Fiction
                    </option>
                    <option value="Thriller">
                        Thriller
                    </option>
                    <option value="Western">
                        Western
                    </option>
                </select><br>
                <input type="text" placeholder="Enter Movie Director" name="create-record-movie-director" required><br>
                <input type="submit" value="Save" name="save-created-record-button" class="save-button">
            </form>
            <form action="updateRecord.php" method="POST" id="update-record-form">
                <input type="text" placeholder="Enter Record ID" name="update-record-record-id" required><br>
                <input type="text" placeholder="Enter Movie Title" name="update-record-movie-title" required><br>
                <label for="select-genre-drop-down">Select Movie Genre:</label>
                <select name="update-record-movie-genre" id="select-genre-drop-down" form="update-record-form" required>
                    <!-- Film genres referenced in below `<option>` elements obtained from https://en.wikipedia.org/wiki/Film_genre: -->
                    <option value="actionFilm">
                        Action
                    </option>
                    <option value="Adventure">
                        Adventure
                    </option>
                    <option value="Animated">
                        Animated
                    </option>
                    <option value="Comedy">
                        Comedy
                    </option>
                    <option value="Drama">
                        Drama
                    </option>
                    <option value="Fantasy">
                        Fantasy
                    </option>
                    <option value="Historical">
                        Historical
                    </option>
                    <option value="Horror">
                        Horror
                    </option>
                    <option value="Musical">
                        Musical
                    </option>
                    <option value="Noir">
                        Noir
                    </option>
                    <option value="Romance">
                        Romance
                    </option>
                    <option value="Science Fiction">
                        Science Fiction
                    </option>
                    <option value="Thriller">
                        Thriller
                    </option>
                    <option value="Western">
                        Western
                    </option>
                </select><br>
                <input type="text" placeholder="Enter Movie Director" name="update-record-movie-director" required><br>
                <input type="submit" value="Save" name="save-updated-record-button" class="save-button">
            </form>
            <form action="deleteRecord.php" method="POST" id="delete-record-form">
                <input type="text" placeholder="Enter Record ID" name="delete-record-record-id" required><br>
                <input type="submit" value="Save" name="save-deleted-record-button" class="save-button">
            </form>
            <br><br>
            <button id="delete-all-records-button">Delete All Records</button>
        </div>

        <!-- Checking Boolean values of "recordNonExistentDeleteRecord" and "recordNonExistentUpdateRecord" variables - obtained (respectively) 
        from "deleteRecord.php" and "updateRecord.php - which indicate whether MovieFlix CRUD user has entered invalid value in "Enter Movie ID" 
        fields in "Update Record" form or "Delete Record" form. If either variable has value of "true", then JavaScript contained in below 
        `<script>` element - which requests that user enter valid "Record ID" value - executes: -->
        <?php
            if($_SESSION["recordNonExistentDeleteRecord"] == true or $_SESSION["recordNonExistentUpdateRecord"] == true){ ?>
                <script>
                    alert('No record with specified ID found. Please input an integer value found in the "Record ID" column and try again.');
                </script>
        <!-- Regardless of whether or not above `if` statement executes, reassigning "recordNonExistentDeleteRecord" variable and 
        "recordNonExistentUpdateRecord" variable values of "false" to prevent scenario in which above `alert()` invocation executes 
        every time "index.php" is re-loaded following single submission of invalid "Record ID" value in "Update Record" or "Delete Record" 
        form): -->
        <?php
            };
            $_SESSION["recordNonExistentDeleteRecord"] = false;
            $_SESSION["recordNonExistentUpdateRecord"] = false;
        ?>
        <script src="script.js"></script>
    </body>
</html>