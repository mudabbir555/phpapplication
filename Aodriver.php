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
include_once "dbconn.php";
require_once('fpdf/fpdf.php');

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
function downloadRow($row, $conn)
{
    // Create a new PDF instance
    $pdf = new FPDF();

    // Add a new page to the PDF
    $pdf->AddPage();

    // Set the font size and style
    $pdf->SetFont('Arial', 'B', 16);

    // Output the row data in the PDF
    $pdf->Cell(40, 10, 'Name: ' . $row['Name']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'ID Number: ' . $row['id_Number']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Phone: ' . $row['Phone']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Present Address: ' . $row['Present_address']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Permanent Address: ' . $row['Permanent_address']);
    $pdf->Ln();

    // Check if the image BLOB data is not empty
    $imageData = $row['image'];
    if (!empty($imageData)) {
        // Create a temporary file path with a .jpg extension
        $tempFile = tempnam(sys_get_temp_dir(), 'image') . '.jpg';

        // Write the image data to the temporary file
        file_put_contents($tempFile, $imageData);

        // Load the image and convert it to a JPEG format
        $image = imagecreatefromstring($imageData);
        imagejpeg($image, $tempFile, 100);

        // Get the image dimensions
        $imageInfo = getimagesize($tempFile);
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];

        // Load the converted image and place it in the PDF
        $pdf->Image($tempFile, $pdf->GetX(), $pdf->GetY(), 100, 100);

        // Delete the temporary file
        unlink($tempFile);
    }

    $filename = 'table_data.pdf';
    $pdf->Output('F', $filename);

    // Set the appropriate headers to initiate the download
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
    exit;
}


if (isset($_GET['row_id'])) {
    $rowId = $_GET['row_id'];

    // Fetch the row data from the database
    $query = "SELECT * FROM o_driver WHERE id = '$rowId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        downloadRow($row, $conn);
    } else {
        echo "Row not found.";
    }
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
                                    <h5> Driver</h5>
                                    <hr>
                                    <div class="table-responsive">
                                        <?php
                                        // Fetch data from the database
                                        
                                        $query = "SELECT * FROM o_driver";
                                        $result = mysqli_query($conn, $query);
                                        $row = mysqli_fetch_assoc($result);


                                        // Check if any rows are returned
                                        if (mysqli_num_rows($result) > 0) {
                                            echo '<table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Id_Number</th>
                                                    <th class="text-center">Phone</th>
                                                    <th class="text-center">Present_address</th>
                                                    <th class="text-center">Permanent_address</th>
                                                    <th class="text-center">Image</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                                            // Output data for each row
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>
                                                    <td>' . $row["Name"] . '</td>
                                                    <td>' . $row["id_Number"] . '</td>
                                                    <td>' . $row["Phone"] . '</td>
                                                    <td>' . $row["Present_address"] . '</td>
                                                    <td>' . $row["Permanent_address"] . '</td>
                                                    <td>';
                                                displayImage($row["image"], '200px', '150px');
                                                echo '</td>
                                                    <td>
                                                        <button class="edit-button" onclick="editRow(this)">Edit</button>
                                                        <button data-id="' . $row["id"] . '" class="delete-button" onclick="deleteRow(this)">Delete</button>
                                                        <button><a href="Aodriver.php?row_id=' . $row["id"] . '" class="edit-button download-button">Download</a></button>
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
        var image = cells[5].getElementsByTagName("img")[0].src;

        // Perform desired edit operations, such as updating a form with the values
        console.log("Editing row: " + name + " - " + idNumber + " - " + phone + "\nPresent Address: " + presentAddress + "\nPermanent Address: " + permanentAddress + "\nImage: " + image);
        window.location.href = "sunshineD.php";
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
        xhr.open("POST", "controller/deleteSD.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("id=" + encodeURIComponent(id));
    }
</script>
