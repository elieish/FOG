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
$cur_page																= "?p=config";

# ==================================================================================
# DISPLAY FUNCTIONS
# ==================================================================================

function display() {
	# Global Variables
	global $cur_page, $_db, $_GLOBALS, $validator;
	
	# Retrieve Template
	$template															= "";
	$template_file														= dirname(__FILE__) . "/../../template/html/index.html";
	if (file_exists($template_file) && is_readable($template_file)) {
		$template														= file_get_contents($template_file);
	}
	else {
		logg("ADMIN ERROR: Could not access template file `{$template_file}`.");
	}
	
	# Get Variables for Editing
	preg_match_all("/\{\{[A-Z0-9_]*\}\}/", $template, $matches);
	
	# Generate Form Items HTML
	$form_items															= "";
	foreach ($matches[0] as $match) {
		$match															= substr($match, 2, strlen($match) - 4);
		if (!($match == "MENU" || $match == "INCLUDE_CSS" || $match == "INCLUDE_JS" || $match == "CONTENT"))
			$form_items													.= "
			<!-- Form Element -->
			<strong>{$match}</strong>
			<br />
			<input type='text' name='var_{$match}' value=\"" . get_db_variable($match) . "\" />
			<br /><br />
			";
	}
	
	# Generate HTML
	$html																= "
	
	<div class='content' id='content'>
	
		<h2><span class='config'></span>Configuration</h2>
			
		<form method='POST' action='{$cur_page}&action=save'>
			{$form_items}
			
			<input type='submit' value='Save' />
		</form>
		
	</div><!-- END: Content -->
	";
	
	# Display HTML
	print $html;
}

# ==================================================================================
# PROCESSING FUNCTIONS
# ==================================================================================

function save() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Get Variables
	$variables															= array();
	foreach ($_POST as $key => $val) {
		if (substr($key, 0, 4) == "var_") {
			$key														= substr($key, 4);
			
			# Validate
			$key														= $validator->validate($key, "String");
			$val														= $validator->validate($val, "String");
			
			# Save to Database
			if ($_db->fetch_single("SELECT COUNT(*) FROM `config` WHERE `var` = \"{$key}\"")) {
				$_db->update(	"config",
					array(		"val"									=> $val),
					array(		"var"									=> $key)
				);
			}
			else {
				$_db->insert(	"config",
					array(		"var"									=> $key,
								"val"									=> $val)
				);
			}
		}
	}
	
	# Display Information Banner
	print "
	<!-- Info Banner -->
	<div class='banner'>
		Configuration Saved.
	</div><!-- END: Info Banner -->
	";
	
	# Display the Form
	display();
}

# ==================================================================================
# ACTION HANDLER
# ==================================================================================

if (isset($_GET['action'])) {
	$action																= $_GET['action'];
	if ($action 														== "display") {
		display();
	}
	else if ($action													== "save") {
		save();
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