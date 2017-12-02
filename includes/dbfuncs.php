<?php
	function dbConnect() {
		if (! isset($db_con)) {
		
			global $db_con;
		
			$mysql_host = "localhost";
			$mysql_database = "";
			$mysql_user = "";
			$mysql_password = "";
			
			$db_con = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_database);	
			if ($db_con->connect_errno > 0) {
				throw new exception ("Could not connect to database '" . $mysql_database . "': " . $db_con->connect_error);
			};
		};
	};
	
	function dbDisconnect() {
		global $db_con;
		if (! isset($db_con)) {
			$db_con->close();
		}
	}
	
	/*
	function dbGetExample() {
		
		global $db_con;
			
		dbConnect();
			
		//$statement = $db_con->prepare("SELECT `name` FROM `users` WHERE `username` = ?");
		//$statement->bind_param('s', "bob");
		//$statement->execute();
		//$returned_name = "";
		//$statement->bind_result($returned_name);
		//$statement->free_result();
			
		$sql = "SELECT 'face' as test FROM tblHits;";
		if(!$result = $db_con->query($sql)) {
			throw new exception("Failed to get content from database: " . $db_con->error);
		}
		while($row = $result->fetch_assoc()){
			echo $row['test'] . '<br />';
		}
		echo 'Total results: ' . $result->num_rows;
		$result->free();
	};
	*/
?>