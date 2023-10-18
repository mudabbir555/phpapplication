<?php
include_once "dbconn.php";
require_once('fpdf/fpdf.php');
include('sidebar2.php');
include('footer.php');

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

if (isset($_GET['id_Number'])) {
    $id_Number = $_GET['id_Number'];

    // Fetch data for the given employee ID from the sunshine_d table
    $query1 = "SELECT * FROM sunshine_d WHERE id_Number = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param('s', $id_Number);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    // Fetch data for the given employee ID from the sunshine_vehicle table
    $query2 = "SELECT * FROM sunshine_vehicle WHERE id_Number = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('s', $id_Number);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
}
?>

<div class="page-content">
    <div class="page-content-wrapper">
        <div class="page-content">
         
            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body">
                            <?php
                            if (isset($_GET['id_Number'])) {
                                $id_Number = $_GET['id_Number'];

                                // Query to fetch employee data based on ID
                                $query = "SELECT * FROM sunshine_d WHERE id_Number = '$id_Number'";
                                $query_run = mysqli_query($conn, $query);

                                // Query to fetch vehicle data based on ID
                                $vehicle_query = "SELECT * FROM sunshine_vehicle WHERE id_Number = '$id_Number'";
                                $vehicle_query_run = mysqli_query($conn, $vehicle_query);

                                if (mysqli_num_rows($query_run) > 0 || mysqli_num_rows($vehicle_query_run) > 0) {
                                    echo '<div>
                                        <h5>Employee Data</h5>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">ID Number</th>
                                                        <th class="text-center">Phone</th>
                                                        <th class="text-center">Present Address</th>
                                                        <th class="text-center">Permanent Address</th>
                                                        <th class="text-center">Image</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';

                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        echo '<tr>
                                                <td>' . $row["Name"] . '</td>
                                                <td>' . $row["id_Number"] . '</td>
                                                <td>' . $row["Phone"] . '</td>
                                                <td>' . $row["Present_address"] . '</td>
                                                <td>' . $row["Permanent_address"] . '</td>
                                                <td>';
                                        displayImage($row["image"], '200px', '150px');
                                        echo '</td>
                                            </tr>';
                                    }

                                    echo '</tbody>
                                        </table>
                                    </div>
                                </div>';
                                } else {
                                    echo "<p>No employee found with the provided ID.</p>";
                                }
                            }
                            ?>

                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['id_Number'])) {
                                    $id_Number = $_GET['id_Number'];

                                    $query = "SELECT * FROM sunshine_vehicle WHERE id_Number = '$id_Number'";
                                    $query_run = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($query_run) > 0) {
                                        echo '<table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">vehicle RC</th>
                                                        <th class="text-center">vehicle Permit</th>
                                                        <th class="text-center">vehicle Fitness</th>
                                                        <th class="text-center">vehicle Insurance</th>
                                                        <th class="text-center">vehicle PUC</th>
                                                        <th class="textcenter">police Verification Sticker</th>
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
                                                    </td>
                                                </tr>';
                                        }

                                        echo '</tbody>
                                            </table>
                                        </div>
                                    </div>';
                                    } else {
                                        echo "<p>No vehicle found with the provided ID.</p>";
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
