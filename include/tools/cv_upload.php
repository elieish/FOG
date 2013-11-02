<?php
/**
 * CV Upload
 * 
 * @author Ralfe Poisson <ralfe@implyit.co.za>
 * @version 1.0
 * @copyright Copyright (C) Imply Development 2011
 * @package ImplyCMS
 */

# ==================================================================================
# CONFIGURATION
# ==================================================================================

# Configuration Variables
$redirect																= "../../?p=home.html";
$directory																= dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "content" . DIRECTORY_SEPARATOR . "files" . DIRECTORY_SEPARATOR;

# Include Required Scripts
include_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "include.php");

# ==================================================================================
# CV UPLOAD
# ==================================================================================

# Get POST Data
$name																	= $validator->validate($_POST['name']			, "String");
$email																	= $validator->validate($_POST['email']			, "String");
$contact_number															= $validator->validate($_POST['contact_number']	, "String");
$job_title																= $validator->validate($_POST['job_title']		, "String");
$cv																		= (isset($_FILES['cv']))? $_FILES['cv'] : 0;

# Add to Database
$uid																	= $_db->insert(
	"candidates",
	array(
		"datetime"														=> date("Y-m-d H:i:s"),
		"name"															=> $name,
		"email"															=> $email,
		"contact_number"												=> $contact_number,
		"job_title"														=> $job_title,
		"active"														=> 1
	)
);

# Upload CV
if (isset($cv['tmp_name'])) {
	$filename															= "cv" . $uid . "_" . str_replace(" ", "_", strtolower($name)) . substr($cv['name'], strrpos($cv['name'], "."));
	$destination														= $directory . $filename;
	if (!copy($cv['tmp_name'], $destination)) {
		logg("CV Upload ERROR: Could not copy {$cv['tmp_name']} to $destination.");
	}
	else {
		$_db->update(
			"candidates",
			array(
				"cv"													=> $filename
			),
			array(
				"uid"													=> $uid
			)
		);
	}
}

# Redirect
print "<script>window.location.replace(\"{$redirect}\");</script>";

# ==================================================================================
# THE END
# ==================================================================================

?>