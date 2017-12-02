<?php 
	function checkEmail($field) {
		//filter_var() sanitizes the e-mail address using FILTER_SANITIZE_EMAIL
		$field=filter_var($field, FILTER_SANITIZE_EMAIL);

		//filter_var() validates the e-mail address using FILTER_VALIDATE_EMAIL
		if(filter_var($field, FILTER_VALIDATE_EMAIL)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	//Check values are set
	$formCompleted = TRUE;
	if (!isset($_REQUEST['email'])) {
		$formCompleted = FALSE;
	}
	elseif (!isset($_REQUEST['body']) || $_REQUEST['body']=="") {
		$formCompleted = FALSE;
	};	
	
	//Check for validation issues
	$validated = TRUE;
	if (checkEmail($_REQUEST['email'])==FALSE) {
		$validated = FALSE;
	};
	
	if ($validated==TRUE && $formCompleted==TRUE) {
		//Send the email
		$name = $_REQUEST["name"];
		$phoneno = $_REQUEST["phoneno"];
		$email = $_REQUEST["email"];
		$body = $_REQUEST["body"];
		mail("info@total-interior.co.uk", 
			"Email from website",
			"\nName: " . $name . 
			"\nPhone number: " . $phoneno . 
			"\nEmail: " . $email . 
			"\n\n" . $body);
	}
	elseif (isset($_REQUEST["submit"]) && ($formCompleted==FALSE || $validated==FALSE) ) {		
		echo "<p class='error'>There were validation issues with the webform.</p>";
	};

	if ($formCompleted==TRUE && $validated==TRUE) {
		echo "Thanks for your message!";
	}
	else {
		echo "<form id='emailme' method='post' action='#'><div id='webform'>";
		
		//Name
		echo "<p><input type='text' name='name' value='" . $_REQUEST['name'] . "' placeholder='Name' />";
		if (isset($_REQUEST['name']) && $_REQUEST['name']=="") { 
			echo "<label class='error' for='name'>This field is required.</label>";
		}
		echo "</p>";
		
		//Phone Number
		echo "<p><input type='tel' name='phoneno' value='" . $_REQUEST['phoneno'] . "' placeholder='Phone Number' /></p>";
		
		//Email address
		echo "<p><input type='email' name='email' value='" . $_REQUEST['email'] . "' placeholder='Email Address' />";
		if ( isset($_REQUEST['email']) && checkEmail($_REQUEST['email'])==FALSE ) {
			echo "<label class='error' for='email'>Please check this address.</label>";
		}
		echo "</p>";
		
		//Email body
		echo "<p><textarea name='body' rows='5' cols='40' placeholder='Please enter the details of your enquiry.'>" . $_REQUEST['body'] . "</textarea>";
		if (isset($_REQUEST['body']) && $_REQUEST["body"]=="") {
			echo "<label class='error' for='body'>This field is required.</label>";
		}
		echo "</p>";
		
		//Remaining stuff
		echo "<input type='submit' name='submit' value='Send' onclick='' class='btn'/>";
		echo "</div></form>";
	}
?>