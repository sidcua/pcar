<?php
    if($_SESSION['status'] == 1){
        ?>
        <script>
            window.location = "user/<?php echo $_SESSION['directory']; ?>/home";
        </script>
        <?php
    }
?>