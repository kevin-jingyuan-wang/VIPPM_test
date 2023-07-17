<?php
if (!isset($_SESSION)) {
    session_start(); // Start the session
}

// Logout functionality
if (isset($_GET['logout']) && $_GET['logout'] === 'true')  {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page
    header("Location: index.php");
    exit;
}

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // User is logged in, check if the session has expired
    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 7200) {
        // Session has expired, logout the user
        unset($_SESSION['username']);
        unset($_SESSION['user_type']);
        session_destroy();
        header("Location: index.php");
        exit;
    } else {
        // Update the last activity time
        $_SESSION['last_activity'] = time();
    }
}

// Get the user type
$userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';

?>


<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-container">
        <nav>
            <ul>
                <?php if (isset($_SESSION['username'])): ?>
                    <?php $username = $_SESSION['username']; ?>
                    <?php if ($_SESSION['user_type'] === 'user'): ?>
                        <a href="index.php">London</a>
                        <a href="service_reserve.php">Reserve</a>
                        <span class="order">
                            <a href="order_show.php">Order </a>
                            <span class="dropdown-menu">
                                <a href="#">Order Now</a>
                                <a href="#">History Order</a>
                            </span>
                        </span>
                        <a href="#">Message</a>
                        <span class="username">
                            <a href="#"><?php echo $username; ?> <span class="vip">VIP</span></a>
                            <span class="dropdown-menu">
                                <a href="view_modify_profile.php">Profile</a>
                                <a href="#">Membership</a>
                                <a href="header.php?logout=true" class="logout-link">Logout</a>
                            </span>
                        </span>
                    <?php elseif ($_SESSION['user_type'] === 'contractor'): ?>   
                        <a href="index.php">London</a></li>
                        <a href="service_reserve.php">Apply</a></li>
                        <span class="order">
                            <a href="#">Order </a>
                            <span class="dropdown-menu">
                                <a href="#">Order Now</a>
                                <a href="view_reservation.php">History Order</a>
                            </span>
                        </span>
                        <a href="#">Message</a>
                        <span class="username">
                            <a href="#"><?php echo $username; ?> <span class="vip">VIP</span></a>
                            <span class="dropdown-menu">
                                <a href="view_modify_profile.php">Profile</a>
                                <a href="#">Membership</a>
                                <a href="#">Status</a>
                                <a href="header.php?logout=true" class="logout-link">Logout</a>
                            </span>
                        </span>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="index.php">London</a>
                    <a href="login.php">Login</a>
                    <?php if (basename($_SERVER['PHP_SELF']) === 'index_contractor.php'): ?>
                        <a href="signup_contractor.php">Register</a>
                        <a href="index_contractor.php">Become partner</a>
                    <?php else: ?>
                        <a href="signup.php">Register</a>
                        <a href="index_contractor.php">Become partner</a>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>


</body>
</html>