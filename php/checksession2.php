<?php  
	if(isset($_SESSION['accID'])){
		?>
		<script>
			window.location = "user/<?php echo $_SESSION['directory']; ?>/home";
		</script>
		<?php
	}
?>
