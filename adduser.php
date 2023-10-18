<?php
  session_start();
  
  include('sidebar.php');
  include('footer.php');

?>
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Forms</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Form Layouts</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">User Registration</h5>
                            </div>
                            <hr>
                            <form action="controller/Adduser.php" method="POST" class="row g-3">
                                <div class="col-md-6">
                                    <label for="Name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="UserName" class="form-label">User Name</label>
                                    <input type="text" class="form-control" name="User_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="Email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="col-md-6">
                                    <label for="Phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" name="Phone">
                                </div>
                                <div class="col-12">
                                    <label for="Address" class="form-label">Address</label>
                                    <textarea class="form-control" placeholder="Address..." rows="3" name="address"></textarea>
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
