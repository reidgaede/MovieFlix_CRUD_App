<?php
    /* Using `session_start()` to facilitate - by way of `$_SESSION` superglobal - sharing of "recordNonExistentDelete-
    Record" variable between "deleteRecord.php" and "index.php" to determine whether MovieFlix CRUD user has input valid 
    "Record ID" value in "Enter Record ID" input field in `<form>` element in "index.php" to whom `id` value of "delete-
    record-form" has been passed: */
    session_start();

    /* Defining `deleteRecord()` function, which connects to "movieFlix_userCreatedDB" database, 
    assigns value obtained from "Delete Record" form into single variable, and uses value in 
    variable to delete specified record from "movieFlix_userCreatedTable" table: */
    function deleteRecord(){
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

        /* Storing user input into "Delete Record" form in "index.php" in `$movieID` variable: */
        $movieID = $_POST["delete-record-record-id"];

        /* Structuring/executing SQL `SELECT` query to verify whether value that MovieFlix CRUD user has input into 
        "Enter Record ID" input field in "Delete Record" form in "index.php" does correspond to at least one extant 
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

        /* If `$rowCountRecordIDVerification` contains value greater than or equal to 1, execute SQL `DELETE` query as 
        intended: */
        if($rowCountRecordIDVerification >= 1){
            /* Structuring and executing SQL `DELETE` query: */
            $sqlDeleteQuery = "DELETE FROM movieFlix_userCreatedTable WHERE movie_id='$movieID'";
            $deleteQuery = mysqli_query($conn, $sqlDeleteQuery);

            /* Verifying `DELETE` query's success: */
            if(!$deleteQuery){
                echo "<br>"."`DELETE` query unsuccessful: ".$sqlDeleteQuery.mysqli_error($conn);
            }else{
                echo "<br>"."`DELETE query successful.";
            };
            /* Assigning "recordNonExistentDeleteRecord" variable Boolean value of "false" to indicate that MovieFlix CRUD 
            user has input valid "Record ID" value in "Enter Record ID" input field in "Delete Record" form linked to 
            "deleteRecord.php" (!): */
            $_SESSION["recordNonExistentDeleteRecord"] = false;
        }elseif($rowCountRecordIDVerification <= 0){
            /* Assigning "recordNonExistentDeleteRecord" variable Boolean value of "true" to indicate that MovieFlix CRUD 
            user has input invalid "Record ID" value in "Enter Record ID" input field in "Delete Record" form linked to 
            "deleteRecord.php" (!): */
            $_SESSION["recordNonExistentDeleteRecord"] = true;
            echo "<br>".'Specified "Record ID" value not found in MySQL table. Returning to "index.php".';
            /* Terminating connection to "movieFlix_userCreatedDB" database: */
            mysqli_close($conn);
            /* Redirecting to MovieFlix front-end to execute JavaScript `alert()` method that requests user input valid 
            value into "Enter Record ID" input field in "Delete Record" form in "index.php": */
            header("location: index.php");
        };

        /* For scenario in which all records in "movieFlix_userCreatedTable" table have been deleted one-by-one via 
        “Delete Record” form, ensuring that if user then adds new record via "Create Record" form on "index.php", auto- 
        incrementation for “Record ID” column "resets", meaning that new "first record" in "movieFlix_userCreatedTable" 
        table will have value of 1 at its intersection with "movie_id"/"Record ID" column: */
        $sqlSelectQuery = "SELECT * FROM movieFlix_userCreatedTable";
        $selectQuery = mysqli_query($conn, $sqlSelectQuery);
        /* Obtaining count of rows in the "movieFlix_userCreatedTable" table to verify whether said table is empty: */
        $rowCount = mysqli_num_rows($selectQuery);
        /* If "movieFlix_userCreatedTable" table contains zero or fewer rows (i.e., is empty), execute `DROP` query 
        effectively deleting "movieFlix_userCreatedTable". When user is redirected from “deleteRecord.php” back to 
        “index.php”, `CREATE TABLE` query automatically executes and effectively re-creates “movieFlix_userCreatedTable” 
        table anew with auto-incrementation reset such that first new record added to table has "Record ID"/"movie_id" 
        value of 1, second new record added to table (granted first new record has not already been deleted) has 
        "Record ID"/"movie_id" value of 2, etc.: */
        if($rowCount <= 0){
            $sqlDropQuery = "DROP TABLE movieFlix_userCreatedTable";
            mysqli_query($conn, $sqlDropQuery);
        };

        /* Terminating connection to "movieFlix_userCreatedDB" database: */
        mysqli_close($conn);

        /* Redirect user to MovieFlix front-end: */
        header("location: index.php");
    };
    
    /* Invoke `deleteRecord()` if "Save" button in "Delete Record" form in "index.php" clicked: */
    if(isset($_POST["save-deleted-record-button"])){
        deleteRecord();
    };
?>