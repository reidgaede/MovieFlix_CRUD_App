<?php
    /* Using `session_start()` to facilitate - by way of `$_SESSION` superglobal - sharing of "recordNonExistentUpdate-
    Record" variable between "updateRecord.php" and "index.php" to determine whether MovieFlix CRUD user has input valid 
    "Record ID" value in "Enter Record ID" input field in `<form>` element in "index.php" to whom `id` value of "update-
    record-form" has been passed: */
    session_start();

    /* Defining `updateRecord()` function, which connects to "movieFlix_userCreatedDB" database, 
    assigns values obtained from "Update Record" form in "index.php" into variables, and uses values 
    in variables to update specified record in "movieFlix_userCreatedTable" table: */
    function updateRecord(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $databasename = "movieFlix_userCreatedDB";

        /* Attempting connection to "movieFlix_userCreatedDB" database: */
        $conn = mysqli_connect($servername, $username, $password, $databasename);

        /* Verifying attempted connection to "movieFlix_userCreatedDB" database: */
        if(!$conn){
            /* If connection attempt unsuccessful, output "Connection unsuccessful: " with error 
            information concatenated to said string: */
            die("<br>"."Connection unsuccessful: ".mysqli_connect_error());
        }else{
            echo "<br>"."Connection successful.";
        };

        /* Storing user input into "Update Record" form in variables: */
        $movieID = $_POST["update-record-record-id"];
        $movieTitle = $_POST["update-record-movie-title"];
        $movieGenre = $_POST["update-record-movie-genre"];
        $movieDirector = $_POST["update-record-movie-director"];

        /* Structuring/executing SQL `SELECT` query to verify whether value that MovieFlix CRUD user has input into 
        "Enter Record ID" input field in "Update Record" form in "index.php" does correspond to at least one extant 
        "Record ID"/"movie_id" value in "movieFlix_userCreatedTable" table: */
        $sqlRecordIDVerificationQuery = "SELECT * from movieFlix_userCreatedTable WHERE movie_id='$movieID'";
        $recordIDVerificationQuery = mysqli_query($conn, $sqlRecordIDVerificationQuery);
        /* If user-input "Record ID"/"movie_id" value found in "movie_id" column in "movieFlix_userCreatedTable" 
        table, then below invocation of `mysqli_num_rows()` returns value greater than or equal to zero. If, on other 
        hand, user-input "Record ID"/"movie_id" value not found in "movie_id" column in "movieFlix_userCreatedTable" 
        table, then below invocation of `mysqli_num_rows()` returns value less than or equal to zero. */
        $rowCountRecordIDVerification = mysqli_num_rows($recordIDVerificationQuery);
        /* For testing purposes, verifying value of `$rowCountRecordIDVerification` via `echo` statement: */
        echo "<br>".'"movieFlix_userCreatedTable" table contains '.$rowCountRecordIDVerification.' row(s) 
        with values matching specified "Record ID" value.';

        /* If `$rowCountRecordIDVerification` contains value greater than or equal to 1, execute SQL `UPDATE` query as 
        intended: */
        if($rowCountRecordIDVerification >= 1){
            /* Structuring and executing SQL `UPDATE` query: */
            $sqlUpdateQuery = "UPDATE movieFlix_userCreatedTable SET movie_title='$movieTitle', movie_genre='$movieGenre', 
            movie_director='$movieDirector' WHERE movie_id='$movieID'";
            $updateQuery = mysqli_query($conn, $sqlUpdateQuery);

            /* Verifying `UPDATE` query's success: */
            if(!$updateQuery){
                /* If query attempt unsuccessful, `echo`-out "`UPDATE` query unsuccessful: " concatenated 
                to string-structured query stored in `$sqlUpdateQuery`, which itself is then concatenated to  
                error message (if any) outputted from invocation of `mysqli_error()`: */
                echo "<br>"."`UPDATE` query unsuccessful: ".$sqlUpdateQuery.mysqli_error($conn);
            }else{
                echo "<br>"."`UPDATE` query successful.";
            };
            /* Assigning "recordNonExistentUpdateRecord" variable Boolean value of "false" to indicate that MovieFlix CRUD 
            user has input valid "Record ID" value in "Enter Record ID" input field in "Update Record" form linked to 
            "updateRecord.php" (!): */
            $_SESSION["recordNonExistentUpdateRecord"] = false;
        }elseif($rowCountRecordIDVerification <= 0){
            /* Assigning "recordNonExistentUpdateRecord" variable Boolean value of "true" to indicate that MovieFlix CRUD 
            user has input invalid "Record ID" value in "Enter Record ID" input field in "Update Record" form linked to 
            "updateRecord.php" (!): */
            $_SESSION["recordNonExistentUpdateRecord"] = true;
            echo "<br>".'Specified "Record ID" value not found in MySQL table. Returning to "index.php".';
            /* Terminating connection to "movieFlix_userCreatedDB" database: */
            mysqli_close($conn);
            /* Redirecting to MovieFlix front-end to execute JavaScript `alert()` method that requests user input valid 
            value into "Enter Record ID" input field in "Update Record" form in "index.php": */
            header("location: index.php");
        };

        /* Terminating connection to "movieFlix_userCreatedDB" database: */
        mysqli_close($conn);

        /* Redirect user to MovieFlix front-end: */
        header("location: index.php");
    };
    
    /* Invoke `updateRecord()` if "Save" button in "Update Record" form in "index.php" clicked: */
    if(isset($_POST["save-updated-record-button"])){
        updateRecord();
    };
?>