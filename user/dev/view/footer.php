<footer class="page-footer font-small primary-color pt-4">

    <!--Footer Links-->
    <div class="container-fluid">
        <div class="row">

            <!--First column-->
            <div class="col-md-6">
                <h5 class="text-uppercase"></h5>
                <p></p>
            </div>
            <!--/.First column-->

            <!--Second column-->
            <div class="col-md-6">
                <h5 class="text-uppercase">Links</h5>
                <ul>
                    <li><a href="."><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                    <?php  
                        if($_SESSION['level'] <= 2){
                            echo 
                            '<li><a href="./account.php"><i class="fa fa-users" aria-hidden="true"></i> Accounts</a></li>
                            <li><a href="./program.php"><i class="fa fa-book" aria-hidden="true"></i> Programs</a></li>';
                        }
                        else{
                            echo 
                            '<li><a href="./target.php"><i class="fa fa-calendar-o" aria-hidden="true"></i> Targets</a></li>
                            <li><a href="./accomplishment.php"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Accomplishment</a></li>';
                        }
                    ?>
                    <li><a href="./report.php"><i class="fa fa-desktop" aria-hidden="true"></i> Reports</a></li>
                    <li><a href="./performance.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Peroformance</a></li>
                </ul>
            </div>
            <!--/.Second column-->
        </div>
    </div>
    <!--/.Footer Links-->

    <!--Copyright-->
    <div class="footer-copyright">
    <div class="footer-copyright text-center py-3">© 2018 Copyright:
      <a href="."> pcar.chedro9.com</a>
    </div>
    </div>
    <!--/.Copyright-->

</footer>