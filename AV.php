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

// Check if the form is submitted
if (isset($_POST['upload'])) {
    if (isset($_POST['vehicleGroup'])) {
        $selectedOption = $_POST['vehicleGroup'];
        // Check the selected option and handle the form data accordingly
        if ($selectedOption == 'sunshine_vehicle') {
            // Process the form data for sunshine_vehicle
            // Example: Save the data into the sunshine_vehicle table in the database
            // Your code here...
            echo "Form data for sunshine_vehicle submitted!";
        } elseif ($selectedOption == 'other_vehicle') {
            // Process the form data for other_vehicle
            // Example: Save the data into the other_vehicle table in the database
            // Your code here...
            echo "Form data for other_vehicle submitted!";
        } else {
            // Invalid option selected
            // Handle the error here if needed
        }
    } else {
        // Handle the case when vehicleGroup is not set
        // Handle the error here if needed
    }
}
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
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                                </div>
                                <h5 class="mb-0 text-primary"> Add Vehicle</h5>
                            </div>
                            <form action="controller/sunshinevehicle.php" method="POST" class="row g-3" enctype="multipart/form-data">
                                
                                <div class="col-md-6">
                                    <label for="id_Number" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="id_Number">
                                </div>
                                <div class="col-md-6">
                                    <label for="vehicleRc" class="form-label">Vehicle Rc</label>
                                    <input type="text" class="form-control" name="vehicleRc">
                                </div>
                                <div class="col-md-6">
                                    <label for="vehiclePermit" class="form-label">Vehicle Permit</label>
                                    <input type="text" class="form-control" name="vehiclePermit">
                                </div>
                                <div class="col-md-6">
                                    <label for="vehicleFitness" class="form-label">Vehicle Fitness</label>
                                    <input type="text" class="form-control" name="vehicleFitness">
                                </div>
                                <div class="col-md-6">
                                    <label for="vehicleInsurance" class="form-label">Vehicle Insurance</label>
                                    <input type="text" class="form-control" name="vehicleInsurance">
                                </div>
                                <div class="col-md-6">
                                    <label for="vehiclePUC" class="form-label">Vehicle PUC</label>
                                    <input type="text" class="form-control" name="vehiclePUC">
                                </div>
                                <div class="col-md-6">
                                    <label for="policeVerificationSticker" class="form-label">Police verification sticker</label>
                                    <input type="text" class="form-control" name="policeVerificationSticker">
                                </div>
                                <h6 class="mb-0 text-uppercase">Upload Vehicle Document</h6>
                                <div class="mb-3">
                                    <label for="VRc" class="form-label">Vehicle RC</label>
                                    <input class="form-control" type="file" name="VRc">
                                </div>
                                <div class="mb-3">
                                    <label for="Vpermit" class="form-label">Vehicle Permit</label>
                                    <input class="form-control" type="file" name="Vpermit">
                                </div>
                                <div class="mb-3">
                                    <label for="Vfitness" class="form-label">Vehicle Fitness</label>
                                    <input class="form-control" type="file" name="Vfitness">
                                </div>
                                <div class="mb-3">
                                    <label for="Vinsurance" class="form-label">Vehicle Insurance</label>
                                    <input class="form-control" type="file" name="Vinsurance">
                                </div>
                                <div class="mb-3">
                                    <label for="Vpuc" class="form-label">Vehicle PUC</label>
                                    <input class="form-control" type="file" name="Vpuc">
                                </div>
                                <div class="mb-3">
                                    <label for="Vpvs" class="form-label">Police verification sticker</label>
                                    <input class="form-control" type="file" name="Vpvs">
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="upload" class="btn btn-primary px-5">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
