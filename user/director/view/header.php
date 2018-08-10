<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark primary-color">
        <img src="../../../img/custom/chedlogo2.png" style="height: 40px; margin-left: -20px;">
        <a class="navbar-brand" href="." style="margin-left: -10px;"><strong>CHED PCAR - <?php echo $_SESSION['region_code']; ?> (Director)</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent"> 
            <ul class="navbar-nav nav-flex-icons ml-auto">
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="."><i class="fa fa-home" aria-hidden="true"></i> Home<span class="sr-only"></span></a>
                </li>
                <?php
                    if($_SESSION['level'] <= 2){
                        echo 
                        '<li class="nav-item">
                            <a class="nav-link waves-effect waves-light" href="./account.php"><i class="fa fa-users" aria-hidden="true"></i> Accounts<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light" href="./program.php"><i class="fa fa-book" aria-hidden="true"></i> Programs/Projects<span class="sr-only"></span></a>
                        </li>';
                        if($_SESSION['level'] <= 1){
                            echo 
                            '<li class="nav-item">
                                <a class="nav-link waves-effect waves-light" href="./weight.php"><i class="fa fa-pie-chart" aria-hidden="true"></i> Weight Percentage<span class="sr-only"></span></a>
                            </li>';
                        }
                    }
                    else{
                        if($_SESSION['level'] != 4){
                            echo 
                            '
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PCAR</a>    
                                <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="./target.php"><i class="fa fa-calendar-o" aria-hidden="true"></i> Targets<span class="sr-only"></span></a>
                                    <a class="dropdown-item" href="./accomplishment.php"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Accomplishment<span class="sr-only"></span></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">IPCR</a>    
                                <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#!"><i class="fa fa-calendar-o" aria-hidden="true"></i> Targets<span class="sr-only"></span></a>
                                    <a class="dropdown-item" href="#!.php"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Accomplishment<span class="sr-only"></span></a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link waves-effect waves-light" href="./milestone.php"><i class="fa fa-archive" aria-hidden="true"></i> Milestone<span class="sr-only"></span></a>
                            </li>';
                        }
                    }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-desktop" aria-hidden="true"></i> Reports</a>  
                    <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink"> 
                        <a class="dropdown-item" href="./report.php"><i class="fa fa-desktop" aria-hidden="true"></i> Target and Accomplishment<span class="sr-only"></span></a>
                        <a class="dropdown-item" href="./performance.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Performance<span class="sr-only"></span></a>
                        <?php
                            if($_SESSION['level'] < 3 || $_SESSION['level'] == 4){
                                echo '<a class="dropdown-item" href="./assign.php"><i class="fa fa-asterisk" aria-hidden="true"></i> Assigns<span class="sr-only"></span></a>
                                <a class="dropdown-item" href="./percentage.php"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Percentage Accomplishment<span class="sr-only"></span></a>
                                <a class="dropdown-item" href="./monthreport.php"><i class="fa fa-line-chart" aria-hidden="true"></i> Monthly Report<span class="sr-only"></span></a>
                                <a class="dropdown-item" href="./opcr.php"><i class="fa fa-area-chart" aria-hidden="true"></i> OPCR <span class="sr-only"></span></a>';
                            }
                            else{
                                if($_SESSION['level'] != 4){
                                    echo '<a class="dropdown-item" href="./ipcr.php"><i class="fa fa-area-chart" aria-hidden="true"></i> IPCR <span class="sr-only"></span></a>';   
                                }
                            }
                        ?>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>
                    <?php
                        echo $_SESSION['name'];
                    ?>
                    </a>    
                    <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" data-toggle="modal" data-target="#modalchangepassword"><i class="fa fa-wrench" aria-hidden="true"></i> Change Password</a>
                        <?php
                            if($_SESSION['level'] < 2){
                                echo '<a class="dropdown-item" data-toggle="modal" data-target="#modallock"><i class="fa fa-sliders" aria-hidden="true"></i> Lock/Unlcok of T-A</a>';
                            }
                        ?>
                        <a class="dropdown-item" href="../../../php/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="modal fade" id="modalchangepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header indigo">
                <p class="heading lead">Change Password</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body" id="changepasswordmodalbody">
                <p class="error" id="errormsgchangepassword"></p>
                <div class="md-form">
                    <i class="fa fa-lock prefix" aria-hidden="true"></i>
                    <input type="password" id="txtoldpassword" class="form-control">
                    <label for="txtoldpassword">Old Password</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock prefix" aria-hidden="true"></i>
                    <input type="password" id="txtnewpassword" class="form-control">
                    <label for="txtnewpassword">New Password</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock prefix" aria-hidden="true"></i>
                    <input type="password" id="txtconfirmpassword" class="form-control">
                    <label for="txtconfirmpassword">Confirm password</label>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center" id="changepasswordmodalfooter">
                <button type="button" class="btn btn-indigo" onclick="changepassword()">Change</button>
                <button type="button" class="btn btn-outline-indigo waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="modallock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-sm" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header indigo">
                <p class="heading lead">Locking and Unlocking of T-A</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="d-flex flex-row justify-content-end">
                    <label for="slctyear_lock" class="h4-responsive" style="margin-top: 5px; margin-right: 5px;">Year</label>
                    <select onchange="selectyear_lock(this.value)" class="form-control" id="slctyear_lock" style="margin-left: 100px;">
                    </select>
                </div>
                <div style="margin: 5px 0px 5px 0;"></div>
                <div id="toggle">
                    <div class="form-group">
                        <label for="chcktarget" class="h4-responsive"><i class="fa fa-circle red-text" aria-hidden="true"></i> Targets</label>
                        <div class="switch text-center">
                            <label>
                                Unlock
                                <input onclick="targettoggle()" id="chcktarget" type="checkbox" hidden>
                                <span class="lever"></span>
                                Lock
                            </label>
                        </div>
                    <div style="margin: 5px 0px 5px 0;"></div></div>
                    <div class="form-group">
                        <label for="chckaccomplish" class="h4-responsive"><i class="fa fa-circle green-text" aria-hidden="true"></i> Accomplishments</label>
                        <div class="switch text-center">
                            <label>
                                Unlock
                                <input onclick="accomplishtoggle()" id="chckaccomplish" type="checkbox" hidden>
                                <span class="lever"></span>
                                Lock
                            </label>
                        </div>
                    </div>
                </div>
                <div class="cssload-container" id="loaderlock">
                    <div class="cssload-speeding-wheel"></div>
                </div>
            </div>
            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-indigo waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>