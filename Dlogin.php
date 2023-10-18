<?php
include 'dbconn.php';

session_start();

$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'dbconn.php';
    $EmailAddress = $_POST["EmailAddress"];
    $Password = $_POST["Password"];
    $role = $_POST["role"];

    if (strtolower($role) == "client") {
        // Prepare the SQL statement to prevent SQL injection
        $sql = "SELECT * FROM client_login WHERE EmailAddress=?";
    } elseif (strtolower($role) == "driver") {
        // Prepare the SQL statement to prevent SQL injection
        $sql = "SELECT * FROM driver_login WHERE EmailAddress=?";
    } else {
        $showError = "Invalid role.";
    }

    if (!$showError) {
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $EmailAddress);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($Password, $row['Password'])) {
                $login = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = $role;
                $_SESSION['EmailAddress'] = $EmailAddress;

                if (strtolower($role) == "client") {
                    header("Location: index.php");
                    exit;
                } elseif (strtolower($role) == "driver") {
                    header("Location: index3.php");
                    exit;
                }
            } else {
                $showError = "Invalid Credentials";
            }
        } else {
            $showError = "Invalid Credentials";
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
    <title>login</title>
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

<body class="bg-login">
    <?php require 'nav.php'; ?>
    <?php if ($showError) {
        echo '<div class="alert alert-danger" role="alert">' . $showError . '</div>';
    }
 ?>
    <div class="wrapper">
        <div class="section-authentication-login d-flex align-items-center justify-content-center mt-4">
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="card radius-15 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-xl-6">
                                <div class="card-body p-5">
                                    <div class="text-center">
                                    <img src="assets/images/logo.jpg" width="80" alt="">
                                        <h3 class="mt-4 font-weight-bold">Welcome</h3>
                                        <hr>
                                        <h3 class="mt-4 font-weight-bold"> Login</h3>
                                    </div>
                                    <div class="form-body">
                                        <form action="login.php" method="POST" class="row g-3" >
                                            <div class="col-12">
                                                <label for="Role" class="form-label">Role</label>
                                                <input type="text" class="form-control" name="role" placeholder="client or driver">
                                            </div>

                                            <div class="col-12">
                                                <label for="EmailAddress" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" name="EmailAddress" placeholder="example@user.com">
                                            </div>
                                            <div class="col-12">
                                                <label for="Password" class="form-label">Enter Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="Password" class="form-control" placeholder="Password">
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <a href="Cfpassword.php">Forgot Password?</a>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bx bxs-lock-open"></i> Log in
                                                    </button>
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 bg-login-color d-flex align-items-center justify-content-center">
                                <img src="assets/images/register-frent-img.jpg" class="img-fluid" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <!--Password show & hide js -->
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
