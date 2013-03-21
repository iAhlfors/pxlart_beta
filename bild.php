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
    				header('Location: http://ahlforsfrilans.se/pxl_arta_login/index.php');
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
			<p>Artist:<br />PXL-namn:<br />Skapad:<br/>Dela:</p>
		</div>
		<div class="metaR">
			<p><strong>
				<?php
				$currentUrl = "http://ahlforsfrilans.se/pxl_arta_login/pxl/".$id;
				echo '<a href="visa.php?artist='. $artist .'">'. $artist .'</a>';
				echo '<br />';
				echo $artName;
				echo '<br />';
				echo $time;
				echo '<br />';
				echo '<a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=' . $currentUrl . '">Dela på Facebook</a>';
				?>
			<strong></p>
		</div>
	</div>

	<?php include "footer.php"; ?>
</body>
</html>