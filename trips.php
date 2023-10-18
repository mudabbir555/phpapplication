<?php
session_start();

include('sidebar2.php');
include('footer.php');
include_once "dbconn.php";

// Check if the form is submitted
if (isset($_POST['upload'])) {
    // Retrieve form input values
    $id_number = $_POST["id_number"];
    $Passenger_name = $_POST["Passenger_name"];
    $Passenger_PN = $_POST["Passenger_PN"];
    $Pick_up = $_POST["Pick_up"];
    $Destination = $_POST["Destination"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $payment_method = $_POST["payment_method"];
    $Total = $_POST["Total"];

    // Prepare the SQL statement
    $query = "INSERT INTO trips (id_number, Passenger_name, Passenger_PN, Pick_up, Destination, date, time, payment_method, Total) 
              VALUES ('$id_number', '$Passenger_name', '$Passenger_PN', '$Pick_up', '$Destination', '$date', '$time', '$payment_method', '$Total')";

    // Execute the statement
    $query_run = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($query_run) {
        echo "Form data successfully inserted into the database.";
    } else {
        echo "Error inserting form data into the database: " . mysqli_error($conn);
    }
}
?>
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div>
                <div class="row">
                    <div class="col-xl-10 mx-auto">
                        <div class="card border-top border-0 border-4 border-primary">
                            <div class="card-body p-5">
                                <div class="card-title d-flex align-items-center">
                                    <div>
                                        <i class="bx bxs-user me-1 font-22 text-primary"></i>
                                    </div>
                                    <h5 class="mb-0 text-primary">Trip Details</h5>
                                </div>
                                <hr>
                                <form action="trips.php" method="POST" class="row g-3" enctype="multipart/form-data">
    <div class="col-md-6">
        <label for="id_number" class="form-label"><h3>Driver ID</h3></label>
        <input type="text" class="form-control" name="id_number" required>
    </div>
    <h3>Passenger Details</h3>
    <div class="col-md-6">
        <label for="Passenger_name" class="form-label"> Name</label>
        <input type="text" class="form-control" name="Passenger_name" required>
    </div>
    <div class="col-md-6">
        <label for="Passenger_PN" class="form-label">Phone Number</label>
        <input type="text" class="form-control" name="Passenger_PN" required>
    </div>
    <hr>
    <div class="col-md-6">
        <label for="Pick_up" class="form-label">Pick Up </label>
        <input type="text" class="form-control" name="Pick_up" required>
    </div>
    <div class="col-md-6">
        <label for="Destination" class="form-label">Destination </label>
        <input type="text" class="form-control" name="Destination" required>
    </div>
    <div class="col-md-6">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" name="date" required>
    </div>
    <div class="col-md-6">
        <label for="time" class="form-label">Time</label>
        <input type="time" class="form-control" name="time" required>
    </div>
    <div class="col-md-6">
        <label for="payment_method" class="form-label">Payment Method</label>
        <select class="form-control" name="payment_method" required>
            <option selected disabled>Choose...</option>
            <option value="CASH">CASH</option>
            <option value="ONLINE">ONLINE</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="Total" class="form-label">Total</label>
        <input type="text" class="form-control" name="Total" required>
    </div>
    <div class="col-12">
        <button type="submit" name="upload" class="btn btn-primary px-5">Submit</button>
    </div>
</form>

                                <hr>
                                <div class="table-responsive">
                                    <?php
                                    include_once "dbconn.php";

                                    // Fetch data from the database
                                    $query = "SELECT * FROM trips";
                                    $query_run = mysqli_query($conn, $query);

                                    // Check if any rows are returned
                                    if (mysqli_num_rows($query_run) > 0) {
                                        echo '<table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Driver ID</th>
                                                    <th class="text-center">Passenger Name</th>
                                                    <th class="text-center">Passenger Phone Number</th>
                                                    <th class="text-center">Pick Up</th>
                                                    <th class="text-center">Destination</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Time</th>
                                                    <th class="text-center">Payment Method</th>
                                                    <th class="text-center">Total</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
    
                                        // Output data for each row
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            echo '<tr>
                                                    <td>'.$row["id_number"].'</td>
                                                    <td>'.$row["Passenger_name"].'</td>
                                                    <td>'.$row["Passenger_PN"].'</td>
                                                    <td>'.$row["Pick_up"].'</td>
                                                    <td>'.$row["Destination"].'</td>
                                                    <td>'.$row["date"].'</td>
                                                    <td>'.$row["time"].'</td>
                                                    <td>'.$row["payment_method"].'</td>
                                                    <td>'.$row["Total"].'</td>
                                                    <td>
                                                        <button class="edit-button" onclick="editRow(this)">Edit</button>
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
                        </div>
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
  var name = cells[0].innerText;
  var idNumber = cells[1].innerText;
  var phone = cells[2].innerText;
  var presentAddress = cells[3].innerText;
  var permanentAddress = cells[4].innerText;
  var image = cells[5].innerText;

  // Perform desired edit operations, such as updating a form with the values
  console.log("Editing row: " + name + " - " + idNumber + " - " + phone + "\nPresent Address: " + presentAddress + "\nPermanent Address: " + permanentAddress + "\nImage: " + image);
  window.location.href = "serviceremainder.php"; // Replace "sunshineD.php" with the correct form file name
}
</script>
           