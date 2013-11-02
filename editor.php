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


function display() {
	
	# Get page content
	$p																	= (isset($_GET['p']))? preg_replace('@[^a-zA-Z0-9_]@', '', $_GET['p']) : $_GLOBALS['default_page'];
	$type																= (isset($_GET['t']))? preg_replace('@[^a-zA-Z0-9_]@', '', $_GET['t']) : "content";
	
	if ($type == "content") {
		$content_file													= dirname(__FILE__) . "/content/pages/{$p}.html";
	}	
	elseif ($type == "template") {
		$content_file													= dirname(__FILE__) . "/template/html/{$p}.html";
	}
	elseif ($type == "js") {
		$content_file													= dirname(__FILE__) . "/template/js/{$p}.js";
	}
	elseif ($type == "css") {
		$content_file													= dirname(__FILE__) . "/template/css/{$p}.css";
	}
	
	
	if ($content_file) {
		
		$content														= "";
		if (file_exists($content_file) && is_readable($content_file)) {
			$content													= file_get_contents($content_file);
		}
		
		else
			$content													= "   ";
		if (($type == "content") || ($type == "template")) {
			$ckeditor													= "

						$('#page_data').ckeditor(function() {
							$('body').css('margin','0');
							$('#cke_page_data').css( {
								'padding'				:	'0',
								'-moz-border-radius'	:	'0',
								'-webkit-border-radius'	:	'0',
								'border-radius'			:	'0'
							});
							$('.cke_wrapper.cke_ltr').css( {
								'-moz-border-radius'	:	'0',
								'-webkit-border-radius'	:	'0',
								'border-radius'			:	'0'
							});
							
						}, {
							fullPage					: true,
							resize_enabled				: true,
							customConfig				: 'custom/editor.js',
							filebrowserImageBrowseUrl	: 'browser.php?action=browse&t=images',
							filebrowserBrowseUrl		: 'browser.php?action=browse',
							filebrowserImageUploadUrl	: 'browser.php?action=upload&t=image',
							filebrowserUploadUrl		: 'browser.php?action=upload'
						});

																		  ";
		}
		
		else {
			$ckeditor													= "";
		}
		
		$html															= "
		<html>
			<head>
				<script lang='javascript' src='admin/include/js/jquery.js'></script>
				<script lang='javascript' src='admin/include/js/ckeditor/ckeditor.js'></script>
				<script lang='javascript' src='admin/include/js/ckeditor/jquery.ckeditor.js'></script>
			</head>
			<body>
				
				
				<form id='page_content'>
				    
					<textarea id='page_data' style='width:100%; height: 90%;'>{$content}</textarea>
					<input type='button' value='Save' id='page_save' /></br>
					    
				</form>
				
				<script>
				
		
					$(document).ready(function() {

						{$ckeditor}
					
						$('#page_save').click(function() {
	
							var postdata = $('#page_data').val();
						
							var pagename='{$p}';
	
							$.ajax({
								type:		'POST',
								async:		true,
								dataType:	'html',
								url:		'editor.php?action=save&t={$type}&page={$p}',
								data:		{	postdata: postdata,pagename: pagename},
					
								success:	function(result) {
									alert(result);
								}
							});
						});
						
					
						
						
						
					});
					
				</script>
				
			</body>
		<html>
		";
		
		print $html;		
		
	}

}

function save() {
	
	global $validator, $_db;
	
	$data																= trim($_POST['postdata']);
	
	
	
	
	$type																= strtolower($_GET['t']);	

	$p																	= $_GET['page'];
	$last_period														= strrpos($p, ".");
	if ($last_period !== false) {
		$p																= substr($p, 0, strlen($p) - $last_period);
	}
	$p																	= preg_replace('@[^a-zA-Z0-9_]@', '', $p);
	
	if ($p) {
		
		if (($type == "content") || ($type == "template")){
	
			$body_open													= strpos($data, "<body>");
			if ($body_open !== false) {
				$data													= trim(substr($data, ($body_open + 6)));
			}
			
			$body_close													= strpos($data, "</body>");
			if ($body_close !== false) {
				$data													= trim(substr($data, 0, $body_close));
			}
			
			if ($type == "content") {
				$content_file											= dirname(__FILE__) . "/content/pages/{$p}.html";
			}
			elseif ($type == "template") {
				$content_file											= dirname(__FILE__) . "/template/html/{$p}.html";
			}
		
		}
		elseif ($type == "css") {
			$content_file												= dirname(__FILE__) . "/template/css/{$p}.css";
		}
		elseif ($type == "js") {
			$content_file												= dirname(__FILE__) . "/template/js/{$p}.js";
		}
		
		if (!file_exists($content_file)) {
			$handle														= fopen($content_file, 'a');
			fclose($handle);
		}
	
		if ($content_file && $data && (is_writable($content_file))) {
			$content													= file_put_contents($content_file, $data);
			print "Page saved";
		
		}
		else {
			print "Could not save page.";
		}		
	}
	else {
		print "Could not save page.";
	}		


	
}


# ==================================================================================
# THE END
# ==================================================================================


if (isset($_GET['action'])) {
	$action																= $_GET['action'];
	if ($action 														== "display") {
		display();
	}
	else if ($action													== "save") {
		save();
	}
	else {
		display();
	}
}
else {
	display();
}


?>