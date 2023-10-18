<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: Ulogin.php");
    exit;
}

// Handle logout
if (isset($_POST['logout'])) {
    if ($_SESSION['loggedin']) {
        $_SESSION['loggedin'] = false;
        session_destroy();
    }
    header("Location: login.php"); // Redirect to login page
    exit;
}
    include('sidebar2.php');
    include('footer.php');

include_once "dbconn.php";

// Check if the form is submitted
if (isset($_POST['upload'])) {
    // Retrieve form input values
    $Name = $_POST["Name"];
    $Email = $_POST["Email"];
    $Phone = $_POST["Phone"];
	$MSG = $_POST["MSG"];

    // Establish database connection
    // $conn = mysqli_connect('localhost', 'username', 'password', 'database');

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement
    $query = "INSERT INTO comment_db (Name, Email, Phone, MSG) VALUES ('$Name', '$Email', '$Phone', '$MSG')";

    // Execute the statement
    $query_run = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($query_run) {
        echo "Form data successfully inserted into the database.";
    } else {
        echo "Error inserting form data into the database.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .container.contact-form {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .contact-image img {
            width: 100%;
            max-width: 150px;
            margin-bottom: 20px;
        }

        .contact-form h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        .contact-form .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .contact-form .col-md-6 {
            width: 50%;
            padding: 0 10px;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form .form-control {
            width: 100%;
            height: 40px;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .contact-form textarea.form-control {
            height: 150px;
        }

        .contact-form .btnContact {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .contact-form .btnContact:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="container contact-form">
            <div class="contact-image">
                <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact"/>
            </div>
            <form action="contact.php" method="POST">
                <h3>Drop Us a Message</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="Name" class="form-control" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="Email" class="form-control" placeholder="Email" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="Phone" class="form-control" placeholder="Phone Number" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="MSG" class="form-control" placeholder="Your Message" style="width: 100%; height: 150px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" name="upload" class="btnContact" value="Submit" />
                </div>
            </form>
        </div>
    </div>
</body>
</html>
