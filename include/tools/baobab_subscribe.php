<?php
/**
 * Baobab Subscription
 * 
 * @author Ralfe Poisson <ralfe@implyit.co.za>
 * @version 1.0
 * @copyright Copyright (C) Imply Development 2011
 * @package Baobab
 */

# ==================================================================================
# CONFIGURATION
# ==================================================================================

# Congiruation Variables
$api_host																= "http://api.baobabcrm.co.za/?action=subscribe";
$company																= "1";
$type																	= "2";
$group																	= "3";
$redirect																= "../../?p=home.html";
$fields																	= array("first_name"		=> "1",
																				"last_name"			=> "2",
																				"email"				=> "3");

# ==================================================================================
# SUBSCRIBE
# ==================================================================================

# Create Query
$params																	= "";
foreach ($_POST as $key => $val) {
	if (substr($key, 0, 4) == "key_") {
		$params															.= "&key_" . $fields[substr($key, 4)] . "=" . urlencode($val);
	}
}

# Make API Call
$url																	= $api_host;
$url																	.= "&company=" . $company;
$url																	.= "&type=" . $type;
$url																	.= "&group=" . $group;
$url																	.= $params;
$ch																		= curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output																	= curl_exec($ch);
curl_close($ch);

# Redirect
print "<script>window.location.replace(\"{$redirect}\");</script>";

# ==================================================================================
# THE END
# ==================================================================================

?>