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

function template_menu() {
	# Global Variables
	global $_db, $_GLOBALS, $validator;
	
	# Get Menu
	$query																= "	SELECT
																				*
																			FROM
																				`menu`
																			WHERE
																				`active` > 0
																			ORDER BY
																				`order`, 
																				`label`";
	$menu_items															= $_db->fetch($query);
	
	# Construct Menu
	$item_html															= "";
	foreach ($menu_items as $item) {
		$item_html														.= "
			<!-- Menu Item -->
			<li><a href='?p={$item->content}'>{$item->label}</a></li>
			<!-- END: Menu Item -->
		";
	}
	
	# Construct HTML
	$html																= "
	<!-- Nav -->
	<ul class='nav'>
		{$item_html}
	</ul>
	<!-- END: Nav -->
	";
	
	# Return HTML
	return $html;
}

# ==================================================================================
# THE END
# ==================================================================================

?>