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
ini_set("session.save_handler", "files");
session_start();

# Include Required Scripts
include_once ("../include/include.php");
include_once ("./include/include.inc.php");

# Authenticate
authenticate();

# Get Page Content
$p																		= (isset($_GET['p']))? preg_replace('@[^a-zA-Z0-9_]@', '', $_GET['p']) : "home";

# ==================================================================================
# GENERATE PAGE
# ==================================================================================

# Template Top
template_top();

# Generate Content
include_once ("content/" . $p . ".php");

# Template Bottom
template_bottom();

# ==================================================================================
# THE END
# ==================================================================================

?>