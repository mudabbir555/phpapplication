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
    $style = '';
    if ($width !== null) {
        $style .= 'width: ' . $width . ';';
    }
    if ($height !== null) {
        $style .= 'height: ' . $height . ';';
    }

    // Check if the image data is not empty
    if (!empty($imageData)) {
        // Display the image
        echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Image" style="' . $style . '">';
    } else {
        echo 'No image available.';
    }
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
    $pdf->Cell(40, 10, 'vehicleName: ' . $row['vehicleName']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'vehicleNumber: ' . $row['vehicleNumber']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'engineNumber: ' . $row['engineNumber']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'model: ' . $row['model']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'chassisNumber : ' . $row['chassisNumber']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'yearOfManufacture : ' . $row['yearOfManufacture']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'color : ' . $row['color']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'fuelType : ' . $row['fuelType']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'fuelMeasurement : ' . $row['fuelMeasurement']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'trackUsage : ' . $row['trackUsage']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'vehicleGroup : ' . $row['vehicleGroup']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'secondaryMeter : ' . $row['secondaryMeter']);
    $pdf->Ln();

    // Check if the image BLOB data is not empty
    $imageData = $row['vehicleImage'];
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
    } else {
        $pdf->Cell(40, 10, 'No image available');
        $pdf->Ln();
    }

    $filename = 'table_data.pdf';
    $pdf->Output('F', $filename);

    return $filename;
}

if (isset($_GET['row_id'])) {
    $rowId = $_GET['row_id'];

    // Fetch the row data from the database
    $query = "SELECT * FROM add_vehicle WHERE id = '$rowId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $filename = downloadRow($row, $conn);

        // Set the appropriate headers to initiate the download
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($filename));

        readfile($filename);
        exit;
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
                                    <h5> All vehicle</h5>
                                    <hr>
                                    <div class="table-responsive">
                                        <?php
                                        include_once "dbconn.php";

                                        // Fetch data from the database
                                        $query = "SELECT * FROM add_vehicle";
                                        $result = mysqli_query($conn, $query);

                                        // Check if any rows are returned
                                       // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table">
            <thead>
                <tr>
                    <th class="text-center">Vehicle Name</th>
                    <th class="text-center">Vehicle Number</th>
                    <th class="text-center">Engine Number</th>
                    <th class="text-center">Model</th>
                    <th class="text-center">Chassis Number</th>
                    <th class="text-center">Year of Manufacture</th>
                    <th class="text-center">Color</th>
                    <th class="text-center">Fuel Type</th>
                    <th class="text-center">Fuel Measurement</th>
                    <th class="text-center">Track Usage</th>
                    <th class="text-center">Vehicle Group</th>
                    <th class="text-center">Secondary Meter</th>
                    <th class="text-center">Vehicle Image</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>';

        // Output data for each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>'.$row["vehicleName"].'</td>
                    <td>'.$row["vehicleNumber"].'</td>
                    <td>'.$row["engineNumber"].'</td>
                    <td>'.$row["model"].'</td>
                    <td>'.$row["chassisNumber"].'</td>
                    <td>'.$row["yearOfManufacture"].'</td>
                    <td>'.$row["color"].'</td>
                    <td>'.$row["fuelType"].'</td>
                    <td>'.$row["fuelMeasurement"].'</td>
                    <td>'.$row["trackUsage"].'</td>
                    <td>'.$row["vehicleGroup"].'</td>
                    <td>'.$row["secondaryMeter"].'</td>

                                                <td>';
                                                displayImage($row['vehicleImage'], '200px', '150px');
                                                echo '</td>
                                                <td>
                                                    <button class="edit-button" onclick="editRow(this)">Edit</button>
                                                    <button data-id="' . $row["id"] . '" class="delete-button" onclick="deleteRow(this)">Delete</button>
                                                    <button><a href="myvehicle.php?row_id=' . $row["id"] . '" class="edit-button download-button">Download</a></button>
                                                </td>
                                            </tr>';
                                            }

                                            echo '</tbody>
                                                </table>';
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
        var vehicleName = cells[0].innerText;
        var vehicleNumber = cells[1].innerText;
        var engineNumber = cells[2].innerText;
        var model = cells[3].innerText;
        var yearOfManufacture = cells[4].innerText;
        var color = cells[5].innerText;
        var fuelType = cells[6].innerText;
        var fuelMeasurement = cells[7].innerText;
        var trackUsage = cells[8].innerText;
        var vehicleGroup = cells[9].innerText;
        var secondaryMeter = cells[10].innerText;

        // Perform desired edit operations, such as updating a form with the values
        console.log("Editing row: " + vehicleName + " - " + vehicleNumber + " - " + engineNumber + "\nModel: " + model + "\nYear of Manufacture: " + yearOfManufacture + "\nColor: " + color + "\nFuel Type: " + fuelType + "\nFuel Measurement: " + fuelMeasurement + "\nTrack Usage: " + trackUsage);
        window.location.href = "addvehicle.php"; // Replace "addvehicle.php" with the correct form file name
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
                        xhr.open("POST", "controller/allvehicle.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("id=" + encodeURIComponent(id));
                    }

</script>
