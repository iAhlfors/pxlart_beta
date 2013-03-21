<?php 
    session_start();

	include 'PasswordHash.php';
	$title = "PXLART";
	include "header.php"; 

	$hasher = new PasswordHash(8, FALSE);

	if (!empty($_POST))
	{
	    $username = $sql->real_escape_string($_POST['username']);

	    $query = "SELECT ***, UNIX_TIMESTAMP(created) AS salt
	              FROM ***
	              WHERE *** = '{$***}'";
	    $user = $sql->query($query)->fetch_object();
	    if ($user && $user->password == $hasher->CheckPassword($_POST['password'], $user->password))
	    {
	        session_regenerate_id();
	        $_SESSION['user_id']       = $user->id;
	        $_SESSION['authenticated'] = TRUE;
	        $_SESSION['signature']     = md5($user->id . $_SERVER['HTTP_USER_AGENT'] . $user->salt);
	        header('Location: index.php');
	    }
	    else
	    {
	        $error = "Login failed.";
	    }
	}

?>
		<div id="canvas">
			<?php
				if ($userLoggedIn) {
					for ($row = 1; $row <= 45; $row++) {
				    	for ($col = 1; $col <= 60; $col++) {
							echo '<div class="box"></div>';
				    	}
				    		echo '<div class="clear"></div>';
						}
				} else { ?>
					
					<div id="loggaIn">
						<div class="medlemsInfo">
							<h1>Välkommen!</h1>
							För att kunna rita och spara dina PXLar på PXLART behöver du ett medlemskonto. Att registrera sig tar inte mer än 30 sekunder!
							<h1>Vad är en PXL?</h1>
							En PXL är en liten kvadrat, 10x10 pixlar stor. På PXLART får du hela 2700 små PXLar till ditt förfogande.
							<h1>Vad är PXLART?</h1>
							PXLART är ett open source-projekt. Kolla gärna vad <a href="http://ahlforsfrilans.se/pxl_arta_login/visa.php?artist=demo">demo</a> har ritat!
						</div>
						<div class="loginreg">
							<h1>Logga in</h1>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					    		<p class="anvandare">
					    			<input type="text" value="Användarnamn" name="username" id="username" onfocus="if (this.value=='Användarnamn') this.value='';" onblur="if(this.value == ''){this.value='Användarnamn';}" /><br />	    				
					    		</p>
					    		<p class="losenord">
					    			<input type="password" value="Lösenord" name="password" id="password" onfocus="if (this.value=='Lösenord') this.value='';" onblur="if(this.value == ''){this.value='Lösenord';}" /><br />
					    		</p>
					    		<p class="pLoggaIn">
					    			<input type="submit" value="Logga in" />
					    		</p>
					    	</form>
					    	<?php if (isset($error)): ?>
	        					<p class="error"><?php echo $error; ?></p>
	        				<?php endif; ?>
	        			</div>
					</div>

				<?php }
			?>
		</div>	
		<p id="dittNamnP" style="display:none;"><?php echo $iAmLoggedIn['username']; ?></p>
		<p id="pxlNamnP"  style="display:none;"></p>
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
	<div id="myModal" class="reveal-modal">
		Hej,
		<br />
		Vad vill du kalla din konst för? <br />
	    		<p class="epost">
	    			<input type="text" value="PXL-namn" name="pxlNamn" id="pxlNamn" onfocus="if (this.value=='PXL-namn') this.value='';" onblur="if(this.value == ''){this.value='PXL-namn';}" /><br />
	    		</p>
	    		<br />
		<a class="loading_save" href="#" onclick="onClick()">Spara bild</a>
		<div id="loading" style="display:none">
			<img src="ajax-loader.gif">
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
	<?php  echo $saveOrReg; ?>
	<script type="text/javascript">
	$("#dittNamn").keyup(function () {
		    	var value = $(this).val();
		      		$("p#dittNamnP").text(value);
		   	});

		   	$("#pxlNamn").keyup(function () {
		    	var value = $(this).val();
		      		$("p#pxlNamnP").text(value);
		   	});
		   </script>
	<?php include "footer.php"; ?>
</body>
</html>