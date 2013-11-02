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

function set_error($message) {
	$_SESSION['error_message']											= $message;
}

function set_info($message) {
	$_SESSION['info_message']											= $message;
}

/**
 * Display an error message
 * @param string $message The message to be displayed
 */
function error($message) {
	# Generate HTML
	$html									= "
		<div class='error'>
			<string>ERROR</strong>
			 : 
$message
		</div>
	";

# Return HTML
return $html;
}

# ==================================================================================
# THE END
# ==================================================================================

?>