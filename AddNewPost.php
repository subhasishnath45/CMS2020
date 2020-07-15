<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
if(isset($_POST['Submit'])){

    $PostTitle = $_POST["PostTitle"];
    $Category = $_POST["Category"];
    // to take files values we can't use $_POST superglobal
    // Instead, we must use $_FILES superglobal.

    $Image = $_FILES["Image"]["name"];

    // We can't save our whole image file inside our database.
    // So, we will save the nsame of our image into our database.
    // And we will save the actual image, somewhere inside our directory.
    $Target = "uploads/" . basename($Image);
    $PostText = $_POST["PostDescription"];

    // Dummy Author for now
    $Admin = "Subhasish";

    // Formatting the time for our project.
    // The date_default_timezone_set() function sets the default timezone used by 
    // all date/time functions in the script.
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    // echo $DateTime;



    // checking whether the form field is empty or not.
    if(empty($PostTitle)){
        // I've created a session variable bellow with an error message.
        $_SESSION["ErrorMessage"] = "Title can't be empty.";
        // calling our Redirect_to function.
        Redirect_to("AddNewPost.php");
        // echo"
        // <script>
        // document.getElementById('title').focus();
        // </script>";
    }elseif(strlen($PostTitle)<5){
        $_SESSION["ErrorMessage"] = "Post Title should be greater than 5 characters.";
        Redirect_to("AddNewPost.php");
    }elseif(strlen($PostText)>999){
        $_SESSION["ErrorMessage"] = "Post Description should be less than 1000 characters.";
        Redirect_to("AddNewPost.php");
    }else{
        //In this block, we will have query to insert data into the database.
        $sql = "INSERT INTO posts(datetime , title ,category ,author ,image , post)";
        // $sql .= "VALUES($Category,$Admin,$DateTime)";
        $sql .= "VALUES(:datetime, :postTitle, :categoryName,:adminName, :imageName,:postDescription )";
        // -> this is a notation for accessing objects in php.
        // In this case, we're accessing the PDO object called prepare().
        $stmp = $ConnectingDB->prepare($sql);
        // Binding the pseudo values to the real values.
        // The order of binding values don't matter.
        $stmp->bindValue(':datetime',$DateTime);
        $stmp->bindValue(':postTitle',$PostTitle);
        $stmp->bindValue(':categoryName',$Category);
        $stmp->bindValue(':adminName',$Admin);
        $stmp->bindValue(':imageName',$Image);
        $stmp->bindValue(':postDescription',$PostText);
        // finally we need to perform the execute().
        $Execute = $stmp->execute();
        // The following line is must to actually upload our image into the uploads folder.
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute){
            $_SESSION["SuccessMessage"] = "Your New POST is Added.";
            Redirect_to("AddNewPost.php");
        }else{
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
            Redirect_to("AddNewPost.php");
        }

    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add new Post</title>
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
                    <li><a href=""><i class="fas fa-user-times text-secondary"></i> LogOut</a></li>
                </ul>
            </div>
        </nav>
    <!--NAVBAR-->
        <header class="bg-secondary text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1><i class="fas fa-edit"></i> Add New Post</h1>
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
                <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
                        <div class="card bg-secondary text-light mb-3">
                            <div class="card-body bg-dark">
                                <div class="form-group">
                                    <label for="title"><span class="FieldInfo">Post Title: </span></label>
                                    <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="">
                                </div>
                                <div class="form-group">
                                    <label for="CategoryTitle"><span class="FieldInfo">Choose category: </span></label>
                                    <select class="form-control" name="Category" id="CategoryTitle">
                                        <option disabled selected>Choose Post Category</option>
                                        <?php 
                                            // Fetching All categories from category table.
                                            // global variable name is only required for php<5.7
                                            global $ConnectingDB;
                                            $sql = "SELECT * FROM category";
                                            
                                            $stmt = $ConnectingDB->query($sql);
                                            while($DataRows = $stmt->fetch()){
                                                // We will take only 2 columns from our table.
                                                // field name of the table are id, title.
                                                $Id = $DataRows["id"];
                                                $CategoryName = $DataRows["title"];
                                        ?>
                                            <option value="<?php echo $CategoryName; ?>"><?php echo $CategoryName; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input class="custom-file-input" type="file" name="Image" id="imageSelect"/>
                                        <label class="custom-file-label" for="imageSelect">
                                            Select Image...
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Post"><span class="FieldInfo">Post: </span></label>
                                    <textarea class="form-control" name="PostDescription" id="Post" cols="30" rows="5"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <a href="dashboard.php" class="btn btn-block btn-warning btn-lg">
                                            <i class="fas fa-arrow-left"></i> back to Dashboard
                                        </a>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <button type="submit" name="Submit" class="btn btn-success btn-block btn-lg">
                                        <i class="fas fa-check"></i> Publish
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