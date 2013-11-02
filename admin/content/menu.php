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
$cur_page																= "?p=menu";

# ==================================================================================
# DISPLAY FUNCTIONS
# ==================================================================================

function display() {
	# Global Variables
	global $cur_page, $_db, $_GLOBALS, $validator;
	
	# Local Variables
	$count																= 0;
	$count2																= 0;
	$sub																= array();
	$pages																= array();
	
	# Get list of Pages
	$page_list															= array();
	$dir																= dirname(dirname(dirname(__FILE__))) . "/content/pages/";
	if (is_dir($dir)) {
		if ($d															= opendir($dir)) {
			while (($file = readdir($d)) !== false) {
				if (strlen($file) > 3 && strstr($file, ".html")) {
					$page_list[]										= $file;
				}
			}
		}
		else {
			logg("Unable to access Content directory `{$dir}`.");
		}
	}
	else {
		logg("Unable to access Content directory `{$dir}`.");
	}
	
	# Retrieve Content Pages
	for ($count = 0; $count < sizeof($page_list); $count++) {
		# Get File
		$file															= $page_list[$count];
		
		# Get Menu Item Settings
		$data															= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`menu`
																							WHERE
																								`content` = \"{$file}\"
																								AND `parent` = -1
																							ORDER BY
																								`order`");
		if (isset($data->uid) || !($_db->fetch_single("SELECT COUNT(*) FROM `menu` WHERE `content` = \"{$file}\""))) {
			$uid															= (isset($data->uid))? $data->uid : rand(1000, 9999);
			$label															= (isset($data->label))? $data->label : $file;
			$order															= (isset($data->order))? $data->order : "0";
			$this_parent													= (isset($data->parent))? $data->parent : "0";
			$sub															= array();
			
			# Generate Submenu
			$submenu														= "";
			$dir2															= dirname(dirname(dirname(__FILE__))) . "/content/pages/";
			for ($count2 = 0; $count2 < sizeof($page_list); $count2++) {
				# Get File
				$file2														= $page_list[$count2];
				$parent_id													= (isset($data->uid))? $data->uid : 0;
				
				# Get Submenu Item Settings
				$data2														= $_db->fetch_one("	SELECT
																									*
																								FROM
																									`menu`
																								WHERE
																									`content` = \"{$file2}\"
																									AND `parent` = '$parent_id'
																								ORDER BY
																									`order`");
				if (isset($data2->uid)) {
					$uid2													= (isset($data2->uid))? $data2->uid : rand(1000, 9999);
					$label2													= (isset($data2->label))? $data2->label : $file;
					$order2													= (isset($data2->order))? $data2->order : "0";
					
					# Add to Submenu
					$sub[]													= "{$order2} 
					<table width='100%'> 
						<tr>
							<td width='40'>
								<input type='text' name='order_{$uid2}' value=\"{$order2}\" style='width: 30px; text-align: right;' />
							</td>
							<td>
								<input type='text' name='label_{$uid2}' value=\"{$label2}\" />
							</td>
							<td>
								<input type='text' name='content_{$uid2}' value=\"{$file2}\" />
							</td>
							<td>
								" . menu_parent_select($page_list, $data2->parent, "parent_" . $uid2) . "
							</td>
						</tr>
					</table>";
				}
			}
			
			# Order Submenu
			for ($j = 0; $j < (sizeof($sub) - 1); $j++) {
				for ($k = $j + 1; $k < sizeof($sub); $k++) {
					if (substr($sub[$j], 0, strpos($sub[$j], " ")) > substr($sub[$k], 0, strpos($sub[$k], " "))) {
						$tmp												= $sub[$j];
						$sub[$j]											= $sub[$k];
						$sub[$k]											= $tmp;
					}
				}
			}
			
			# Generate Form Sub Item HTML
			$submenu														= "";
			foreach ($sub as $item) {
				$submenu													.= substr($item, strpos($item, " "));
			}
			$submenu														= (strlen($submenu))? "> Submenu<br />" . $submenu : "";
			
			# Add Menu Item to Form
			$pages[]														= "{$order} 
			<tr>
				<td width='40'>
					<input type='text' name='order_{$uid}' value=\"{$order}\" style='width: 30px; text-align: right;' />
				</td>
				<td>
					<input type='text' name='label_{$uid}' value=\"{$label}\" />
				</td>
				<td>
					<input type='text' name='content_{$uid}' value=\"{$file}\" />
				</td>
				<td>
					" . menu_parent_select($page_list, $this_parent, "parent_" . $uid) . "
				</td>
				<td>
					<a href='{$cur_page}&action=delete&id={$uid}'>
						<img src='include/images/delete_icon.png' border='0' />
					</a>
				</td>
			</tr>
			<tr>
				<td colspan='4'>
					{$submenu}
				</td>
			</tr>
			";
		}
	}
	
	# Order Pages
	for ($j = 0; $j < (sizeof($pages) - 1); $j++) {
		for ($k = $j + 1; $k < sizeof($pages); $k++) {
			if (substr($pages[$j], 0, strpos($pages[$j], " ")) > substr($pages[$k], 0, strpos($pages[$k], " "))) {
				$tmp													= $pages[$j];
				$pages[$j]												= $pages[$k];
				$pages[$k]												= $tmp;
			}
		}
	}
	
	# Generate Form Item HTML
	$form_elements														= "";
	foreach ($pages as $item) {
		$form_elements													.= substr($item, strpos($item, " "));
	}
	
	# Generate HTML
	$html																= "
	
	<div class='content' id='content'>
	
		<h2><span class='sign'></span>Menu</h2>
			
		<form method='POST' action='{$cur_page}&action=save'>
			
			<table class='results_table'>
				<tr>
					<th>Order</th>
					<th>Title</th>
					<th>File</th>
					<th>Parent</th>
				</tr>
				{$form_elements}
			</table>
			
			<br /><br />
			
			<input type='submit' value='Save' />
		</form>
		
	</div><!-- END: Content -->
	";
	
	# Display HTML
	print $html;
}

function menu_parent_select($pages, $active, $name) {
	# Global Variables
	global $_db;
	
	# Generate Page Options
	$options															= "";
	foreach ($pages as $item) {
		$uid															= $_db->fetch_single("SELECT `uid` FROM `menu` WHERE `content` = \"{$item}\"");
		$selected														= ($uid == $active)? " selected" : "";
		$options														.= "
		<option value='{$uid}'{$selected}>{$item}</option>
		";
	}
	
	# Generate HTML
	$html																= "
	<select name='{$name}'>
		<option value='-1'>None</option>
		{$options}
	</select>
	";
	
	# Return HTML
	return $html;
}

# ==================================================================================
# PROCESSING FUNCTIONS
# ==================================================================================

function save() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Get Variables
	$variables															= array();
	foreach ($_POST as $key => $val) {
		if (substr($key, 0, 8) == "content_") {
			$uid														= substr($key, 8);
			
			# Validate
			$uid														= $validator->validate($uid						, "String");
			$val														= $validator->validate($val						, "String");
			
			# Get Related POST Data
			$content													= $val;
			$order														= $validator->validate($_POST['order_' . $uid]	, "Integer");
			$label														= $validator->validate($_POST['label_' . $uid]	, "String");
			$parent														= $validator->validate($_POST['parent_' . $uid]	, "Integer");
			
			//print "UID: $uid | Content: $content | Order: $order | Label: $label | Parent: $parent | <br />\n"; // DEBUG
			
			# Save to Database
			if ($_db->fetch_single("SELECT COUNT(*) FROM `menu` WHERE `content` = \"{$content}\"")) {
				$_db->update(	"menu",
					array(		"label"									=> $label,
								"order"									=> $order,
								"parent"								=> $parent,
								"datetime"								=> date("Y-m-d H:i:s")
					),
					array(		"content"								=> $content)
				);
			}
			else {
				$_db->insert(	"menu",
					array(		"label"									=> $label,
								"order"									=> $order,
								"content"								=> $content,
								"parent"								=> $parent
					)
				);
			}
		}
	}
	
	# Display Information Banner
	print "
	<!-- Info Banner -->
	<div class='banner'>
		Menu Saved.
	</div><!-- END: Info Banner -->
	";
	
	# Display the Form
	display();
}

function delete() {
	# Global Variables
	global $_db, $cur_page, $validator;
	
	# Get GET Data
	$uid																= $validator->validate($_GET['id'], "Integer");
	
	# Delete
	$_db->delete("menu", "uid", $uid);
	
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
	else if ($action													== "save") {
		save();
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