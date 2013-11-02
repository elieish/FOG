<?php
/**
 * CMS Templating System
 * 
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
 * @copyright Copyright (C) Imply Development 2011
 * @package ImplyCMS
 */

# ==================================================================================
# SCRIPT SETUP
# ==================================================================================

# Current Page
$cur_page																= "?p=home";

# ==================================================================================
# DISPLAY FUNCTIONS
# ==================================================================================

function display() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Generate HTML
	$html																= "
	<div class='welcome'>
	
		<span class='hammer'></span>
	
		<h2>CMS Administration</h2>
		
		<p>
			Welcome to the Administration panel for your CMS system. <br />
			Here you will be able to edit the content of your website.
			<a href='?p=editor'>
				<span class='start'>Start</span>
			</a>
		</p>
		
	</div>
	";
	
	# Display HTML
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