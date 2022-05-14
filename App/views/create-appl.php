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
                            <h4 class="card-title mb-4">Submit a new vacation request</h4>
                            <form class="outer-repeater"  method="post">
                                <div data-repeater-list="outer-group" class="outer">
                                    <div data-repeater-item class="outer">
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label col-lg-2">Reason(s) I apply*</label>
                                            <div class="col-lg-10">
                                                <textarea id="taskdesc-editor" class="w-100" style="min-height: 200px" name="reason"><?=(!empty($reason))? $reason : ''?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-form-label col-lg-2">Vacation dates (to/from)*</label>
                                            <div class="col-lg-10">
                                                <div class="input-daterange input-group" data-provide="datepicker">
                                                    <input type="text" class="date form-control" placeholder="Start Date" name="start" />
                                                    <input type="text" class="date form-control" placeholder="End Date" name="end" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-lg-10">
                                        <input required class="btn btn-primary waves-effect waves-light" type="submit" name="appl-create" value="Submit" >
                                        <span style=" width: 100%; margin-top: .25rem; font-size: 1.5rem; color: #ef6767;"><?=(!empty($msg))?$msg:''?></span>
                                    </div>
                                </div>
                            </form>

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