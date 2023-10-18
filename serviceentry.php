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
    include('footer.php');

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
                    <h5 class="mb-0 text-primary">Service Entry</h5>
                </div>
                <form action="controller/serviceentry.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label for="Vehicle" class="form-label">Vehicle</label>
                        <select class="form-select" name="Vehicle">
    <option selected>Choose...</option>
    <option>Maruti Suzuki Alto</option>
    <option>Hyundai Creta</option>
    <option>Tata Nexon</option>
    <option>Mahindra XUV500</option>
    <option>Ford EcoSport</option>
    <option>Renault Kwid</option>
    <option>Volkswagen Polo</option>
    <option>Toyota Innova Crysta</option>
    <option>Honda Amaze</option>
    <option>Maruti Suzuki Vitara Brezza</option>
    <option>Maruti Suzuki Swift</option>
    <option>Hyundai i20</option>
    <option>Tata Tiago</option>
    <option>Mahindra Scorpio</option>
    <option>Honda City</option>
</select>

                    </div>
                    <div class="col-md-6">
                        <label for="Serviced" class="form-label">Serviced On</label>
                        <input type="date" class="form-control" name="Serviced">
                    </div>
                    <div class="col-md-6">
                        <label for="Odometer" class="form-label">Odometer</label>
                        <input type="text" class="form-control" name="Odometer">
                    </div>
                    <div class="col-md-6">
                        <label for="CompletedS" class="form-label">Completed Service</label>
                        <input type="text" class="form-control" name="CompletedS">
                    </div>
                    <div class="col-md-6">
                        <label for="Vendor" class="form-label">Vendor</label>
                        <select class="form-select" name="Vendor">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="Comments" class="form-label">Comments</label>
                        <textarea class="form-control" name="Comments" placeholder="Description..." rows="3"></textarea>
                    </div>
                    <hr>
                    <div class="col-md-6">
                        <label for="Labour" class="form-label">Labour</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="Labour" placeholder="0.00">
                            <span class="input-group-text">₹</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Parts" class="form-label">Parts</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="Parts" placeholder="0.00">
                            <span class="input-group-text">₹</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Tax" class="form-label">Tax</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="Tax" placeholder="Enter percentage">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <label for="Total" class="form-label">Total</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="total" placeholder="0.00" pattern="^₹?\d+(,\d{3})*(\.\d{1,2})?$" required>
                            <span class="input-group-text">₹</span>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <label for="InvoiceN" class="form-label">Invoice number</label>
                        <input type="text" class="form-control" name="InvoiceN">
                    </div>
                    <div class="col-12">
                        <button type="submit" name="upload" class="btn btn-primary px-5">Register</button>
                    </div>
                </form>

                <?php
    include_once "dbconn.php";

    // Fetch data from the database
    $query = "SELECT * FROM service_entry";
    $query_run = mysqli_query($conn, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($query_run) > 0) {
        echo '<table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Vehicle</th>
                        <th class="text-center">Serviced</th>
                        <th class="text-center">Odometer</th>
                        <th class="text-center">CompletedS</th>
                        <th class="text-center">Vendor</th>
                        <th class="text-center">Comments</th>
                        <th class="text-center">Labour</th>
                        <th class="text-center">Parts</th>
                        <th class="text-center">Tax</th>
                        <th class="text-center">InvoiceN</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>';

        // Output data for each row
        while ($row = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                        <td>' . $row["Vehicle"] . '</td>
                        <td>' . $row["Serviced"] . '</td>
                        <td>' . $row["Odometer"] . '</td>
                        <td>' . $row["CompletedS"] . '</td>
                        <td>' . $row["Vendor"] . '</td>
                        <td>' . $row["Comments"] . '</td>
                        <td>' . $row["Labour"] . '</td>
                        <td>' . $row["Parts"] . '</td>
                        <td>' . $row["Tax"] . '</td>
                        <td>' . $row["InvoiceN"] . '</td>
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
?>

                <script>
                    function editRow(button) {
                        var row = button.parentNode.parentNode;
                        var cells = row.getElementsByTagName("td");

                        // Get the values from the row cells
                        var Vehicle = cells[0].innerText;
                        var Serviced = cells[1].innerText;
                        var Odometer = cells[2].innerText;
                        var CompletedS = cells[3].innerText;
                        var Vendor = cells[4].innerText;
                        var Comments = cells[5].innerText;
                        var Labour = cells[6].innerText;
                        var Parts = cells[7].innerText;
                        var Tax = cells[8].innerText;
                        var InvoiceN = cells[9].innerText;

                        // Perform desired edit operations, such as updating a form with the values
                        console.log("Editing row: " + Vehicle + " - " + Serviced + " - " + Odometer + " - " + CompletedS + " - " + Vendor + " - " + Comments + " - " + Labour + " - " + Parts + " - " + Tax + " - " + InvoiceN);
                        window.location.href = "serviceentry.php"; // Replace "serviceentry.php" with the correct form file name
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
                        xhr.open("POST", "controller/deleteSERVE.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("id=" + encodeURIComponent(id));
                    }
                </script>
            </div>
        </div>


    </div>
</div>

			