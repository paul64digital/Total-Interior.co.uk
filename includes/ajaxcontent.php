<?php 	
	if (is_numeric($_POST["contentid"])) {
		include_once('dbfuncs.php');
        include_once('contentfuncs.php');
		
		if (isset($_POST["pageid"]) && isset($_POST["content"]) ) {
			setContent($_POST["contentid"], $_POST["type"], $_POST["pageid"], $_POST["content"], $_POST["sequence"]);
		}
		else {
			getContent($_POST["contentid"]);
		}
		
	}
	else {
		throw new exception("Parameter contentid was not passed in the expected format");
	}
?>


