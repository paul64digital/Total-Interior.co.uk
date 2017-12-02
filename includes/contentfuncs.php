<?php
	function getContent($contentid) {
		try {
			global $db_con;
			dbConnect();
			
			$sql = "SELECT type, content, sequence FROM content WHERE contentid = " . $contentid . ";";
			if(!$result = $db_con->query($sql)) {
				throw new exception("Failed to get content from database: " . $db_con->error);
			}
			
			$row = $result->fetch_assoc();
			echo TRIM($row["content"]);
			$result->free();
			
		} catch (Exception $e) {
			echo '<div class="exception">An unexpected error occurred:'. "<br/>" . $e->getMessage() . '</div>';
		};
	};
	
	function setContent($contentid, $type, $pageid, $content, $sequence) {
		try {
			global $db_con;
			dbConnect();
			
			if ( !(isset($contentid)) || $contentid == 0) {
				if (!$stmt = $db_con->prepare("INSERT INTO content(pageid, content) VALUES (?, ?);")) {
					throw new exception("Failed to set INSERT statement"); 
				};
				$content = TRIM($content);
				if (!$stmt->bind_param('is', $pageid, $content)) {
					throw new exception("Failed to bind INSERT arguments");
				};
			} else {
				if (!$stmt = $db_con->prepare("UPDATE content SET content = ? WHERE contentid = ? AND pageid = ?;")) { 
					throw new exception("Failed to set UPDATE statement"); 
				};
				if (!$stmt->bind_param('sii', $content, $contentid, $pageid)) {
					throw new exception("Failed to bind UPDATE arguments");
				};
			}
			
			if (!$stmt->execute()) {
				throw new exception ("Failed to write content to database:" . $db_con->error);
			};
			$stmt->close();
			
			$newcontentid = $mysqli->insert_id;
			echo $newcontentid;
			
			if (!$stmt = $db_con->prepare("INSERT INTO contentversion(pageid, content) VALUES (?, ?);")) {
				throw new exception("Failed to set version INSERT statement"); 
			};
			$content = TRIM($content);
			if (!$stmt->bind_param('is', $pageid, $content)) {
				throw new exception("Failed to bind version INSERT arguments");
			};
			if (!$stmt->execute()) {
				throw new exception ("Failed to write contentversion to database:" . $db_con->error);
			};
			$stmt->close();
			
		} catch (Exception $e) {
			echo '<div class="exception">An unexpected error occurred:'. "<br/>" . $e->getMessage() . '</div>';
		};
	}
	
	function getPageContents($pageid, $editmode) {
		try {
			global $db_con;
			dbConnect();
			
			if (!$pageid) {
				throw new exception ("Pageid has not been set");
			}
			
			$sql = "SELECT contentid, type, content FROM content WHERE pageid = " . $pageid . " ORDER BY sequence, contentid;";
			if(!$result = $db_con->query($sql)) {
				throw new exception("Failed to get content from database: " . $db_con->error);
			}
			
			$pagecontents = "";
			
			while ($row = $result->fetch_assoc()) {
				if ($editmode) {
					$pagecontents .= '<input type="button" class="btn" onclick="editContent(\'' . $row["contentid"] . '\')" value="Edit" style="display:block;clear:both;" />';
				}
				$pagecontents .= '<div id="contentid' . $row["contentid"] . '">';
				if ( $row["type"] == 'P') {
					//e.g. '<plugin type="gallery" />'
					$pluginid = str_replace('<plugin type="', '', $row["content"]);
					$pluginid = str_replace('" />', '', $pluginid);
					switch ($pluginid) {
						case 'gallery':
							include('plugins_gallery.php');
							break;
						case 'testimonials':
							include('plugins_testimonials.php');
							break;
						default:
							$pagecontents .= "Unrecognised plugin ID: $pluginid";
					}
					$pagecontents .= $plugin_output;
					
				}
				else {
					$pagecontents .= $row["content"];
				}
				$pagecontents .= '</div>' . "\n";
			}
			$result->free();
			
			if ($editmode) {
				$pagecontents .= '<input type="button" class="btn" onclick="newContent()" value="Add" style="display:block;" />';
			}
			
			echo $pagecontents;
			
		} catch (Exception $e) {
			echo '<div class="exception">An unexpected error occurred:'. "<br/>" . $e->getMessage() . '</div>';
		};
	}
?>