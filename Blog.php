<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

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
                    <form action="Blog.php" method="post" class="form-inline d-none d-sm-block">
                        <div class="form-group">
                            <input type="text" class="form-control" name="Search" placeholder="Search Here" value=""/>
                            <button type="submit" class="btn btn-primary ml-2" name="SearchButton">Search</button>
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
                <!--main area starts-->
                <div class="col-sm-8">
                    <h1>Your Blog Posts</h1>
                    <h1 class="lead">Created By CAD CENTRE STUDENTS in 2020</h1>

                    <?php 
                        global $ConnectingDB;
                        $sql = "SELECT * FROM posts ORDER BY id DESC";
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
      if(strlen($PostDescription)>150){
        $PostDescription = substr($PostDescription,0,150) . '...';
        echo html_entity_decode($PostDescription);
      }else{
        echo html_entity_decode($PostDescription);
      }
      
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
      <li>
          <a href="FullPost.php">
              Read More...
          </a>
      </li>
    </ul>
  </div>

</div>
                    
                    <?php
                        }
                    ?>


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