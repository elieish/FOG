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

function logg($message) {
	# Global Variables
	global $_GLOBALS, $validator;
	
	# Sanitize Content
	$message															= $validator->validate($message, "String");
	
	# Open File for Writing
	//$f																	= fopen($_GLOBALS['log_file'], 'a');
	
	# Compose Message
	$full_message														= date("Y-m-d H:i:s") . " ";
	$full_message														.= get_ip_address() . " ";
	$full_message														.= $message . " ";
	$full_message														.= "\n";
	
	# Write Message to Log File
	//fputs($f, $full_message);
	
	# Close File
	//fclose($f);
}

function get_ip_address() {
	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
		if (array_key_exists($key, $_SERVER) === true) {
			foreach (explode(',', $_SERVER[$key]) as $ip) {
				if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
					return $ip;
				}
			}
		}
	}
}

function format_string($tmpString) {
	# Format String
	$result																= str_replace("\n", "<br />\n", $tmpString);
	
	# Return Formatted String
	return $result;
}


function generate_select($name, $values, $active="") {
	# Construct HTML
	$html  																= "<select name='{$name}'>\n";
	$use_key															= (is_array($values[0]))? true : false;
	foreach ($values as $key => $value) {
		$key															= ($use_key)? $key : $value;
		$checked 														= ($key == $active)? " SELECTED" : "";
		$html 															.= "	<option value='$key'{$checked}>$value</option>\n";
	}
	$html 																.= "</select>\n";
	
	# Return HTML
	return $html;
}


function paginated_listing($query, $this_page="", $prefix="",$sector="") {
	# GLobal Variables
	global $_GLOBALS, $cur_page, $_db;
	
	# Local Variables
	$head 																= array();
	
	# Get Page Variables
	$page																= (isset($_GET['results_page']))? $_GET['results_page'] : 1;
	$p																	= (isset($_GET['p']))? $_GET['p'] : 'home';
	$this_page															= (strlen($this_page))? $this_page : "?p=" . $p;
	
	# Get Count
	$num_records														= get_query_count($query);
	$num_pages															= ceil($num_records / $_GLOBALS['max_results']);
	
	# Get Starting Record
	$starting_record													= ($page - 1) * $_GLOBALS['max_results'];
	
	# Get Body
	$data																= $_db->fetch($query . " LIMIT {$starting_record}, {$_GLOBALS['max_results']}");
	$body																= array();
	$row_num															= 0;
	foreach ($data as $item) {
		$item_arr														= get_object_vars($item);
		$body[$row_num]													= array();
		foreach ($item_arr as $key => $value) {
			$body[$row_num][]											= $value;
		}
		$row_num++;
	}
	
	# Generate Headings
	$obj_data															= get_object_vars($item);
	foreach ($obj_data as $item => $content) {
		$head[]															= $item;
	}
	
	# Generate Headings
	$headings															= "
		<tr>
	";
	foreach ($head as $item) {
		$headings														.= "
			<th>{$item}</th>
			";
	}
	$headings															.= "
		</tr>
	";
	
	# Generate rows
	
	$rows_num														=0;
	$rows
																	= "";
	foreach ($body as $row) {
		if($rows_num%3==0)
		{
			$rows														.="<tr>";
		}	
		$rows															.= "
		<td>
		";
		foreach ($row as $item) {
			$rows														.= "
			{$item}</br>
			";
		}
		$rows															.= "
		</td>
		";
		$rows_num	=$rows_num	+1;
	}
	
	# Output Page selection
	$page_select														= "";
	if ($num_records > $_GLOBALS['max_results']){
		$page_select 													.= "<script>\n";
		$page_select 													.= "	function gotoURL(me){\n";
		$page_select 													.= "		window.location.replace('$this_page&results_page=' + me.value+'&sector=$sector');\n";
		$page_select 													.= "}\n";
		$page_select 													.= "</script>\n";
		$page_select 													.= "<div align='right' style='padding:0;margin:0;'>\n";
		$page_select 													.= "	Page : <SELECT name='results_pages' onchange='gotoURL(this);'>\n";
		for ($x = 0; $x < $num_pages; $x++){
			$selected													= ($page == ($x + 1))? " SELECTED" : "";
			$page_select 												.= "		<OPTION value='" . ($x + 1) . "'{$selected}>" . ($x + 1) . "</OPTION>\n";
		}
		$page_select 													.= "	</SELECT>\n";
		$page_select 													.= "</div>\n";
	}
	
	# Navigation Buttons
	$buttons															= "";
	if ($num_records > $_GLOBALS['max_results']){
		$previous_link													= ($page > 1)? "$this_page&sector=$sector&$prefix" . "results_page=" . ($page - 1) : "";
		$next_link														= (($page * $_GLOBALS['max_results']) < $num_records)? "$this_page&sector=$sector&$prefix" . "results_page=" . ($page + 1) : "";
		$buttons 														.= new_line() . nav_buttons($previous_link, $next_link);
	}
	
	# Generate HTML
	$html																= "
	{$page_select}
	
	<table class='table table-striped table-hover'>
		
		{$rows}
	</table>
	
	{$buttons}
	";
	
	# Return HTML
	return $html;
}

function new_line($num = 1){
	for ($x = 0; $x < $num; $x++){
		print "<br />\n";
	}
}


function previous_button($link){
	$button 															= "<a href='$link'><img src='include/images/previous.gif' border='0' height='35' width='100'></a>";
	return $button;
}

/**
 * Generates the HTML for a pair of navigation buttons; Next and Previous.
 * @param string $link_next The URL for the Next Button
 * @param string $link_previous The URL for the Previous Button
 * @param string $align The alignment of the nav buttons. default = 'center'
 * @return string
 */
function nav_buttons($link_previous, $link_next, $align="center"){
	$html 																= "<table align='center'><tr>";
	if ($link_previous){
		$html 															.= "<td>" . previous_button($link_previous) . "</td>";
	}
	if ($link_next){
		$html 															.= "<td>" . next_button($link_next) . "</td>";
	}
	$html 																.= "</tr></table>";
	return $html;
}


function next_button($link){
	$button 															= "<a href='$link'><img src='include/images/next.gif' border='0' height='35' width='97'></a>";
	return $button;
}


function get_query_count($query) {
	# GLobal Variables
	global $_db;
	
	# Get Count
	$count_query														= substr($query, 0, strpos($query, "SELECT") + 7) . " COUNT(*) " . substr($query, strrpos($query, "FROM"));
	$num_records														= $_db->fetch_single($count_query);
	
	# Return Count
	return $num_records;
}

function tabbed_page($tab_data, $id="tabs1") {
	# Get Current Active Tab
	$active_tab															= 0;
	if (isset($_SESSION["tab_" . $_GET['p']][$_GET['id']])) {
		$active_tab														= $_SESSION["tab_" . $_GET['p']][$_GET['id']];
	} 
	
	# Generate Headers and Body Areas
	$tab_headers														= "";
	$tab_sections														= "";
	$js_reset															= "";
	$x																	= 0;
	foreach ($tab_data as $title => $contents) {
		$default_class													= ($x == $active_tab)? "active" : "inactive";
		/*$tab_headers													.= "
			<div class='tab_heading' onclick='{$id}_activate_tab(\"{$id}_$x\")'>
				{$title}
			</div>
		";*/
		
		$tab_headers													.= "
			<li><a href='#{$id}_$x' data-toggle='tab'>{$title}</a></li>
		";
		
		
		$tab_sections													.= "
			<div class='tab-pane {$default_class}' id=\"{$id}_$x\">
				{$contents}
			</div>
		";
		$js_reset														.= "
		var cur_class = document.getElementById(\"{$id}_$x\").className;
		if (cur_class == \"tab-pane inactive\" && active_tab == \"{$id}_$x\") {
			document.getElementById(\"{$id}_$x\").className = \"tab-pane active\";
		}
		else  if (!(active_tab == \"{$id}_$x\")) {
			document.getElementById(\"{$id}_$x\").className = \"tab-pane inactive\";
		}
		";
		$x++;
	}
	
	# Generate Javascript
	$js																	= "
	function {$id}_activate_tab(active_tab) {
		ajax_get_data(\"include/content/ajax.php?action=set_page_tab&p={$_GET['p']}&id={$_GET['id']}&tab=\" + active_tab.substring(" . strlen($id . "_") . "));
		$js_reset
	}
	";
	
	# Generate HTML
	$html																= "
	<!-- Javascript -->
	<script>
		{$js}
	</script>
	
	<!-- Tab Wrapper {$id} -->
	<div class='tabbable well' id=\"{$id}\">
		<!-- Tab Head -->
		<ul class='nav nav-tabs'>
			{$tab_headers}
		</ul><!-- END: Tab Head -->
		
		<!-- Tab Body -->
		<div class='tab-content'>
			{$tab_sections}
		</div><!-- END: Tab Body -->
	</div><!-- END: Tab Wrapper {$id} -->
	";
	
	# Return HTML
	return $html;
}

function date_select($name="date", $default="", $min_year=1950, $max_year=2050, $only_month=0) {
	# Generate HTML
	$html = "<input id='$name' name='{$name}' class='date' type='text' size='25' value=\"{$default}\">";
	
	# Return HTML
	return $html;
}


# ==================================================================================
# THE END
# ==================================================================================

?>