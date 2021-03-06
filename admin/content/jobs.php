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
$cur_page																= "?p=jobs";

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
	$data									= $_db->fetch("	SELECT
																*
															FROM
																`jobs`
															WHERE
																`active` = 1
															ORDER BY
																`datetime` DESC");
	
	# Generate Listing
	$head									= array("#", "Job Title", "Location", "Salary", "Email");
	$body									= array();
	foreach ($data as $item) {
		$body[]								= array(	$item->uid . " <a href='$cur_page&action=delete&id={$item->uid}' class='remove'>x</a>",
														"<a href='$cur_page&action=profile&id={$item->uid}'>" . $item->job_title . "</a>",
														$item->location,
														$item->salary,
														"<a href='mailto:{$item->email}'>" . $item->email . "</a>"
													);
	}
	$listing								= results_table($head, $body);
	
	# Generate HTML
	$html									= "
	
	<div class='content' id='content'>
	
		<h2>Jobs </h2>
				
		" . button("Add", "$cur_page&action=add") . "
		
		<!-- Listing -->
		{$listing}
	
	</div><!-- END: Content -->
	";
	
	# Display HTML
	print $html;
}

function profile() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS;
	
	# Get GET Data
	$uid									= $_GET['id'];
	
	# Generate HTML
	$html									= "
	<!-- Title -->
	<h2>Job Administration</h2>
	
	<!-- Form -->
	" . item_form($uid) . "
	";
	
	# Display HTML
	print $html;
}

function add() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS;
	
	# Generate HTML
	$html									= "
	<!-- Title -->
	<h2>New Job</h2>
	
	<!-- Form -->
	" . item_form() . "
	";
	
	# Display HTML
	print $html;
}

function item_form($uid=0) {
	# Global Variables
	global $_db, $cur_page;
	
	# Validate
	$uid																= intval($uid);

	# Get Data
	$item																= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`jobs`
																							WHERE
																								`uid` = {$uid}");
	
	# Generate HTML
	$html																= "
	<form id='item_form' method='POST' action='{$cur_page}&action=save'>
		<!-- Job Title -->
		<strong>Job title</strong><br />
		<input type='text' name='job_title' value=\"{$item->job_title}\" />
		<br /><br />
		
		<!-- Location -->
		<strong>Location</strong><br />
		<input type='text' name='location' value=\"{$item->location}\" />
		<br /><br />
		
		<!-- Salary -->
		<strong>Salary</strong><br />
		<input type='text' name='salary' value=\"{$item->salary}\" />
		<br /><br />
		
		<!-- Text -->
		<strong>Advert</strong><br />
		<textarea name='text' rows='10' cols='50'>{$item->text}</textarea>
		<br /><br />
		
		<!-- Email -->
		<strong>Email</strong><br />
		<input type='text' name='email' value=\"{$item->email}\" />
		<br /><br />
		
		<!-- Active -->
		<strong>Active</strong><br />
		<input type='checkbox' name='active' " . is_checked($item->active) . " />
		<br /><br />
		
		<!-- Submit -->
		<input type='submit' value='Save' />
	</form>
	";

	# Return HTML
	return $html;
}

function is_checked($val) {
	return ($val)? " checked " : "";
}

# =========================================================================
# PROCESSING FUNCTIONS
# =========================================================================

function save() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS, $validator;
	
	# Get POST Data
	$uid								= $validator->validate($_POST['uid']			, "Integer");
	$job_title							= $validator->validate($_POST['job_title']		, "String");
	$location							= $validator->validate($_POST['location']		, "String");
	$salary								= $validator->validate($_POST['salary']			, "String");
	$text								= $validator->validate($_POST['text']			, "String");
	$email								= $validator->validate($_POST['email']			, "Email");
	$active								= (isset($_POST['active']))? 1 :  0;
	
	# Insert Into Database
	if (!$uid) {
		$uid							= $_db->insert(
			"jobs",
			array(
				"job_title"				=> $job_title
			)
		);
	}
	
	# Update Database
	$_db->update(
		"jobs",
		array(
			"job_title"					=> $job_title,
			"location"					=> $location,
			"salary"					=> $salary,
			"text"						=> $text,
			"email"						=> $email,
			"active"					=> $active
		),
		array(
			"uid"						=> $uid
		)
	);
	
	# Set info message
	set_info("Job $job_title has been saved successfully.");
	
	# Redirect
	redirect("$cur_page");
}

function delete() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS, $validator;
	
	# Get GET Data
	$uid								= $validator->validate($_GET['id'], "Integer");
	
	# Get Name
	$username							= $_db->fetch_single("SELECT `job_title`
																FROM `jobs`
																WHERE `uid` = \"$uid\"");
	
	# Delete From Database
	$_db->update(
		"jobs",
		array(
			"active"					=> 0
		),
		array(
			"uid"						=> $uid
		)
	);
	
	# Set info message
	set_info("Job $username has been deleted successfully.");
	
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
	else if ($action == "profile") {
		profile();
	}
	else if ($action == "add") {
		add();
	}
	else if ($action == "save") {
		save();
	}
	else if ($action == "delete") {
		delete();
	}
	else {
		error("Invalid action `$action`.");
	}
}
else {
	display();
}

# ==================================================================================
# THE END
# ==================================================================================

?>