<?php 
	//Turn off all error reporting
	//error_reporting(0);
	
	//phpinfo();
	
	//session_start();
	
	include_once('includes/dbfuncs.php');
	global $db_con;
	dbConnect();
	$sql = "SELECT pageid FROM page WHERE filename = '" . $filename . "';";
	if(!$result = $db_con->query($sql)) {
		throw new exception("Failed to get content from database: " . $db_con->error);
	}
	$row = $result->fetch_assoc();
	$pageid = $row["pageid"];
	$result->free();
	
	include_once('contentfuncs.php');
	include_once('testimonialfuncs.php');
	
	//echo 'editmode is ' . var_export($editmode,true);
	//echo '<br>';
	//echo 'insession is ' . var_export($_SESSION['insession'],true);
	//echo '<br>';
	
	if ($_GET["edit"] == "1" && $_POST["password"] == "iliketrains") {
		$_SESSION['insession']='true';
	}
	if ($_GET["edit"] == "0") {
		$_SESSION['insession']='false';
	}
	
	if($_SESSION['insession'] == 'true') {
		$editmode = true;
	}
	else {
		$editmode = false;		
	}
	
	//echo 'editmode is ' . var_export($editmode,true);
	//echo '<br>';
	//echo 'insession is ' . var_export($_SESSION['insession'],true);
	//echo '<br>';

	function curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			//$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			$pageURL .= $_SERVER['HTTP_HOST'] . $uri_parts[0];
		}
		return $pageURL;
	}

	function curPageName() {
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Total Interior">
	<meta name="keywords" content="<?php echo $keywords; ?>">
	<meta name="author" content="Paul Davis - pdavis86@hotmail.co.uk">
	
	<title>Total Interior<?php if (isset($title)) echo " - " . $title ?></title>
	
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" type="text/css" media="all" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css"> <!-- For login screen -->
	<link rel="stylesheet" type="text/css" media="all" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="all" href="css/jquery.tosrus.all.css" /> <!-- For photo gallery -->
	<link rel="stylesheet" type="text/css" media="all" href="css/default.css">
</head>

<body<?php echo $bodyattributes ?>>

<div id="contenteditor" style="display:none;">
	<div id="contenteditorinner">
		<div id="contenteditorcontent"></div>
		<input type="hidden" name="contentid" value="" />
		<!--<select name="type">
			<option value="C">Content</option>
			<option value="P">Plugin</option>
		</select>
		<input type="text" name="sequence" value="" style="width:50px; margin-bottom:10px; height:22px;" />-->
		<textarea name="content"></textarea>
		<input type="button" class="btn" value="Save" onclick="updateContent($('#contenteditor input[name=contentid]').val());" />
		<input type="button" class="btn" value="Cancel" onclick="$('#contenteditor').hide();" />
	</div>
</div>

<input type="button" id="editmode" value="Exit Edit Mode" style="display:none;" onclick="window.location.href = location.protocol + '//' + location.host + location.pathname;" />

<?php 
	if($editmode) { 
		echo '<input type="button" class="btn" id="editmode" value="Exit Edit Mode" onclick="window.location.href = \'' . curPageURL() . '?edit=0\'" />';
	}
?>

<div class="container">
	
	<div class="row">
		<div id="page-logo" class="col-md-3">
			<a href="./"><img src="./images/logo.png" alt="Total Interior Logo" class="img-responsive" /></a>
		</div>
		
		<div class="col-md-9 page-banner-container">
			<div id="page-banner">
				<div class="col-md-5">
					<div class="phone-numbers-title">Office:</div><div class="phone-numbers-value"><a href="tel:01322 522179">01322 522179</a></div>
					<div class="phone-numbers-title">Mobile:</div><div class="phone-numbers-value"><a href="tel:07765 258126">07765 258126</a></div>
					<div class="phone-numbers-title">Email:</div><div class="phone-numbers-value"><a href="mailto:info@total-interior.co.uk">info@total-interior.co.uk</a></div>
				</div>
				
				<div class="col-md-7">
					<div class="page-banner-special"><a href="employment.php">Employment Opportunities</a></div>
					<div class="page-banner-special"><a href="localbusinesses.php">Recommended other local businesses</a></div>
				</div>
			</div>
			
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="float-left">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</span>
							<span class="float-left menu-name">Menu</span>
						</button>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="./">Home</a></li>
							<li><a href="whychoosetotalinterior.php">Why choose Total Interior?</a></li>
							<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Services<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="12monthguarantee.php">Free 12 Month Guarantee</a></li>
									<li><a href="areascovered.php">Areas Covered</a></li>
									<li><a href="plastering.php">Plastering</a></li>
									<li><a href="drylining.php">Dry Lining</a></li>
									<li><a href="screedingfloorleveling.php">Screeding/Floor Levelling</a></li>
									<li><a href="paintingdecorating.php">Painting/Decorating</a></li>
									<li><a href="bathroomfitting.php">Bathroom Fitting</a></li>
									<li><a href="kitchenfitting.php">Kitchen Fitting</a></li>
									<li><a href="tiling.php">Tiling</a></li>
									<li><a href="electrical.php">Electrical Work</a></li>
									<li><a href="gas.php">Gas Work</a></li>
									<li><a href="floors.php">Floor sanding/ repairs /re-finishing</a></li>
									<li><a href="windowsanddoors.php">Windows and doors</a></li>
								</ul>
							</li>
							<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Useful Guides<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="ug-avoidcheapquotes.php">Avoid Cheap Quotes</a></li>
									<li><a href="ug-plastering.php">Plastering</a></li>
									<li><a href="ug-drylining.php">Dry Lining</a></li>
									<li><a href="ug-dryliningvsplastering.php">Plastering vs Dry Lining</a></li>
									<li><a href="ug-paintingdecorating.php">Painting new plaster</a></li>
									<li><a href="ug-whichquoteisthebest.php">Which quote is best? How do I choose?</a></li>
									<li><a href="ug-howwillyouquote.php">How will you quote for my work?</a></li>
								</ul>
							</li>
							<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Work Examples<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="gallery.php">Gallery</a></li>
									<li><a href="feedback.php">Customer Feedback</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div><!-- /.container-fluid -->
			</nav>
		</div>
	</div>
	
	<div class="row" id="maincontainer">
		<div class="col-md-7" id="mainbodycontents">
			<h1><?php if (isset($title)) { echo $title; } else { echo "Total Interior"; }; ?></h1>
			<?php getPageContents($pageid, $editmode); ?>
			<div id="mainbodycontents-footer">
				<div>Don’t hesitate to contact us if you have any questions, even if you are just looking for some free advice. Simply fill out the form on this page and we will reply within 48 hours.</div>
			</div>
		</div>
		<div class="col-md-5">
			<h3><span>Contact Us</span></h3>
			<?php include_once('webform.php'); ?>
			<?php include('widget_testimonials.php'); echo $plugin_output; ?>
		</div>
	</div>
	
	<div>
		<a href="https://www.facebook.com/TotalInterior.co.uk" target="_blank"><img src="images/FB-f-Logo__blue_29.png" alt="Find us on Facebook" /></a>
		<a href="https://twitter.com/totalinterior1" target="_blank"><img src="images/Twitter_logo_blue_29x29.png" alt="Find us on Twitter" style="margin:15px;" /></a>
		<a href="//plus.google.com/u/0/110575949396935052781?prsrc=3" rel="publisher" target="_blank"><img src="//ssl.gstatic.com/images/icons/gplus-32.png" alt="Google+" style="border:0;width:32px;height:32px;"/></a>
	</div>
	
</div><!-- /.container -->

<p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Total-Interior Ltd.</p>

<!-- script section -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script><!--Ensure this is after loading bootstrap -->
<script type="text/javascript" src="http://cdn.jsdelivr.net/hammerjs/2.0.3/hammer.min.js"></script>
<script type="text/javascript" src="js/jquery.tosrus.min.all.js"></script>
<script type="text/javascript">

	var divs = $('div[class^="testimonial"]').hide(),
		i = 0;

	(function cycle() { 
		divs.eq(i).fadeIn(400)
				  .delay(9000)
				  .fadeOut(400, cycle);

		i = ++i % divs.length; // increment i, and reset to 0 when it equals divs.length
	})();
</script>

<script type="text/javascript">

	var xmlhttp=new XMLHttpRequest();
	
	function editContent(ai_contentid) {
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#contenteditor').hide();
				$('#contenteditor').insertBefore('#contentid'.concat(ai_contentid));
				$('#contenteditor textarea').val(xmlhttp.responseText);
				$('#contenteditor input[name=contentid]').val(ai_contentid);
				$('#contenteditor').fadeIn('slow');
			}
		}
		xmlhttp.open("POST","./includes/ajaxcontent.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("contentid=".concat(ai_contentid));
	}
	
	function updateContent(ai_contentid) {
		$('#contenteditorinner input[value="Save"]').attr("disabled", true);
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#contenteditor').hide();
				$('#contenteditorinner input[value="Save"]').removeAttr("disabled");
				if (ai_contentid > 0) {
					$('#contentid'.concat(ai_contentid)).html($('#contenteditor textarea').val());
				}
				else {
					location.reload();
				}
			}
		}
		xmlhttp.open("POST","./includes/ajaxcontent.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("contentid=".concat(ai_contentid).concat("&pageid=").concat(<?php echo $pageid ?>).concat("&content=").concat(encodeURIComponent($('#contenteditor textarea').val())));
	}
	
	function newContent() {
		$('#contenteditor').hide();
		$('#mainbodycontents').append($('#contenteditor').detach());
		$('#contenteditor textarea').val("");
		$('#contenteditor input[name=contentid]').val(0);
		$('#contenteditor').fadeIn('slow');
	}
	
</script>

<?php 
$xml = array('sXML' => '
<div id="LoginDialog" title="Login to make changes" style="display:none">
	<form id="LoginForm" method="post" action="' . curPageURL() . "?edit=1" . '">
	<div>
		<label for="LoginUsername">Username</label>
		<input type="text" name="username" id="LoginUsername" />
		<label for="LoginPassword">Password</label>
		<input type="password" name ="password" id="LoginPassword" />
	</div>
	</form>
</div>

<script>
	$(function() {
		$( "#LoginDialog" ).dialog({
			modal: true,
			buttons: {
				Login: function() {
					$( "#LoginForm" ).submit();
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	$("#LoginUsername").keypress(function(e) {
		if(e.which == 13) {
			jQuery(this).blur();
			jQuery("#LoginPassword").focus().click();
		}
	});
	$("#LoginPassword").keypress(function(e) {
		if(e.which == 13) {
			$( "#LoginForm" ).submit();
		}
	});
</script>
');
if ($_GET["edit"] == "1" && (!isset($_SESSION['insession']) || $_SESSION['insession'] == 'false') ) {
	echo join("", $xml);
}
?>

<script type="text/javascript">
   $(document).ready(function() {
	  $("#links a").tosrus();
   });
</script>
	
</body>
</html>