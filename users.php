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
    include('footer.php');s

?>
		<div class="page-wrapper">
			<!--page-content-wrapper-->
			<div class="page-content-wrapper">
				<div class="page-content">
					<!--breadcrumb-->
					<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
						<div class="breadcrumb-title pe-3">Forms</div>
						<div class="ps-3">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb mb-0 p-0">
									<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
									</li>
									<li class="breadcrumb-item active" aria-current="page">Form Layouts</li>
								</ol>
							</nav>
						</div>
					</div>
					<!--end breadcrumb-->
					<div class="row">
						<div class="col-xl-7 mx-auto">
							
							<div class="card border-top border-0 border-4 border-primary">
								<div class="card">
                                    <div class="card-body">
                                        <div>
                                            <h5>Users</h5>
                                            <hr>
                                            <div class="table-responsive">
											<?php
    include_once "dbconn.php"; 

    // Fetch data from the database
    $query = "SELECT * FROM add_user";
    $query_run = mysqli_query($conn, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($query_run) > 0) {
        echo '<table class="table">
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">User Name</th>
                    <th class="text-center">E mail</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Address</th>
					<th class="text-center">Action</th>

                </tr>
            </thead>
            <tbody>';
        
        // Output data for each row
        while ($row = mysqli_fetch_assoc($query_run)) {
			echo '<tr>
			<td>'.$row["Name"].'</td>
			<td>'.$row["User_name"].'</td>
			<td>'.$row["email"].'</td>
			<td>'.$row["Phone"].'</td>
			<td>'.$row["address"].'</td>
			<td>
				<button class="edit-button" onclick="editRow(this)">Edit</button>
			</td>
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
  var Name = cells[0].innerText;
  var User_name = cells[1].innerText;
  var email = cells[2].innerText;
  var Phone = cells[3].innerText;
  var address = cells[4].innerText;

  // Perform desired edit operations, such as updating a form with the values
  console.log("Editing row: " + Name + " - " + User_name + " - " + email + "\nPhone: " + Phone + "\nAddress: " + address);
  window.location.href = "adduser.php"; // Replace "adduser.php" with the correct form file name
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
            xhr.open("POST", "controller/deleteuser.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("id=" + encodeURIComponent(id));}

</script>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
						
						
						</div>
					</div>
				
				</div>
			</div>
			<!--end page-content-wrapper-->
		</div>
		