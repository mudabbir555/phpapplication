<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the email input value
    $EmailAddress = $_POST['EmailAddress'];

    include 'dbconn.php';

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate the email address
    if (!filter_var($EmailAddress, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit();
    }

    // Prepare the SQL statement to fetch user data based on email
    $sql_client = "SELECT * FROM client_login WHERE EmailAddress = ?";
    $stmt_client = $conn->prepare($sql_client);
    $stmt_client->bind_param("s", $EmailAddress);
    $stmt_client->execute();
    $result_client = $stmt_client->get_result();

    // Prepare the SQL statement to fetch user data based on email
    $sql_user = "SELECT * FROM user_login WHERE EmailAddress = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $EmailAddress);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    // Prepare the SQL statement to fetch user data based on email
    $sql_driver = "SELECT * FROM driver_login WHERE EmailAddress = ?";
    $stmt_driver = $conn->prepare($sql_driver);
    $stmt_driver->bind_param("s", $EmailAddress);
    $stmt_driver->execute();
    $result_driver = $stmt_driver->get_result();

    if ($result_client->num_rows > 0 || $result_user->num_rows > 0 || $result_driver->num_rows > 0) {
        // User found, redirect to password reset link
        $resetLink = "client_forgot_password.php";
        header("Location: $resetLink");
        exit();
    } else {
        // User not found, show an error message or redirect to an error page
        echo "User not found";
    }

    // Close the statements and the database connection
    $stmt_client->close();
    $stmt_user->close();
    $stmt_driver->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Check EmailAddress</title>
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Roboto&display=swap" />
    <!-- Icons CSS -->
    <link rel="stylesheet" href="assets/css/icons.css" />
    <!-- App CSS -->
    <link rel="stylesheet" href="assets/css/app.css" />
</head>

<body class="bg-forgot">
    <!-- wrapper -->
    <div class="wrapper">
        <div class="authentication-forgot d-flex align-items-center justify-content-center">
            <div class="card shadow-lg forgot-box">
                <div class="card-body p-md-5">
                    <div class="text-center">
                        <img src="assets/images/forgot-2.png" width="140" alt="" />
                    </div>
                    <h4 class="mt-5 font-weight-bold">Forgot Password?</h4>
                    <p class="text-muted">Enter your registered email ID to reset the password</p>
                    <form method="post" action="">
                        <div class="mb-3 mt-4">
                            <label for="EmailAddress" class="form-label">Email id</label>
                            <input type="text" class="form-control form-control-lg radius-30" name="EmailAddress" placeholder="example@user.com" />
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg radius-30">Send</button>
                            <a href="login.php" class="btn btn-light radius-30"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
