<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<!--php code for comment section-->
<?php 

$SearchQueryParameter = $_GET["id"];

?>
<?php 
    // This if block should be placed at the very top ogf the page
    if(isset($_POST['Submit'])){
    // getting all of our form fields.
    $CommenterName = $_POST["CommenterName"];
    $CommenterEmail = $_POST["CommenterEmail"];
    $CommenterThoughts = $_POST["CommenterThoughts"];


    // Formatting the time for our project.
    // The date_default_timezone_set() function sets the default timezone used by 
    // all date/time functions in the script.
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    // echo $DateTime;



    // checking whether the form fields are empty or not.
    if(empty($CommenterName) || empty($CommenterEmail) || empty($CommenterThoughts)){
        // I've created a session variable bellow with an error message.
        $_SESSION["ErrorMessage"] = "All fields must be filled out.";
        // calling our Redirect_to function.
        // As we can't access to the FullPost.php page directly,
        // Therefore, we must pass the query parameter variable value
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
    }elseif(strlen($CommenterThoughts)>500){
        $_SESSION["ErrorMessage"] = "Comment length should be less than 500 characters.";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
    }else{
        //In this block, we will have query to insert data into the database.
        // The order of insertion must be same as in our database.
        $sql = "INSERT INTO comments(datetime, name, email, comment, approvedby, status, post_id)";
        // last 2 are default values for approvedby and status columns.
        $sql .= "VALUES(:datetime, :name,:email,:comment, 'Pending', 'OFF',:postidfromurl)";
        // -> this is a notation for accessing objects in php.
        // In this case, we're accessing the PDO object called prepare().
        $stmp = $ConnectingDB->prepare($sql);
        // Binding the pseudo values to the real values.
        // The order of binding values don't matter.
        $stmp->bindValue(':datetime',$DateTime);
        $stmp->bindValue(':name',$CommenterName);
        $stmp->bindValue(':email',$CommenterEmail);
        $stmp->bindValue(':comment',$CommenterThoughts);
        $stmp->bindValue(':postidfromurl',$SearchQueryParameter);
        // finally we need to perform the execute().
        $Execute = $stmp->execute();

        if($Execute){
            $_SESSION["SuccessMessage"] = "Your comment is Added.";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
        }else{
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
        }

    }


    }
?>
<!--php code for comment section-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog Page</title>
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
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <form action="Blog.php" method="get" class="form-inline d-none d-sm-block">
                        <div class="form-group">
                            <input type="text" class="form-control" name="Search" placeholder="Search Here" value=""/>
                            <button class="btn btn-primary ml-2" name="SearchButton">Search</button>
                        </div>
                    </form>
                </ul>
            </div>
        </nav>
    <!--NAVBAR-->
        <!-- <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><i class="fas fa-text-height"></i> Basic</h1>
                    </div>
                </div>
            </div>
        </header> -->


        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mt-4">
                    <?php 
                        echo Errormessage(); 
                        echo Successmessage();
                    ?>
                </div>
                <!--main area starts-->
                <div class="col-sm-8">
                    <h1>Your Blog Posts</h1>
                    <h1 class="lead">Created By CAD CENTRE STUDENTS in 2020</h1>

                    <?php 
                    global $ConnectingDB;

                        // getting the id query variable value passed through URL.
                        $PostIdFromURL = $_GET["id"];
                        // The following if block will make sure that
                        // No visitor can directly go to FullPost.php page.
                        if(!isset($PostIdFromURL)){
                            $_SESSION["ErrorMessage"] = "Bad Request!";
                            Redirect_to("Blog.php");
                        }
                        // Doing to prevent SQL injection.
                        // SQL statements with named parameters
                        $sql = "SELECT * FROM posts 
                        WHERE id='$PostIdFromURL'";

                        $stmt = $ConnectingDB->query($sql);
                       
                        
                        while($DataRows = $stmt->fetch()){
                            $PostId = $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $PostTitle = $DataRows["title"];
                            $Category = $DataRows["category"];
                            $Admin = $DataRows["author"];
                            $Image = $DataRows["image"];
                            $PostDescription = $DataRows["post"];
                    ?>

<div class="blog-container">
  
  <div class="blog-header">
    <div class="blog-cover" style="background:url('uploads/<?php echo $Image; ?>');">
      <div class="blog-author">
        <h3><?php echo $Admin; ?></h3>
      </div>
    </div>
  </div>

  <div class="blog-body">
    <div class="blog-title">
      <h1><a href="#"><?php echo $PostTitle; ?></a></h1>
    </div>
    <div class="blog-summary">
      <?php 
        echo html_entity_decode($PostDescription);
      ?>
    </div>
    <div class="blog-tags">
      <ul>
        <li><a href="#"><?php echo $Category; ?></a></li>
      </ul>
    </div>
  </div>
  
  <div class="blog-footer">
    <ul>
      <li class="published-date"><?php echo $DateTime; ?></li>
      <!-- <li class="comments"><a href="#"><svg class="icon-bubble"><use xlink:href="#icon-bubble"></use></svg><span class="numero">4</span></a></li>
      <li class="shares"><a href="#"><svg class="icon-star"><use xlink:href="#icon-star"></use></svg><span class="numero">1</span></a></li> -->
    </ul>
  </div>

</div>
                    
    <?php
        }
    ?>

    <!-- Fetching comments starts -->
        <div class="alert alert-info">
            <span class="field-info">
                    Comments
            </span>
        </div>
    <?php 
        global $ConnectingDB;
        // getting all of the comments of the current post.
        // $sql = "SELECT * FROM comments WHERE post_id='$SearchQueryParameter'";
        
        // Getting all of the comments of the current post, only if those are approved.
        // or status field value is ON.
        $sql = "SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
        $stmt = $ConnectingDB->query($sql);
        // Loop through all of our existing comments.
        while($DataRows = $stmt->fetch()){
            $Comment = $DataRows["comment"];
            $CommenterName = $DataRows["name"];
            $CommentDate = $DataRows["datetime"];
    ?>


            <div class="media mb-2">
                <div class="media-body ml-2">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between">
                                <img src="images/comment.png" class="rounded-circle" width="50" />
                                <h6 class="lead text-uppercase"><?php echo $CommenterName; ?></h6>
                                <p class="small mb-0 ">
                                    <?php echo $CommentDate; ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <p>
                                <?php echo $Comment; ?>
                                </p>
                            </div>
                    </div>

                </div>
            </div>

    <?php
        }
    ?>

    <!-- Fetching comments ends -->

    <!--comment part starts-->

        <form action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" class="mt-5">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="FieldInfo">Share your thoughts about this post</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="text" name="CommenterName" placeholder="Name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" name="CommenterEmail" placeholder="Email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                    <label for="comment">Comment:</label>
                        <div class="input-group">
                            <textarea name="CommenterThoughts" class="form-control" id="comment" cols="80" rows="8"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-block" type="submit" name="Submit">POST</button>
                    </div>
                </div>
            </div>
        </form>

    <!--comment part ends-->

                </div>
                <!--main area ends-->
                <!--side area starts-->
                <div class="col-sm-4">

                </div>
                <!--side area ends-->
            </div>
        </div>

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
    </script>
</body>
</html>