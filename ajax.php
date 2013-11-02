<?php
/**
 * Project
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 1.0
 * @package Project
 */

# =========================================================================
# SETTINGS
# =========================================================================

# Start Session
ini_set("session.save_handler", "files");
session_start();

# Include Required Scripts
include_once ("include/include.php");


# =========================================================================
# FUNCTIONS
# =========================================================================

function set_page_tab() {
	# Get GET Data
	$p																	= $_GET['p'];
	$tab																= $_GET['tab'];
	$id																	= $_GET['id'];
	# Set SESSION Data
	$_SESSION["tab_" . $p][$id]											= $tab;
}


















# =========================================================================
# ACTION HANDLER
# =========================================================================

if (isset($_GET['action'])) {
	$action 															= $_GET['action'];
	if ($action															== "set_page_tab") {
		set_page_tab();
	}

	else {
		print "Error: Invalid Action";
	}
}
else {
	//print "Error: Invalid Action";
}

# =========================================================================
# THE END
# =========================================================================

?>
