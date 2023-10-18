<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: Ulogin.php");
    exit;
}

    // Handle logout
    if (isset($_POST['logout'])) {
        $_SESSION['loggedin'] = false;
        session_destroy();
        header("Location: login.php"); // Redirect to login page
        exit;
    }
    include('sidebar2.php');
    include('sidebar2.php');
    include('footer.php');

include_once "dbconn.php";

// Check if the form is submitted
if (isset($_POST['upload'])) {
    // Retrieve form input values
    $vehicle = $_POST["vehicle"];
    $date = $_POST["date"];
    $odometer = $_POST["odometer"];
    $fuel_amount = $_POST["fuel_amount"];
    $cost = $_POST["cost"];

    // Establish database connection
    include_once "dbconn.php";

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement
    $query = "INSERT INTO service_entry_fuel (vehicle, date, odometer, fuel_amount, cost) VALUES ('$vehicle', '$date', '$odometer', '$fuel_amount', '$cost')";

    // Execute the statement
    $query_run = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($query_run) {
        echo "Form data successfully inserted into the database.";
    } else {
        echo "Error inserting form data into the database.";
    }
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Delete the row from the database
    $query = "DELETE FROM service_entry_fuel WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Row deleted successfully";
    } else {
        echo "Failed to delete the row";
    }

    // Close database connection
    mysqli_close($conn);
}
?>

		<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-8">
                            <div class="card-title d-flex align-items-center">
                                <div>
                                    <i class="bx bxs-user me-1 font-22 text-primary"></i>
                                </div>
                                <h5 class="mb-0 text-primary">Fuel Entry</h5>
                            </div>
                            <form action="fuelhistory.php" method="POST" class="row g-3">
                                <div class="col-md-6">
                                    <label for="vehicle">Vehicle:</label>
                                    <input type="text" id="vehicle" class="form-control" name="vehicle" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="date">Date:</label>
                                    <input type="date" id="date" class="form-control" name="date" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="odometer">Odometer Reading:</label>
                                    <input type="number" id="odometer" class="form-control" name="odometer" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fuel_amount">Fuel Amount (in liters):</label>
                                    <input type="number" id="fuel_amount" class="form-control" name="fuel_amount" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cost">Fuel Cost (in USD):</label>
                                    <input type="number" id="cost" class="form-control" name="cost" step="0.01">
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="upload" class="btn btn-primary px-5">Register</button>
                                </div>
                            </form>
                        </div>
                        <?php
// Fetch data from the database
$query = "SELECT * FROM service_entry_fuel";
$query_run = mysqli_query($conn, $query);

// Check if any rows are returned
if (mysqli_num_rows($query_run) > 0) {
    echo '<table class="table">
            <thead>
                <tr>
                    <th class="text-center">vehicle</th>
                    <th class="text-center">date</th>
                    <th class="text-center">odometer</th>
                    <th class="text-center">Fuel</th>
                    <th class="text-center">cost</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>';

    // Output data for each row
    while ($row = mysqli_fetch_assoc($query_run)) {
        echo '<tr>
        <td class="text-center">' . $row["vehicle"] . '</td>
                <td class="text-center">' . $row["date"] . '</td>
                <td class="text-center">' . $row["odometer"] . '</td>
                <td class="text-center">' . $row["fuel_amount"] . '</td>
                <td class="text-center">' . $row["cost"] . '</td>
                    <td>
                        <button class="edit-button" onclick="editRow(this)">Edit</button>
                    </td>
                    <td>
                        <button data-id="' . $row["id"] . '" class="delete-button" onclick="deleteRow(this)">Delete</button>
                    </td>
                </tr>';
    }

    echo '</tbody></table>';
} else {
    echo "<p>No records found.</p>";
}

// Close the database connection
mysqli_close($conn);
?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editRow(button) {
        var row = button.parentNode.parentNode;
        var cells = row.getElementsByTagName("td");

        // Get the values from the row cells
        var vehicle = cells[0].innerText;
        var date = cells[1].innerText;
        var odometer = cells[2].innerText;
        var fuel_amount = cells[3].innerText;

        var cost = cells[4].innerText;

        // Perform desired edit operations, such as updating a form with the values
        console.log("Editing row: " + vehicle + " - " + date + " - " + odometer + " - " + cost);
        window.location.href = "fuelhistory.php"; // Replace "serviceentry.php" with the correct form file name
    }


                    function deleteRow(button) {
                        var row = button.parentNode.parentNode;
                        var id = button.getAttribute("data-id");

                        // Perform AJAX request to delete the row from the database
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Row deleted successfully, you can perform any additional actions here
                                row.remove();
                            }
                        };
                        xhr.open("POST", "fuelhistory.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("id=" + encodeURIComponent(id));
                    }
                </script>
            </div>
        </div>


    </div>
</div>

			