<?php 
	$plugin_output = "";
	
	try {
		
		if ( isset($_GET["albumid"]) ) {
			
			$plugin_output .= "<h2>".ucfirst($_GET["albumid"])."</h2>";
			$plugin_output .= '<div id="links" class="imagegallery">';
			
			$dirpath = "images/jobs/".$_GET["albumid"]."/large";
			foreach(glob("$dirpath/*") as $file) {
				$plugin_output .= '    <div><a href="'.$file.'" title="'.$_GET["albumid"].'" data-gallery><img src="'.str_replace("large","thumbs",$dirpath).'/'.basename($file).'" alt="'.basename($file).'"></a></div>';
			}
			
			$plugin_output .= '</div>';
			
			$plugin_output .= '<div style="clear:both;"><a href="'.curPageURL().'">Back to work examples</a></div>';
			
			if ($editmode == true) {
				$plugin_output .= '<input type="button" value="Generate Thumbnails" class="btn" onclick="window.location.href = \'http://www.total-interior.co.uk/staging/images/jobs/generate_thumbs.php?albumid=' . $_GET["albumid"] . '\'" />';
			}
		}
		else {
			$plugin_output .= "<h2>Albums</h2>";
			$plugin_output .= '<div class="imagegallery">';
			foreach(glob('images/jobs/*', GLOB_ONLYDIR) as $dir) {
				//echo "Directory: " . $dir . "<br />";	
				$plugin_output .= '    <div><a href="'.curPageURL().'?albumid='.basename($dir).'" title="'.basename($dir).'"><img src="'.$dir.'.jpg'.'" alt="'.basename($dir).'"></a></div>';
			}
			$plugin_output .= '</div>';
		}
		
	} catch (Exception $e) {
		echo '<div class="exception">An unexpected error occurred:'. "<br/>" . $e->getMessage() . '</div>';
	};
?>