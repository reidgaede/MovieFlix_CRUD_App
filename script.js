/* In this file, defining jQuery that provides for rendering/hiding of "Create Record", "Update Record", and 
"Delete Record" forms in "index.php" on user click. Note that as presently structured, MovieFlix CRUD only 
allows for one such form to be rendered on-page at once (i.e., if one form is presently rendered and user 
clicks button that renders another form, presently-rendered form will be hidden and other form rendered). */

/* Defining variables to effectively control `display` properties for "Create Record", "Update Record", and 
"Delete Record" forms from "index.php" */
let isCreateRecordFormDisplaying = false;
let isUpdateRecordFormDisplaying = false;
let isDeleteRecordFormDisplaying = false;

/* For any click of "Create Record" button in "index.php": */
$("#create-record-button").click( () => {
    console.log("'Create Record' button click detected.");
    /* If "Create Record" form not presently rendered: */
    if(isCreateRecordFormDisplaying == false){
        /* Render "Create Record" form in "index.php": */
        $("#create-record-form").css("display", "block");
        isCreateRecordFormDisplaying = true;
        /* Hide "Update Record" form in "index.php", if presently rendered: */
        $("#update-record-form").css("display", "none");
        isUpdateRecordFormDisplaying = false;
        /* Hide "Delete Record" form in "index.php", if presently rendered: */
        $("#delete-record-form").css("display", "none");
        isDeleteRecordFormDisplaying = false;
        console.log("'Create Record' form displayed. All other forms hidden if previously rendered.")
    }else{
        /* Hide "Create Record" form in "index.php": */
        $("#create-record-form").css("display", "none");
        isCreateRecordFormDisplaying = false;
        console.log("'Create Record' form hidden.")
    };
});

/* For any click of "Update Record" button in "index.php": */
$("#update-record-button").click( () => {
    console.log("'Update Record' button click detected.");
    if(isUpdateRecordFormDisplaying == false){
        /* Render "Update Record" form in "index.php": */
        $("#update-record-form").css("display", "block");
        isUpdateRecordFormDisplaying = true;
        /* Hide "Create Record" form in "index.php", if presently rendered: */
        $("#create-record-form").css("display", "none");
        isCreateRecordFormDisplaying = false;
        /* Hide "Delete Record" form in "index.php", if presently rendered: */
        $("#delete-record-form").css("display", "none");
        isDeleteRecordFormDisplaying = false;
        console.log("'Update Record' form displayed. All other forms hidden if previously rendered.")
    }else{
        /* Hide "Update Record" form in "index.php" on user click: */
        $("#update-record-form").css("display", "none");
        isUpdateRecordFormDisplaying = false;
        console.log("'Update Record' form hidden.")
    };
});

/* For any click of "Delete Record" button in "index.php": */
$("#delete-record-button").click( () => {
    console.log("'Delete Record' button click detected.");
    if(isDeleteRecordFormDisplaying == false){
        /* Render "Delete Record" form in "index.php": */
        $("#delete-record-form").css("display", "block");
        isDeleteRecordFormDisplaying = true;
        /* Hide the "Create Record" form in "index.php", if presently rendered: */
        $("#create-record-form").css("display", "none");
        isCreateRecordFormDisplaying = false;
        /* Hide the "Update Record" form in "index.php", if presently rendered: */
        $("#update-record-form").css("display", "none");
        isUpdateRecordFormDisplaying = false;
        console.log("'Delete Record' form displayed. All other forms hidden if previously rendered.")
    }else{
        /* Hide "Delete Record" form in "index.php" on user click: */
        $("#delete-record-form").css("display", "none");
        isDeleteRecordFormDisplaying = false;
        console.log("'Delete Record' form hidden.")
    };
});

/* For any click of "Delete All Records" button in "index.php": */
$("#delete-all-records-button").click( () => {
    console.log('"Delete All Records" button click detected. Awaiting final user input.');
    /* Execute `confirm()` method and store user input in `deleteAllRecordsYes` variable: */
    let deleteAllRecordsYes = confirm('Are you sure you want to delete all records? If so, click "OK".');
    /* If MovieFlix CRUD user clicks "OK" in window generated by above `confirm()` invocation: */
    if(deleteAllRecordsYes == true){
        console.log("Total deletion request confirmed. All records deleted.");
        /* Redirect to "deleteAllRecord.php", which contains code to drop "movieFlix_userCreatedTable" table: */
        function deleteAllRecords(){
            location.href = "deleteAllRecords.php";
        };
        deleteAllRecords();
    }else{
        console.log("Request for deletion of all records cancelled.");
    };
});