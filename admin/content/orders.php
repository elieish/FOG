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

function display() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Get Data
	$data																= $_db->fetch("	SELECT
																							*
																						FROM
																							`orders`
																						ORDER BY
																							`uid` DESC
																						");
	
	# Generate Listing
	$listing															= "";
	foreach ($data as $item) {
		$listing														.= "
			<tr>
				<td>{$item->datetime}</td>
				<td>{$item->reference}</td>
				<td>{$item->name}</td>
				<td>{$item->contact_number}</td>
				<td>{$item->email}</td>
				<td>{$item->amount}</td>
			</tr>
		";
	}
	
	# Generate HTML
	$html																= "
	<div class='content'>
	
		<h2>Orders</h2>
		
		<table class='results_table' width='100%'>
			<tr>
				<th>Date/Time</th>
				<th>Reference No.</th>
				<th>Name</th>
				<th>Contact Number</th>
				<th>Email</th>
				<th>Amount</th>
			</tr>
			{$listing}
		</table>
		
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