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
    
    echo '<div>';
    echo '<a href="' . $imageSrc . '" download>';
    echo '<img src="' . $imageSrc . '" alt="Image" style="' . $style . '" onclick="enlargeImage(this)" class="enlarge-image">';
    echo '</a>';
    echo '</div>';
    
    unlink($tempFile);
}

function createPDF($fieldName, $fieldValue, $imageData, $pdfName)
{
    // Create a new PDF instance
    $pdf = new FPDF();

    // Add a new page to the PDF
    $pdf->AddPage();

    // Set the font size and style
    $pdf->SetFont('Arial', 'B', 16);

    // Output the field data in the PDF
    $pdf->Cell(40, 10, $fieldName . ': ' . $fieldValue);
    $pdf->Ln();

    // Output the image in the PDF
    if (!empty($imageData)) {
        // Convert BLOB data to image file
        $imagePath = $pdfName . '.jpg'; // Temporary file to store the image
        file_put_contents($imagePath, $imageData);

        // Add the image to the PDF
        $pdf->Image($imagePath, 10, 30, 80, 0);

        // Remove the temporary image file
        unlink($imagePath);

        $pdf->Ln();
    }

    // Save the PDF to a file
    $pdfFilename = $pdfName . '.pdf';
    $pdf->Output($pdfFilename, 'F');
    return $pdfFilename;
}

function downloadRow($row)
{
    // Create a temporary folder to store PDFs
    $tempFolder = 'temp_pdfs/';
    if (!file_exists($tempFolder)) {
        mkdir($tempFolder);
    }

    // Initialize the ZIP archive
    $zip = new ZipArchive();
    $zipFilename = 'vehicle_documents.zip';

    if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        die('Failed to create ZIP archive');
    }

    // Loop through the fields and create PDFs for each
    $fields = [
        'vehicleRc' => 'VRc',
        'vehiclePermit' => 'Vpermit',
        'vehicleFitness' => 'Vfitness',
        'vehicleInsurance' => 'Vinsurance',
        'vehiclePUC' => 'Vpuc',
        'policeVerificationSticker' => 'Vpvs'
    ];

    foreach ($fields as $fieldName => $pdfName) {
        $fieldValue = $row[$fieldName];
        $imageData = $row[$pdfName];
        $pdfFilename = createPDF($fieldName, $fieldValue, $imageData, $pdfName);

        // Add the PDF file to the ZIP archive
        $zip->addFile($pdfFilename, $pdfName . '.pdf');
    }

    // Close the ZIP archive
    $zip->close();

    // Set the appropriate headers to initiate the download
    header('Content-type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
    header('Content-Length: ' . filesize($zipFilename));

    // Read the ZIP file and output it to the browser
    readfile($zipFilename);

    // Clean up the temporary files and folder
    foreach (glob($tempFolder . '*.pdf') as $file) {
        unlink($file);
    }
    rmdir($tempFolder);
}

if (isset($_GET['row_id'])) {
    // Establish database connection
    // Replace the database credentials with your own

    $row_id = $_GET['row_id'];

    // Fetch the row data from the database
    $query = "SELECT * FROM o_vehicle WHERE id = '$row_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        downloadRow($row);
    } else {
        echo "Row not found.";
    }
}



?>
<?php include('sidebar2.php'); ?>
<?php include('footer.php'); ?>

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
                                    <h5>All Sunshine Vehicle</h5>
                                    <hr>
                                    <div class="table-responsive">
                                      

                                        <div class="table-responsive">
                                            <?php
                                            // Fetch data from the database
                                            $query = "SELECT * FROM o_vehicle";
                                            $query_run = mysqli_query($conn, $query);

                                            // Check if any rows are returned
                                            if (mysqli_num_rows($query_run) > 0) {
                                                echo '<table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">vehicle RC</th>
                                                                <th class="text-center">vehicle Permit</th>
                                                                <th class="text-center">vehicle Fitness</th>
                                                                <th class="text-center">vehicle Insurance</th>
                                                                <th class="text-center">vehicle PUC</th>
                                                                <th class="text-center">police Verification Sticker</th>
                                                                <th class="text-center">vehicleRC</th>
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
                                                            <td>' . $row["vehicleRc"] . '</td>
                                                            <td>' . $row["vehiclePermit"] . '</td>
                                                            <td>' . $row["vehicleFitness"] . '</td>
                                                            <td>' . $row["vehicleInsurance"] . '</td>
                                                            <td>' . $row["vehiclePUC"] . '</td>
                                                            <td>' . $row["policeVerificationSticker"] . '</td>
                                                            <td>';
                                                    displayImage($row["VRc"], '200px', '150px');
                                                    echo '</td>
                                                            <td>';
                                                    displayImage($row["Vpermit"], '200px', '150px');
                                                    echo '</td>
                                                            <td>';
                                                    displayImage($row["Vfitness"], '200px', '150px');
                                                    echo '</td>
                                                            <td>';
                                                    displayImage($row["Vinsurance"], '200px', '150px');
                                                    echo '</td>
                                                            <td>';
                                                    displayImage($row["Vpuc"], '200px', '150px');
                                                    echo '</td>
                                                            <td>';
                                                    displayImage($row["Vpvs"], '200px', '150px');
                                                    echo '</td>
                                                            <td>
                                                                <button class="edit-button" onclick="editRow(this)">Edit</button>
                                                                <button data-id="' . $row["id"] . '" class="delete-button" onclick="deleteRow(this)">Delete</button>
                                                                <button><a href="AOvehicle.php?row_id=' . $row["id"] . '" class="edit-button download-button">Download</a></button>
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
    <!--end page-content-wrapper-->
</div>
<style>
    .enlarged img {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 500%;
    }
</style>


<script>
function enlargeImage(image) {
        image.style.width = 'auto';
        image.style.height = '500%';
    }
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
        window.location.href = "Ovehicle.php"; // Replace "sunshineD.php" with the correct form file name
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
        xhr.open("POST", "controller/deleteOV.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("id=" + encodeURIComponent(id));
    }

</script>
