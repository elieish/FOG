<?php
/**
 * CMS Templating System
 * 
 * @author Ralfe Poisson <ralfe@implyit.co.za>
 * @version 1.0
 * @copyright Copyright (C) Imply Development 2011
 * @package ImplyCMS
 */

# ====================================================
# SCRIPT SETTINGS
# ====================================================

$cur_page 			= "?p=file_manager";

# Handle Searches
if (isset($_POST['search_string'])){
	$search_string = $_POST['search_string'];
	$_SESSION['search_string'] = $search_string;
}
else if (isset($_SESSION['search_string'])){
	$search_string = $_SESSION['search_string'];
}
else {
	$search_string = "";
	$_SESSION['search_string'] = "";
}

# ====================================================
# DISPLAY FUNCTIONS
# ====================================================

function display() {
	# Global Variables
	global $_db, $cur_page, $validator;
	
	# Local Variables
	$root_dir															= dirname(dirname(dirname(__FILE__))) . "/content/";
	
	# Get GET Data
	$folder																= (isset($_GET['folder']))? $validator->validate($_GET['folder'], "String") : "/";
	
	# Log Activity
	logg("Viewing Documents");
	
	# Get a list of Parent Folders
	$data																= array();
	if ($folder == "/") {
		$handle															= opendir($root_dir);
		while (false !== ($file = readdir($handle))) {
			if (!($file == "." || $file == ".." || substr($file, 0, 1) == ".")) {
				$data[]													= $file;
			}
		}
	}
	
	$folder_listing														= "";
	foreach ($data as $item) {
		$folder_listing													.= "
		
				    <tr onclick=\"window.location.href = '{$cur_page}&folder={$item}';\">
				    	<td><img src='include/images/folder.png' style='float: left; margin-right: 5px;' /></td>
				        <td><strong>{$item}</strong></td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
				    </tr>
		";
	}
	if (!($folder == "/")) {
		$folder_listing													= "
		
				    <tr onclick=\"window.location.href = '{$cur_page}&folder=/';\">
				    	<td><img src='include/images/folder.png' style='float: left; margin-right: 5px;' /></td>
				        <td><strong>../</strong></td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
				    </tr>
		" . $folder_listing;
	}
	
	# Get a list of files
	$data																= array();
	if (!($folder == "/")) {
		$folder															= preg_replace('@[^a-zA-Z]@', '', $folder);
		$handle															= opendir($root_dir . $folder);
		while (false !== ($file = readdir($handle))) {
			if (!($file == "." || $file == ".." || substr($file, 0, 1) == ".")) {
				$data[]													= $file;
			}
		}
	}
	$file_listing														= "";
	foreach ($data as $item) {
		$file_listing													.= "
				    <tr>
				    	<td><img src='include/images/doc16.png' style='float: left; margin-right: 5px;' /></td>
				        <td><a href='../content/{$folder}/{$item}' target='_blank'>{$item}</a></td>
				        <td>content/{$folder}/{$item}</td>
				        <td><a href='{$cur_page}&action=delete&folder={$folder}&file={$item}'><img src='include/images/delete_icon.png' border='0' /></a></td>
				    </tr>
		";
	}
	
	# Compile listing
	$listing															= $folder_listing . $file_listing;
	
	# Get Folder Name
	$folder_name														= ($folder)? " in <span style='text-decoration: underline;'>" . ($folder) . "</span>" : "";
	
	# File Upload
	$file_upload													= "
				
			<div style='float: left; width: 98%; background-color: #FFF; padding: 10px; border: 1px solid #546D81; margin-bottom: 20px; -moz-box-shadow: 0 2px 4px #777777;'>
				" . upload_form($folder) . "
			</div>
				
	";
	
	# Generate HTML
	$html = "
	<h2>Documents</h2>
	
	{$file_upload}
	
	<!-- File Listing -->
	<div id='file_listing' style='float:left; width: 100%;'>
		
		<table class='results_table' width='100%' cellspacing='0'>
		    <tr>
		        <th style='width: 20px;'>&nbsp;</th>
		        <th>Document{$folder_name}</th>
		        <th>Link URL Text</th>
		        <th style='width: 20px;'><img src='include/images/delete_icon.png' /></th>
		    </tr>
		    {$listing}
		</table>
		
	</div><!-- END: File Listing -->
	
	<script>cur_folder = $folder;</script>
	
	";
	
	# Display Page
	print $html;
}

function upload_form($folder="") {
	# Global Variables
	global $cur_page, $_db, $validator;
	
	# Validate
	$folder																= $validator->validate($folder, "String");
	$folder																= preg_replace('@[^a-zA-Z]@', '', $folder);
	
	# Generate HTML
	$html																= "
	<form enctype='multipart/form-data' action='{$cur_page}&action=upload' method='POST'>
		<input type='hidden' name='folder' value='{$folder}' />
		Add File : <input name='new_file' type='file' /><br /><br />
		<input type='submit' value='Upload' />
	</form>
	
	";
	
	# Return HTML
	return $html;
}

# ====================================================
# PROCESSING FUNCTIONS
# ====================================================

function upload() {
	# Global Variables
	global $cur_page, $_db, $validator;
	
	# Log Activity
	logg("Uploading File.");

	# Validate
	$folder																= $validator->validate($_POST['folder'], "String");
	$folder																= preg_replace('@[^a-zA-Z]@', '', $folder);
	$file																= $_FILES['new_file'];
	
	# Log History
	logg("Upload: File {$file['name']} to /{$folder}.");
	
	# Check file exists
	if (strlen($file['tmp_name'])){
		# Security Checks
		if (!(
			strstr($file['name'], ".exe") ||
			strstr($file['name'], ".php") ||
			strstr($file['name'], ".pl") ||
			strstr($file['name'], ".py") || 
			strstr($file['name'], ".sh")
		)) {
			# Upload File
			$destination 											= dirname(dirname(dirname(__FILE__))) . "/content/" . $folder . "/" . $file["name"];
			logg("Upload: Uploading to $destination .");
			if (!(copy($file["tmp_name"], $destination))){
				logg("Upload: Error copying file {$file['tmp_name']} to $destination.");
			}
		}
		else {
			# Logg Security Alert
			logg ("SECURITY ALERT : " . get_user_email(get_user_uid()) . " is trying to upload an illegal file ( {$file['name']} ).");
		}
	}
	
	# Redirect
	redirect($cur_page . "&folder=" . $folder);
}

function delete() {
	# Global Variables
	global $cur_page, $_db, $validator;
	
	# Log Activity
	logg("Deleting File.");

	# Get GET Data
	$folder																= $validator->validate($_GET['folder'], "String");
	$folder																= preg_replace('@[^a-zA-Z]@', '', $folder);
	$folder																= (strlen(trim($folder)))? "/" . trim($folder) : "/";
	$file																= $validator->validate($_GET['file'], "String");
	
	# Delete
	$file_path															= dirname(dirname(dirname(__FILE__))) . "/content" . $folder . "/" . $file;
	if(!unlink($file_path)) {
		logg("Delete File: Could not delete {$file_path}.");
		print "Delete File: Could not delete {$file_path}.";
		die();
	}
	
	# Redirect
	redirect($cur_page . "&folder=" . $folder);
}

# ====================================================
# ACTION HANDLER
# ====================================================

if (isset($_GET['action'])){
	$action 															= $_GET['action'];
	if ($action 														== "display") {
		display();
	}
	else if ($action 													== "upload") {
		upload();
	}
	else if ($action 													== "delete") {
		delete();
	}
	else {
		print "<div class='error'><b>ERROR</b> : Invalid Action `$action`.</div>\n";
	}
}
else {
	display();
}

# ====================================================
# THE END
# ====================================================

?>