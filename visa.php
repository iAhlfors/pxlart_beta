<?php 
	session_start();
	$artist = $_GET['artist'];
	$title = "PXLART [" . $artist . "]";
	include "header.php";
	$tiny = true;
	if ($tiny) { ?>
		<style>
			.box {
				width:3px;
				height:3px;
			}
		</style>
	<?php }
?>

<div id="canvas_big">
		<?php
			mysql_connect('***', '****', '***');
			mysql_select_db('***');

			$query = "SELECT * FROM * WHERE name='**' ORDER BY ** DESC";
			$resultat = mysql_query($query);
			$n = 0;
				while ($row = mysql_fetch_array($resultat)){
					$skapades = date("Y-m-d", strtotime($row['artCreated']));
					echo '<div class="outerMiniCanvas">';
					echo '<a href="http://ahlforsfrilans.se/pxl_arta_login/pxl/'. $row['id'] , '"><div class="miniCanvas">';
					echo $row['art'];
					echo '</div></a>';
					echo "Artist: " . $row['name'];
					echo "<br />PXL-namn: " . $row['artName'];
					echo "<br />Skapades: " . $skapades;
					if($iAmLoggedIn['username'] == $artist) {
						$sameUser = true;
						echo '<br /><a href="http://ahlforsfrilans.se/pxl_arta_login/d/'. $row ['id'] . '">Radera</a>';
					}
					echo '</div>';
					++$n;
				} 
				if (0 == $n) {
					header('Location: index.php');
    				die();
				}
			
		?>
	</div>
	<div class="clear"></div>


	<?php include "footer.php"; ?>
</body>
</html>