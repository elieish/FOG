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
$cur_page																= "?p=candidates";

# ==================================================================================
# DISPLAY FUNCTIONS
# ==================================================================================

function display() {
	# Global Variables
	global $_db, $_GLOBALS, $validator, $cur_page;
	
	# Get Data
	$data																= $_db->fetch("	SELECT
																							*
																						FROM
																							`candidates`
																						WHERE
																							`active` = 1
																						ORDER BY
																							`uid` DESC
																						");
	
	# Generate Listing
	$listing															= "";
	foreach ($data as $item) {
		$listing														.= "
			<tr>
				<td>{$item->datetime}</td>
				<td>{$item->name}</td>
				<td>{$item->contact_number}</td>
				<td><a href='mailto:{$item->email}'>{$item->email}</a></td>
				<td><a href='../content/files/{$item->cv}' target='_blank'><img src='include/images/file_icon.png' height='30' /></a></td>
				<td><a href='$cur_page&action=delete&id={$item->uid}'><img src='include/images/delete_icon.png' border='0' /></a></td>
			</tr>
		";
	}
	
	# Generate HTML
	$html																= "
	<div class='content'>

		<h2>Candidates</h2>
		
		<table width='100%' class='results_table'>
			<tr>
				<th>Submitted On</th>
				<th>Name</th>
				<th>Contact Number</th>
				<th>Email Address</th>
				<th>CV</th>
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

function delete() {
	# Global Variables
	global $_db, $validator, $cur_page;
	
	# Get GET Data
	$uid																= $validator->validate($_GET['id'], "Integer");
	
	# Delete from Database
	$_db->delete("candidates", "uid", $uid);
	
	# Redirect
	redirect($cur_page);
}

# ==================================================================================
# ACTION HANDLER
# ==================================================================================

if (isset($_GET['action'])) {
	$action																= $_GET['action'];
	if ($action 														== "display") {
		display();
	}
	else if ($action													== "delete") {
		delete();
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