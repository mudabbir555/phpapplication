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
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                                </div>
                                <h5 class="mb-0 text-primary"> Add Vehicle</h5>
                            </div>

                            <form action="controller/allvehicle.php" method="POST" class="row g-3" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <label for="vehicleName" class="form-label">Vehicle Name</label>
                                    <input type="text" class="form-control" name="vehicleName">
                                </div>
                                <div class="col-md-6">
                                    <label for="vehicleNumber" class="form-label">Vehicle Number</label>
                                    <input type="text" class="form-control" name="vehicleNumber">
                                </div>
                                <div class="col-md-6">
                                    <label for="engineNumber" class="form-label">Engine Number</label>
                                    <input type="text" class="form-control" name="engineNumber">
                                </div>
                                <div class="col-md-6">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" class="form-control" name="model">
                                </div>
                                <div class="col-md-6">
                                    <label for="chassisNumber" class="form-label">Chassis Number</label>
                                    <input type="text" class="form-control" name="chassisNumber">
                                </div>
                                <div class="col-md-6">
                                    <label for="yearOfManufacture" class="form-label">Year of Manufacture</label>
                                    <input type="text" class="form-control" name="yearOfManufacture">
                                </div>
                                <div class="col-md-6">
                                    <label for="color" class="form-label">Color</label>
                                    <input type="text" class="form-control" name="color">
                                </div>
                                <div class="col-md-6">
                                    <label for="fuelType" class="form-label">Fuel Type</label>
                                    <select class="form-select" name="fuelType">
                                        <option selected="">Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="fuelMeasurement" class="form-label">Fuel Measurement</label>
                                    <select class="form-select" name="fuelMeasurement">
                                        <option selected="">Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="trackUsage" class="form-label">Track Usage</label>
                                    <select class="form-select" name="trackUsage">
                                        <option selected="">Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="vehicleGroup" class="form-label">Vehicle Group</label>
                                    <select class="form-select" name="vehicleGroup">
                                        <option selected="">Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-secondaryMeter-label" for="secondaryMeter">Secondary meter</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="secondaryMeter" id="gridCheckYes" value="yes">
                                        <label class="form-check-label" for="gridCheckYes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="secondaryMeter" id="gridCheckNo" value="no">
                                        <label class="form-check-label" for="gridCheckNo">No</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="vehicleImage" class="form-label">Vehicle Image</label>
                                    <input class="form-control" type="file" name="vehicleImage">
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
    <!--end page-content-wrapper-->
</div>
