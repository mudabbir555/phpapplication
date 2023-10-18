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
   
?>

<div class="page-wrapper">
    <div class="page-content-wrapper">
    <div>
                <h1>Enter Employee ID</h1>
                <form method="GET" action="assignedD.php">
                    <div class="form-group">
                        <label for="id_Number">Employee ID:</label>
                        <input type="text" id="id_Number" name="id_Number" required>
                    </div>
                    <button type="submit">Check</button>
                </form>
            </div>
        <div class="page-content">

<style>
    .card {
        height: 100%;
        background-color: #e6f2ff;
    }
    
    .card-body {
        text-align: center;
    }
    
    .card-title {
        font-size: 2rem;
    }
    
    .display-number {
        font-size: 3rem;
        font-weight: bold;
    }
    
    .vehicle-rc {
        font-size: 2.5rem;
        font-weight: bold;
        margin-top: 10px;
    }
</style>

<div class="row">
    <div class="col-12 col-lg-6">
        <?php
        include_once "dbconn.php";

        // Fetch the last ID from the query
        $query = "SELECT id_Number FROM sunshine_d ORDER BY id_Number DESC LIMIT 1";
        $result = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $lastId = $row["id_Number"];

            // Display the last ID number
            echo '<div class="card card-driver radius-15">
                    <div class="card-body">
                        <h5 class="card-title">Driver ID Number</h5>
                        <p class="display-number">' . $lastId . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>

    <div class="col-12 col-lg-6">
        <?php
        include_once "dbconn.php";

        // Fetch the vehicle RC number from the query
        $query = "SELECT vehicleRc FROM sunshine_vehicle ORDER BY id_Number DESC LIMIT 1";
        $result = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $vehicleRc = $row["vehicleRc"];

            // Display the vehicle RC number
            echo '<div class="card card-vehicle radius-15">
                    <div class="card-body">
                        <h5 class="card-title">Vehicle RC Number</h5>
                        <p class="vehicle-rc">' . $vehicleRc . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No vehicle records found.</p>";
        }
        ?>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6">
        <?php
        // Fetch the last ID from the database
        $query = "SELECT id FROM fuel ORDER BY id DESC LIMIT 1";
        $query_run = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
            $lastId = $row["id"];

            echo '<div class="card card-fuel-entry radius-15">
                    <div class="card-body">
                        <h5 class="card-title">Fuel Entry</h5>
                        <p class="display-number">' . $lastId . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>

    <div class="col-12 col-lg-6">
        <?php
        // Fetch the last ID from the database
        $query = "SELECT id FROM add_issue ORDER BY id DESC LIMIT 1";
        $query_run = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
            $lastId = $row["id"];

            echo '<div class="card card-driver radius-15">
                    <div class="card-body">
                        <h5 class="card-title">Issues</h5>
                        <p class="display-number">' . $lastId . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>
    <div class="col-12 col-lg-6">
        <?php
        // Fetch the last ID from the database
        $query = "SELECT id FROM trips ORDER BY id DESC LIMIT 1";
        $query_run = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
            $lastId = $row["id"];

            echo '<div class="card card-trips radius-15">
                    <div class="card-body">
                        <h5 class="card-title">Trips</h5>
                        <p class="display-number">' . $lastId . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>
</div>


        </div>
    </div>
</div>
