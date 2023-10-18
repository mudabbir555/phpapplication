<?php
include_once "dbconn.php";

// Function to check if the password meets the requirements
function isPasswordStrong($password)
{
    // Minimum password length
    $minLength = 8;

    // Regular expressions to check for different password requirements
    $regexUpperCase = '/[A-Z]/';
    $regexLowerCase = '/[a-z]/';
    $regexNumber = '/[0-9]/';
    $regexSpecialChar = '/[!@#$%^&*()\-_=+{};:,<.>]/';

    // Check if the password meets all the requirements
    if (
        strlen($password) >= $minLength &&
        preg_match($regexUpperCase, $password) &&
        preg_match($regexLowerCase, $password) &&
        preg_match($regexNumber, $password) &&
        preg_match($regexSpecialChar, $password)
    ) {
        return true;
    }

    return false;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "dbconn.php";

    $role = $_POST["role"];
    $FirstName = $_POST["FirstName"];
    $LastName = $_POST["LastName"];
    $EmailAddress = $_POST["EmailAddress"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];

    if ($Password !== $ConfirmPassword) {
        $showError = "Password and confirm password do not match.";
    } elseif (!isPasswordStrong($Password)) {
        $showError = "Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } else {
        // Establish database connection
        // $conn = mysqli_connect('localhost', 'username', 'password', 'database');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if email address already exists in the specified role table
        $checkEmailQuery = "SELECT * FROM " . $role . "_login WHERE EmailAddress = ?";
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
            $insertQuery = "INSERT INTO " . $role . "_login (role, FirstName, LastName, EmailAddress, Password) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, "sssss", $role, $FirstName, $LastName, $EmailAddress, $hashedPassword);
            mysqli_stmt_execute($stmt);

            // Check if the query executed successfully
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $showAlert = true;
                echo "Form data successfully inserted into the database.";
            } else {
                $showError = "Error inserting form data into the database.";
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Client Login</title>
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
                                        <h3 class="mt-4 font-weight-bold">Create Client</h3>
                                    </div>
                                    <div class="">
                                        <div class="form-body">
                                            <form action="csignup.php" method="POST" class="row g-3">
                                            <div class="col-sm-12" style="display: none;">
    <label for="Role" class="form-label">Role</label>
    <select class="form-control" name="role">
        <option value="client">Client</option>
    </select>
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
                                                    <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                                                    <input type="password" name="ConfirmPassword" class="form-control" placeholder="Confirm Password">
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" name="upload" class="btn btn-primary"><i class="bx bx-user me-1"></i>Add user</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 bg d-flex ">
                            <div class="card border-top  border-primary">
                            <h5>All Client</h5>
                            <div class="table-responsive">
    <?php
    // Fetch data from the database

    $query = "SELECT * FROM client_login";
    $result = mysqli_query($conn, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table">
        <thead>
            <tr>
                <th class="text-center">First Name</th>
                <th class="text-center">Last Name</th>
                <th class="text-center">Email Address</th>
                <th class="text-center">Password</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>';

        // Output data for each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                <td>' . $row["FirstName"] . '</td>
                <td>' . $row["LastName"] . '</td>
                <td>' . $row["EmailAddress"] . '</td>
                <td>' . $row["Password"] . '</td>
                <td>
                    <button class="edit-button" onclick="editRow(this)">Edit</button>
                    <button data-id="' . $row["id"] . '" class="delete-button" onclick="deleteRow(this)">Delete</button>
                </td>
            </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo "<p>No records found.</p>";
    }

    ?>
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

</body>

</html>
