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
                <?php $user = get_user_info() ?>
                <div>
                    <span class="text-light">Welcome back <?=$user['first_name']?>!</span>
                    <a class="btn btn-light mx-3" href="/logout">Logout</a>
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
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h5 class="card-title">User List <span class="text-muted fw-normal ms-2">(<?=$user_count?>)</span></h5>
                                        </div>
                                    </div>
        
                                    <div class="col-md-6">
                                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                            <div>
                                                <a href="/users/create" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                                <!-- end row -->
        
                                <div class="table-responsive mb-4">
                                    <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Type</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ( $users as $user ) : ?>
                                                <tr class="clickable" data-user-id="<?=$user['user_id']?>">
                                                    <td><?=$user['last_name']?></td>
                                                    <td><?=$user['first_name']?></td>
                                                    <td><?=$user['user_email']?></td>
                                                    <td><?=$user['role']?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                    <!-- end table -->
                                </div>
                                <?php insertPagination( $current_page, $pages_num ) ?>
                                <!-- end table responsive -->
                            </div>
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