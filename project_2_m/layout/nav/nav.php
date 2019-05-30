<?php
    if(isset($_POST['login'])) {
        if(!$customer->login()) {
            $message = $customer->response;
        } else {
        }
     }
     if(isset($_GET['logout'])) {
        $_SESSION = array();
        header("Location: login.php");
     }
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="index.php" class="navbar-brand">Bookintel AB</a>
    <button class="navbar-toggler">
        <span class="navbar-toggler-icon" data-toggle="collapse" data-target="#navbarMenu"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="licenses.php" class="nav-link">Licenses</a>
            </li>
            <li class="nav-item">
                <a href="upload_csv.php" class="nav-link">Upload CSV</a>
            </li>
            <?php if(isset($_SESSION['customer_id'])) { ?>
                <li class="nav-item">
                    <a href="my_account.php" class="nav-link">My Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?logout">Log Out</a>
                </li>
            <?php } ?>
        </ul>
      </div>    

    <?php if(!isset($_SESSION['customer_id'])) { ?>
    <ul class="flex-container">
        <li class="nav-item log-in-hover">
            <a class="nav-link" href="login.php">Log In</a>
            <div class="log-in-wrapper">
                <div class="col log-in-container">
                    <h4 class="text-center">Log In </h4>
                    <div class="row">
                        <div class="col">
                            <form method="post">
                                <div class="form-group">
                                <input type="text" name="user" class="form-control" placeholder="Username" required>        
                                </div>
                                <div class="form-group">
                                <input type="password" name="pass" class="form-control" placeholder="Password" required>        
                                </div>
                                <button type="submit" class="btn btn-primary" name="login">Log In
                                </button>
                                <?php if(isset($customer->response)) { echo "<p>$message</p>";} ?>
                            </form>
                            <a class="nav-link" href="create_account.php">I don't have an account</a>
                        </div>
                    </div>    
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="create_account.php">Create Account</a>
        </li>
    </ul>
    <?php } ?>
</nav>