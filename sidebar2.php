<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sunshine Transworld</title>
	
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Roboto&display=swap" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="assets/css/icons.css" />
	<!-- App CSS -->
	<link rel="stylesheet" href="assets/css/app.css" />
	<link rel="stylesheet" href="assets/css/dark-sidebar.css" />
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
	<div class="sidebar-wrapper" data-simplebar="true">
		<div class="sidebar-header">
				<div class="">
				<img src="assets/images/logo.jpg" class="logo-icon-2" alt="" />
				</div>
				<div>
					<h4 class="logo-text">Sunshine</h4>
				</div>
				<a href="javascript:;" class="toggle-btn ms-auto"> <i class="bx bx-menu"></i>
				</a>
			</div>
			<!--navigation-->
			<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('dbconn.php');

$role = ''; // Initialize role variable

if (isset($_SESSION['EmailAddress'])) {
    $email = mysqli_real_escape_string($conn, $_SESSION['EmailAddress']);
    
    // Check user_login table
    $query = "SELECT * FROM user_login WHERE EmailAddress=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // User exists in user_login table, grant login access
        // Redirect or perform necessary actions
    } else {
        // User not found in user_login table, check other tables
        $query = "SELECT * FROM client_login WHERE EmailAddress=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // User exists in client_login table, grant login access
            // Redirect or perform necessary actions
        } else {
            $query = "SELECT * FROM driver_login WHERE EmailAddress=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                // User exists in driver_login table, grant login access
                // Redirect or perform necessary actions
            } else {
                // User not found in any login table, handle the case accordingly
            }
        }
    }
}

?>


<ul>
<?php
if (isset($_SESSION['EmailAddress'])) {
    $email = mysqli_real_escape_string($conn, $_SESSION['EmailAddress']);
    $role = '';

    // Query user_login table
    $query = "SELECT * FROM user_login WHERE EmailAddress=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $role = $row['role'];
    }

    if ($role === '') {
        // Query client_login table
        $query = "SELECT * FROM client_login WHERE EmailAddress=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $role = 'client'; // Set role to 'client' if found in client_login table
        }
    }

    if ($role === '') {
        // Query driver_login table
        $query = "SELECT * FROM driver_login WHERE EmailAddress=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $role = 'driver'; // Set role to 'driver' if found in driver_login table
        }
    }

    if ($role === 'client') { ?>
        
<ul class="metismenu" id="menu">
            <li>
                <a class="#" href="index.php">
                    <div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="client_profile.php">
                    <div class="parent-icon icon-color-4"><i class="bx bx-user-circle"></i></div>
                    <div class="menu-title">User Profile</div>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="#">
                    <div class="parent-icon icon-color-6"><i class="bx bx-error"></i></div>
                    <div class="menu-title">Issue</div>
                </a>
                <ul>
                    <li><a href="addissue.php"><i class="bx bx-right-arrow-alt"></i>Add Issue</a></li>
                    <li><a href="allissue.php"><i class="bx bx-right-arrow-alt"></i>Issues</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="#">
                    <div class="parent-icon icon-color-12"><i class="bx bx-user-circle"></i></div>
                    <div class="menu-title">Reminder</div>
                </a>
                <ul>
                    <li><a href="setremainder.php"><i class="bx bx-right-arrow-alt"></i>Set Reminder</a></li>
                    <li><a href="serviceremainder.php"><i class="bx bx-right-arrow-alt"></i>Service Reminder</a></li>
                </ul>
            </li>
            <li class="menu-label">Contact</li>
            <li>
                <a class="#" href="contact.php">
                    <div class="parent-icon icon-color-5"><i class="bx bx-support"></i></div>
                    <div class="menu-title">Contact</div>
                </a>
            </li>
 </ul>
    <?php } elseif ($role === 'admin') { ?>
<ul class="metismenu" id="menu">
	<li>
	<a class="#" href="index2.php">
			<div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i></div>
			<div class="menu-title" >Dashboard</div>

	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-12"><i class="bx bx-user"></i></div>
			<div class="menu-title">Add User</div>
		</a>
		<ul>
			<li><a href="csignup.php"><i class="bx bx-right-arrow-alt"></i> Client </a></li>
			<li><a href="csignup.php"><i class="bx bx-right-arrow-alt"></i> Driver</a></li>
		</ul>
	</li>
	
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-11"><i class="bx bx-car"></i></div>
			<div class="menu-title">Sunshine Vehicle</div>
		</a>
		<ul>
			<li><a href="sunshineV.php"><i class="bx bx-right-arrow-alt"></i>Sunshine Vehicle</a></li>
			<li><a href="AsunshineV.php"><i class="bx bx-right-arrow-alt"></i>All Sunshine Vehicle</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-11"><i class="bx bx-user"></i></div>
			<div class="menu-title">Sunshine Driver</div>
		</a>
		<ul>
			<li><a href="sunshineD.php"><i class="bx bx-right-arrow-alt"></i>Sunshine Driver</a></li>
			<li><a href="AsunshineD.php"><i class="bx bx-right-arrow-alt"></i>All Sunshine Driver</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-9"><i class="bx bx-car"></i></div>
			<div class="menu-title">Other Vehicle</div>
		</a>
		<ul>
			<li><a href="Ovehicle.php"><i class="bx bx-right-arrow-alt"></i>Other Vehicle</a></li>
			<li><a href="AOvehicle.php"><i class="bx bx-right-arrow-alt"></i>All Other Vehicle</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-9"><i class="bx bx-user"></i></div>
			<div class="menu-title">Other Driver</div>
		</a>
		<ul>
			<li><a href="odriver.php"><i class="bx bx-right-arrow-alt"></i>Other Driver</a></li>
			<li><a href="Aodriver.php"><i class="bx bx-right-arrow-alt"></i>All Other Driver</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-4"><i class="bx bx-water"></i></div>
			<div class="menu-title">Fuel</div>
		</a>
		<ul>
			<li><a href="fuelentry.php"><i class="bx bx-right-arrow-alt"></i>Fuel entries</a></li>
			<li><a href="fuelentered.php"><i class="bx bx-right-arrow-alt"></i> Fuel Details</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-3"><i class="bx bx-car"></i></div>
			<div class="menu-title">Vehicle</div>
		</a>
		<ul>
		<li>
			<a href="AV.php"><i class="bx bx-right-arrow-alt"></i>Add Vehicle</a></li>
			<li><a href="addvehicle.php"><i class="bx bx-right-arrow-alt"></i>Add Vehicle</a></li>
			<li><a href="myvehicle.php"><i class="bx bx-right-arrow-alt"></i>My vehicles</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-6"><i class="bx bx-error"></i></div>
			<div class="menu-title">Issue</div>
		</a>
		<ul>
			<li><a href="addissue.php"><i class="bx bx-right-arrow-alt"></i>Add Issue</a></li>
			<li><a href="allissue.php"><i class="bx bx-right-arrow-alt"></i>Issues</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-12"><i class="bx bx-user-circle"></i></div>
			<div class="menu-title">Service entry</div>
		</a>
		<ul>
			<li><a href="serviceentry.php"><i class="bx bx-right-arrow-alt"></i>Issue</a></li>
			<li><a href="fuelhistory.php"><i class="bx bx-right-arrow-alt"></i>Fuel entries</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-12"><i class="bx bx-user-circle"></i></div>
			<div class="menu-title">Remainder</div>
		</a>
		<ul>
			<li><a href="setremainder.php"><i class="bx bx-right-arrow-alt"></i>Set Remainder</a></li>
			<li><a href="serviceremainder.php"><i class="bx bx-right-arrow-alt"></i>Service Remainder</a></li>
		</ul>
	</li>
	
	<li class="menu-label">Contact </li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-5"><i class="bx bx-support"></i></div>
			<div class="menu-title">Contact</div>
		</a>
		<ul>
			<li><a href="usercontact.php"><i class="bx bx-right-arrow-alt"></i>Admin</a></li>
		</ul>
	</li>
</ul>    <?php } elseif ($role === 'driver') { ?>
	<ul class="metismenu" id="menu">
    	<li>
        	<a class="#" href="index3.php">
    			<div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i></div>
    			<div class="menu-title" >Dashboard</div>
        	</a>

	</li>
    <li>
			<a href="client_profile.php">
					<div class="parent-icon icon-color-4"><i class="bx bx-user-circle"></i>
					</div>
					<div class="menu-title">User Profile</div>
					</a>    
	</li>
    <li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-4"><i class="bx bx-water"></i></div>
			<div class="menu-title">Fuel</div>
		</a>
		<ul>
			<li><a href="fuelentry.php"><i class="bx bx-right-arrow-alt"></i>Fuel entries</a></li>
			<li><a href="fuelentered.php"><i class="bx bx-right-arrow-alt"></i> Fuel history</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-6"><i class="bx bx-error"></i></div>
			<div class="menu-title">Issue</div>
		</a>
		<ul>
			<li><a href="addissue.php"><i class="bx bx-right-arrow-alt"></i>Add Issue</a></li>
			<li><a href="allissue.php"><i class="bx bx-right-arrow-alt"></i>Issues</a></li>
		</ul>
	</li>
	<li>
		<a class="#" href="trips.php">
			<div class="parent-icon icon-color-3"><i class="bx bx-box"></i></div>
			<div class="menu-title">Trips</div>
		</a>
		
	</li>	
	<li class="menu-label">Driver Details</li>
	<li>
		<a class="has-arrow" href="#">
			<div class="parent-icon icon-color-12"><i class="bx bx-user-circle"></i></div>
			<div class="menu-title">Driver & Vehicle</div>
		</a>
		<ul>
		<li><a href="assignedD.php"><i class="bx bx-right-arrow-alt"></i>Driver </a></li>
		</ul>
	</li>
	<li class="menu-label">Contact </li>
	<li>
		<a class="#" href="contact.php">
			<div class="parent-icon icon-color-5"><i class="bx bx-support"></i></div>
			<div class="menu-title">support</div>
		</a>
		
	</li>
</ul>
    <?php }
}
?>




		</div>
		<header class="top-header">
			<nav class="navbar navbar-expand">
            
				<div class="right-topbar ms-auto">
					<ul class="navbar-nav">
						<li class="nav-item search-btn-mobile">
							<a class="nav-link position-relative" href="javascript:;">	<i class="bx bx-search vertical-align-middle"></i>
							</a>
						</li>						
						<li>
            <form action="Clogout.php" method="POST">
                <button type="submit" name="logout" class="dropdown-item">Logout</button>
            </form>
        </li>
					</ul>
				</div>
			</nav>
		</header>