<?php
// Assuming you have a database connection established
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'dbconn.php';

    // Retrieve the form input values
    $newPassword = $_POST['Password'];
    $confirmPassword = $_POST['ConfirmPassword'];
    $EmailAddress = $_POST['EmailAddress'];

    // Validate the new password and confirm password fields
    if ($newPassword !== $confirmPassword) {
        echo "Passwords do not match";
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Prepare the SQL query to update the hashed password in the client_login table
    $sql_client = "UPDATE client_login SET Password = ? WHERE EmailAddress = ?";
    $stmt_client = $conn->prepare($sql_client);
    $stmt_client->bind_param("ss", $hashedPassword, $EmailAddress);
    $result_client = $stmt_client->execute();

    // Prepare the SQL query to update the hashed password in the user_login table
    $sql_user = "UPDATE user_login SET password = ? WHERE EmailAddress = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("ss", $hashedPassword, $EmailAddress);
    $result_user = $stmt_user->execute();

    // Prepare the SQL query to update the hashed password in the driver_login table
    $sql_driver = "UPDATE driver_login SET password = ? WHERE EmailAddress = ?";
    $stmt_driver = $conn->prepare($sql_driver);
    $stmt_driver->bind_param("ss", $hashedPassword, $EmailAddress);
    $result_driver = $stmt_driver->execute();

    if ($result_client && $result_user && $result_driver) {
        // Password updated successfully in all tables
        echo "Password changed successfully";
    } else {
        echo "Error updating password";
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
    <title>Syndash - Bootstrap4 Admin Template</title>
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

<body>
    <!-- wrapper -->
    <div class="wrapper">
        <div class="authentication-reset-password d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col-12 col-lg-10 mx-auto">
                    <div class="card radius-15">
                        <div class="row g-0">
                            <div class="col-lg-5">
                                <div class="card-body p-md-5">
                                    
                                    <h4 class="mt-5 font-weight-bold">Generate New Password</h4>
                                    <p class="text-muted">We received your reset password request. Please enter your new password!</p>
                                    <form method="post" action="">
                                    <div class="mb-3 mt-5">
                                            <label  for="EmailAddress" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="EmailAddress" placeholder="Enter new password" />
                                        </div>
                                        <div class="mb-3 mt-5">
                                            <label  for="Password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" name="Password" placeholder="Enter new password" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="ConfirmPassword"class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="ConfirmPassword" placeholder="Confirm password" />
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                            <!-- <a href="login.php" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <img src="assets/images/forgot-password-frent-img.jpg" class="card-img login-img h-100" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
</body>

</html>
