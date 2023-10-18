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
    <!-- page-content-wrapper -->
    <div class="page-content-wrapper">
        <div class="page-content">
	

<div class="row">
    <div class="col-12 col-lg-4">
        <?php
        include_once "dbconn.php";

        // Fetch the last ID from the database
        $query = "SELECT id FROM add_issue ORDER BY id DESC LIMIT 1";
        $query_run = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
            $lastId = $row["id"];

            echo '<div class="card card-issues radius-15">
                    <div class="card-body">
                        <h5 class="mb-4">Issues</h5>
                        <p class="display-1 font-weight-bold">' . $lastId . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>

    <!-- <div class="col-12 col-lg-4">
        <?php
        // Fetch the last ID from the database
        $query = "SELECT id FROM service_remainder ORDER BY id DESC LIMIT 1";
        $query_run = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
            $lastId = $row["id"];

            echo '<div class="card card-service radius-15">
                    <div class="card-body">
                        <h5 class="mb-4">Service Reminder</h5>
                        <p class="display-1 font-weight-bold">' . $lastId . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div> -->

    <div class="col-12 col-lg-4">
        <?php
        // Fetch the last ID from the first query
        $query1 = "SELECT id FROM sunshine_vehicle ORDER BY id DESC LIMIT 1";
        $result1 = mysqli_query($conn, $query1);

        // Fetch the last ID from the second query
        $query2 = "SELECT id FROM o_vehicle ORDER BY id DESC LIMIT 1";
        $result2 = mysqli_query($conn, $query2);

        $query3 = "SELECT id FROM add_vehicle ORDER BY id DESC LIMIT 1";
        $result3 = mysqli_query($conn, $query3);

        // Initialize total variable
        $total = 0;

        // Check if any row is returned for the first query
        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $lastId1 = $row1["id"];

            $total += $lastId1;
        }

        // Check if any row is returned for the second query
        if (mysqli_num_rows($result2) > 0) {
            $row2 = mysqli_fetch_assoc($result2);
            $lastId2 = $row2["id"];

            $total += $lastId2;
        }

        // Display the total value
        echo '<div class="card card-vehicles radius-15">
                <div class="card-body">
                    <h5 class="mb-4">Total Vehicles</h5>
                    <p class="display-1 font-weight-bold">' . $total . '</p>
                </div>
            </div>';
        ?>
    </div>
</div>



<!-- <div class="row">
    <div class="col-12 col-lg-4">
        <?php
        include_once "dbconn.php";

        // Fetch the last ID from the first query
        $query1 = "SELECT id FROM sunshine_d ORDER BY id DESC LIMIT 1";
        $result1 = mysqli_query($conn, $query1);

        // Fetch the last ID from the second query
        $query2 = "SELECT id FROM o_driver ORDER BY id DESC LIMIT 1";
        $result2 = mysqli_query($conn, $query2);

        // Initialize total variable
        $total = 0;

        // Check if any row is returned for the first query
        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $lastId1 = $row1["id"];

            $total += $lastId1;
        } else {
            echo "<p>No records found for the first query.</p>";
        }

        // Check if any row is returned for the second query
        if (mysqli_num_rows($result2) > 0) {
            $row2 = mysqli_fetch_assoc($result2);
            $lastId2 = $row2["id"];

            $total += $lastId2;
        } else {
            echo "<p>No records found for the second query.</p>";
        }

        // Display the total value
        echo '<div class="card card-driver radius-15">
                <div class="card-body">
                    <h5 class="mb-4">Total Driver</h5>
                    <p class="display-1 font-weight-bold">' . $total . '</p>
                </div>
            </div>';
        ?>
    </div>

    <div class="col-12 col-lg-4">
        <?php
        // Fetch the last ID from the database
        $query = "SELECT id FROM renewal_remainder ORDER BY id DESC LIMIT 1";
        $query_run = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
            $lastId = $row["id"];

            echo '<div class="card card-renewal radius-15">
                    <div class="card-body">
                        <h5 class="mb-4">Renewal Reminder</h5>
                        <p class="display-1 font-weight-bold">' . $lastId . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>

    <div class="col-12 col-lg-4">
        <?php
        // Fetch the last ID from the database
        $query = "SELECT id FROM service_entry ORDER BY id DESC LIMIT 1";
        $query_run = mysqli_query($conn, $query);

        // Check if any row is returned
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
            $lastId = $row["id"];

            echo '<div class="card card-service-entry radius-15">
                    <div class="card-body">
                        <h5 class="mb-4">Service Entry</h5>
                        <p class="display-1 font-weight-bold">' . $lastId . '</p>
                    </div>
                </div>';
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>
</div> -->

                <div class="card radius-15">
                    <div class="card-body">
                        
						<form action="controller/comment.php" method="POST" class="row g-3">
    <div class="col-md-6">
        <label for="Comment" class="form-label">Comment</label>
        <textarea class="form-control" name="Comment" placeholder="Enter your comment..."></textarea>
    </div>
    <div class="col-12">
        <button type="submit" name="upload" class="btn btn-primary px-5">Submit</button>
    </div>
</form>

<?php
    include_once "dbconn.php"; 

    // Fetch data from the database
    $query = "SELECT * FROM comments";
    $query_run = mysqli_query($conn, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($query_run) > 0) {
        echo '<table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Comment</th>
                    <th class="text-center">Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';

        // Output data for each row
        while ($row = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                <td>'.$row["Comment"].'</td>
                <td>
                    <button data-id="'.$row["id"].'" class="delete-button btn btn-danger" onclick="deleteRow(this)">Delete</button>
                </td>
                <td></td>
            </tr>';
        }

        echo '</tbody>
        </table>';
    }
?>








<script>
// function editRow(button) {
//   var row = button.parentNode.parentNode;
// //   var cells = row.getElementsByTagName("td");

// //   // Get the values from the row cells
// //   var Comment = cells[0].innerText;

// //   // Perform desired edit operations, such as updating a form with the values
//   console.log("Editing row: " + Comment);
// }


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
            xhr.open("POST", "controller/deleteCom.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("id=" + encodeURIComponent(id));}

</script>

                    </div>
                </div>
            </div>
            <!--end page-content-wrapper-->
        </div>
    </div>
</div>
		