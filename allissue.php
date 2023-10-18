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
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h5>All Issues </h5>
                                    <hr>
                                    <div class="table-responsive" >
                                        <?php
                                        include_once "dbconn.php";
                                        require_once('fpdf/fpdf.php');

                                        // Function to display the image
                                        function displayImage($imageData, $width = null, $height = null)
{
    $tempFile = tempnam(sys_get_temp_dir(), 'image');
    file_put_contents($tempFile, $imageData);
    $imageInfo = getimagesize($tempFile);

    $base64Data = base64_encode($imageData);
    $imageSrc = 'data:' . $imageInfo['mime'] . ';base64,' . $base64Data;
    
    $style = '';
    if ($width !== null) {
        $style .= 'width: ' . $width . ';';
    }
    if ($height !== null) {
        $style .= 'height: ' . $height . ';';
    }

    echo '<img src="' . $imageSrc . '" alt="Image" style="' . $style . '">';
    unlink($tempFile);
}
                                        // Function to download the row as a PDF
                                        function downloadRow($row)
                                        {
                                            // Create a new PDF instance
                                            $pdf = new FPDF();

                                            // Add a new page to the PDF
                                            $pdf->AddPage();

                                            // Set the font size and style
                                            $pdf->SetFont('Arial', 'B', 16);

                                            // Output the row data in the PDF
                                            $pdf->Cell(40, 10, 'Vehicle: ' . $row['vehicle']);
                                            $pdf->Ln();
                                            $pdf->Cell(40, 10, 'Title: ' . $row['title']);
                                            $pdf->Ln();
                                            $pdf->Cell(40, 10, 'Description: ' . $row['description']);
                                            $pdf->Ln();
                                            $pdf->Cell(40, 10, 'Priority: ' . $row['priority']);
                                            $pdf->Ln();
                                            $pdf->Cell(40, 10, 'file: ' . $row['file']);
                                            $pdf->Ln();
                                            $pdf->Cell(40, 10, 'Assigned: ' . $row['assigned']);
                                            $pdf->Ln();

                                            // Output the PDF to the browser
                                            $pdf->Output('row.pdf', 'F');
                                        }

                                        // Fetch data from the database
                                        $query = "SELECT * FROM add_issue";
                                        $query_run = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($query_run) > 0) {
                                            echo '<table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">vehicle</th>
                                                    <th class="text-center">title</th>
                                                    <th class="text-center">description</th>
                                                    <th class="text-center">priority</th>
                                                    <th class="text-center">file</th>
                                                    <th class="text-center">assigned</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody >';

                                            // Output data for each row
                                          // Output data for each row
while ($row = mysqli_fetch_assoc($query_run)) {
    echo '<tr>
        <td>' . $row["vehicle"] . '</td>
        <td>' . $row["title"] . '</td>
        <td>' . $row["description"] . '</td>
        <td>' . $row["priority"] . '</td>
        <td>';
    displayImage($row["file"], '200px', '150px');
    echo '</td>
        <td>' . $row["assigned"] . '</td>
        <td>
            <button class="edit-button" onclick="editRow(this)">Edit</button>
            <button data-id="' . $row["id"] . '" class="delete-button" onclick="deleteRow(this)">Delete</button>
            <button><a href="download.php?row_id=' . $row["id"] . '" class="edit-button download-button">Download</a></button>
        </td>
    </tr>';
}


                                            echo '</tbody></table>';
                                        } else {
                                            echo "<p>No records found.</p>";
                                        }

                                        // Check if a row download is requested
                                        if (isset($_GET['row_id'])) {
                                            $row_id = $_GET['row_id'];

                                            // Fetch the row data from the database
                                            $query = "SELECT * FROM add_issue WHERE id = '$row_id'";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);

                                            // Download the row data
                                            if ($row) {
                                                downloadRow($row);
                                                exit;
                                            } else {
                                                echo "Row not found.";
                                            }
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
    <!--end page-content-wrapper-->
</div>

<script>
    function editRow(button) {
        var row = button.parentNode.parentNode;
        var cells = row.getElementsByTagName("td");

        // Get the values from the row cells
        var vehicle = cells[0].innerText;
        var title = cells[1].innerText;
        var description = cells[2].innerText;
        var priority = cells[3].innerText;
        var file = cells[4].innerText;
        var assigned = cells[5].innerText;

        // Perform desired edit operations, such as updating a form with the values
        console.log("Editing row: " + vehicle + " - " + title + "\nDescription: " + description + "\nPriority: " + priority + "\nFile: " + file + "\nAssigned: " + assigned);
        window.location.href = "addissue.php"; // Replace "addvehicle.php" with the correct form file name
    }

    function deleteRow(button) {
        var row = button.parentNode.parentNode;
        var id = button.getAttribute("data-id");

        // Perform AJAX request to delete the row from the database
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Row deleted successfully, you can perform any additional actions here
                row.remove();
            }
        };
        xhr.open("POST", "controller/deleteISU.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("id=" + encodeURIComponent(id));
    }
</script>
