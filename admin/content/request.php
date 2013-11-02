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
$cur_page																= "?p=request";

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
																							`request`
																						WHERE
																							`active`=1
																						ORDER BY
																							`uid` DESC
																						");
	
	# Generate Listing
	$listing															= "";
	foreach ($data as $item) {
		$listing														.= "
			<tr>
				<td>{$item->datetime}</td>
				<td>{$item->Surname}</td>
				<td>{$item->Name}</td>
				<td>{$item->Cellphone}</td>
				<td>{$item->Email}</td>
				<td><a class='main_button' href='?p=clients&action=add&id={$item->uid}&surname={$item->Surname}&name={$item->Name}&cellphone={$item->Cellphone}&email={$item->Email}'>Add</a></td>
			</tr>
		";
	}
	
	# Generate HTML
	$html																= "
	<div class='content'>
	
		<h2>Requests</h2>
		
		<table class='results_table' width='100%'>
			<tr>
				<th>Date/Time</th>
				<th>Surname</th>
				<th>Name</th>
				<th>Contact Number</th>
				<th>Email</th>
				<th>&nbsp;</th>
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