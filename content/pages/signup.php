<?php
 
	 
	function display(){
		# Global Variables
		global $_db;
		
		$template														= new Template(dirname(dirname(dirname(__FILE__))) . "/content/pages/signup.html");
		$html															= $template->toString();
		
		# Display HTML
		print $html;
	}

if (isset($_GET['action'])){
	$action = $_GET['action'];
	
	if ($action == "display"){
		display();
	}
	
	else {
		error("Invalid action `$action`.");
	}
}
else {
	display();
}



	

?>