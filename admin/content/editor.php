<?php
/**
 * CMS Templating System
 * 
 * @author Ralfe Poisson <ralfe@implyit.co.za>
 * @version 1.0
 * @copyright Copyright (C) Imply Development 2011
 * @package ImplyCMS
 */

# ==================================================================================
# SCRIPT SETUP
# ==================================================================================

# Current Page
$cur_page																= "?p=editor";

# ==================================================================================
# DISPLAY FUNCTIONS
# ==================================================================================

function display() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	$html																= "
	
		<div class='content' id='content'>
	
			<h2><span class='edit'></span>Editor</h2>
		
			<div class='page_list'>";
	
	# Content pages
	$html																.= "<div class='page_list_header'>Content Pages<span onclick='loadpage(\"\", \"content\");' class='add'>+</span></div>";
	$dir																= dirname(__FILE__) . "/../../content/pages/";
	if (is_dir($dir)) {		
		foreach (glob("{$dir}*.html") as $filename) {			
			$filename													= str_replace(".html", "", basename($filename));
			$html														.= "<span class='page_link' onclick='loadpage(\"$filename\", \"content\")'>- {$filename}</span>";
		}
	}
	else {
		logg("Unable to access the pages directory `{$dir}`.");
	}


	# CSS files
	$html																.= "<div class='page_list_header'>CSS Files<span onclick='loadpage(\"\", \"css\");' class='add'>+</span></div>";
	$dir																= dirname(__FILE__) . "/../../template/css/";
	if (is_dir($dir)) {		
		foreach (glob("{$dir}*.css") as $filename) {
			$filename													= str_replace(".css", "", basename($filename));
			$html														.= "<span class='page_link' onclick='loadpage(\"$filename\", \"css\")'>{$filename}</span>";
		}
	}
	else {
		logg("Unable to access the css directory `{$dir}`.");
	}
	
	
	# JS files
	$html																.= "<div class='page_list_header'>Javascript Files<span onclick='loadpage(\"\", \"js\");' class='add'>+</span></div>";
	$dir																= dirname(__FILE__) . "/../../template/js/";
	if (is_dir($dir)) {		
		foreach (glob("{$dir}*.js") as $filename) {
			$filename													= str_replace(".js", "", basename($filename));
			$html														.= "<span class='page_link' onclick='loadpage(\"$filename\", \"js\")'>{$filename}</span>";
		}
	}
	else {
		logg("Unable to access the javascript directory `{$dir}`.");
	}
	
	
	# Template pages
	$html																.= "<div class='page_list_header'>Template Pages</div>";
	$dir																= dirname(__FILE__) . "/../../template/html/";
	if (is_dir($dir)) {		
		foreach (glob("{$dir}*.html") as $filename) {
			$filename													= str_replace(".html", "", basename($filename));
			$html														.= "<span class='page_link' onclick='loadpage(\"$filename\", \"template\")'>{$filename}</span>";
		}
	}
	else {
		logg("Unable to access the templates directory `{$dir}`.");
	}
	
	
	
	
	#Client Pages
	$html																.= "<div class='page_list_header'>Client Pages<span onclick='loadpage(\"\", \"clients\");' class='add'>+</span></div>";
	$dir																= dirname(__FILE__) . "/../../template/clients/";
	if (is_dir($dir)) {		
		foreach (glob("{$dir}*.html") as $filename) {			
			$filename													= str_replace(".html", "", basename($filename));
			
			$html														.= "<span class='page_link' onclick='loadpage(\"$filename\", \"clients\")'>- {$filename}</span>";
		}
	}
	else {
		logg("Unable to access the pages directory `{$dir}`.");
	}
	
	
	
	
	
	$html																.= "</div>";

	
	$html																.= "
		
				<iframe id='page_frame' src='../editor.php?p=home'></iframe>
			
				<!-- Clearfix -->
				<div class='clearfix'></div>
				<!-- END: Clearfix -->
				
			</div><!-- END: Content -->";
	

	
	# Return CSS Include HTML
	print $html;

	
}
 
# ==================================================================================
# PROCESSING FUNCTIONS
# ==================================================================================

# ==================================================================================
# ACTION HANDLER
# ==================================================================================

if (isset($_GET['action'])) {
	$action																= $_GET['action'];
	if ($action 														== "display") {
		display();
	}
	else {
		display();
	}
}
else {
	display();
}

# ==================================================================================
# THE END
# ==================================================================================

?>