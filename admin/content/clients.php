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
$cur_page																= "?p=clients";

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
																`members`
															WHERE
															     `active`=1
															");
	
	# Generate Listing
	$head									= array("#", "Name","Surname");
	$body									= array();
	foreach ($data as $item) {
		$body[]								= array(	$item->uid . " <a href='$cur_page&action=delete&id={$item->uid}' class='remove'>x</a>",
														"<a href='$cur_page&action=clientProfile&id={$item->uid}'>" . $item->Name . "</a>",$item->Surname
													);
	}
	$listing								= results_table($head, $body);
	
	# Generate HTML
	$html									= "
	
	<div class='content' id='content'>
	
		<h2><span class=''></span>Members</h2>
				
		" . button("Add", "{$cur_page}&action=add") . "
		
		<!-- Listing -->
		{$listing}
	
	</div><!-- END: Content -->
	";
	
	# Display HTML
	print $html;
}



function clientProfile() {
	# Global Variables
	global $_db, $cur_page, $validator, $_GLOBALS;
	
	# Get GET Data
	$uid																= $validator->validate($_GET['id'], "Integer");
	
	# Get Data
	$item																= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`members`
																							WHERE
																								`uid` = {$uid}
																							"); 
																							
	$details="
	
									<div class='btn-position'>
		                		
		                			<a class='btn pull-right' href='{$cur_page}&action=add&id={$uid}'><i class='icon-edit icon-white'></i> Edit Member Details</a> 
		                			<a class='btn pull-right' href='{$cur_page}&action=printpdf&id={$uid}'><i class='icon-edit icon-white'></i> Print Member Details</a> 
		                			</div>
		                		
		                				<div class='control-group'>
			                				
			                				<label>Status:</label>
			                				<p><strong class='text-blue'>Active</strong></p>
			                				
			                			</div><br>	          		
										<div class='control-group'>
		                					
		                					<label>Date Joined:</label>
		                				    <p>{$item->datetime}</p>
		                				
		                			 	</div><br>
		                				
		                				<div class='control-group'>
		                					
		                					<label>Surname:</label>
		                				    <p>{$item->Surname}</p>
		                				
		                			 	</div><br>
		                			
			                			<div class='control-group'>
			                				
			                				<label>First Name:</label>
			                				<p>{$item->Name}</p>
			                				
			                			</div><br>
		                			
			                			<div class='control-group'>
			                				
			                				<label>Contact:</label>
			                				<p>{$item->cellphone}</p>
			                				
			                			</div><br>
		                			
			                			<div class='control-group'>
			                				
			                				<label>Phone:</label>
			                				<p>{$item->Telephonework}</p>
			                				
			                			</div><br>
			                			
			                			<div class='control-group'>
			                				
			                				<label>Email:</label>
			                				<a href='mailto:name@address.co.za'>{$item->EmailAddress}</a>
			                				
			                			</div><br>
			                			
			                			<div class='control-group'>
			                				
			                				<label>Date of Marriage:</label>
			                				<p>{$item->Datemarriage}</p>
			                				
			                			</div><br>
			                			
										<div class='control-group'>
			                				
			                				<label>Residential Address:</label>
			                				<p>{$item->residentialaddress}</p>
			                				
			                			</div><br>
			                			
										<div class='control-group'>
			                				
			                				<label>Postal Address:</label>
			                				<p>{$item->postaladdress}</p>
			                				
			                			</div><br>
			                			<a class='btn pull-right add' href='{{link}}'><i class='icon-edit icon-white'></i> Edit Notes</a>
			                			
			                			<h2>Current Notes</h2>
	
				                		<div class='control-group'>
			
					                		<p>{{notes}}</p>
					                				
					                	</div>";
																								
	$details2="
	
		                				
		                				
		                				<div class='control-group'>
		                					
		                					<label>Surname:</label>
		                				    <p>{$item->Surnamewife}</p>
		                				
		                			 	</div><br>
		                			
			                			<div class='control-group'>
			                				
			                				<label>First Name:</label>
			                				<p>{$item->Namewife}</p>
			                				
			                			</div><br>
		                			
			                			<div class='control-group'>
			                				
			                				<label>Contact:</label>
			                				<p>{$item->cellphonewife}</p>
			                				
			                			</div><br>
		                			
			                			<div class='control-group'>
			                				
			                				<label>Phone:</label>
			                				<p>{$item->Telephoneworkwife}</p>
			                				
			                			</div><br>
			                			
			                			<div class='control-group'>
			                				
			                				<label>Email:</label>
			                				<a href='mailto:name@address.co.za'>{$item->EmailAddresswife}</a>
			                				
			                			</div><br>
			                			
			                			
			                			
			           ";
	
	
	$tab_data															= array(		"Member Details"		    =>  $details,
																						"Member Spouse Details"		=>  $details2,
																						"Member Children Details"	=>  'under construction',
																						
																					);	
	# Generate Tabs
	$tabs																= tabbed_page($tab_data);
		
	# Generate HTML
	$html 																= 	"
																					<h2> Member: {$item->Name} {$item->Surname}</h2>
																					
																					{$tabs}	
																				";
	
 	# Display HTML
	print $html;
	
	
}
function add() {
	# Global Variables
	global $cur_page, $_db;
	
	$id																	= $_GET['id'];
	$query																= "
																				SELECT 
																					*
																				FROM
																					`members`
																				WHERE
																					`uid`={$id}
																			
	";

	
	$item																= $_db->fetch_one($query);
	
	
	$name																= (isset($_GET['name']))?$_GET['name']:$item->Name;
	$surname															= (isset($_GET['surname']))?$_GET['surname']:$item->Surname;
	$cellphone															= (isset($_GET['cellphone']))?$_GET['cellphone']:$item->cellphone;
	$email																= (isset($_GET['email']))?$_GET['email']:$item->EmailAddress;
	
	
	# Generate HTML
	$html																= "
        
        <!-- Forms -->
        <form id='new_project_form' method='POST' action='{$cur_page}&action=save_member'>
        <input type='hidden' value='{$id}' name='request'/>
        <input type='hidden' value='{$item->uid}' name='uid'/>
        <fieldset>
			<h2 class='fs-title'>PERSONAL DETAILS</h2>
			<!--<h3 class='fs-subtitle'>This is step 1</h3>-->
			<span class='form_input'>
				<label>Surname</label> <br />
				<input type='text' name='Surname' value='{$surname}'/>
			</span>
			<span class='form_input'>
				<label>Name</label> <br />
				<input type='text' name='Name' value='{$name}'/>
			</span>
			<span class='form_input'>
				<label>Date of Birth</label> <br />
				<!--<input type='text' name='Dateofbirth'/>-->
				 " . date_select("Dateofbirth",$item->Dateofbirth) . "
			</span
			<span class='form_input'>
				<label>Telephone</label> <br />
				<input type='text' name='Telephonework' value='$item->Telephonework'/>
			</span>
			<span class='form_input'>
				<label>Cellphone</label> <br />
				<input type='text' name='cellphone' value='{$cellphone}'/>
			</span>
			<span class='form_input'>
				<label>Email Address</label> <br />
				<input type='text' name='EmailAddress' value='{$email}'/>
			</span>
			<span class='form_input'>
				<label>Date of Marriage</label> <br />
				<!--<input type='text' name='Datemarriage'/>-->
				" . date_select("Datemarriage",$item->Datemarriage) . "
			</span>
			<span class='form_input'>
				<label>Residential Address</label> <br />
					<textarea name='residentialaddress' style='width:300px; height: 10%;'>{$item->residentialaddress}</textarea>
			</span>
			<span class='form_input'>
				<label>Postal Address</label> <br />
					<textarea name='postaladdress' style='width:300px; height: 10%;'>{$item->postaladdress}</textarea>
			</span>
		
		</fieldset>
       <fieldset>
		<h2 class='fs-title'>SPOUSE'S DETAILS</h2>
		<!--<h3 class='fs-subtitle'>This is step 2</h3>-->
		<span class='form_input'>
			<label>Surname</label><br/>
			<input type='text' name='Surnamewife' value='{$item->Surnamewife}'/>
		</span>
		<span class='form_input'>
			<label>Name</label><br/>
			<input type='text' id='Namewife' value='{$item->Namewife}'/>
		</span>
		<span class='form_input'>
			<label>Date of Birth</label><br/>
			<!--<input type='text' name='Dateofbirthwife'/>-->
			" . date_select("Dateofbirthwife",$item->Dateofbirthwife) . "
		</span>
		<span class='form_input'>
			<label>Telephone</label><br/>
			<input type='text' name='Telephoneworkwife' value='{$item->Telephoneworkwife}'/>
		</span>
		<span class='form_input'>
			<label>Cellphone</label><br/>
			<input type='text' name='Cellphonewife' value='{$item->cellphonewife}'/>
		</span>
		<span class='form_input'>
			<label>Email Address</label><br/>
			<input type='text' name='EmailAddresswife' value='$item->EmailAddresswife'/>
		</span>
		<span class='form_input'>             
            	<input type='submit' value='Submit' />
		</span>
	</fieldset>
		
        </form>
        <!-- END: Forms -->
        
        <!-- Clearfix -->
        <div class='clearfix'>
        </div>
        <!-- END: Clearfix -->
	";
	
	# Return HTML
	print $html;
}


function save_member() {
		
		
	
	# Global Variables
	global $cur_page, $_db, $validator;
	## Get POST Data Get GET Data
	$surname															= $validator->validate($_POST['Surname']						, "String");
	$name																= $validator->validate($_POST['Name']							, "String");
	$dateofbirth														= $validator->validate($_POST['Dateofbirth']					, "String");
	$telephonework														= $validator->validate($_POST['Telephonework']					, "String");
	$cellphone															= $validator->validate($_POST['cellphone']						, "String");
	$emailaddress														= $validator->validate($_POST['EmailAddress']					, "String");
	$datemarriage														= $validator->validate($_POST['Datemarriage']					, "String");
	$request															= $validator->validate($_POST['request']						, "Integer");
	$surnamewife														= $validator->validate($_POST['Surnamewife']					, "String");
	$namewife															= $validator->validate($_POST['Namewife']						, "String");
	$dateofbirthwife													= $validator->validate($_POST['Dateofbirthwife']				, "String");
	$telephoneworkwife													= $validator->validate($_POST['Telephoneworkwife']				, "String");
	$cellphonewife														= $validator->validate($_POST['cellphonewife']					, "String");
	$emailaddresswife													= $validator->validate($_POST['EmailAddresswife']				, "String");
	$residentialaddress													= $validator->validate($_POST['residentialaddress']				, "String");
	$postaladdress														= $validator->validate($_POST['postaladdress']					, "String");
	$uid																= $validator->validate($_POST['uid']						, "Integer");
	if ($uid>0) {
		# Set UID of Project for Redirect
		# Update the Database
		$_db->update(
			"members",
			array(
				
				"datetime"												=> date("Y-m-d H:i:s"),
				"Surname"												=> $surname,
				"Name"													=> $name,
				"Dateofbirth"											=> $dateofbirth,
				"Telephonework"											=> $telephonework,
				"cellphone"												=> $cellphone,
				"EmailAddress"											=> $emailaddress,
				"Datemarriage"											=> $datemarriage,
				"Surnamewife"											=> $surnamewife,
				"Namewife"												=> $namewife,
				"Dateofbirthwife"										=> $dateofbirthwife,
				"Telephoneworkwife"										=> $telephoneworkwife,
				"cellphonewife"											=> $cellphonewife,
				"EmailAddresswife"										=> $emailaddresswife,
				"residentialaddress"									=> $residentialaddress,
				"postaladdress"											=> $postaladdress,
			
			),
			array(
				"uid"													=> $uid
			)
		);
	}
	else {	
		# Add to Database
		$uid															= $_db->insert(
			"members",
			array(
				"datetime"												=> date("Y-m-d H:i:s"),
				"Surname"												=> $surname,
				"Name"													=> $name,
				"Dateofbirth"											=> $dateofbirth,
				"Telephonework"											=> $telephonework,
				"cellphone"												=> $cellphone,
				"EmailAddress"											=> $emailaddress,
				"Datemarriage"											=> $datemarriage,
				"Surnamewife"											=> $surnamewife,
				"Namewife"												=> $namewife,
				"Dateofbirthwife"										=> $dateofbirthwife,
				"Telephoneworkwife"										=> $telephoneworkwife,
				"cellphonewife"											=> $cellphonewife,
				"EmailAddresswife"										=> $emailaddresswife,
				"residentialaddress"									=> $residentialaddress,
				"postaladdress"											=> $postaladdress,
				
			)
		);
	}
	
		# Update the Database
		$_db->update(
			"request",
			array(
				"active"											=> 0,
			
			),
			array(
				"uid"												=> $request
			)
		);
  
	# Redirect
	/*print "<h3>you have been successfull registered</h3>";*/
	redirect("{$cur_page}&action=display");
}

# =========================================================================
# PROCESSING FUNCTIONS
# =========================================================================



function printpdf()
{
# Global Variables
	global $_db, $cur_page, $validator, $_GLOBALS;
	
	# Get GET Data
	$uid																= $validator->validate($_GET['id'], "Integer");
	
	# Get Data
	$item																= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`members`
																							WHERE
																								`uid` = {$uid}
																							"); 	
	// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo_example.jpg';
		//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
		
		//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		$this->Cell(0, 15, 'FOUNDATION OF GRACE MINISTRIES', 0, TRUE, 'C', 0, '', 1, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 18);
		$this->Cell(0, 15, 'Membership Form', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Members Application form');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 004', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 11);

// add a page
$pdf->AddPage();

$html ="<table border='1'>";
$html.="<tr><th><strong>PERSONAL DETAILS</strong></th><th><strong>SPOUSE'S DETAILS</strong></th></tr>";
$html.="<tr><td><hr/></td><td><hr/></td></tr>";
$html.="<tr><td><strong>Surname:&nbsp;&nbsp;&nbsp;&nbsp;<i>{$item->Surname}</i></strong></td><td><strong>Surname:</strong></td></tr>";
$html.="<tr><td></td><td></td></tr>";
$html.="<tr><td><strong>Name:&nbsp;&nbsp;&nbsp;&nbsp;<i>{$item->Name}</i></strong></td><td><strong>Name:</strong></td></tr>";
$html.="<tr><td></td><td></td></tr>";
$html.="<tr><td><strong>Date of Birth:&nbsp;&nbsp;&nbsp;&nbsp;<i>{$item->Dateofbirth}</i></strong></td><td><strong>Date of Birth:</strong></td></tr>";
$html.="<tr><td></td><td></td></tr>";
$html.="<tr><td><strong>Telephone Work:&nbsp;&nbsp;&nbsp;&nbsp;<i>{$item->Telephonework}</i></strong></td><td><strong>Telephone Work:</strong></td></tr>";
$html.="<tr><td></td><td></td></tr>";
$html.="<tr><td><strong>Cellphone:&nbsp;&nbsp;&nbsp;&nbsp;<i>{$item->cellphone}</i></strong></td><td><strong>Cellphone:</strong></td></tr>";
$html.="<tr><td></td><td></td></tr>";
$html.="<tr><td><strong>Email Address:&nbsp;&nbsp;&nbsp;&nbsp;<i>{$item->EmailAddress}</i></strong></td><td><strong>Email Address:</strong></td></tr>";
$html.="<tr><td></td><td></td></tr>";
$html.="<tr><td><strong>Date of Marriage:&nbsp;&nbsp;&nbsp;&nbsp;<i>{$item->datemarriage}</i></strong></td><td><strong></strong></td></tr>";
$html.="<tr><td></td><td></td></tr>";
$html.="<tr><th><strong>CONTACT DETAILS</strong></th><th></th></tr>";
$html.="<tr><td><hr/></td><td><hr/></td></tr>";
$html.="<tr><td><strong>Residential Address:</strong></td><td><strong>Postal Address:</strong></td></tr>";
$html.="<tr><td><strong>Telephone(Home):{$item->Telephonework}</strong></td><td><strong>Telephone(Other):</strong></td></tr>";
$html .="</table>";
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
 ob_end_clean();
//Close and output PDF document
$pdf->Output('form.pdf', 'I');

//============================================================+
// END OF FILE
//==========================
}

function delete() {
	# Global Variables
	global $_db, $cur_page, $_GLOBALS, $validator;
	
	# Get GET Data
	$uid								= $validator->validate($_GET['id'], "Integer");
	
	# Delete From Database
	
	
	$query								= "UPDATE `members`
											SET `active`=0
											WHERE `uid`=\"{$uid}\"";
	$_db->query($query);
	
	# Set info message
	/*
	set_info("Category $clientname has been deleted successfully.");
		*/
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
				"clients",
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
	redirect("{$cur_page}&action=clientProfile&id={$product}");
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
	else if ($action == "save_member") {
		save_member();
	}
	else if ($action == "save_product") {
		save_product();
	}
	else if ($action == "clientProfile") {
		clientProfile();
	}
	else if ($action == "printpdf") {
		printpdf();
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