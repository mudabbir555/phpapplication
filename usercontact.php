<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
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
                <div class="col-xl-7 mx-auto">

                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h5>All Comments</h5>
                                    <hr>
                                    <div class="table-responsive">
                                        <?php
                                        include_once "dbconn.php";

                                        // Fetch data from the database
                                        $query = "SELECT * FROM comment_db";
                                        $query_run = mysqli_query($conn, $query);

                                        // Check if any rows are returned
                                        if (mysqli_num_rows($query_run) > 0) {
                                            echo '<table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Email</th>
                                                        <th class="text-center">Phone</th>
                                                        <th class="text-center">Message</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';

                                            // Output data for each row
                                            while ($row = mysqli_fetch_assoc($query_run)) {
                                                echo '<tr>
                                                    <td class="text-center">' . $row["Name"] . '</td>
                                                    <td class="text-center">' . $row["Email"] . '</td>
                                                    <td class="text-center">' . $row["Phone"] . '</td>
                                                    <td class="text-center">' . $row["MSG"] . '</td>
                                                    <td class="text-center">
                                                        <button data-id="' . $row["id"] . '" class="delete-button" onclick="deleteRow(this)">Delete</button>
                                                    </td>
                                                </tr>';
                                            }

                                            echo '</tbody></table>';
                                        } else {
                                            echo "<p>No records found.</p>";
                                        }

                                        // Delete row
                                        if (isset($_POST['delete_id'])) {
                                            $delete_id = $_POST['delete_id'];
                                            $delete_query = "DELETE FROM comment_db WHERE id = $delete_id";
                                            $delete_result = mysqli_query($conn, $delete_query);

                                            if ($delete_result) {
                                                echo '<script>alert("Row deleted successfully.");</script>';
                                                echo '<script>window.location.href = "usercontact.php";</script>';
                                            } else {
                                                echo '<script>alert("Failed to delete row. Please try again.");</script>';
                                            }
                                        }
                                        ?>

                                        <script>
                                            // Delete row function
                                            function deleteRow(button) {
                                                var delete_id = button.getAttribute("data-id");

                                                if (confirm("Are you sure you want to delete this row?")) {
                                                    // Create a hidden form and submit it to perform the delete action
                                                    var form = document.createElement("form");
                                                    form.method = "post";
                                                    form.action = "";
                                                    form.style.display = "none";

                                                    var input = document.createElement("input");
                                                    input.type = "hidden";
                                                    input.name = "delete_id";
                                                    input.value = delete_id;

                                                    form.appendChild(input);
                                                    document.body.appendChild(form);

                                                    form.submit();
                                                }
                                            }
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
</div>
