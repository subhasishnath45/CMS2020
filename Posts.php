<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Posts</title>
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
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><i class="fas fa-blog"></i> Blog Posts</h1>
                    </div>
                    <div class="col-lg-3 mb-1">
                        <a href="AddNewPost.php" class="btn btn-primary btn-block">
                            <i class="fas fa-edit"> Add New Post</i>
                        </a>
                    </div>
                    <div class="col-lg-3 mb-1">
                        <a href="categories.php" class="btn btn-info btn-block">
                            <i class="fas fa-folder-plus"> Add New Category</i>
                        </a>
                    </div>
                    <div class="col-lg-3 mb-1">
                        <a href="Admins.php" class="btn btn-warning btn-block">
                            <i class="fas fa-user-plus"> Add New Admin</i>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a href="Comments.php" class="btn btn-success btn-block">
                            <i class="fas fa-check"> Add New Admin</i>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!--MAIN AREA-->
        <section class="container py-2 mb-4">
        
            <div class="row">
                <div class="col-lg-12 text-center">
                <?php 
                    echo Errormessage(); 
                    echo Successmessage();
                ?>
                </div>

                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date & Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                            global $ConnectingDB;
                            // Fetching all of our posts from the posts table.
                            $sql = "SELECT * FROM posts";
                            $stmt = $ConnectingDB->query($sql);
                            // variable for serial no of our post.
                            $sr = 1;
                            while($DataRows = $stmt->fetch()){
                                $Id = $DataRows["id"];
                                $DateTime = $DataRows["datetime"];
                                $PostTitle = $DataRows["title"];
                                $Category = $DataRows["category"];
                                $Admin = $DataRows["author"];
                                $Image = $DataRows["image"];
                                $PostText = $DataRows["post"];
                        ?>

                        <tr>
                            <td><?php echo $sr; ?></td>
                            <td>
                            <?php if(strlen($PostTitle)>20){
                            ?>
                            <?php 
                            $PostTitle = substr($PostTitle,0,20);
                            echo $PostTitle . '...'; 
                            ?>
                            <?php
                            }else{
                            ?>
                            <?php echo $PostTitle; ?>
                            <?php
                            } 
                            ?>
                            
                            </td>
                            <td>
                                <?php 
                                    if(strlen($Category)>8){
                                        $Category = substr($Category,0,8) . '...';
                                        echo $Category; 
                                    }else{
                                        echo $Category; 
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if(strlen($DateTime)>11){
                                    $DateTime = substr($DateTime,0,11) . '...';
                                    echo $DateTime; 
                                }else{
                                    echo $DateTime; 
                                }
                                
                                ?>
                            </td>
                            <td>
                                <?php 
                                if(strlen($Admin)>6){
                                    $Admin = substr($Admin,0,6) . '...';
                                    echo $Admin; 
                                }else{
                                    echo $Admin; 
                                }
                                ?>
                            </td>
                            <td><img src="uploads/<?php echo $Image; ?>" class="img-responsive" width="150px" height="100px"/></td>
                            <td>Comments</td>
                            <td>
                                <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning btn-block mb-1">Edit</sppan></a>
                                <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger btn-block">Delete</sppan></a>
                            </td>
                            <td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</sppan></a></td>
                        </tr>

                        <?php
                            $sr++;
                            }
                        ?>
                        </tbody>

                    </table>
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
    <script>
        document.getElementById('copyright-year').innerHTML = new Date().getFullYear();
    </script>
</body>
</html>