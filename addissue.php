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
										<h5 class="mb-0 text-primary"> Add issue</h5>
									</div>
									
									<form action="controller/issues.php" method="POST" class="row g-3" enctype="multipart/form-data">
    <div class="col-md-6">
        <label for="vehicle" class="form-label">Vehicle</label>
        <select id="vehicle" class="form-select" name="vehicle">
            <option selected>Choose...</option>
            <option>PRIME</option>
            <option>SEDAN</option>
            <option>SUV</option>
            <option>HATCHBACK</option>
            <option>TRUCK</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" placeholder="Description..." rows="3" name="description"></textarea>
    </div>
    <div class="col-md-6">
        <label for="priority" class="form-label">Priority</label>
        <select id="priority" class="form-select" name="priority">
            <option selected>Choose...</option>
            <option>...</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="file" class="form-label">File Upload</label>
        <input class="form-control" type="file" name="file">
    </div>
    <div class="col-md-6">
        <label for="assigned" class="form-label">Assigned</label>
        <input type="text" class="form-control" name="assigned">
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