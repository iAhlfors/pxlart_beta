<?php 
	session_start();
	$id = $_GET['id']; 
	$title = "PXLART [" . $id . "]";
	include "header.php";
?>
	<div id="canvas">
		<?php

			$query = mysql_query("SELECT * FROM skrap WHERE id='$id'");

			$row = mysql_fetch_array($query);
			
				if (!$row) {
    				header('Location: index.php');
    				die();
				} else {
					echo $row['art'];
					$artist =  $row['name'];
					$artName = $row['artName'];
					$time = $row['artCreated'];
				}
			
		?>
	</div>

	<div id="meta">
		<div class="metaL">
			<p>Artist:<br />PXL-namn:<br />Skapad:</p>
		</div>
		<div class="metaR">
			<p><strong>
				<?php echo $artist;
				echo '<br />';
				echo $artName;
				echo '<br />';
				echo $time;
				?>
			<strong></p>
		</div>
	</div>

	<?php include "footer.php"; ?>
</body>
</html>