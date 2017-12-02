<?php
	function getTestimonials() {
		try {
			global $db_con;
			dbConnect();
			
			//, %Y
			$sql = "SELECT testimonialid, DATE_FORMAT(dategiven, '%D %b') as date_formatted, fullname, testimonial FROM testimonial ORDER BY dategiven ASC;";
			if(!$result = $db_con->query($sql)) {
				throw new exception("Failed to get testimonials from database: " . $db_con->error);
			}
			
			$returnstring = "";
			
			while ($row = $result->fetch_assoc()) {
				$returnstring .= '<div class="testimonial" data-testimonialid="' . $row["testimonialid"] . '" style="display:none;">' . "\n";
				$returnstring .= '	<div class="col-sm-4 testimonial-header">' . $row["fullname"] . ' -<br/>' . $row["date_formatted"] . "</div>\n";
				$returnstring .= '	<div class="col-sm-8 testimonial-body">' . $row["testimonial"] . "</div>\n";
				$returnstring .= "</div>\n";
			}
			$result->free();
			
			echo $returnstring;
			
		} catch (Exception $e) {
			echo '<div class="exception">An unexpected error occurred:'. "<br/>" . $e->getMessage() . '</div>';
		};
	}
?>