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
										<h5 class="mb-0 text-primary">User Registration</h5>
									</div>
									<hr>
									<form action="controller/Odriver.php" method="POST" class="row g-3"  enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <label for="Name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="EmployeeIdNumber" class="form-label">Employee Id Number</label>
                                    <input type="number" class="form-control" name="id_Number">
                                </div>
                                <div class="col-md-6">
                                    <label for="Phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" name="Phone">
                                </div>
                                <div class="col-12">
                                    <label for="PresentAddress" class="form-label">Present Address</label>
                                    <textarea class="form-control" placeholder="Address..." rows="3" name="Present_address"></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="PermanentAddress" class="form-label">Permanent Address</label>
                                    <textarea class="form-control" placeholder="Address 2..." rows="3" name="Permanent_address"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="image">
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
		