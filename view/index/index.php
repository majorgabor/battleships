<!DOCTYPE html>
<?php
require_once "../../services/methods.php";
remember();

?>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="../../open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <title>Battleships</title>
</head>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Battleships game</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <?php if(isset($_SESSION["logged_in"])) :?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="navbar-text">Logged in as <b><?php echo $_SESSION["logged_in"]; ?></b></span>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                        <a class="nav-link" href="../account/account.php" >
                            <span class="oi oi-person" title="account" aria-hidden="true"></span>
                        Account</a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../services/logout.php" >
                        <span class="oi oi-account-logout" title="logout" aria-hidden="true"></span>
                    Logout</a>
                </li>
            </ul>
            <?php else : ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../login/login.php" >
                        <span class="oi oi-account-login" title="login" aria-hidden="true"></span>
                    LogIn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../signup/signup.php">
                    <span class="oi oi-people" title="singup" aria-hidden="true"></span>
                    Sign Up</a>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </nav>
<!-- The First Row -->
    <div id="first_row" class="row">
        <div class="offset-lg-1 col-lg-3 col-md-4">
            <img class="rounded-circle" src="http://pipsum.com/140x140.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, totam blanditiis dolores placeat pariatur asperiores quos vero. Consequatur nostrum inventore perspiciatis hic sequi, fugit adipisci dolor vero, nisi eum illum?</p>
            <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-lg-4 col-md-4">
            <img class="rounded-circle" src="http://pipsum.com/140x140.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque eveniet modi, asperiores dignissimos ratione et repudiandae rerum, sit cum cumque sapiente? Corporis assumenda modi ducimus! Provident, quia. Asperiores, eligendi sed?</p>
            <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-lg-3 col-md-4">
            <img class="rounded-circle" src="http://pipsum.com/140x140.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam quod sequi veniam quia repellendus provident aliquid harum quas minus esse? Consequatur vero esse ad. Dolorem esse eum qui ratione aliquid!</p>
            <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
        </div>
    </div>
<!-- End Tirst Row -->
<!-- The Carousel  -->
    <div class="d-none d-md-block">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ul>
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../../images/ship_1.jpg" alt="Ship1">
                    <div class="carousel-caption">
                        <div class="carousel_background">
                            <h3>The War is Now</h3>
                            <p>Fight against the enemy!</p>
                        </div>
                        <a class="btn btn-lg btn-primary" href="../account/account.php" role="button">Play Now</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="../../images/ship_2.jpg" alt="Ship2">
                    <div class="carousel-caption">
                        <div class="carousel_background">
                            <h3>We Need You</h3>
                            <p>Join to the battle and win the war!</p>
                        </div>
                        <a class="btn btn-lg btn-primary" href="../signup/signup.php" role="button">Sign Up</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="../../images/ship_6.jpg" alt="Ship6">
                    <div class="carousel-caption">
                        <div class="carousel_background">
                            <h3>Destroy Them</h3>
                            <p>The louck isn't enought. Prove that you have the best strategy!</p>
                        </div>
                        <a class="btn btn-lg btn-primary" href="../account/account.php" role="button">Play Now</a>
                        <a class="btn btn-lg btn-primary" href="../signup/signup.php" role="button">Sign Up</a>
                    </div>
                </div>
            </div>
            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
</body>
</html>