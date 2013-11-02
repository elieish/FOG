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

function template_top() {
	ob_start();
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Catalogue & eCommerce Menu Items
	$catalogue_menu														= "";
	if ($_GLOBALS['catalogue_enabled']) {
		$catalogue_menu													= "
			<!-- Menu Item -->
			<li><a href='?p=products'>Catalogue</a></li>
			
			<!-- Menu Item -->
			<li><a href='?p=request'>Requests</a></li>
			
			<!-- Menu Item -->
			<li><a href='?p=clients'>Members</a></li>
			
		";
	}
	
	# Recruitment Menu Items
	$recruitment_menu													= "";
	if ($_GLOBALS['recruitment_enabled']) {
	$recruitment_menu													= "
			<!-- Menu Item -->
			<li><a href='?p=jobs'>Jobs</a></li>
			
			<!-- Menu Item -->
			<!--<li><a href='?p=candidates'>Candidates</a></li>-->
			";
	}
	
	# Generate HTML
	$html																= "<!DOCTYPE html>
	<html>
		<head>
			<!-- Title -->
			<title>CMS Administration</title>
			
			<!-- CSS -->
		
			<link href='include/css/bootstrap.css' rel='stylesheet' type='text/css' />
			<link href='include/css/bootstrap-responsive.min.css' type='text/css' />
			<link href='include/css/datepicker.css' rel='stylesheet' type='text/css' />
			<link href='include/css/style.css' rel='stylesheet' type='text/css' />
			<link href='include/css/editor.css' rel='stylesheet' type='text/css' />
			<link href='include/css/file_manager.css' rel='stylesheet' type='text/css' />
		
			
			<!-- JS -->
			<script src='include/js/jquery-1.8.2.js'></script>
			<script src='include/js/bootstrap.js'></script>	
			<script src='include/js/ui.datepicker.js'></script>
			<script src='include/js/editor.js'></script>
			
		</head>
		<body>
		
		<div class='page_wrapper' id='page_wrapper'>
			
			<!-- Header -->
				<div class='header' id='header'>

					<ul class='menu' id='menu'>
						
						<a href='?p=config'><span class='spanner'></span></a>
						
						<!-- Website -->
						<li><a href='../' target='_blank'>{$_GLOBALS['site_name']}</a></li>
														
						<!-- Menu Item -->
						<li><a href='?p=config'>Configuration</a></li>
													
						<!-- Menu Item -->
						<li><a href='?p=editor'>Editor</a></li>
													
						<!-- Menu Item -->
						<li><a href='?p=file_manager'>File Manager</a></li>
																
						<!-- Menu Item -->
						<li><a href='?p=menu'>Menu</a></li>
													
						<!-- Menu Item -->
						<li><a href='?p=users'>Users</a></li>
						
						{$catalogue_menu}
						
						{$recruitment_menu}
						
						<!-- Login -->
						<span >
							<li class='login'>
								<a href='?p=logout'>Logout</a>
							</li>
							<li class='login'>
								<a href='?p=users'>" . user_get_name() . "</a>
							</li>
						</span>
						<!-- END: Login -->
						
					</ul><!-- END: Menu -->
					
				</div><!-- Header -->
				
				<!-- Content -->
				<div class='content_wrapper' id='content_wrapper'>
					";
	
	# Display HTML
	print $html;
}

function template_bottom() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Generate HTML
	$html																= "
					
				</div><!-- END: Content Wrapper -->
				
				<!-- Footer -->
				<div class='footer' id='footer'>
					<div class='version'>
						version {$_GLOBALS['version']}
					</div>
					<div class='copyright'>
						Copyright &copy; <a href='' target='_blank'>Foundation of Grace</a> 2013
					</div>
				</div><!-- END: Footer -->
				
			</div><!-- END: Page Wrapper -->
		</body>
	</html>";
	
	# Display HTML
	print $html;
}

function results_table($head, $body) {
	# Generate Headings
	$headings															= "";
	foreach ($head as $item) {
		$headings														.= "
			<th>{$item}</th>
		";
	}
	
	# Generate Rows
	$rows																= "";
	foreach ($body as $row) {
		$fields															= "";
		foreach ($row as $item) {
			$fields														.= "
				<td>{$item}</td>
			";
		}
		$rows															.= "
		<tr>
			{$fields}
		</tr>
		";
	}
	
	# Construct HTML
	$html																= "
	<table class='results_table'>
		<tr>
			{$headings}
		</tr>
		{$rows}
	</table>
	";
	
	# Return HTML
	return $html;
}

function button($text, $link, $align="right", $action="href", $tag="a", $tag_class="link") {
	# Generate HTML
	$html 																= "
	<!-- Button -->
	<{$tag} class='{$tag_class}' {$action}='{$link}'>
		<div class='main_button'>
			{$text}
		</div>
	</{$tag}><!-- END: Button -->
	";
	# Return HTML
	return $html;
}

function redirect($url) {
	print "<script>window.location = \"{$url}\";</script>";
	die();
}

function authenticate() {
	if (!is_logged_in()) {
		redirect("login.php");
		die();
	}
}

function get_user_uid() {
	if (isset($_SESSION['user_uid'])) {
		if ($_SESSION['user_uid'] > 0) {
			return $_SESSION['user_uid'];
		}
	}
	return 0;
}

function is_logged_in() {
	if (get_user_uid()) {
		return true;
	}
	return false;
}

function user_get_name($user_id=0) {
	# Global Variables
	global $_db;
	
	# User ID
	$user_id															= ($user_id)? $user_id : get_user_uid();
	
	# Get Data
	$data																= $_db->fetch_single("	SELECT
																									CONCAT(`first_name`, ' ', `last_name`)
																								FROM
																									`users`
																								WHERE
																									`uid` = '$user_id'");
	
	# Return Data
	return $data;
}

# ==================================================================================
# THE END
# ==================================================================================

?>