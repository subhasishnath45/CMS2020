<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories</title>
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
                        <h1><i class="fas fa-edit"></i> Manage Categories</h1>
                    </div>
                </div>
            </div>
        </header>

        <!--MAIN AREA-->
        <section class="container py-2 mb-4">
            <div class="row">
                <div class="offset-lg-1 col-lg-10 category-content-wrapper d-flex flex-column justify-content-center align-items-center">
                    <form class="" action="categories.php" method="post">
                        <div class="card bg-secondary text-light mb-3">
                            <div class="card-header text-uppercase text-center">
                                <h1>Add new Category</h1>
                            </div>
                            <div class="card-body bg-dark">
                                <div class="form-group">
                                    <label for="title"><span class="FieldInfo">Category Title: </span></label>
                                    <input class="form-control" type="text" name="Title" id="title" placeholder="Type title here" value="">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <a href="dashboard.php" class="btn btn-block btn-warning btn-lg">
                                            <i class="fas fa-arrow-left"></i> back to Dashboard
                                        </a>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <button type="button" name="Submit" class="btn btn-success btn-block btn-lg">
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
    </script>
</body>
</html>