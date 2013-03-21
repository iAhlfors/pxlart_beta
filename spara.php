<?php
	mysql_connect('***', '***', '***');
	mysql_select_db('***');

	$div = mysql_real_escape_string($_POST['contents']);
	$name = mysql_real_escape_string($_POST['name']);
	$artName = mysql_real_escape_string($_POST['pxlName']);
	if ($_POST['contents'] != "") {
		$insertInto = mysql_query("INSERT INTO skrap VALUES ('', '". $name ."', '". $div ."', '" . $artName . "', NOW())");
	}
	$q = mysql_query("SELECT * FROM skrap ORDER BY id DESC LIMIT 1");
		while ($row = mysql_fetch_array($q))
			{
				$myId = $row['id'];
			}
		header('Location: bild.php?id=' . $myId);

?>