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
$cur_page																= "?p=orders";

# ==================================================================================
# DISPLAY FUNCTIONS
# ==================================================================================

/**
 * The default function called when the script loads
 */
function display(){
	# Global Variables
	global $cur_page, $_db;
	
	# Get Data
	$items																= $_db->fetch("	SELECT
																							*
																						FROM
																							`payments`
																						ORDER BY
																							`uid` DESC
																						");
	
	# Construct Results Table
	$heading															= array("Date", "Time", "User", "Reference", "Payment Method", "Description", "Amount", "Status", "");
	$body 																= array();
	foreach ($items as $item) {
		$actions														= ($item->status == "PRE")? "<a href='$cur_page&action=approve_payment&id={$item->uid}'>Approve</a> | <a href='$cur_page&action=reject_payment&id={$item->uid}'>Reject</a>" : "";
		$body[]															= array(
																					substr($item->datetime, 0, 10),
																					substr($item->datetime, 11),
																					$item->user,
																					$item->ref,
																					$item->payment_method,
																					$item->description,
																					$item->amount,
																					$item->status,
																					$actions
																				);
	}
	$content															= results_table($heading, $body);
	
	# Display Content
	print $content;
}

# =========================================================================
# PROCESSING FUNCTIONS
# =========================================================================

function approve_payment() {
	# Global Variables
	global $_db, $cur_page;
	
	# Get GET Data
	$id																	= $_GET['id'];
	
	# Update Payment Database
	$_db->update(
		"payments",
		array(
			"status"													=> "APPROVED"
		),
		array(
			"uid"														=> $id
		)
	);
	
	# Update Credits
	$payment															= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`payments`
																							WHERE
																								`uid` = '$id'");
	
	# Redirect
	redirect($cur_page);
}

function reject_payment() {
	# Global Variables
	global $_db, $cur_page;
	
	# Get GET Data
	$id																	= $_GET['id'];
	
	# Update Payment Database
	$_db->update(
		"payments",
		array(
			"status"													=> "REJECTED"
		),
		array(
			"uid"														=> $id
		)
	);
	
	# Redirect
	redirect($cur_page);
}

# =========================================================================
# ACTION HANDLER
# =========================================================================

if (isset($_GET['action'])){
	$action = $_GET['action'];
	if ($action == "display"){
		display();
	}
	else if ($action == "approve_payment") {
		approve_payment();
	}
	else if ($action == "reject_payment") {
		reject_payment();
	}
	else {
		error("Invalid action `$action`.");
	}
}
else {
	display();
}

# =========================================================================
# THE END
# =========================================================================

?>