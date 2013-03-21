<?php
	session_start();
	include 'PasswordHash.php';
	$title = "PXLART";
	include "header.php"; 
	$artist = $_GET['artist'];
	$id = $_GET['id'];

	$q = mysql_query("SELECT * FROM * WHERE id={$id}");
	$row = mysql_fetch_array($q);

	if ($userLoggedIn && $row['*'] == $iAmLoggedIn['*']) {
			
		if (!$row) {
			header('Location: index.php');
			die();
		} else {
			mysql_query("DELETE FROM skrap WHERE id = {$id}");
			header('Location: http://ahlforsfrilans.se/pxl_arta_login/visa.php?artist='. $row['name']);
		}
	} else {
		header('Location: index.php');
		die();
	}

?>