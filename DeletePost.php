<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
// Getting the query variable named id passed through URL.
    $SearchQueryParameter = $_GET['id'];
    //Fetching Existing content from our Database.
    global $ConnectingDB;
    // Getting the Query parameter variable named id.
    // Now ruuning our SQL query.
    $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
    // making a query to our posts table in the database.
    $stmp = $ConnectingDB->query($sql);
    // Checking if there is a record for our id.
    while($DataRows = $stmp->fetch()){
        $TitleToBeDeleted = $DataRows['title'];
        $CategoryToBeDeleted = $DataRows['category'];
        $ImageToBeDeleted = $DataRows['image'];
        $PostToBeDeleted = $DataRows['post'];
    }
?>
<?php 
// When the Delete button is pressed.
if(isset($_POST['Submit'])){

        $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";

        $Execute = $ConnectingDB->query($sql);
        // if deletion is successful.
        if($Execute){
            // Deleting the Image from hard drive.
            // Getting the image path and the image name 
            // In early php versions:
            //$Target_Path_To_DELETE_Image = "uploads/{$ImageToBeDeleted}";
            $Target_Path_To_DELETE_Image = "uploads/$ImageToBeDeleted";
            // The unlink() function is an inbuilt function in PHP which is used to delete a file.
            // filename with Path : Required argument . Specifies the path to the file to delete
            unlink($Target_Path_To_DELETE_Image);
            $_SESSION["SuccessMessage"] = "Your POST is Deleted Successfully.";
            Redirect_to("Posts.php");
        }else{ // if deletion is not successful.
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
            Redirect_to("Posts.php");
        }

    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Post</title>
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
    <!--NAVBAR-->
        <div style="height:5px; background:#ff0000;"></div>
        <nav class="navbar navbar-expand-lg navbar-light navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Your Blog</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto ml-auto">
                    <li class="nav-item">
                        <a href="MyProfile.php" class="nav-link"><i class="far fa-user"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">DashBoard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li><a href="#"><i class="fas fa-user-times text-secondary"></i> LogOut</a></li>
                </ul>
            </div>
        </nav>
    <!--NAVBAR-->
        <header class="bg-secondary text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1><i class="fas fa-edit"></i> Delete Your Post</h1>
                    </div>
                </div>
            </div>
        </header>

        <!--MAIN AREA-->
        <section class="container py-2 mb-4">
            <div class="row">
                <div class="offset-lg-1 col-lg-10 category-content-wrapper d-flex flex-column justify-content-center align-items-center">
                    <?php 
                        echo Errormessage(); 
                        echo Successmessage();
                    ?>
                    <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                        <div class="card bg-secondary text-light mb-3">
                            <div class="card-body bg-dark">
                                <div class="form-group">
                                    <label for="title"><span class="FieldInfo">Post Title: </span></label>
                                    <input class="form-control disabled" disabled="true" type="text" name="PostTitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeDeleted; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="CategoryTitle"><span class="FieldInfo">Post category: </span></label>
                                    <select class="form-control" disabled="true" name="Category" id="CategoryTitle">
                                        <option disabled selected><?php echo $CategoryToBeDeleted; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <span class="FieldInfo">Existing Image: </span><br/>
                                    <img src="uploads/<?php echo $ImageToBeDeleted; ?>" alt="" width="300px" class="mb-3"/>
                                    <br/>
                                </div>
                                <div class="form-group">
                                    <label for="Post"><span class="FieldInfo">Post: </span></label>
                                    <textarea class="form-control" disabled="true" name="PostDescription" id="Post" cols="30" rows="5">
                                        <?php echo $PostToBeDeleted; ?>
                                    </textarea>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <a href="dashboard.php" class="btn btn-block btn-warning btn-lg">
                                            <i class="fas fa-arrow-left"></i> back to Dashboard
                                        </a>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <button type="submit" name="Submit" class="btn btn-danger btn-block btn-lg">
                                        <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </section>
        <!--MAIN AREA-->

    <!--FOOTER-->
        <footer class="bg-dark text-white">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="lead text-center small">Theme By Subhasish&trade; | &copy; <span id="copyright-year"></span> | All Rights are Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    <!--FOOTER-->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/b1a47ddc93.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('copyright-year').innerHTML = new Date().getFullYear();
        // function to hide the success or error mesages after certain time.
        function hideMessage() {
            var error_msg = document.getElementById("error_alert");
            var success_msg = document.getElementById("success_alert");
            if(typeof(error_msg) != 'undefined' && error_msg != null){

                error_msg.style.display = "none";

            }
            if(typeof(success_msg) != 'undefined' && success_msg != null){

                success_msg.style.display = "none";

            }
        };
        setTimeout(hideMessage, 3000);

    </script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'PostDescription' );
    </script>
</body>
</html>