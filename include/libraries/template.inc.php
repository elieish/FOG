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
# FUNCTIONS
# ==================================================================================

function construct_page($content_file) {
	# Global Variables
	global $_GLOBALS, $validator;
	
	# Sanitize Content File name
	$content_file														= preg_replace('@[^a-zA-Z0-9_.]@', '', $content_file);
	$content_file														= dirname(__FILE__) . "/../../content/pages/" . $content_file;
	
	# Retrieve Content
	$content															= "";
	if (file_exists($content_file) && is_readable($content_file)) {
			if (strpos($content_file,'.html') !== false) {
				$content												= file_get_contents($content_file);
				 
             }
			
			elseif(strpos($content_file,'.php') !== false)
			{
					
				ob_start();
				include ($content_file);
				$content = ob_get_clean();
             }
			
	}
	else {
		//logg("ERROR: Could not access content file `{$content_file}`.");
	}
	
	# Retrieve Template
	$template															= "";
	$template_file														= dirname(__FILE__) . "/../../template/html/index.html";
	if (file_exists($template_file) && is_readable($template_file)) {
		$template														= file_get_contents($template_file);
	}
	else {
		//logg("ERROR: Could not access template file `{$template_file}`.");
	}
	
	# Insert content into Template
	$page_content														= combine_page_components($template, $content);
	
	# Return Page Content
	return $page_content;
}

function combine_page_components($template, $content) {
	# Global Variables
	global $_GLOBALS, $validator;
	
	# Insert content
	while (strstr($template, "{{")) {
		# Find location of variable
		$pos1															= strpos($template, "{{");
		$pos2															= strpos($template, "}}", $pos1) + 2;
		$len															= $pos2 - $pos1;
		
		# Extract Variable
		$variable														= substr($template, $pos1, $len);
		$variable														= str_replace(array("{{", "}}"), "", $variable);
		$variable														= strtoupper($variable);
		
		# Find appropriate content
		$value															= ($variable == "CONTENT")? $content : get_template_variable($variable);
		
		# Insert Content
		$template														= substr($template, 0, $pos1) . $value . substr($template, $pos2);
	}
	
	# Return Content
	$content															= $template;
	return $content;
}

function get_template_variable($variable) {
	# Global Variables
	global $_GLOBALS, $validator, $_db;
	
	# Get Variable Value
	switch($variable) {
		case "SITE_NAME":
			return get_db_variable($variable);
			break;
		case "INCLUDE_CSS":
			return include_template_css();
			break;
		case "INCLUDE_JS":
			return include_template_js();
			break;
		case "LOGO":
			return get_db_variable($variable);
			break;
		case "MENU":
			return template_menu();
			break;
		case "COPYRIGHT":
			return get_db_variable($variable);
			break;
		default:
			return get_db_variable($variable);
	}
}

function get_db_variable($variable) {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Get Data
	$data																= $_db->get_data("config", "val", "var", $variable);
	
	# Return Data
	return $data;
}

function include_template_css() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Generate CSS Include HTML
	$html																= "";
	$dir																= dirname(__FILE__) . "/../../template/css/";
	if (is_dir($dir)) {
		if ($d															= opendir($dir)) {
			while (($file = readdir($d)) !== false) {
				if (strlen($file) > 3) {
					$html												.= "		<link href='template/css/{$file}' rel='stylesheet' type='text/css' />\n";
				}
			}
		}
	}
	else {
		logg("Unable to access CSS directory `{$dir}`.");
	}
	
	# Return CSS Include HTML
	return $html;
}

function include_template_js() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
}

function get_template_top() {
	# Global Variables
	global $_GLOBALS, $validator;
	
	# Local Variables
	$content_token														= "[[<<>>]]";
	
	# Retrieve Template
	$template															= "";
	$template_file														= dirname(__FILE__) . "/../../template/html/index.html";
	if (file_exists($template_file) && is_readable($template_file)) {
		$template														= file_get_contents($template_file);
	}
	else {
		logg("ERROR: Could not access template file `{$template_file}`.");
	}
	
	# Insert content
	while (strstr($template, "{{")) {
		# Find location of variable
		$pos1															= strpos($template, "{{");
		$pos2															= strpos($template, "}}", $pos1) + 2;
		$len															= $pos2 - $pos1;
		
		# Extract Variable
		$variable														= substr($template, $pos1, $len);
		$variable														= str_replace(array("{{", "}}"), "", $variable);
		$variable														= strtoupper($variable);
		
		# Find appropriate content
		$value															= ($variable == "CONTENT")? $content_token : get_template_variable($variable);
		
		# Insert Content
		$template														= substr($template, 0, $pos1) . $value . substr($template, $pos2);
	}
	
	# Return Content
	$content															= $template;
	return substr($content, 0, strpos($content, $content_token));
}

function get_template_bottom() {
	# Global Variables
	global $_GLOBALS, $validator;
	
	# Local Variables
	$content_token														= "[[<<>>]]";
	
	# Retrieve Template
	$template															= "";
	$template_file														= dirname(__FILE__) . "/../../template/html/index.html";
	if (file_exists($template_file) && is_readable($template_file)) {
		$template														= file_get_contents($template_file);
	}
	else {
		logg("ERROR: Could not access template file `{$template_file}`.");
	}
		
	# Insert content
	while (strstr($template, "{{")) {
		# Find location of variable
		$pos1															= strpos($template, "{{");
		$pos2															= strpos($template, "}}", $pos1) + 2;
		$len															= $pos2 - $pos1;
		
		# Extract Variable
		$variable														= substr($template, $pos1, $len);
		$variable														= str_replace(array("{{", "}}"), "", $variable);
		$variable														= strtoupper($variable);
		
		# Find appropriate content
		$value															= ($variable == "CONTENT")? $content_token : get_template_variable($variable);
		
		# Insert Content
		$template														= substr($template, 0, $pos1) . $value . substr($template, $pos2);
	}
	
	# Return Content
	$content															= $template;
	return substr($content, strpos($content, $content_token) + strlen($content_token));
}

# Takes an image and returns the proportionally resized width and height based on a max height and max width
function get_resized_image_dimensions($image, $max_width, $max_height) {
 
        list($width, $height) = getimagesize($image);
        $ratioh = $max_height/$height;
        $ratiow = $max_width/$width;
        $ratio = min($ratioh, $ratiow);
        $width = intval($ratio*$width);
        $height = intval($ratio*$height);
         
        return array('w' => $width, 'h' => $height);
                
}

# ==================================================================================
# THE END
# ==================================================================================
?>