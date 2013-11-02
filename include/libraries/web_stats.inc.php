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

function log_web_stats($page) {
	# Global Variables
	global $_db, $validator, $_GLOBALS;
	
	# Get Visitor Details
	$ip																	= get_ip_address();
	$session															= session_id();
	
	# Log to Database
	$_db->insert(	"web_stats",
		array(		"datetime"											=> date("Y-m-d H:i:s"),
					"ip"												=> $ip,
					"session"											=> $session,
					"page"												=> $page
		)
	);
}

# ==================================================================================
# THE END
# ==================================================================================

?>