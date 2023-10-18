<?php
  session_start();
  
  include('sidebar2.php');
  include('footer.php');
?>
        <div class="page-wrapper">
			<!--page-content-wrapper-->
			<div class="page-content-wrapper">
				<div class="page-content">
					<!--breadcrumb-->
					<div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
						<div class="breadcrumb-title pe-3">User Profile</div>						
					</div>
					<!-- <div class="tab-pane fade" id="Edit-Profile"> -->
										<!-- <div class="card shadow-none border mb-0 radius-15"> -->
											<div class="card-body">
												<div class="form-body">
													<div class="row">
														<div class="col-12 col-lg-5 border-right">
														<form action="controller/clientprofile.php" method="POST" class="row g-3">
    <div class="col-6">
        <label for="FirstName" class="form-label">First Name</label>
        <input type="text" name="FirstName" placeholder="Svetlana" class="form-control">
    </div>
    <div class="col-6">
        <label for="LastName" class="form-label">Last Name</label>
        <input type="text" name="LastName" placeholder="Anyukova" class="form-control">
    </div>
    <div class="col-12">
        <label for="Email" class="form-label">Email</label>
        <input type="text" name="Email" placeholder="svetlana1997@example.com" class="form-control">
    </div>
    <div class="col-12">
        <label for="Phone" class="form-label">Phone</label>
        <input type="text" name="Phone" placeholder="99-10-XXX-XXX" class="form-control">
    </div>
    <div class="col-12">
        <label for="address" class="form-label">Address</label>
        <input type="text" name="address" placeholder="116-B, Cutela Colony, Sydney, Australia" class="form-control">
    </div>


													
														</div>
														<div class="col-12 col-lg-7">
														<div class="row g-3">
    <div class="col-12">
        <label for="Gender" class="form-label">Gender</label>
        <select name="Gender" class="form-control">
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
        </select>
    </div>

    <div class="col-12" for="Dob">
        <p class="mb-0"name="Dob">Date of Birth</p>
    </div>
    <div class="col-12 col-lg-4">
        <select name="month" class="form-control">
            <option>January</option>
            <option>February</option>
            <option selected>March</option>
            <option>April</option>
            <option>May</option>
            <option>June</option>
            <option>July</option>
            <option>August</option>
            <option>September</option>
            <option>October</option>
            <option>November</option>
            <option>December</option>
        </select>
    </div>
    <div class="col-12 col-lg-4">
        <select name="day" class="form-control">
            <option>01</option>
            <option>02</option>
            <option>03</option>
            <option>04</option>
            <option>05</option>
            <option>06</option>
            <option>07</option>
            <option>08</option>
            <option>09</option>
            <option selected>10</option>
            <option>11</option>
            <option>12</option>
            <option>13</option>
            <option>14</option>
            <option>15</option>
            <option>16</option>
            <option>17</option>
            <option>18</option>
            <option>19</option>
            <option>20</option>
            <option>21</option>
            <option>22</option>
            <option>23</option>
            <option>24</option>
            <option>25</option>
            <option>26</option>
            <option>27</option>
            <option>28</option>
            <option>29</option>
            <option>30</option>
            <option>31</option>
        </select>
    </div>
    <div class="col-12 col-lg-4">
        <select name="year" class="form-control">
            <option>1990</option>
            <option>1991</option>
            <option>1992</option>
            <option selected>1993</option>
            <option>1994</option>
        </select>
    </div>

    <div class="col-12">
        <label for="facebook" class="form-label">Facebook</label>
        <input type="text" name="facebook" placeholder="https://www.facebook.com/anyukova" class="form-control">
    </div>

	<div class="col-12">
        <button type="submit" name="upload" class="btn btn-primary px-5">Submit</button>
    </div>
</div>
</form>
														</div>
													</div>
												</div>
											</div>
											<div class="card">
												<div class="card-body">
													<div class="card-title">
													<h4 class="mb-0">DataTable Example</h4>
													</div>
													<hr/>
												</div><?php
    include_once "dbconn.php"; 

    // Fetch data from the database
    $query = "SELECT * FROM client_profile";
    $query_run = mysqli_query($conn, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($query_run) > 0) {
        echo '<table class="table">
            <thead>
                <tr>
                    <th class="text-center">FirstName</th>
                    <th class="text-center">LastName</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Address</th>
					<th class="text-center">Gender</th>
                    <th class="text-center">Date of Birth</th>
                    <th class="text-center">Facebook</th>
					<th class="text-center">Action</th>


                </tr>
            </thead>
            <tbody>';
        
        // Output data for each row
        while ($row = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>'.$row["FirstName"].'</td>
                    <td>'.$row["LastName"].'</td>
                    <td>'.$row["Email"].'</td>
                    <td>'.$row["Phone"].'</td>
					<td>'.$row["address"].'</td>
					<td>'.$row["Gender"].'</td>
					<td>'.(isset($row["Dob"]) ? $row["Dob"] : '').'</td>
					<td>'.$row["facebook"].'</td>
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
											</div>
									
											<script>
function editRow(button) {
  var row = button.parentNode.parentNode;
  var cells = row.getElementsByTagName("td");

  // Get the values from the row cells
  var FirstName = cells[0].innerText;
  var LastName = cells[1].innerText;
  var Email = cells[2].innerText;
  var Phone = cells[3].innerText;
  var address = cells[4].innerText;
  var Gender = cells[5].innerText;
  var Dob = cells[6].innerText;
  var facebook = cells[7].innerText;

  // Perform desired edit operations, such as updating a form with the values
  console.log("Editing row: " + FirstName + " - " + LastName + " - " + Phone + "\nAddress: " + address + "\nGender: " + Gender + "\nDate of Birth: " + Dob + "\nFacebook: " + facebook);
  window.location.href = "client_profile.php"; // Replace "client_profile.php" with the correct form file name
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
            xhr.open("POST", "controller/deleteprofile.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("id=" + encodeURIComponent(id));}

</script>


		