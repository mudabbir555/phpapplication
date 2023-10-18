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
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
               
            </div>
            <div>
			
                <div class="row">
    <div class="col-xl-7 mx-auto">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body p-5">
                <div class="card-title d-flex align-items-center">
                    <div>
                        <i class="bx bxs-user me-1 font-22 text-primary"></i>
                    </div>
                    <h5 class="mb-0 text-primary"> Service Remainder</h5>
                </div>
                <hr>
                <form action="controller/serviceremainder.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label for="vehicleRc" class="form-label">Vehicle Rc</label>
                        <input type="text" class="form-control" name="vehicleRc">
                    </div>
                    <div class="col-md-6">
                        <label for="vehiclePermit" class="form-label">Vehicle Permit</label>
                        <input type="text" class="form-control" name="vehiclePermit">
                    </div>
                    <div class="col-md-6">
                        <label for="vehicleFitness" class="form-label">Vehicle Fitness</label>
                        <input type="text" class="form-control" name="vehicleFitness">
                    </div>
                    <div class="col-md-6">
                        <label for="vehicleInsurance" class="form-label">Vehicle Insurance</label>
                        <input type="text" class="form-control" name="vehicleInsurance">
                    </div>
                    <div class="col-md-6">
                        <label for="vehiclePUC" class="form-label">Vehicle PUC</label>
                        <input type="text" class="form-control" name="vehiclePUC">
                    </div>
                    <div class="col-md-6">
                        <label for="policeVerificationSticker" class="form-label">Police verification sticker</label>
                        <input type="text" class="form-control" name="policeVerificationSticker">
                    </div>
                    <div class="col-12">
                        <button type="submit" name="upload" class="btn btn-primary px-5">Submit</button>
                    </div>
                </form>
                <h5> Remaider</h5>
                                            <hr>
                                            <div class="table-responsive">
											<?php
    include_once "dbconn.php"; 

    // Fetch data from the database
    $query = "SELECT * FROM service_remainder";
    $query_run = mysqli_query($conn, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($query_run) > 0) {
        echo '<table class="table">
            <thead>
                <tr>
                    <th class="text-center">vehicleRc</th>
                    <th class="text-center">vehiclePermit</th>
                    <th class="text-center">vehicleFitness</th>
                    <th class="text-center">vehicleInsurance</th>
                    <th class="text-center">vehiclePUC</th>
                    <th class="text-center">policeVerificationSticker</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>';
        
        // Output data for each row
        while ($row = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>'.$row["vehicleRc"].'</td>
                    <td>'.$row["vehiclePermit"].'</td>
                    <td>'.$row["vehicleFitness"].'</td>
                    <td>'.$row["vehicleInsurance"].'</td>
                    <td>'.$row["vehiclePUC"].'</td>
                    <td>'.$row["policeVerificationSticker"].'</td>
					<td>
					<button class="edit-button" onclick="editRow(this)">Edit</button></td>
					<td>
				<button data-id="'.$row["id"].'" class="delete-button" onclick="deleteRow(this)">Delete</button>
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
            xhr.open("POST", "controller/deleteSER.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("id=" + encodeURIComponent(id));}

</script>
            </div>
            
        </div>
    </div>
</div>