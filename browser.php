<?php
/**
 * CMS Templating System
 * 
 * @author Richard Keller <richardk@implyit.co.za>
 * @version 1.0
 * @copyright Copyright (C) Imply Development 2011
 * @package ImplyCMS
 */

# ==================================================================================
# SCRIPT SETUP
# ==================================================================================

# Include Required Scripts
include_once ("include/include.php");


function browse() {
	
		logg('called');
	
	
	
	
	# Get Page Content
	$type																= $_GET['t'];
	$CKEditorFuncNum													= $_GET['CKEditorFuncNum'];
	$types																= array();
	$types['images']													= array('jpg','gif','png');
	$types['documents']													= array('doc','docx','xls','xlsx','pdf','txt');
	
	if ($types[$type]) {
		$types															= $types[$type];
	}
	else {
		$types															= array_unique(array_merge(	$types['images'],
																									$types['documents']
																									));
	}
	
	$dir																= dirname(__FILE__) . "/content/files/";
	$type_list															= "";
	if (is_dir($dir)) {
		$types															= "{" . $dir . "*." . implode("," . $dir . "*.", $types) . "}";
		foreach (glob($types, GLOB_BRACE) as $filename) {
			$dimensions													= get_resized_image_dimensions($filename, 200, 200);
			$filename													= basename($filename);
			$js_callback												= "window.opener.CKEDITOR.tools.callFunction({$CKEditorFuncNum},\"content/files/{$filename}\"); self.close()";
			$type_list													.= "<img onclick='{$js_callback}' style='margin: 10px; cursor: pointer; border: 2px solid #cecece;' src='content/files/{$filename}' width='{$dimensions['w']} height='{$dimensions['h']}'>";
		}
	}
	
	$html																	= "
	<html>
		<head>
			<script lang='javascript' src='admin/include/js/jquery.js'></script>
			<script lang='javascript' src='admin/include/js/ckeditor/ckeditor.js'></script>
			<script lang='javascript' src='admin/include/js/ckeditor/jquery.ckeditor.js'></script>
		</head>
		<body>
			{$type_list}
		</body>
	<html>
	";
	
	print $html;

}

function upload() {

	$CKEditorFuncNum													= $_GET['CKEditorFuncNum'];
	
	# Check whether a file upload was attempted
	if ($_FILES['upload']) {
		$file	=	$_FILES['upload'];
		logg('files uploading');
		
		# Check that file exists
		if (strlen($file['tmp_name'])){
			
			logg('tmp name');
			
			# Security Checks
			if (!(
				strstr($file['name'], ".exe") ||
				strstr($file['name'], ".php") ||
				strstr($file['name'], ".pl") ||
				strstr($file['name'], ".py") || 
				strstr($file['name'], ".sh") ||
				strstr($file['name'], ".gif") ||
				strstr($file['name'], ".png") ||
				strstr($file['name'], ".bmp") ||
				strstr($file['name'], ".psd") ||
				strstr($file['name'], ".jpeg") ||
				strstr($file['name'], ".tiff") ||
				strstr($file['name'], ".html")
			)) {
				logg('security check passed');
				$filename												= preg_replace('@[^a-zA-Z0-9_.]@', '', $file['name']);
				$fullpath												= dirname(__FILE__) . "/content/files/" . $filename;
				
				if ($filename) {
					logg('filename is ' . $filename);
					if (copy($file["tmp_name"], $fullpath)){
						logg('copied successfully');
						$img_url		= "content/files/{$filename}";
						$js				= "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction({$CKEditorFuncNum}, '{$img_url}', '');</script>";
						print $js;
					}
					else {
						$js				= "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction({$CKEditorFuncNum}, '', 'Error: Could not upload image');</script>";
						print $js;
					}
				}
			}
		}
	}
}

# ==================================================================================
# THE END
# ==================================================================================


if (isset($_GET['action'])) {
	$action																= $_GET['action'];
	if ($action 														== "browse") {
		browse();
	}
	else if ($action 													== "upload") {
		upload();
	}
	else {
		browse();
	}
}
else {
	browse();
}


?>