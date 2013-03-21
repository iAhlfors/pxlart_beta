<?php 
    session_start();

	include 'PasswordHash.php';
	$title = "PXLART";
	include "header.php"; 
	$artist = $_GET['artist'];
	$id = $_GET['id'];
?>
		<div id="canvas">
			<?php
				$query = mysql_query("SELECT * FROM skrap WHERE id='$id'");
				if ($row['name'] == $iAmLoggedIn['username']) {

					$row = mysql_fetch_array($query);
			
					if (!$row) {
	    				header('Location: index.php');
	    				die();
					} else {
						echo $row['art'];
					}
				} else {
					header('Locatoin: index.php');
					die();
				}
			?>
		</div>	
	<script type="text/javascript">
			var isKeyDown = "no";
			$(window).keydown(function(evt) {
				if (evt.which == 70) {
					isKeyDown = "yes";
				}
				if (evt.which == 87) {
					isKeyDown = "no";
					colour = "FFF";
				}
			}).keyup(function(evt) {
				isKeyDown = "no";
				colour = "";
			});

			$('.box').hover(function(){
			if (isKeyDown == "no")	{
				$(this).css('background',"#"+colour)
			} else {
				$(this).css('background',"#"+((1<<24)*Math.random()|0).toString(16));
			}
			});
  			function onClick() {
         		$('#loading').show();
         		$('.loading_save').hide();
         		$('.close-reveal-modal').hide();
         		$('.form').hide();
         		var div_contents = $("#canvas").html();
  				var p_name = $("p#dittNamnP").text();
  				var p_art = $("p#pxlNamnP").text();
				$.post("spara.php", { contents: div_contents,name: p_name,pxlName: p_art })
				.done(function(data) {
					window.location = "spara.php";
				});
			}
	</script>
	<?php echo $saveOrReg; ?>
	<?php include "footer.php"; ?>
</body>
</html>