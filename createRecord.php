<?php
    /* Defining `createRecord()` function, which connects to "movieFlix_userCreatedDB" database, 
    assigns values obtained from "Create Record" form found on "index.php" into variables, and 
    uses values in variables to create new record in "movieFlix_userCreatedTable" table: */
    function createRecord(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $databasename = "movieFlix_userCreatedDB";

        /* Attempting connection to "movieFlix_userCreatedDB" database: */
        $conn = mysqli_connect($servername, $username, $password, $databasename);

        /* Verifying attempted connection to "movieFlix_userCreatedDB" database: */
        if(!$conn){
            /* If connection attempt unsuccessful, terminate connection attempt and output 
            "Connection unsuccessful: " with error information concatenated to said string: */
            die("<br>"."Connection unsuccessful: ".mysqli_connect_error());
        }else{
            echo "<br>"."Connection successful.";
        };

        /* Storing user input into "Create Record" form in "index.php" in variables: */
        $movieTitle = $_POST["create-record-movie-title"];
        $movieGenre = $_POST["create-record-movie-genre"];
        $movieDirector = $_POST["create-record-movie-director"];

        /* Structuring SQL `INSERT` query: */
        $sqlInsertQuery = "INSERT INTO movieFlix_userCreatedTable (movie_title, movie_genre, movie_director) 
        VALUES ('$movieTitle', '$movieGenre', '$movieDirector')";

        /* Verifying `INSERT` query's success: */
        if(mysqli_query($conn, $sqlInsertQuery)){
            echo "<br>"."`INSERT` query successfully executed.";
        }else{
            /* If query attempt unsuccessful, `echo`-out "`INSERT` query unsuccessful: " concatenated 
            to string-structured query stored in `$sqlInsertQuery`, which itself is then concatenated to  
            error message (if any) outputted from invocation of `mysqli_error()`: */
            echo "<br>"."`INSERT` query unsuccessful: ".$sqlInsertQuery.mysqli_error($conn);
        };

        /* Terminating connection to "movieFlix_userCreatedDB" database: */
        mysqli_close($conn);

        /* Redirect user to MovieFlix front-end: */
        header("location: index.php");
    };

    /* Invoke `createRecord()` if "Save" button in "Create Record" form in "index.php" clicked: */
    if(isset($_POST["save-created-record-button"])){
        createRecord();
    };
?>