<?php 
	$sql = new mysqli('***', '***', '***', '***');
	mysql_connect('***', '***', '***');
	mysql_select_db('***');
	$q = mysql_query("SELECT * FROM skrap ORDER BY RAND() LIMIT 0,1;");
	$row = mysql_fetch_array($q);
	$random = $row['id'];

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
    	$qone = "SELECT username FROM pxlart_usrz WHERE id = '{$getUserFromDB}'";
		$resultat = $sql->query($qone);
		$iAmLoggedIn = $resultat->fetch_array(MYSQLI_ASSOC);
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
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<link rel="stylesheet" href="reveal/reveal.css">
		<script src="reveal/jquery.reveal.js" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,800" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="topMenu">
			<div id="innerMenu">
				
				<!-- Länkar -->
				<?php 
					if ($userLoggedIn) {
					echo '<ul>';
					echo '<li>Välkommen, ';
					echo $iAmLoggedIn['username'];
					echo '</li>';
					echo '<li><a href="?logout">Logga ut<a></li>';
					echo '</ul>';
					}
				?>
			</div>
		</div>
		<div id="logo">
			<a href="index.php" style="text-decoration: none; color:#FFF;">PXLART</a>
		</div> 