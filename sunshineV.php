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
            <div>
			
                <div class="row">
    <div class="col-xl-7 mx-auto">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body p-5">
                <div class="card-title d-flex align-items-center">
                    <div>
                        <i class="bx bxs-user me-1 font-22 text-primary"></i>
                    </div>
                    <!-- <h5 class="mb-0 text-primary">Sunshine Vehicle Document</h5> -->
                </div>
                <hr>
                <form action="controller/sunshinevehicle.php" method="POST" class="row g-3" enctype="multipart/form-data">
                <div class="col-md-6">
        <label for="id_Number" class="form-label">ID</label>
        <input type="text" class="form-control" name="id_Number" required>
    </div>
    <div class="col-md-6">
        <label for="vehicleRc" class="form-label">Vehicle Rc</label>
        <input type="text" class="form-control" name="vehicleRc" required>
    </div>
    <div class="col-md-6">
        <label for="vehiclePermit" class="form-label">Vehicle Permit</label>
        <input type="text" class="form-control" name="vehiclePermit" required>
    </div>
    <div class="col-md-6">
        <label for="vehicleFitness" class="form-label">Vehicle Fitness</label>
        <input type="text" class="form-control" name="vehicleFitness" required>
    </div>
    <div class="col-md-6">
        <label for="vehicleInsurance" class="form-label">Vehicle Insurance</label>
        <input type="text" class="form-control" name="vehicleInsurance" required>
    </div>
    <div class="col-md-6">
        <label for="vehiclePUC" class="form-label">Vehicle PUC</label>
        <input type="text" class="form-control" name="vehiclePUC" required>
    </div>
    <div class="col-md-6">
        <label for="policeVerificationSticker" class="form-label">Police verification sticker</label>
        <input type="text" class="form-control" name="policeVerificationSticker" required>
    </div>
    <h6 class="mb-0 text-uppercase">Upload Vehicle Document</h6>
    <div class="mb-3">
        <label for="VRc" class="form-label">Vehicle RC</label>
        <input class="form-control" type="file" name="VRc" required>
    </div>
    <div class="mb-3">
        <label for="Vpermit" class="form-label">Vehicle Permit</label>
        <input class="form-control" type="file" name="Vpermit" required>
    </div>
    <div class="mb-3">
        <label for="Vfitness" class="form-label">Vehicle Fitness</label>
        <input class="form-control" type="file" name="Vfitness" required>
    </div>
    <div class="mb-3">
        <label for="Vinsurance" class="form-label">Vehicle Insurance</label>
        <input class="form-control" type="file" name="Vinsurance" required>
    </div>
    <div class="mb-3">
        <label for="Vpuc" class="form-label">Vehicle PUC</label>
        <input class="form-control" type="file" name="Vpuc" required>
    </div>
    <div class="mb-3">
        <label for="Vpvs" class="form-label">Police verification sticker</label>
        <input class="form-control" type="file" name="Vpvs" required>
    </div>
    <div class="col-12">
        <button type="submit" name="upload" class="btn btn-primary px-5">Submit</button>
    </div>
</form>

            </div>
        </div>
    </div>
</div>
		