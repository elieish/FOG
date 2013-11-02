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
$cur_page																= "?p=products";

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
																`categories`
															ORDER BY
																`name`");
	
	# Generate Listing
	$head									= array("#", "Name");
	$body									= array();
	foreach ($data as $item) {
		$body[]								= array(	$item->uid . " <a href='$cur_page&action=delete&id={$item->uid}' class='remove'>x</a>",
														"<a href='$cur_page&action=profile&id={$item->uid}'>" . $item->name . "</a>"
													);
	}
	$listing								= results_table($head, $body);
	
	# Generate HTML
	$html									= "
	
	<div class='content' id='content'>
	
		<h2><span class=''></span>Product Categories</h2>
				
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
	$uid									= intval($_GET['id']);
	
	# Get Item Name
	$name																= $_db->get_data("categories", "name", "uid", $uid);
	
	# Generate Listing
	$data									= $_db->fetch("	SELECT
																*
															FROM
																`products`
															WHERE
																`category` = {$uid}
															");
	$listing								= "";
	foreach ($data as $item) {
		$listing							.= "
			<tr>
				<td><a href='{$cur_page}&action=product_profile&id={$item->uid}'>{$item->name}</a></td>
				<td>R " . sprintf("%01.2f", $item->price) . "</td>
			</tr>
		";
	}
	
	# Generate HTML
	$html									= "
	<div class='content' id='content'>
		
		<!-- Title -->
		<h2>Products: {$name}</h2>
		
		<!-- Add Button -->
		<a href='{$cur_page}&action=add_product&category={$uid}'>
			<div class='main_button'>
				Add
			</div>
		</a>
		
		<!-- Listing -->
		<table class='results_table' width='100%'>
			<tr>
				<th>Product</th>
				<th>Price</th>
			</tr>
			{$listing}
		</table>
	
	</div><!-- END: Content -->
	";
	
	# Display HTML
	print $html;
}

function add() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS;
	
	# Generate HTML
	$html									= "
	
	<div class='content' id='content'>
		
		<!-- Title -->
		<h2>New Category</h2>
		
		<!-- Form -->
		" . item_form() . "
		
	</div><!-- END: Content -->
	";
	
	# Display HTML
	print $html;
}

function add_product() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS, $validator;
	
	# Get GET Data
	$category								= $validator->validate($_GET['category'], "Integer");
	
	# Get Category name
	$category_name							= $_db->get_data("categories", "name", "uid", $category);
	
	# Generate HTML
	$html									= "
	
	<div class='content' id='content'>
	
		<!-- Title -->
		<h2>{$category_name}: New Product</h2>
		
		<!-- Form -->
		" . product_item_form(0, $category) . "
		
	</div><!-- END: Content -->
	";

	# Display HTML
	print $html;
}

function item_form($uid=0) {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS;
	
	# Get Item
	$item									= $_db->fetch_one("SELECT * FROM `categories` WHERE `uid` = {$uid}");
	
	# Generate HTML
	$html									= "
	<form method='POST' action='{$cur_page}&action=save'>
		<input type='hidden' name='uid' value=\"{$uid}\" />
		
		<strong>Name</strong>
		<br />
		<input type='text' name='name' value=\"{$item->name}\" />
		<br /><br />
		
		<input type='submit' value='Save' />
	</form>
	";
	
	# Return HTML
	return $html;
}

function product_item_form($uid=0, $category=0) {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS;
	
	# Get Item
	$item									= $_db->fetch_one("SELECT * FROM `products` WHERE `uid` = {$uid}");
	
	# Set Category
	$category								= (isset($item->category))? $item->category : $category;

	# Generate HTML
	$html									= "
	<form method='POST' action='{$cur_page}&action=save_product'>
		<input type='hidden' name='uid' value=\"{$uid}\" />
		<input type='hidden' name='category' value=\"{$category}\" />
		
		<strong>Name</strong>
		<br />
		<input type='text' name='name' value=\"{$item->name}\" />
		<br /><br />
		
		<strong>Price</strong>
		<br />
		R <input type='text' name='price' value=\"{$item->price}\" />
		<br /><br />
		
		<input type='submit' value='Save' />
	</form>
	";
		
	# Return HTML
	return $html;
}

function product_profile() {
	# Global Variables
	global $_db, $cur_page, $validator, $_GLOBALS;
	
	# Get GET Data
	$uid																= $validator->validate($_GET['id'], "Integer");
	
	# Get Data
	$item																= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`products`
																							WHERE
																								`uid` = {$uid}
																							"); 
	
	# Get Category Name
	$category_name 														= $_db->get_data("categories", "name", "uid", $item->category);
	
	# Get Image
	$image																= "";
	if (strlen($item->picture)) {
		$image															= "<img src='../content/files/{$item->picture}' /><br /><br />";
	}

	# Generate HTML
	$html 																= "
	
	<div class='content' id='content'>
	
		<h2>{$item->name}</h2>
		<h3>Category: <a href='{$cur_page}&action=profile&id={$item->category}'>{$category_name}</a></h3>
		
		<table width='100%'>
			<tr>
				<td>
					{$image}
					
					<!-- Image Form -->
					<form id='product_image_form' method='POST' action='{$cur_page}&action=upload_product_photo' enctype='multipart/form-data'> 
						<input type='hidden' name='product' value='{$uid}' />
						Upload Product Image<br />
						<input type='file' name='product_image' />
						<br /><br />
						<input type='submit' value='Upload' />
					</form><!-- END: Image Form -->
					
				</td>
				<td>
					" . product_item_form($uid) . "
				</td>
			</tr>
		</table>
		
	</div><!-- END: Content -->
	";
	
	# Return HTML
	print $html;
}

# =========================================================================
# PROCESSING FUNCTIONS
# =========================================================================

function save() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS, $validator;
	
	# Get POST Data
	$uid								= $validator->validate($_POST['uid']	, "Integer");
	$name								= $validator->validate($_POST['name']	, "String");
	
	# Insert Into Database
	if (!$uid) {
		$uid							= $_db->insert(
			"categories",
			array(
				"name"					=> $name
			)
		);
	}
	
	# Update Database
	$_db->update(
		"categories",
		array(
			"name"						=> $name
		),
		array(
			"uid"						=> $uid 
		)
	);
	
	# Set info message
	set_info("Category $name has been saved successfully.");
	
	# Redirect
	redirect("$cur_page&action=profile&id={$uid}");
}

function save_product() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS, $validator;
	
	# Get POST Data
	$uid								= $validator->validate($_POST['uid']		, "Integer");
	$category							= $validator->validate($_POST['category']	, "Integer");
	$name								= $validator->validate($_POST['name']		, "String");
	$price								= $validator->validate($_POST['price']		, "Float");
	
	# Insert Into Database
	if (!$uid) {
		$uid							= $_db->insert(
			"products",
			array(
				"datetime"				=> date("Y-m-d H:i:s"),
				"user"					=> get_user_uid(),
				"name"					=> $name,
				"category"				=> $category,
				"price"					=> $price,
				"active"				=> 1
			)
		);
	}
	
	# Update Database
	$_db->update(
		"products",
		array(
			"name"						=> $name,
			"price"						=> $price
		),
		array(
			"uid"						=> $uid
		)
	);
		
	# Set info message
	set_info("Product $name has been saved successfully.");
		
	# Redirect
	redirect("$cur_page&action=product_profile&id={$uid}");
}

function delete() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS, $validator;
	
	# Get GET Data
	$uid								= $validator->validate($_GET['id'], "Integer");
	
	# Get Name
	$username							= $_db->fetch_single("SELECT `name`
																FROM `categories`
																WHERE `uid` = \"$uid\"");
	
	# Delete From Database
	$query								= "DELETE FROM `categories`
											WHERE `uid` = \"{$uid}\"";
	$_db->query($query);
	
	# Set info message
	set_info("Category $username has been deleted successfully.");
	
	# Redirect
	redirect($cur_page);
}

function upload_product_photo() {
	# Global Variables
	global $_db, $cur_page, $validator, $_GLOBALS;

	# Get POST Data
	$product															= $validator->validate($_POST['product'], "Integer");
	$file																= $_FILES['product_image'];
	
	# Upload File
	if (isset($file['tmp_name'])) {
		$file_name														= "p" . $product . "_image" . substr($file['name'], strrpos($file['name'], "."));
		$dir															= dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "content" . DIRECTORY_SEPARATOR . "files" . DIRECTORY_SEPARATOR;
		$destination													= $dir . $file_name;
		if (!copy($file['tmp_name'], $destination)) {
			logg("Upload Product Photo: Error. Could not move file from {$file['tmp_name']} to {$destination}.");
		}
		else {
			$_db->update(
				"products",
				array(
					"picture"											=> $file_name
				),
				array(
					"uid"												=> $product
				)
			);
		}
	}
	
	# Redirect
	redirect("{$cur_page}&action=product_profile&id={$product}");
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
	else if ($action == "add_product") {
		add_product();
	}
	else if ($action == "save_product") {
		save_product();
	}
	else if ($action == "product_profile") {
		product_profile();
	}
	else if ($action == "upload_product_photo") {
		upload_product_photo();
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