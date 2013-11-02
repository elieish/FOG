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

# Start Session
session_start();

# Include Required Scripts
include_once ("include/include.php");

# Get Page Content
$p																		= (isset($_GET['p']))? preg_replace('@[^a-zA-Z0-9_.]@', '', $_GET['p']) : $_GLOBALS['default_page'];

# ==================================================================================
# GENERATE PAGE
# ==================================================================================

# Generate Content
if ($p																	== "catalogue") {
	print get_template_top();
	include_once("content/pages/" . $p . ".php");
	print get_template_bottom();
}
else if ($p																== "jobs") {
	print get_template_top();
	include_once("content/pages/" . $p . ".php");
	print get_template_bottom();
}
else {
	print construct_page($p);
}

# Log to Web Stats
log_web_stats($p);

# ==================================================================================
# THE END
# ==================================================================================

?>