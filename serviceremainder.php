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
                    <h5 class="mb-0 text-primary"> Renewal Remainder</h5>
                </div>
                <form action="controller/renewalremainder.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label"> Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-md-6">
                        <label for="servicetask" class="form-label">Servicetask</label>
                        <input type="text" class="form-control" name="servicetask">
                    </div>
                    <div class="col-md-6">
                        <label for="notes" class="form-label">Notes </label>
                        <input type="text" class="form-control" name="notes">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <input type="text" class="form-control" name="date">
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
    $query = "SELECT * FROM renewal_remainder";
    $query_run = mysqli_query($conn, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($query_run) > 0) {
        echo '<table class="table">
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Service task</th>
                    <th class="text-center">Notes</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>';
        
        // Output data for each row
        while ($row = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>'.$row["name"].'</td>
                    <td>'.$row["servicetask"].'</td>
                    <td>'.$row["notes"].'</td>
                    <td>'.$row["email"].'</td>
                    <td>'.$row["date"].'</td>
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
            xhr.open("POST", "controller/deleteRen.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("id=" + encodeURIComponent(id));}

</script>
            </div>
            
        </div>
    </div>
</div>