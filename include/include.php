<?php
/**
 * CMS Templating System
 * 
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
 * @copyright 
 * @package 
 */

# ==================================================================================
# INCLUDE REQUIRED SCRIPTS
# ==================================================================================

# Configuration
include_once("config/config.inc.php");

# Classes
include_once("classes/classes.php");

# Function Libraries
include_once("libraries/libraries.php");




# ==================================================================================
# INITIALIZE OBJECTS
# ==================================================================================

# Create Database Object
$_db																	= new db_engine(	$_GLOBALS['mysql_host'],
																							$_GLOBALS['mysql_user'],
																							$_GLOBALS['mysql_pass'],
																							$_GLOBALS['mysql_db']
																						);
$_db->db_connect();
																						
# Create Validator Object
$validator																= new Validator();

# ==================================================================================
# THE END
# ==================================================================================

?>