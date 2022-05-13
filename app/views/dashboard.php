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
                <span class="text-light">Welcome back <?=$user['first_name']?>!</span>
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
                            <h4 class="card-title mb-4">My Applications</h4>
                            
                            <?php if ( !empty($applications) ) : ?>
                                <div class="text-end">
                                    <a href="/dashboard/create" class="btn btn-light"><i class="bx bx-plus me-1"></i> Submit Request</a>
                                </div>
                            <?php endif ?>
                            
                            <div class="table-responsive">
                                <?php if ( !empty($applications) ) : ?>
                                    <table class="table table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Submitted</th>
                                                <th scope="col">Request Dates</th>
                                                <th scope="col">Duration (in Days)</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php foreach ($applications as $appl) : ?>
                                            <tr>
                                                <!-- Submitted -->
                                                <td><p class="ml-4 mb-0">
                                                    <?=$appl['submit_date']?> <span class="text-muted"></span>at</span> <?=$appl['submit_time']?>
                                                </p></td>
                                                
                                                <!-- Request Dates -->
                                                <td><p class="ml-4 mb-0">
                                                    <span class="text-muted">from:</span> <?=$appl['from_date']?> <span class="text-muted">to:</span> <?=$appl['to_date']?>
                                                </p></td>
                                                
                                                <!-- Duration (in Days) -->
                                                <td><h5 class="text-truncate font-size-14 m-0">
                                                    <?=$appl['days_interval']?>
                                                </h5></td>
                                            
                                                <!-- Status -->
                                                <?php $status = $appl['status'] ?>
                                                <?php if ($status==='APPROVED') : 
                                                        $class= 'bg-success text-light';
                                                    elseif ( $status ==='PENDING' ) :
                                                        $class= 'bg-warning text-dark';
                                                    else:
                                                        $class= 'bg-danger text-light';
                                                    endif;
                                                ?>

                                                <td><span class="<?=$class?> badge rounded-pill badge-soft-secondary font-size-11">
                                                    <?=$status?>
                                                </span></td>
                                            
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                <?php else: //no applications yet for the current user ?>
                                    <div class="text-center">
                                        <p>You have not submited any applications yet.</p>
                                        <a href="/dashboard/create" class="btn btn-light"><i class="bx bx-plus me-1"></i>Submit One!</a>
                                    </div>
                                <?php endif; ?>
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