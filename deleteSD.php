<?php
include_once "dbconn.php";

// Check if the ID parameter is provided
if (isset($_POST['id'])) {
    // Retrieve the ID value
    $id = $_POST['id'];

    // Establish database connection
    // $conn = mysqli_connect('localhost', 'username', 'password', 'database');

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement
    $query = "DELETE FROM sunshine_d WHERE id = '$id'";

    // Execute the statement
    $query_run = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($query_run) {
        echo "Row deleted successfully";
    } else {
        echo "Failed to delete the row";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
