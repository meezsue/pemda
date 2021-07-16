        <?php echo base_url(); ?>
		<header class = "navbar navbar-white navbar-fixed-top" style = "background-color: #3F51B5 !important;">
            <div class = "navbar-header">
                <button type = "button" class = "navbar-toggle" data-toggle = "collapse" data-target = ".navbar-collapse">
                    <span class = "zmdi zmdi-view-headline zmdi-hc-2x"></span>
                </button>
                <a class = "navbar-brand" href = "./index.html" style="background: #3F51B5 !important;" title = "Sistem Informasi Manajemen Pengajuan Pembentukan Produk Hukum"><i class = "zmdi zmdi-widgets"></i> SIMPPUH</a>
            </div>
            <nav>
                <!--<ul class = "nav navbar-top-links navbar-left">
                    <li><a href = "javascript:void(0);" class = "toggle-sidebar hvr-underline-from-center" title = "Show/Hide Sidebar"><i class = "zmdi zmdi-menu" style="color:white;" ></i></a></li>					
                </ul>
                <ul class = "nav navbar-top-links navbar-right">     
                    <li class = "dropdown">
                        <a class = "dropdown-toggle hvr-underline-from-center" href = "<?php echo base_url(); ?>pemda/logout" title = "Sign Out">
                            <span class = "zmdi zmdi-walk" style="color:white;"></span>
                        </a>
                    </li>
                </ul>
                <ul class = "nav navbar-top-links navbar-right">     
                    <li class = "dropdown">
                        <a class = "dropdown-toggle hvr-underline-from-center" data-toggle = "dropdown" href = "javascript:void(0);" title = "Notifications">
                            <i class = "him-icon zmdi zmdi-notifications" style="color:white" ></i> 
                            <span class = "him-counts">6</span>
                        </a>
                </ul>	!-->

				<ul class="nav navbar-top-links navbar-left">
                    <li>
                        <a href="javascript:void(0);" class="toggle-sidebar hvr-underline-from-center"  title="Show/Hide Sidebar">
                            <i class="zmdi zmdi-menu" style = "color:white"></i>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="fullscreen hvr-underline-from-center" title="Full Screen" style = "color:white">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>
                    </li>
                </ul>
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
                        <!--<a class="dropdown-toggle hvr-underline-from-center" data-toggle="dropdown" href="javascript:void(0);" title="Tasks">
                            <i class="zmdi zmdi-view-list-alt" style = "color:white"></i>  
                            <span class="him-counts">9</span>
                        </a> -->
                        <!-- .dropdown-tasks -->
                        <ul class="dropdown-menu dropdown-tasks animated fadeIn">
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <p>
                                            <strong>Task 1</strong>
                                            <span class="pull-right text-muted">40% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <p>
                                            <strong>Task 2</strong>
                                            <span class="pull-right text-muted">20% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <p>
                                            <strong>Task 3</strong>
                                            <span class="pull-right text-muted">60% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                <span class="sr-only">60% Complete (warning)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <p>
                                            <strong>Task 4</strong>
                                            <span class="pull-right text-muted">80% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="javascript:void(0);">
                                    <strong>See All Tasks</strong>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-tasks -->
                    </li>
                    <!-- /.dropdown -->
					<!-- .dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle hvr-underline-from-center" data-toggle="dropdown" href="javascript:void(0);" title="Notifications">
                            <i class="him-icon zmdi zmdi-notifications" style = "color:white"></i>  
                            <span class="him-counts">6</span>
                        </a>
                        <!-- .dropdown-alerts -->
                        <ul class="dropdown-menu dropdown-alerts animated fadeIn">
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <i class="zmdi zmdi-comment-more"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <i class="zmdi zmdi-twitter"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <i class="zmdi zmdi-email"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <i class="zmdi zmdi-storage"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <i class="zmdi zmdi-upload"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="javascript:void(0);">
                                    <strong>See All Alerts</strong>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
                    <!-- /.dropdown -->

                    <!-- .dropdown -->
					<li class = "dropdown">
                        <a class = "dropdown-toggle hvr-underline-from-center" href = "<?php echo base_url().'pemda/logout'; ?>" title = "Sign Out">
                            <span class = "zmdi zmdi-walk" style="color:white;"></span>
                        </a>
                    </li>
                    <!-- /.dropdown -->
				</ul>
            </nav>
        </header> 