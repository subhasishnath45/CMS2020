<?php 

// This function will be used for redirection to any page.
function Redirect_to($New_Location){
    header("Location:" . $New_Location);
    exit;
}

?>