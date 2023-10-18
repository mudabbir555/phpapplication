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
						<div class="col-xl-7 mx-auto">
							
							<div class="card border-top border-0 border-4 border-primary">
								<div class="card-body p-5">
									<div class="card-title d-flex align-items-center">
										<div><i class="bx bxs-user me-1 font-22 text-primary"></i>
										</div>
										<h5 class="mb-0 text-primary"> Fuel Entry</h5>
									</div>									
									<form action="controller/fuelentry.php" method="POST" class="row g-3" enctype="multipart/form-data">		
    <div class="col-md-6">
        <label for="Vehicle" class="form-label">Vehicle</label>
        <select id="vehicle" class="form-select" name="Vehicle">
            <option selected>Choose...</option>
            <option>PRIME</option>
            <option>SEDAN</option>
            <option>SUV</option>
            <option>HATCHBACK</option>
            <option>TRUCK</option>
            <option>OTHER</option>
        </select>							
    </div>		    
    <div class="col-md-6">
        <label for="Date" class="form-label">Date On</label>
        <input type="date" name="Date" class="form-control">
    </div>                                    
    <div class="col-md-6">
        <label for="Odometer" class="form-label">Odometer</label>
        <input type="text" name="Odometer" class="form-control">
    </div>
    <div class="col-12">
        <label class="form-check-label" for="gridCheck">Partial Fuel entry</label>
        <div class="form-check">                                            
            <input class="form-check-input" type="radio" name="Fuel_entry" value="yes">
            <label class="form-check-label" for="gridCheckYes">Yes</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="Fuel_entry" value="no">
            <label class="form-check-label" for="gridCheckNo">No</label>
        </div>
    </div>
    <div class="col-md-6">
        <label for="Price" class="form-label">Price/Unit</label>
        <input type="text" name="Price" class="form-control">
    </div>
    <div class="col-md-6">
        <label for="Vendor" class="form-label">Vendor</label>
        <select name="Vendor" class="form-select">
            <option selected="">Choose...</option>
            <option>...</option>
        </select>								
    </div>
    <div class="col-md-6">
        <label for="Invoice" class="form-label">Invoice</label>
        <input type="file" name="Invoice" class="form-control" multiple="">
    </div> 
    <div class="col-12">
        <button type="submit"name="upload" class="btn btn-primary px-5">Register</button>
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