<?php
	$plugin_output = "";
	
	try {
		global $db_con;
		dbConnect();
		
		//, %Y
		$sql = "SELECT testimonialid, DATE_FORMAT(dategiven, '%D %b') as date_formatted, fullname, testimonial FROM testimonial ORDER BY dategiven ASC;";
		if(!$resultTestimonials = $db_con->query($sql)) {
			throw new exception("Failed to get testimonials from database: " . $db_con->error);
		}
		
		while ($rowTestimonials = $resultTestimonials->fetch_assoc()) {
			$plugin_output .= '<div class="testimonial" data-testimonialid="' . $rowTestimonials["testimonialid"] . '" style="display:none;">' . "\n";
			$plugin_output .= '	<div class="col-sm-4 testimonial-header">' . $rowTestimonials["fullname"] . ' -<br/>' . $rowTestimonials["date_formatted"] . "</div>\n";
			$plugin_output .= '	<div class="col-sm-8 testimonial-body">' . $rowTestimonials["testimonial"] . "</div>\n";
			$plugin_output .= "</div>\n";
		}
		$resultTestimonials->free();
		
	} catch (Exception $e) {
		echo '<div class="exception">An unexpected error occurred:'. "<br/>" . $e->getMessage() . '</div>';
	};
?>