<!-- <body data-layout="horizontal"> -->

<?php head() ?>

<!-- Begin page -->
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                    <a href="/" class="logo logo-light" style="padding: 1.25rem 1.25rem;">
                        <span class="logo-lg">
                            <span class="logo-txt text-light">ReVa</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content" style="margin-left: 0">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Create a user</h4>
                        </div>
                        <div class="card-body">
                            <div id="basic-pills-wizard" class="twitter-bs-wizard">

                                <div class="tab-content twitter-bs-wizard-tab-content">
                                    <div class="tab-pane active" id="seller-details">
                                        <div class="text-center mb-4">
                                            <h2>Please DO keep your credentials.</h2>
                                            <p>This page won't be available after you create the first admin account</p>
                                            <p class="card-title-desc">Fill all information below</p>
                                        </div>
                                        <form action="/setup" method="post">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="firstname-input" class="form-label">First name*</label>
                                                        <input required type="text" class="form-control" name="firstname-input" id="firstname-input">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="lastname-input" class="form-label">Last name*</label>
                                                        <input required type="text" class="form-control" name="lastname-input" id="lastname-input">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="email-input" class="form-label">Email*</label>
                                                        <input required type="email" class="form-control" name="email-input" id="email-input">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="user-type-input" class="form-label">User Type</label>
                                                        <input readonly required type="text" value="admin" class="form-control" name="user-type-input" id="user-type-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="pswd" class="form-label">Password*</label>
                                                        <input required type="password" class="form-control" name="pswd" id="pswd">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="pswd-confirm" class="form-label">Confirm Password*</label>
                                                        <input required type="password" class="form-control" name="pswd-confirm" id="pswd-confirm">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                <input required class="btn btn-primary waves-effect waves-light" type="submit" name="user-create" value="Create" >
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                                <!-- end tab content -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    </div>
                </div>
                
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<?php footer() ?>