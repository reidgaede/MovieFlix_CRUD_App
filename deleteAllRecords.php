<?php
    /* Defining `deleteAllRecords()` function, which connects to "movieFlix_userCreatedDB" database and executes 
    `DROP TABLE` MySQL query before re-directing user back to "index.php": */
    function deleteAllRecords(){
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

        /* Structuring and executing SQL `DROP TABLE` query: */
        $sqlDropQuery = "DROP TABLE movieFlix_userCreatedTable";
        mysqli_query($conn, $sqlDropQuery);

        /* Terminating connection to "movieFlix_userCreatedDB" database: */
        mysqli_close($conn);

        /* Redirect user to MovieFlix front-end: */
        header("location: index.php");
    };

    /* Invoking `deleteAllRecords()` function: */
    deleteAllRecords();
?>