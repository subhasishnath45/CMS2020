<?php 

session_start();


function Errormessage(){
    // Checking if the error message is set or not.
    if(isset($_SESSION["ErrorMessage"])){
        $Output = "<div class=\"alert alert-danger\" id=\"error_alert\">";
        $Output .= htmlentities($_SESSION["ErrorMessage"]);
        $Output .= "</div>";

        // Clear our session.
        // So when we load the page for the first time, no error message will be shown.
        $_SESSION["ErrorMessage"] = null;
        return $Output;
    }
}

function Successmessage(){
    // Checking if the error message is set or not.
    if(isset($_SESSION["SuccessMessage"])){
        $Output = "<div class=\"alert alert-success\" id=\"success_alert\">";
        $Output .= htmlentities($_SESSION["SuccessMessage"]);
        $Output .= "</div>";

        // Clear our session.
        // So when we load the page for the first time, no error message will be shown.
        $_SESSION["SuccessMessage"] = null;
        return $Output;
    }
}


?>