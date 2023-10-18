<?php
$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'dbconn.php';
    $role = $_POST["role"];
    $FirstName = $_POST["FirstName"];
    $LastName = $_POST["LastName"];
    $EmailAddress = $_POST["EmailAddress"];
    $Password = $_POST["Password"];
    $Confirmpassword = $_POST["Confirmpassword"];

    if ($Password !== $Confirmpassword) {
        $showError = "Password and confirm password do not match.";
    } else {
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if email address already exists
        $checkEmailQuery = "SELECT * FROM user_login WHERE EmailAddress = ?";
        $stmt = mysqli_prepare($conn, $checkEmailQuery);
        mysqli_stmt_bind_param($stmt, "s", $EmailAddress);
        mysqli_stmt_execute($stmt);
        $checkEmailResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($checkEmailResult) > 0) {
            $showError = "Email address already exists. Please enter a new email.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

            // Prepare the SQL statement
            $sql = "INSERT INTO user_login (Role, FirstName, LastName, EmailAddress, Password) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $role, $FirstName, $LastName, $EmailAddress, $hashedPassword);
            mysqli_stmt_execute($stmt);

            // Check if the query executed successfully
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $showAlert = true;
                echo "Form data successfully inserted into the database.";
            } else {
                $showError = mysqli_error($conn);
                echo "Error inserting form data into the database.";
            }
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }

    // Close the database connection
    mysqli_close($conn);
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Client Login </title>
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- jQuery -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Roboto&display=swap" />
    <!-- Icons CSS -->
    <link rel="stylesheet" href="assets/css/icons.css" />
    <!-- App CSS -->
    <link rel="stylesheet" href="assets/css/app.css" />
</head>

<body class="bg-register">
    <?php require 'nav.php' ?>
    <?php
    if($showAlert){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your account is now created and you can login
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    if($showError){
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '. $showError.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    ?>
    <!-- wrapper -->
    <div class="wrapper">
        <div class="section-authentication-register d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col-12 col-lg-10 mx-auto">
                    <div class="card radius-15 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-xl-6">
                                <div class="card-body p-md-5">
                                    <div class="text-center">
                                    <img src="assets/images/logo.jpg" width="80" alt="">
                                        <h3 class="mt-4 font-weight-bold">Create Account</h3>
                                    </div>
                                    <div class="">
                                        
                                        <div class="form-body">
                                        <form action="usersignup.php" method="POST" class="row g-3">
                                            <div class="col-sm-12">
                                                    <label for="role" class="form-label">Role</label>
                                                    <input type="text" class="form-control" name="role">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="FirstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" name="FirstName" placeholder="John">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="LastName" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" name="LastName" placeholder="Doe">
                                                </div>
                                                <div class="col-12">
                                                    <label for="EmailAddress" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" name="EmailAddress" placeholder="example@user.com">
                                                </div>
                                                <div class="col-12">
                                                <label for="Password" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                <input type="password" name="Password" class="form-control" placeholder="Password">
                                                </div>
                                            </div>

                                                <div class="col-12">
                                                    <label for="Confirmpassword" class="form-label">Confirm Password</label>
                                                    <input type="password" name="Confirmpassword" class="form-control" placeholder="Confirm Password">
                                                </div>
                                               
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" name="upload" class="btn btn-primary"><i class="bx bx-user me-1"></i>Sign up</button>
                                                    </div>
                                                </div>
                                        </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-6 bg-login-color d-flex align-items-center justify-content-center">
                                <img src="assets/images/login-images/register-frent-img.jpg" class="img-fluid" alt="...">
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
    <!-- JavaScript -->
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Password show & hide js -->
    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
</body>

</html>
