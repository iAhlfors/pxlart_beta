<?php 
	$defURL = "http://ahlforsfrilans.se/pxl_arta_login/";
	$sql = new mysqli('*', '*', '*', '*');
	mysql_connect('*', '*', '*');
	mysql_select_db('*');
	$q = mysql_query("SELECT * FROM * ORDER BY RAND() LIMIT 0,1;");
	$row = mysql_fetch_array($q);
	$random = $row['id'];

	/* Hämta URL */
	function curPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}

	$logout = $_GET['logout'];
	if (isset($logout)) {
		session_destroy();
		header("Location: index.php"); 
		exit();
	}

	if (isset($_SESSION['user_id']))
	{
    	$userLoggedIn = true;
    	$getUserFromDB = $_SESSION['user_id'];
    	$qone = "SELECT * FROM * WHERE id = '{$getUserFromDB}'";
		$resultat = $sql->query($qone);
		$iAmLoggedIn = $resultat->fetch_array(MYSQLI_ASSOC);
		$usernamed = $iAmLoggedIn['****'];

		if ($iAmLoggedIn['***'] == "***") {
			$userIsAdmin = true;
		}

		$checkQuery = mysql_query("SELECT * FROM skrap WHERE name='$usernamed'");

		if (mysql_fetch_array($checkQuery)) {
			$myPxls = '<a href="http://ahlforsfrilans.se/pxl_arta_login/'. $iAmLoggedIn['username'] .'">';
		} else {
			$myPxls = '<a href="#" data-reveal-id="noImagesModal">';
		}

	}

	if ($userLoggedIn) {
		$saveOrReg = '<a data-reveal-id="myModal"><div class="button">Spara mina PXLar</div></a>';
	} else {
		$saveOrReg = '<a href="registrera.php" style="text-decoration:none;"><div class="button">Registrera dig!</div></a>';
	}

?>

<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $defURL; ?>style.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<link rel="stylesheet" href="<?php echo $defURL; ?>reveal/reveal.css">
		<script src="<?php echo $defURL; ?>reveal/jquery.reveal.js" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,800" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="topMenu">
				
				<!-- Länkar -->
				<?php 
					if ($userLoggedIn) {
					?>
					<div id="myInfoModal" class="reveal-modal">
					     <h1>PXLART</h1>
					     <p>
					     	<strong>Hur ritar jag?</strong><br />
					     	Det är oerhört enkelt att rita PXLar! Håll nere <strong>F</strong> på ditt tangentbord och dra musen över din kanvas.
					     	Ångrar du dig, eller helt enkelt vill måla vita PXLar håller du nere <strong>W</strong>.<br />
					     	Ett tips är att hålla ringfingret på <strong>W</strong> och pekfingret på <strong>F</strong>.
					     	<br /><br />
					     	<strong>Lorem Ipsum</strong><br />
					     	Lorem Ipsum
					     </p>
					     <a class="close-reveal-modal">&#215;</a>
					</div>
					<?php
					echo '<div id="innerMenu">';
					echo '<ul>';
					echo '<li class="menuUser">'; 
					echo $iAmLoggedIn['username'];
						if ($userIsAdmin) {
							echo " [admin]";
						}
					echo '</li>';
					echo $myPxls;
					echo '<li>Mina PXLar</li></a>';
					echo '<a href="http://ahlforsfrilans.se/pxl_arta_login/index.php"><li>Rita PXLar</li></a>';
					echo '<a href="http://ahlforsfrilans.se/pxl_arta_login/index.php?logout"><li class="right">Logga ut</li><a>';
					echo '<a href="#" data-reveal-id="myInfoModal"><li class="right">Info</li></a>';
					echo '</ul>';
					echo '</div>';
					}
				?>
		</div>
		<div id="noImagesModal" class="reveal-modal">
			Hej,
			<br />
			du har tyvärr inte ritat något än! Sätt genast igång!
			<a class="close-reveal-modal">&#215;</a>
		</div>
		<div id="logo">
			<a href="index.php" style="text-decoration: none; color:#FFF;">PXLART</a>
		</div> 