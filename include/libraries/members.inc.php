<?php
/**
 * MDG Project Management
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 1.0
 * @package MDG
 */

# =========================================================================
# FUNCTIONS
# =========================================================================


function new_member() {
	# Global Variables
	global $cur_page, $_db;
	
	
	$query																= "
																				SELECT 
																					*
																				FROM
																					`members`
																			
	";
	
	$item																= $_db->fetch_one($query);
	
	# Generate HTML
	$html																= "
        
        <!-- Forms -->
        <form id='new_project_form' method='POST' action='?p=members.php&action=save_member'>
        <fieldset>
			<h2 class='fs-title'>PERSONAL DETAILS</h2>
			<!--<h3 class='fs-subtitle'>This is step 1</h3>-->
			<span class='form_input'>
				<label>Surname</label> <br />
				<input type='text' name='Surname'/>
			</span>
			<span class='form_input'>
				<label>Name</label> <br />
				<input type='text' name='Name'/>
			</span>
			<span class='form_input'>
				<label>Date of Birth</label> <br />
				<!--<input type='text' name='Dateofbirth'/>-->
				 " . date_select("Dateofbirth") . "
			</span
			<span class='form_input'>
				<label>Telephone</label> <br />
				<input type='text' name='Telephonework'/>
			</span>
			<span class='form_input'>
				<label>Cellphone</label> <br />
				<input type='text' name='cellphone'/>
			</span>
			<span class='form_input'>
				<label>Email Address</label> <br />
				<input type='text' name='EmailAddress'/>
			</span>
			<span class='form_input'>
				<label>Date of Marriage</label> <br />
				<!--<input type='text' name='Datemarriage'/>-->
				" . date_select("Datemarriage") . "
			</span>
		</fieldset>
       <fieldset>
		<h2 class='fs-title'>SPOUSE'S DETAILS</h2>
		<!--<h3 class='fs-subtitle'>This is step 2</h3>-->
		<span class='form_input'>
			<label>Surname</label><br/>
			<input type='text' name='Surnamewife'/>
		</span>
		<span class='form_input'>
			<label>Name</label><br/>
			<input type='text' id='Namewife'/>
		</span>
		<span class='form_input'>
			<label>Date of Birth</label><br/>
			<!--<input type='text' name='Dateofbirthwife'/>-->
			" . date_select("Dateofbirthwife") . "
		</span>
		<span class='form_input'>
			<label>Telephone</label><br/>
			<input type='text' name='Telephoneworkwife'/>
		</span>
		<span class='form_input'>
			<label>Cellphone</label><br/>
			<input type='text' name='Cellphonewife'/>
		</span>
		<span class='form_input'>
			<label>Email Address</label><br/>
			<input type='text' name='EmailAddresswife'/>
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
	return $html;
}


function new_request() {
	# Global Variables
	global $cur_page, $_db;
	
	
	$query																= "
																				SELECT 
																					*
																				FROM
																					`request`
																			
	";
	
	$item																= $_db->fetch_one($query);
	
	# Generate HTML
	$html																= "
        
        <!-- Forms -->
        <form id='new_project_form' method='POST' action='?p=members.php&action=save_request'>
        <fieldset>
			<h2 class='fs-title'>PERSONAL DETAILS</h2>
			<!--<h3 class='fs-subtitle'>This is step 1</h3>-->
			<span class='form_input'>
				<label>Surname</label> <br />
				<input type='text' name='Surname'/>
			</span>
			<span class='form_input'>
				<label>Name</label> <br />
				<input type='text' name='Name'/>
			</span>
			<span class='form_input'>
				<label>Telephone</label> <br />
				<input type='text' name='Telephonework'/>
			</span>
			<span class='form_input'>
				<label>Cellphone</label> <br />
				<input type='text' name='cellphone'/>
			</span>
			<span class='form_input'>
				<label>Email Address</label> <br />
				<input type='text' name='EmailAddress'/>
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
	return $html;
}

function education_assessment_capture_form($offline=false, $uid=0) {
	
	# Global Variables
	global $cur_page, $_db;

	# Format Query
	$query																= "		SELECT 
																					*
																				FROM
																					`education_assessments`
																				WHERE
																					`uid` = $uid
																			";

	$item																= $_db->fetch_one($query);
	
	$school_id														= (isset($_GET['uid']))?$item->uid:rand(1,9).date("his");
	
	# Generate Buttons for Offline or online
	if ($offline) {
		$buttons														= "
		<input type='button' name='save_button' value='Save' onclick='offline_save(\"education_assessment_form\");' />
		<input type='button' name='submit_button' value='Submit' onclick='offline_submit(\"education_assessment_form\");' />
		";
	}
	else {
		$buttons														= "
		<input type='submit' value='Submit' />
		";
	}
	
	# Generate Login Form
	$login_form															= "";
	if ($offline) {
		$login_form														= "
		<h2>Login Details</h2>
		
		<span class='form_input'>
			<label>Username</label><br />
			<input type='text' name='username' />
		</span>
		
		<span class='form_input'>
			<label>Password</label><br />
			<input type='password' name='password' />
		</span>
		";
	}			
	
	# Generate HTML:
	$html 																= "
	
        <h1>Assest Management Form</h1>
        
        <form id='education_assessment_form' method='POST' action='{$cur_page}&action=save_assessment&id={$school_id}'=>
        	<input type='hidden' name='uid' value='$uid'>
	        
	        <div class='capture_set'>
		        
		        {$login_form}
		        
		        <h2>General Details</h2>
		        
		        <span class='form_input'>
		        	<label>School Name</label><br />
		        	<input type='text' name='school_name' value='$item->school_name'/>
		        </span>
		        
		        <span class='form_input'>
		        	<label>EMIS Number:</label><br />
		        	<input type='text' placeholder='enter value here' name='emis' value='$item->emis'/>
				</span>
				
				<span class='form_input'>
		        	<label>Principal</label><br />
		        	<input type='text' placeholder='enter value here' name='principle' value='$item->principle'/>
				</span>
				
				<span class='form_input'>
		        	<label>Education District</label> <br />
		            " . education_district_select("", $item->district) . "
		        </span>
		        
		        <span class='form_input'>
		        	<label>Municipality</label> <br />
		            " . municipality_select("", $item->municipality) . "
		        </span>
		        
		        <span class='form_input'>
		        	<label>Ward</label> <br />
		            " . ward_select("", $item->ward) . "
		        </span>
		        
		        <span class='form_input'>
		        	<label>Physical Address</label><br />
		        	<input type='text' placeholder='enter value here' name='address' value='$item->address'/>
				</span>
				
		        <span class='form_input'>
		        	<label>Starting Grades</label> <br />
		            <select name='start_grades'>
		            	" . get_option_default_string($item->start_grades) . "
		            	<option value='0'>- Grades</option>
		            	<option value='Grade R'>Grade R</option>
		                <option value='Grade 1'>Grade 1</option>
		                <option value='Grade 2'>Grade 2</option>
		                <option value='Grade 3'>Grade 3</option>
		                <option value='Grade 4'>Grade 4</option>
		                <option value='Grade 5'>Grade 5</option>
		                <option value='Grade 6'>Grade 6</option>
		                <option value='Grade 7'>Grade 7</option>
		                <option value='Grade 8'>Grade 8</option>
		                <option value='Grade 9'>Grade 9</option>
		                <option value='Grade 10'>Grade 10</option>
		                <option value='Grade 11'>Grade 11</option>
		                <option value='Grade 12'>Grade 12</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Ending Grades</label> <br />
		            <select name='end_grades'>
		            	" . get_option_default_string($item->end_grades) . "
		            	<option value='0'>- Grades</option>
		            	<option value='Grade R'>Grade R</option>
		                <option value='Grade 1'>Grade 1</option>
		                <option value='Grade 2'>Grade 2</option>
		                <option value='Grade 3'>Grade 3</option>
		                <option value='Grade 4'>Grade 4</option>
		                <option value='Grade 5'>Grade 5</option>
		                <option value='Grade 6'>Grade 6</option>
		                <option value='Grade 7'>Grade 7</option>
		                <option value='Grade 8'>Grade 8</option>
		                <option value='Grade 9'>Grade 9</option>
		                <option value='Grade 10'>Grade 10</option>
		                <option value='Grade 11'>Grade 11</option>
		                <option value='Grade 12'>Grade 12</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Total Number of Learners</label><br />
		        	<input type='text' placeholder='enter value here' name='learners' value='$item->learners' />
				</span>
				
				<!-- Clearfix-->
		        <div class='clearfix'>&nbsp;</div>
		        <!-- END: Clearfix-->
				
			</div>
					
			<div class='capture_set'>
				
				<h2>Educators and Enrolment</h2>
												
				<h3>Educators</h3>
				
				<span class='form_input'>
		        	<label>Male</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='educators_male' value='$item->educators_male'/>-->
		             <select name='educators_male'>
		            ". get_option_default_int($item->educators_male).
		            print_numerical_options(100)."
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Female</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='educators_female' value='$item->educators_female'/>-->
		             <select name='educators_female'>
		            ". get_option_default_int($item->educators_female).
		            print_numerical_options(100)."
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Disabled</label> <br />
		           <!--<input type='text' placeholder='enter value here' name='educators_disabled' value='$item->educators_disabled'/>-->
		              <select name='educators_disabled'>
		            ". get_option_default_int($item->educators_disabled).
		            print_numerical_options(100)."
		            </select>
		        </span>
		        
				<h3>Learners</h3>
				
				<span class='form_input'>
		        	<label>Grade R Enrolment</label><br />
		        	<input type='text' placeholder='enter value here' name='grade_r_entrolement' value='$item->grade_r_enrolement' />
				</span>
				
				<span class='form_input'>
		        	<label>Other Grades Enrolment</label><br />
		        	<input type='text' placeholder='enter value here' name='grades_enrolement' value='$item->grades_enrolement'/>
				</span>
				
				<span class='form_input'>
		        	<label>Boys</label><br />
		        	<input type='text' placeholder='enter value here' name='boys' value='$item->boys'/>
				</span>
				
				<span class='form_input'>
		        	<label>Girls</label><br />
		        	<input type='text' placeholder='enter value here' name='girls' value='$item->girls'/>
				</span>
				
				<span class='form_input'>
		        	<label>Disabled Boys</label><br />
		        	<input type='text' placeholder='enter value here' name='disabled_boys' value='$item->disabled_boys'/>
				</span>
				
				<span class='form_input'>
		        	<label>Disabled Girls</label><br />
		        	<input type='text' placeholder='enter value here' name='disabled_girls' value='$item->disabled_girls'/>
				</span>
				
				<!-- Clearfix-->
		        <div class='clearfix'>
		        </div>
		        <!-- END: Clearfix-->
				
			</div>
			
			<div class='capture_set'>
				
				<h2>Services</h2>
			
				<h3>Electricity</h3>
				
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='electricity_available'>
		            	" . get_option_default_int($item->electricity_available) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Type</label> <br />
		            <select name='electricity_type'>
		            	" . get_option_default_string($item->electricity_type) . "
		            	<option value='0'>- Type</option>
		            	<option value='Solar'>Solar</option>
		            	<option value='Generator'>Generator</option>
		                <option value='Municipal'>Municipal</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Reliable</label> <br />
		            <select name='electricity_reliable'>
		            	" . get_option_default_int($item->electricity_reliable) . "
		            	<option value='0'>- Reliable</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
		        
		        <h3>Water</h3>
				
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='water_available'>
		            	" . get_option_default_int($item->water_available) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Type</label> <br />
		            <select name='water_type'>
		            	" . get_option_default_string($item->water_type) . "
		            	<option value='0'>- Type</option>
		            	<option value='Rain Harvested'>Rain Harvested</option>
		            	<option value='Borehole'>Borehole</option>
		            	<option value='Portable / Tanker'>Portable / Tanker</option>
		                <option value='Municipal'>Municipal</option>
		                <option value='Borehole and Municipal'>Borehole and Municipal</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Reliable</label> <br />
		            <select name='water_reliable'>
		            	" . get_option_default_int($item->water_reliable) . "
		            	<option value='0'>- Reliabality</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
		        
		        <h3>Fencing</h3>
				
				<span class='form_input'>
		            <select name='fencing_type'>
		            	" . get_option_default_string($item->fencing_type) . "
		            	<option value='0'>- Type</option>
		            	<option value='Concrete Palisade'>Concrete Palisade</option>
		                <option value='Brick Wall'>Brick Wall</option>
		                <option value='Steel Palisade'>Steel Palisade</option>
		                <option value='Wire Fencing'>Wire Fencing</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h3>Parking Bays</h3>
				
		        <span class='form_input'>
		        	<label>Total number of Parking Bays  (excluding disabled parking)</label> <br />		            
		            <select name='normal_parking'>
		            ". get_option_default_int($item->normal_parking).
		            print_numerical_options(100)."
		            </select>
		        </span>

				<span class='form_input'>
		        	<label>Total number of Disabled Parking Bays</label> <br />
		            
			        <select name='disabled_parking'>
			         ". get_option_default_int($item->disabled_parking).
			            print_numerical_options(100)."
			        </select>  
		        </span>

		        <h3>Hardened Courtyard</h3>
				
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='courtyard'>
		            	" . get_option_default_int($item->courtyard) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Size (in square meters)</label> <br />
		            <input type='text' placeholder='enter value here' name='courtyard_size' value='$item->courtyard_size'/>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='courtyard_condition'>
		            	" . get_option_default_string($item->courtyard_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h3>Facilities</h3>
				
				<h4>Paved Combi Area Court</h4>
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='paved_combi_court'>
		            	" . get_option_default_int($item->paved_combi_court) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='paved_combi_court_condition'>
		            	" . get_option_default_string($item->paved_combi_court_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h4>Soccer Facilities</h4>
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='soccer'>
		            	" . get_option_default_int($item->soccer) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='soccer_condition'>
		            	" . get_option_default_string($item->soccer_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h4>Rugby Facilities</h4>
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='rugby'>
		            	" . get_option_default_int($item->rugby) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='rugby_condition'>
		            	" . get_option_default_string($item->rugby_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h4>Netball Facilities</h4>
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='netball'>
		            	" . get_option_default_int($item->netball) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='netball_condition'>
		            	" . get_option_default_string($item->netball_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h4>Cricket Facilities</h4>
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='cricket'>
		            	" . get_option_default_int($item->cricket) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='cricket_condition'>
		            	" . get_option_default_string($item->cricket_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h4>Athletics Facilities</h4>
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='athletics'>
		            	" . get_option_default_int($item->athletics) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='athletics_condition'>
		            	" . get_option_default_string($item->athletics_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h4>Swimming Facilities</h4>
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='swimming'>
		            	" . get_option_default_int($item->swimming) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='swimming_condition'>
		            	" . get_option_default_string($item->swimming_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h4>Tennis Facilities</h4>
				<span class='form_input'>
		        	<label>Available</label> <br />
		            <select name='tennis'>
		            	" . get_option_default_int($item->tennis) . "
		            	<option value='0'>- Availability</option>
		            	<option value='1'>Yes</option>
		                <option value='0'>No</option>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='tennis_condition'>
		            	" . get_option_default_string($item->tennis_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
				
				<!-- Clearfix-->
		        <div class='clearfix'>
		        </div>
		        <!-- END: Clearfix-->
				
			</div>
			
			<div class='capture_set'>
				
				<h2>Sanitation</h2>
				
				<h3>Girls Toilets</h3>
				<span class='form_input'>
		        	<label>Number</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='girls_toilets' value='$item->girls_toilets' />-->
		            <select name='girls_toilets'>
		           	". get_option_default_string($item->girls_toilets).
		            print_numerical_options(100)."
		           </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='girls_toilets_condition'>
		            	" . get_option_default_string($item->girls_toilets_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>		       
						
		        <h3>Boys' Toilets &amp; Urinals</h3>
				<span class='form_input'>
		        	<label>Number of Seats</label> <br />
		           <!-- <input type='text' placeholder='enter value here' name='boys_toilets' value='$item->boys_toilets'/>-->
		           <select name='boys_toilets'>
		           	". get_option_default_string($item->boys_toilets).
		            print_numerical_options(100)."
		           </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='boys_toilets_condition'>
		            	" . get_option_default_string($item->boys_toilets_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
				<span class='form_input'>
		        	<label>Number of Urinals</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='boys_toilets' value='$item->boys_toilets'/>-->
		             <select name='urinals_boys'>
		             ". get_option_default_int($item->urinals_boys).
		             print_numerical_options(100)."
		             </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='urinals_boys_condition'>
		            	" . get_option_default_string($item->urinals_boys_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
		        <h3>Disabled Toilets</h3>
				<span class='form_input'>
		        	<label>Number</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='disabled_toilets' value='$item->disabled_toilets'/>-->
		             <select name='disabled_toilets'>
		             ". get_option_default_int($item->disabled_toilets).
		            print_numerical_options(100)."
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='disabled_toilets_condition'>
		            	" . get_option_default_string($item->disabled_toilets_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>

		        <h3>Male Teacher Toilets</h3>
				<span class='form_input'>
		        	<label>Number of Seats</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='teacher_toilets' value='$item->teacher_toilets'/>-->
		            <select name='male_teacher_toilets'>
		             ". get_option_default_int($item->male_teacher_toilets).
		            print_numerical_options(100)."
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='male_teacher_toilets_condition'>
		            	" . get_option_default_string($item->male_teacher_toilets_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
				<span class='form_input'>
		        	<label>Number of Urinals</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='teacher_toilets' value='$item->teacher_toilets'/>-->
		            <select name='urinals_teacher'>
		             ". get_option_default_int($item->urinals_teacher).
		            print_numerical_options(100)."
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='urinals_teacher_condition'>
		            	" . get_option_default_string($item->urinals_teacher_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
				<h3>Female Teacher Toilets</h3>
				<span class='form_input'>
		        	<label>Number</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='teacher_toilets' value='$item->teacher_toilets'/>-->
		            <select name='female_teacher_toilets'>
		             ". get_option_default_int($item->female_teacher_toilets).
		            print_numerical_options(100)."
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='female_teacher_toilets_condition'>
		            	" . get_option_default_string($item->female_teacher_toilets_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>		        
				
		        <h3>Boys' Grade R Toilets</h3>
				<span class='form_input'>
		        	<label>Number of Seats</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='grade_r_toilets' value='$item->grade_r_toilets'/>-->
		            <select name='grade_r_boys_toilets'>
		             ". get_option_default_int($item->grade_r_boys_toilets).
		            print_numerical_options(100)."
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='grade_r_boys_toilets_condition'>
		            	" . get_option_default_string($item->grade_r_boys_toilets_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
		        
				<span class='form_input'>
		        	<label>Number of Urinals</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='grade_r_toilets' value='$item->grade_r_toilets'/>-->
		            <select name='urinals_grade_r_boys'>
		             ". get_option_default_int($item->urinals_grade_r_boys).
		            print_numerical_options(100)."
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='urinals_grade_r_boys_condition'>
		            	" . get_option_default_string($item->grade_r_boys_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
				
				<h3>Girls' Grade R Toilets</h3>
				<span class='form_input'>
		        	<label>Number</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='grade_r_toilets' value='$item->grade_r_toilets'/>-->
		            <select name='grade_r_girls_toilets'>
		             ". get_option_default_int($item->grade_r_girls_toilets).
		            print_numerical_options(100)."
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='grade_r_girls_toilets_condition'>
		            	" . get_option_default_string($item->grade_r_girls_toilets_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>

				<!-- Clearfix-->
		        <div class='clearfix'></div>
		        <!-- END: Clearfix-->
				
			</div>
	        
	        <div class='capture_set'>
	        	
	        	<h2>School Nutrition Programme/Catering</h2>
	        	
	        	<h3>SNP Kitchen or Tuckshop</h3>
				<span class='form_input'>
		        	<label>Number</label> <br />
		            <!--<input type='text' placeholder='enter value here' name='tuckshop' value='$item->tuckshop'/>-->
		            <select name='tuckshop'>
		           	". get_option_default_int($item->tuckshop).
		            print_numerical_options(100)."
		           </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='tuckshop_condition'>
		            	" . get_option_default_string($item->tuckshop_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
	        	
	        	<!-- Clearfix-->
		        <div class='clearfix'></div>
		        <!-- END: Clearfix-->
	        	
	        </div>
	        
	        <div class='capture_set'>
	        	
	        	<h2>Structure Materials</h2>
				
				<span class='form_input'>
		        	<label>Type</label> <br />
		            <select name='structure_materials'>
		            	<option value='0'>- Material/s Type</option>
		            	<optgroup label='Single Type'>
		            		" . get_option_default_string($item->structure_materials) . "
			            	<option value='Mud'>Mud</option>
			                <option value='Block &amp Plaster'>Block &amp Plaster</option>
			                <option value='Face Brick'>Face Brick</option>
			                <option value='Corogated Iron'>Corogated Iron</option>
			                <option value='Prefab'>Prefab</option>
						</optgroup>
						<optgroup label='Combo Type'>
			                <option value='Face Brick &amp Plaster'>Face Brick &amp Plaster</option>
			                <option value='Face Brick &amp Corogated Iron'>Face Brick &amp Corogated Iron</option>
			                <option value='Brick &amp Prefab'>Brick &amp Prefab</option>
			                <option value='Brick &amp Corograted Iron'>Brick &amp Corograted Iron</option>
						</optgroup>
		            </select>
		        </span>
	
		        <span class='form_input'>
		        	<label>Condition</label> <br />
		            <select name='structure_materials_condition'>
		            	" . get_option_default_string($item->structure_materials_condition) . "
		            	<option value='0'>- Condition</option>
		            	<option value='Poor'>Poor</option>
		                <option value='Good'>Good</option>
		                <option value='Excellent'>Excellent</option>
		                <option value='N/A'>N/A</option>
		            </select>
		        </span>
	        	
	        	<!-- Clearfix-->
		        <div class='clearfix'></div>
		        <!-- END: Clearfix-->
	        	
	        </div>
	        
	        <div class='capture_set'>
	        	
	        	<h2>Learning Spaces</h2>
	
				<div class='capture_content'>
	
					<h3>Standard Classrooms</h3>
					<div id='class_div'>
					".get_classrooms($school_id, 'standard_classrooms')."
					</div>			
					<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='standard_classrooms' value='$item->standard_classrooms'/>-->
			            <select name='standard_classrooms' id='standard_classrooms'>
			           	". get_option_default_int($item->standard_classrooms).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='standard_classrooms_condition' id='standard_classrooms_condition'>
			            	" . get_option_default_string($item->standard_classrooms_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='standard_classrooms_standards' id='standard_classrooms_standards'>
			            	" . get_option_default_int($item->standard_classrooms_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			        <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='standard_classrooms_reason' id='standard_classrooms_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('Standard_Classrooms',$school_id,'standard_classrooms','standard_classrooms_condition','standard_classrooms_standards','standard_classrooms_reason')> Add </a>
			        </span>
		        
				</div>
				
				<div class='capture_content'>
				
			        <h3>Multipurpose/Specialist</h3>
			        <div id='specialist_div'>
					".get_classrooms($school_id, 'Multipurpose/Specialist')."
					</div>	
					<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='specialist_classrooms' value='$item->specialist_classrooms'/>-->
			            <select name='specialist_classrooms' id='specialist_classrooms'>
			           	". get_option_default_int($item->specialist_classrooms).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='specialist_classrooms_condition' id='specialist_classrooms_condition'>
			            	" . get_option_default_string($item->specialist_classrooms_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='specialist_classrooms_standards' id='specialist_classrooms_standards'>
			            	" . get_option_default_int($item->specialist_classrooms_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='specialist_classrooms_reason' id='specialist_classrooms_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('Multipurpose/Specialist',$school_id,'specialist_classrooms','specialist_classrooms_condition','specialist_classrooms_standards','specialist_classrooms_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
				
			        <h3>Grade R Classrooms</h3>
			        <div id='grade_r_div'>
					".get_classrooms($school_id, 'grade_r_classrooms')."
					</div>		        
					<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='grade_r_classrooms' value='$item->grade_r_classrooms'/>-->
			            <select name='grade_r_classrooms' id='grade_r_classrooms'>
			           	". get_option_default_int($item->grade_r_classrooms).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='grade_r_classrooms_condition' id='grade_r_classrooms_condition'>
			            	" . get_option_default_string($item->grade_r_classrooms_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='grade_r_classrooms_standards' id='grade_r_classrooms_standards'>
			            	" . get_option_default_int($item->grade_r_classrooms_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='grade_r_classrooms_reason' id='grade_r_classrooms_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('Grade_R_Classrooms',$school_id,'grade_r_classrooms','grade_r_classrooms_condition','grade_r_classrooms_standards','grade_r_classrooms_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
					
			        <h3>Media Centres &amp; Storerooms</h3>
			        <div id='storeroom_div'>
					".get_classrooms($school_id, 'Media_Centres/Storerooms')."
					</div>	
					<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='media_centres' value='$item->media_centres'/>-->
			            <select name='media_centres' id='media_centres'>
			           	". get_option_default_int($item->media_centres).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='media_centres_condition' id='media_centres_condition'>
			            	" . get_option_default_string($item->media_centres_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='media_centres_standards'id='media_centres_standards'>
			            	" . get_option_default_int($item->media_centres_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='media_classrooms_reason' id='media_classrooms_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('Media_Centres/Storerooms',$school_id,'media_centres','media_centres_condition','media_centres_standards','media_classrooms_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
				
			        <h3>Computer Rooms &amp; Storerooms</h3>
			        <div id='computer_div'>
						".get_classrooms($school_id, 'Computer_Rooms/Storerooms')."
					</div>	        
					<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='computer_rooms' value='$item->computer_rooms' />-->
			            <select name='computer_rooms' id='computer_rooms'>
			           	". get_option_default_int($item->computer_rooms).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='computer_rooms_condition' id='computer_rooms_condition'>
			            	" . get_option_default_string($item->computer_rooms_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='computer_rooms_standards' id='computer_rooms_standards'>
			            	" . get_option_default_int($item->computer_rooms_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='computer_rooms_reason' id='computer_rooms_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('Computer_Rooms/Storerooms',$school_id,'computer_rooms','computer_rooms_condition','computer_rooms_standards','computer_rooms_reason')> Add </a>
			        </span>
			        
				</div>
					
				<div class='capture_content'>
					
			        <h3>Team Teaching Room</h3>
			        <div id='team_div'>
					".get_classrooms($school_id, 'Team_Teaching_Rooms')."
					</div>	
					<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='team_rooms' value='$item->team_rooms'/>-->
			            <select name='team_rooms' id='team_rooms'>
			           	". get_option_default_int($item->team_rooms).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='team_rooms_condition' id='team_rooms_condition'>
			            	" . get_option_default_string($item->team_rooms_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='team_rooms_standards'  id='team_rooms_standards'>
			            	" . get_option_default_int($item->team_rooms_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			        <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='team_rooms_reason' id='team_rooms_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('Team_Teaching_Rooms',$school_id,'team_rooms','team_rooms_condition','team_rooms_standards','team_rooms_reason')> Add </a>
			        </span>
			        
				</div>	        		        	
	        	
	        </div>
	        
	        <div class='capture_set'>
	        	
	        	<h2>Administration and Support Spaces</h2>	        					
				
	        	<h3>Administration Block</h3>
	        	
				<div class='capture_content'>
	        	
		        	<h4>Principal's Office</h4>
		        	<div id='principal_div'>
					".get_classrooms($school_id, 'principal_office')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='principals_office' value='$item->principals_office'/>-->
			            <select name='principals_office' id='principals_office'>
			           	". get_option_default_int($item->principals_office).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='principals_office_condition' id='principals_office_condition'>
			            	" . get_option_default_string($item->principals_office_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='principals_office_standards' id='principals_office_standards'>
			            	" . get_option_default_int($item->principals_office_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='principals_office_reason' id='principals_office_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('principal_office',$school_id,'principals_office','principals_office_condition','principals_office_standards','principals_office_reason')> Add </a>
			        </span>
			        
				</div>
		        
				<div class='capture_content'>
				
			        <h4>Deputy Principal's Office</h4>
			        <div id='deputy_div'>
					".get_classrooms($school_id, 'deputy_office')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='deupity_principals_office' value='$item->deupity_principals_office'/>-->
			            <select name='deupity_principals_office' id='deupity_principals_office'>
			           	". get_option_default_int($item->deupity_principals_office).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='deupity_principals_office_condition' id='deupity_principals_office_condition'>
			            	" . get_option_default_string($item->deupity_principals_office_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='deupity_principals_office_standards' id='deupity_principals_office_standards'>
			            	" . get_option_default_int($item->deupity_principals_office_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='deupity_principals_office_reason' id='deupity_principals_office_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('deputy_office',$school_id,'deupity_principals_office','deupity_principals_office_condition','deupity_principals_office_standards','deupity_principals_office_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
				
			        <h4>General Office</h4>
			         <div id='general_div'>
					".get_classrooms($school_id, 'general_office')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='general_office' value='$item->general_office'/>-->
			             <select name='general_office' id='general_office'>
			           	". get_option_default_int($item->general_office).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='general_office_condition' id='general_office_condition'>
			            	" . get_option_default_string($item->general_office_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='general_office_standards'  id='general_office_standards'>
			            	" . get_option_default_int($item->general_office_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			        <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='general_office_reason' id='general_office_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('general_office',$school_id,'general_office','general_office_condition','general_office_standards','general_office_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
				
			        <h4>Staffroom with Kitchenette</h4>
			          <div id='staffroom_div'>
					".get_classrooms($school_id, 'staffroom')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='staffroom' value='$item->staffroom'/>-->
			             <select name='staffroom' id='staffroom' >
			           	". get_option_default_int($item->staffroom).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='staffroom_condition' id='staffroom_condition'>
			            	" . get_option_default_string($item->staffroom_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='staffroom_standards' id='staffroom_standards'>
			            	" . get_option_default_int($item->staffroom_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='staffroom_reason' id='staffroom_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('staffroom',$school_id,'staffroom','staffroom_condition','staffroom_standards','staffroom_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
				
			        <h4>Strongroom</h4>
			         <div id='strongroom_div'>
					".get_classrooms($school_id, 'strongroom')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='strongroom' value='$item->strongroom'/>-->
			              <select name='strongroom' id='strongroom'>
			           	". get_option_default_int($item->strongroom).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='strongroom_condition' id='strongroom_condition'>
			            	" . get_option_default_string($item->strongroom_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='strongroom_standards' id='strongroom_standards'>
			            	" . get_option_default_int($item->strongroom_condition) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			          <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='strongroom_reason' id='strongroom_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('strongroom',$school_id,'strongroom','strongroom_condition','strongroom_standards','strongroom_reason')> Add </a>
			        </span>
			    
				</div>
				   
				<div class='capture_content'>
					
			        <h4>Stationery/General Store</h4>
			         <div id='stationery_div'>
					".get_classrooms($school_id, 'stationery')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='stationary_room' value='$item->stationary_room'/>-->
			           <select name='stationary_room'  id='stationary_room'>
			           	". get_option_default_int($item->stationary_room).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='stationary_room_condition' id='stationary_room_condition'>
			            	" . get_option_default_string($item->stationary_room_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='stationary_room_standards' id='stationary_room_standards'>
			            	" . get_option_default_int($item->stationary_room_condition) . "
			            	<option value='0'>- Standard</option> 
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			        <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='stationary_room_reason' id='stationary_room_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('stationery',$school_id,'stationary_room','stationary_room_condition','stationary_room_standards','stationary_room_reason')> Add </a>
			        </span>
			        
				</div>
					
				<div class='capture_content'>
						
			        <h4>Printing Room</h4>
			          <div id='printing_room_div'>
					".get_classrooms($school_id, 'printing_room')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='printing_room' value='$item->printing_room'/>-->
			            <select name='printing_room' id='printing_room'>
			           	". get_option_default_int($item->printing_room).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='printing_room_condition' id='printing_room_condition'>
			            	" . get_option_default_string($item->printing_room_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='printint_room_standards'  id='printint_room_standards'>
			            	" . get_option_default_int($item->printint_room_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			        <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='printing_room_reason' id='printing_room_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('printing_room',$school_id,'printing_room','printing_room_condition','printint_room_standards','printing_room_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
				
			        <h4>Sick Room (Male &amp; Female)</h4>
			          <div id='sick_room_div'>
					".get_classrooms($school_id, 'sick_room')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='sick_room' value='$item->sick_room'/>-->
			             <select name='sick_room' id='sick_room'>
			           	". get_option_default_int($item->sick_room).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='sick_room_condition' id='sick_room_condition' >
			            	" . get_option_default_string($item->sick_room_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='sick_room_standards' id='sick_room_standards'>
			            	" . get_option_default_int($item->sick_room_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			          <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='sick_room_reason' id='sick_room_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('sick_room',$school_id,'sick_room','sick_room_condition','sick_room_standards','sick_room_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
					
			        <h4>Entrance Hall</h4>
			       <div id='entrance_hall_div'>
					".get_classrooms($school_id, 'entrance_hall')."
					</div>  
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='entrance_hall' value='$item->entrance_hall'/>-->
			             <select name='entrance_hall' id='entrance_hall'>
			           	". get_option_default_int($item->entrance_hall).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='entrance_hall_condition' id='entrance_hall_condition'>
			            	" . get_option_default_string($item->entrance_hall_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			        
			        <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='entrance_hall_standards' id='entrance_hall_standards'>
			            	" . get_option_default_int($item->entrance_hall_standards) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			        <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='entrance_hall_reason' id='entrance_hall_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('entrance_hall',$school_id,'entrance_hall','entrance_hall_condition','entrance_hall_standards','entrance_hall_reason')> Add </a>
			        </span>
			        
				</div>
				
		        <h3>Support Spaces</h3>
	        	
				<div class='capture_content'>
				
		        	<h4>HoD Office/Teachers' Workroom</h4>
		        	 <div id='hod_office_div'>
					".get_classrooms($school_id, 'hod_office')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='hod_office' value='$item->hod_office'/>-->
			             <select name='hod_office' id='hod_office'>
			           	". get_option_default_int($item->hod_office).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='hod_office_condition' id='hod_office_condition'>
			            	" . get_option_default_string($item->hod_office_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='hod_office_standards' id='hod_office_standards'>
			            	" . get_option_default_int($item->strongroom_condition) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			        <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='hod_office_reason' id='hod_office_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('hod_office',$school_id,'hod_office','hod_office_condition','hod_office_standards','hod_office_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
					
			        <h4>Counselling Suite</h4>
		        	 <div id='counselling_suite_div'>
					".get_classrooms($school_id, 'counselling_suite')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='counselling_suite' value='$item->counselling_suite'/>-->
			             <select name='counselling_suite' id='counselling_suite'>
			           	". get_option_default_int($item->counselling_suite).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='counselling_suite_condition' id='counselling_suite_condition' >
			            	" . get_option_default_string($item->counselling_suite_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='counselling_suite_standards' id='counselling_suite_standards'>
			            	" . get_option_default_int($item->strongroom_condition) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			          <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='counselling_suite_reason' id='counselling_suite_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('counselling_suite',$school_id,'counselling_suite','counselling_suite_condition','counselling_suite_standards','counselling_suite_reason')> Add </a>
			        </span>
			        
				</div>
				
				<div class='capture_content'>
					
			        <h4>General Storerooms Outside</h4>
		        	 <div id='general_storeroom_div'>
					".get_classrooms($school_id, 'general_storeroom')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='general_storerooms' value='$item->general_storerooms'/>-->
			              <select name='general_storerooms' id='general_storerooms'>
			           	". get_option_default_int($item->general_storerooms).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='general_storerooms_condition' id='general_storerooms_condition'>
			            	" . get_option_default_string($item->general_storerooms_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='general_storerooms_standards' id='general_storerooms_standards'>
			            	" . get_option_default_int($item->strongroom_condition) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='general_storerooms_reason' id='general_storerooms_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('general_storeroom',$school_id,'general_storerooms','general_storerooms_condition','general_storerooms_standards','general_storerooms_reason')> Add </a>
			        </span>
			        
				</div>
					
				<div class='capture_content'>
					
			        <h4>Garden Stores and Changeroom</h4>
		        	 <div id='garden_storerooms_div'>
					".get_classrooms($school_id, 'garden_storerooms')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='garden_storerooms' value='$item->garden_storerooms'/>-->
			              <select name='garden_storerooms' id='garden_storerooms'>
			           	". get_option_default_int($item->garden_storerooms).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='garden_storerooms_condition' id='garden_storerooms_condition'>
			            	" . get_option_default_string($item->garden_storerooms_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='garden_storerooms_standards' id='garden_storerooms_standards'>
			            	" . get_option_default_int($item->strongroom_condition) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='garden_storerooms_reason' id='garden_storerooms_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('garden_storerooms',$school_id,'garden_storerooms','garden_storerooms_condition','garden_storerooms_standards','garden_storerooms_reason')> Add </a>
			        </span>
			        
				</div>
			        
				<div class='capture_content'>
					
			        <h4>Gate House</h4>
		        	 <div id='gate_house_div'>
					".get_classrooms($school_id, 'gate_house')."
					</div>
		        	<span class='form_input'>
			        	<label>Total Number</label> <br />
			            <!--<input type='text' placeholder='enter value here' name='gate_house' value='$item->gate_house'/>-->
			             <select name='gate_house' id='gate_house'>
			           	". get_option_default_int($item->gate_house).
			            print_numerical_options(100)."
			           </select>
			        </span>
		
			        <span class='form_input'>
			        	<label>Condition</label> <br />
			            <select name='gate_house_condition' id='gate_house_condition'>
			            	" . get_option_default_string($item->gate_house_condition) . "
			            	<option value='0'>- Condition</option>
			            	<option value='Poor'>Poor</option>
			                <option value='Good'>Good</option>
			                <option value='Excellent'>Excellent</option>
			                <option value='N/A'>N/A</option>
			            </select>
			        </span>
			         <span class='form_input'>
			        	<label>Meets Departmental Standards?</label> <br />
			            <select name='gate_house_standards' id='gate_house_standards'>
			            	" . get_option_default_int($item->strongroom_condition) . "
			            	<option value='0'>- Standard</option>
			            	<option value='1'>Yes</option>
			                <option value='0'>No</option>
			            </select>
			        </span>
		        	     <span class='form_input'>
			        	<label>Reason</label> <br />
			        	<textarea name='gate_house_reason' id='gate_house_reason'></textarea>
			        </span>
			        <span class='form_input'>
			        	<a class='button' onClick=add_class('gate_house',$school_id,'gate_house','gate_house_condition','gate_house_standards','gate_house_reason')> Add </a>
			        </span>
			        
				</div>	        	
	        	
	        </div>
	        
	        <div class='capture_set'>
	        	
	        	<h2>Communication</h2>
	        	
	        	<h3>Telephone</h3>
	        	
		        <span class='form_input'>
		        	<label>Available</label> <br />
		            <select>
		            	" . get_option_default_int() . "
		            	<option value='0'>- Available</option>
		            	<option value='1'>Yes</option>
						<option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Number</label> <br />
		            <input type='text' placeholder='enter value here' name='comm_tel' value='$item->comm_tel'/>
		           
		        </span>
		        
		        <h3>Internet</h3>
	        	
		        <span class='form_input'>
		        	<label>Available</label> <br />
		            <select>
		            	" . get_option_default_int() . "
		            	<option value='0'>- Available</option>
		            	<option value='1'>Yes</option>
						<option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Internet Provider (ie. Mweb)</label> <br />
		            <input type='text' placeholder='enter value here' name='comm_internet' value='$item->comm_internet'/>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Email</label> <br />
		            <input type='text' placeholder='enter value here' name='comm_email' value='$item->comm_email'/>
		        </span>
		        
		        <h3>Fax</h3>
	        	
		        <span class='form_input'>
		        	<label>Available</label> <br />
		            <select>
		            	" . get_option_default_int() . "
		            	<option value='0'>- Available</option>
		            	<option value='1'>Yes</option>
						<option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Number</label> <br />
		            <input type='text' placeholder='enter value here' name='comm_fax' value='$item->comm_fax'/>
		        </span>
		        
		        <h3>Callbox</h3>
	        	
		        <span class='form_input'>
		        	<label>Available</label> <br />
		            <select>
		            	" . get_option_default_int() . "
		            	<option value='0'>- Available</option>
		            	<option value='1'>Yes</option>
						<option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Number</label> <br />
		            <input type='text' placeholder='enter value here' name='comm_callbox' value='$item->comm_callbox'/>
		        </span>
		        
		        <h3>Cellphone</h3>
	        	
		        <span class='form_input'>
		        	<label>Available</label> <br />
		            <select>
		            	" . get_option_default_int() . "
		            	<option value='0'>- Available</option>
		            	<option value='1'>Yes</option>
						<option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Number</label> <br />
		            <input type='text' placeholder='enter value here' name='comm_cellphone' value='$item->comm_cellphone'/>
		        </span>
		        
		        <h3>2way Radio</h3>
	        	
		        <span class='form_input'>
		        	<label>Available</label> <br />
		            <select>
		            	" . get_option_default_int() . "
		            	<option value='0'>- Available</option>
		            	<option value='1'>Yes</option>
						<option value='0'>No</option>
		            </select>
		        </span>
		        
		        <span class='form_input'>
		        	<label>Frequency</label> <br />
		            <input type='text' placeholder='enter value here' name='comm_radio' value='$item->comm_radio'/>
		        </span>
	        	
				<!-- Clearfix-->
		        <div class='clearfix'></div>
		        <!-- END: Clearfix-->        
				
		        {$buttons}
			</div>
		</form>
	";
	
	return $html;
}

function get_education_project_programme($uid) {
	global $_db;
	return $_db->get_data("education_projects", "programme", "uid", $uid);
}

function get_education_programme_expenditure($uid) {
	return "0";
}

function get_education_programme_completion($uid) {
	return "0";
}

function get_education_programme_name($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("education_programmes", "name", "uid", $uid);
	
	# Return Data
	return $data;
}

function get_education_district_name($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("education_districts", "name", "uid", $uid);
	
	# Return Data
	return $data;
}

function get_municipality_name($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("municipalities", "name", "uid", $uid);
	
	# Return Data
	return $data;
}

function get_ward_name($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("wards", "name", "uid", $uid);
	
	# Return Data
	return $data;
}

function get_contractor_name($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("contractors", "name", "uid", $uid);
	
	# Return Data
	return $data;
}

function get_contractor_cbid($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("contractors", "cbid_grade", "uid", $uid);
	
	# Return Data
	return $data;
}

function get_implementing_agent_name($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("implementing_agents", "name", "uid", $uid);
	
	# Return Data
	return $data;
}

function get_consultant_name($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("consultants", "name", "uid", $uid);
	
	# Return Data
	return $data;
}

function get_education_project_expenditure($uid){
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->fetch_single("	SELECT
																									SUM(`claim`)
																								FROM
																									`project_finances`
																								WHERE
																									`project` = {$uid}");
	
	# Return Data
	return $data;
}

function get_education_project_duration($uid){
	
}

function get_education_project_time_lapse($uid){
	
}

function get_education_project_budget($uid) {
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("education_projects", "budget", "uid", $uid);
	
	# Return Data
	return $data;
}

function  get_previous_claim($consultant) {
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->fetch_single(" SELECT 
																									`claim`
																							   FROM
																							 		`project_finances`
																							   WHERE
																							  		`uid`=(SELECT 
																									           MAX(`uid`)
																							               FROM
																							 		           `project_finances`
																							               WHERE
																							  		            `consultant`='$consultant')");																						  	
	
	return $data;
}

function get_sub_name($id)
{
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("sub_contractors", "name", "uid", $id);
	
	# Return Data
	return $data;
}


function get_sub_contractors($projectid) {
	# Global Variables
	global $_db;
	
	$data																= $_db->fetch("SELECT
																						`uid`,
																						`name`
																					FROM
																						`sub_contractors`
																					WHERE
																						`active`=1
																					AND
																						`project`={$projectid}");
	
	
	 
	$sub_contractor_listing												= "<table id='subcontrtable'>";
	
	foreach ($data as $item) {
		$sub_contractor_listing											.= "<tr> ";
		$sub_contractor_listing											.= "<td><a style='color:red;' onclick=delete_sub_contractor($item->uid,$projectid)>x</a></td>";
		$sub_contractor_listing											.= "<td><div id='subnam$item->uid'><a id='subbbname$item->uid' onclick=\"changename('$item->name',$item->uid)\">".$item->name."</a></div></td>";
		$sub_contractor_listing											.= "<td><a id='update'  onclick=update_sub_contractor($item->uid,$projectid)>Update</a></td>";
		$sub_contractor_listing											.= "</tr> ";
	}
	$sub_contractor_listing												.= "</table>";
	
	if($_GET['action']=="project_profile")
	{
		#listing for Project Details Tabl
		foreach ($data as $item) {
		$listing														.= $item->name."<br>";
		}
		$sub_contractor_listing											= $listing;
	}
	
 
 return $sub_contractor_listing	;
	
}


function get_classrooms($school_id,$type)
{
	#Global Variable
	global $_db;
	
	$data																= $_db->fetch("SELECT
																							*
																						FROM
																							`education_classrooms`
																						WHERE
																							`type`='{$type}'
																							AND
																							`school`={$school_id}
																						"
																						);
	#listing when adding
	$classroom_listing													="<table>";
	$classroom_listing													.="<tr>";
	$classroom_listing													.="<th>No.</th>";
	$classroom_listing													.="<th>Condition</th>";
	$classroom_listing													.="<th>Meets DoE Standards</th>";
	$classroom_listing													.="<th>Reason</th>";
	$classroom_listing													.="<th width='40'>Delete</th>";
	$classroom_listing													.="</tr>";
	foreach ($data as $item) {
		$classroom_listing												.= "<tr> ";
		$classroom_listing												.= "<td>".$item->num_school."</td>";
		$classroom_listing												.= "<td>".$item->condition."</td>";
		$classroom_listing												.= "<td>".yesno($item->dept_standard)."</td>";
		$classroom_listing												.= "<td>".$item->reason."</td>";
		$classroom_listing												.= "<td><a style='color:red;' onclick= delete_class($item->uid,$school_id,'$item->type')>x</a></td>";
		$classroom_listing												.= "</tr> ";
	}
	$classroom_listing													.="</table>";
	
	#Listing when viewing
	if($_GET['action']=="profile")
	{
		
		foreach ($data as $value) {
        
		$listing														.="	<div class='details_row'>
            																	<span class='details_label'><strong>{$type}</strong></span>
            																	<span class='details_result'>{$value->num_school}</span>
            																	<span class='details_condition'>" . condition($value->condition) . "</span>
            																	<span class='details_std yes'>" . yesno($value->dept_standard) . "</span>
            																	<span class='details_reason'>{$value->reason}</span>            																	
            																</div>	";
		}
		
		$classroom_listing												= $listing;
	
		
	}
	return $classroom_listing;						
}



function get_consultants($projectid,$type) {
	# Global Variable
	global $_db;
	
	$data																= $_db->fetch("SELECT
																							`uid`,
																							`name`,
																							`consultant_type`
																						FROM
																							`consultants`
																						WHERE
																							`active`=1
																						AND
																							`project`={$projectid}");
	$consultants_listing												= "<table id='consultanttable'>";
	
	foreach ($data as $item) {
		$consultants_listing											.= "<tr> ";
		$consultants_listing											.= "<td><a style='color:red;' onclick= delete_consultant($item->uid,$projectid)>x</a></td>";
		$consultants_listing											.= "<td><div id='consnam$item->uid'><a id='consbbname$item->uid' onclick=\"consultantname('$item->name',$item->uid)\">".$item->name."</a></div></td>";
		$consultants_listing											.= "<td>".$item->consultant_type."</td>";
		$consultants_listing											.= "<td><a id='updateconsultant'  onclick=update_consultant($item->uid,$projectid)>Update</a></td>";
		$consultants_listing											.= "</tr> ";
	}
	$consultants_listing												.= "</table>";
	
	
	if($_GET['action']=="project_profile")
	{
	 $data																= $_db->fetch("SELECT
																							`uid`,
																							`name`,
																							`consultant_type`
																						FROM
																							`consultants`
																						WHERE
																							`active`=1
																						AND
																							`project`={$projectid}
																						AND 
																							`consultant_type`='{$type}'"
																						);	
		
		#listing for Project Details Tabl
		foreach ($data as $item) {
		$listing														.= $item->name."<br>";
		}
		$consultants_listing											= $listing;

	}
 
 return $consultants_listing	;																					
}

function get_consult_name($id)
{
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("consultants", "name", "uid", $id);
	
	# Return Data
	return $data;
}


function get_remaining_budget($project) {
	# Global Variables
	global $_db;
	
	# Get Data
	$uid																= $_db->fetch_single("		SELECT
																										MAX(`uid`)
																									FROM
																										`project_finances`");
	if(isset($uid)) {
		# Get Data
		$data															= $_db->get_data("project_finances", "remaining_budget", "uid", $uid);
	}
	else {
		$data															= get_education_project_budget($project);
	}
		
	# Return Data
	return $data;
}


function get_total_claims($uid) {
	# Global Variables
	global $_db;
	
	# Get Data
	$total																= $_db->fetch_single("		SELECT
																										SUM(`claim`)
																									FROM
																										`project_finances`
																									WHERE
																										`project`={$uid}");
	# Return Data
	return $total;
}


function get_education_project_progress($uid) {
	# Global Variables
	global $_db;
	
	# Get Data
	$raw_data															= $_db->fetch("		SELECT
																								`block`,
																								( `earthworks` 
																									+ `foundations` 
																									+ `floorslab`
																									+ `windows_level_brickwork` 
																									+ `roof_level_brickwork` 
																									+ `roofing` 
																									+ `finishes_1` 
																									+ `finishes_2` 
																									+ `complete`)
																									 / 9 * 100 as 'progress'
																								FROM
																									`education_project_progress`
																								WHERE
																									`project` = {$uid}
																								GROUP BY
																									`block`");
	
	# Get Data
	$progress															= 0;
	$num																= 0;
	foreach ($raw_data as $item) {
		$progress														= $progress + $item->progress;
		$num++;
	}
	$data																= ($num)? sprintf("%01.2f", ($progress / $num)) : "0%";
	
	# Return Data
	return $data;
}

function get_education_project_time_percentage($uid) {
	
}

function get_education_project_num_employed($uid) {
	# Global Variables
	global $_db;
	
	$data																= $_db->fetch_single("	SELECT
	# Get Data
																									COUNT(*)
																								FROM
																									`project_hr`
																								WHERE
																									`project` = {$uid}");
	
	# Return Data
	return $data;
}

function get_education_project_num_dependants($uid) {
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->fetch_single("	SELECT
																									SUM(`human_resources`.`dependants`)
																								FROM
																									`human_resources`,
																									`project_hr`
																								WHERE
																									`human_resources`.`uid` = `project_hr`.`human_resource`
																									AND `project_hr`.`project` = {$uid}");
	
	# Return Data
	return $data;
}

function education_project_details_tab($project, $programme) {
	# Global Variables
	global $_db, $validator, $_GLOBALS, $cur_page;
	
	

	# Get Data
	$project_data														= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`education_projects`
																							WHERE
																								`uid` = {$project}");
	
	# Generate HTML
	$html																= "
			<h2>Details</h2>
				
			<a href='?p=education_programmes&action=edit_project&programme={$programme}&project={$project}' >Edit</a>
		            
            <h3>General</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Programme Name:</strong></span>
            	<span class='details_result'>" . get_education_programme_name($project_data->programme) . "</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Project Name:</strong></span>
            	<span class='details_result'>{$project_data->name}</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>EMIS Number:</strong></span>
            	<span class='details_result'>{$project_data->emis_number}</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>GPS Co-Ordinates:</strong></span>
            	<span class='details_result'> <a href='http://maps.google.com/maps?f=q&amp;hl=en&amp;q={$project_data->longitude} {$project_data->latitude}' target='_blank' rel='gmapsoverlay'>{$project_data->longitude} E, {$project_data->latitude} S</a></span>
            </div>
            
        	<div class='details_row'>
            	<span class='details_label'><strong>Education District:</strong></span>
            	<span class='details_result'>" . get_education_district_name($project_data->district) . "</span>
            </div>
               
            <div class='details_row'>
            	<span class='details_label'><strong>Municipality:</strong></span>
            	<span class='details_result'>" . get_municipality_name($project_data->municipality) . "</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Municipal Ward:</strong></span>
            	<span class='details_result'>" . get_ward_name($project_data->ward) . "</span> 
            </div>
           
			<h3>Start &amp; Completion Dates</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Start Date:</strong></span>
            	<span class='details_result'>{$project_data->start_date}</span>
           	</div>
            
            <div class='details_row'>
           		<span class='details_label'><strong>Completion Date:</strong></span>
            	<span class='details_result'>{$project_data->due_date}</span>
            </div>            
			
            <h3>Contractor</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Contractor:</strong></span>
            	<span class='details_result'>{$project_data->contractor}  </span> <!--. get_contractor_name($project_data->contractor)-->
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>CIDB Grade:</strong></span>
            	<span class='details_result'>{$project_data->CIBD}</span> <!-- . get_contractor_cbid($project_data->contractor) .-->
            </div>
			
			<h3 class='sub-contractor'>Sub-Contractors</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Sub-Contractors:</strong></span>
            	<span class='details_result'> ".get_sub_contractors($project_data->uid)." </span>
            </div>			
            
            <h3>Consultants</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Project/Cluster Management:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Project/Cluster Manager")."</span><!-- . get_consultant_name($project_data->contractor_management) . -->
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Architects:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Architects")."</span><!-- . get_consultant_name($project_data->contractor_architects) . -->
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Quantity Surveyor:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Quantity Surveyors")."</span><!-- . get_consultant_name($project_data->contractor_quantity_surveyor) . -->
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Civil/Structural Engineer:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Civil Engineers")."</span><!-- . get_consultant_name($project_data->contractor_structural_engineer) .-->
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Electrical:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Electrical Engineers")."</span><!--  . get_consultant_name($project_data->contractor_electrical_engineer) . -->
            </div>
			
			<div class='details_row'>
            	<span class='details_label'><strong>Mechanical:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Mechanical Engineers")."</span>
            </div>
            
			<div class='details_row'>
            	<span class='details_label'><strong>Engineering:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Engineering")."</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Health &amp; Safety:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Health")."</span>
            </div>
            
			<div class='details_row'>
            	<span class='details_label'><strong>Environmental:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Environmental")."</span>
            </div>
            
			<div class='details_row'>
            	<span class='details_label'><strong>Other:</strong></span>
            	<span class='details_result'>".get_consultants($project_data->uid,"Other")."</span>
            </div>
	";
	
	# Return HTML
	return $html;
}
/*
 * =================================================================================
 * Dean EDIT
 * 
 * I have copied and pasted the education_project_progress_tab() function on line 2198
 * below and entitled it education_design_progress_tab().  This function must operate exactly
 * as the project progress function except it will have different content.
 * 
 * =================================================================================
 */
function education_project_design_tab($project) {
	# Global Variables
	global $_db, $validator, $_GLOBALS, $cur_page;
	#Get Percent Total
	$total_percent													= $_db->fetch_one("		SELECT  
																								b1.`block`, 
																							(
																								SELECT 
																									`percentD` 
																								FROM 
																									`education_design_progress` 
																								WHERE 
																									`block` = b1.`block`
																								LIMIT
																									1
																							) as percent, 
																							SUM(percentD)/count(b1.`block`) as total
																							FROM 
																								`education_design_progress` b1  
																							WHERE  
																								b1.`project` = {$project};
																						");
	$total_percent													= sprintf("%01.2f", $total_percent->total) . " %";
	

	# Get Data
	$data															= $_db->fetch("			SELECT
																								*
																							FROM
																								`education_design_progress`
																							WHERE
																								`project` = {$project}
																							ORDER BY
																								`datetime`
																					");
	$comment_data													= $_db->fetch("			SELECT
																									c1.`creation_date`,
																									c1.`created_by`,
																									c1.`project`,
																									c1.`content`,
																									(
																										SELECT
																											`first_name`
																										FROM
																											`users`
																										WHERE
																											`uid`=c1.`created_by`
																									) as 'owner'
																							FROM
																								`comments` c1
																							WHERE
																								c1.`project`={$project}
																								AND c1.`active`=1
																								AND c1.`type`=1
																							ORDER BY
																								c1.`creation_date`
																							
	
																					");															
	# Compile Content
	$listing															= "";
	foreach ($data as $item) {
		$earthworks_class												= ($item->earthworksD)? " class='table_graph'" : "";
		$foundations_class												= ($item->foundationsD)? " class='table_graph'" : "";
		$floorslab_class												= ($item->floorslabD)? " class='table_graph'" : "";
		$brickwork1_class												= ($item->windows_level_brickworkD)? " class='table_graph'" : "";
		$brickwork2_class												= ($item->roof_level_brickworkD)? " class='table_graph'" : "";
		$roofing_class													= ($item->roofingD)? " class='table_graph'" : "";
		$finishes1_class												= ($item->finishes_1D)? " class='table_graph'" : "";
		$finishes2_class												= ($item->finishes_2D)? " class='table_graph'" : "";
		$complete_class													= ($item->completeD)? " class='table_graph'" : "";
		$percent														= sprintf("%01.2f", $item->percentD) . " %";
		if (has_authority("education_design_progress")) {
			$listing													.= "
				<tr>
                	<td>{$item->block}</td>
                    <td{$earthworks_class}	id='{$item->block}_earthworksD'				onclick='education_design_progress({$project}, \"{$item->block}\", \"earthworksD\")'>" . 				yesno($item->earthworksD) . "</td>
                    <td{$foundations_class}	id='{$item->block}_foundationsD'				onclick='education_design_progress({$project}, \"{$item->block}\", \"foundationsD\")'>" . 				yesno($item->foundationsD) . "</td>
                    <td{$floorslab_class}	id='{$item->block}_floorslabD'				onclick='education_design_progress({$project}, \"{$item->block}\", \"floorslabD\")'>" . 				yesno($item->floorslabD) . "</td>
                    <td{$brickwork1_class}	id='{$item->block}_windows_level_brickworkD'	onclick='education_design_progress({$project}, \"{$item->block}\", \"windows_level_brickworkD\")'>" . 	yesno($item->windows_level_brickworkD) . "</td>
                    <td{$brickwork2_class}	id='{$item->block}_roof_level_brickworkD'	onclick='education_design_progress({$project}, \"{$item->block}\", \"roof_level_brickworkD\")'>" . 		yesno($item->roof_level_brickworkD) . "</td>
                    <td{$roofing_class}		id='{$item->block}_roofingD'					onclick='education_design_progress({$project}, \"{$item->block}\", \"roofingD\")'>" . 					yesno($item->roofingD) . "</td>
                    <td{$finishes1_class}	id='{$item->block}_finishes_1D'				onclick='education_design_progress({$project}, \"{$item->block}\", \"finishes_1D\")'>" . 				yesno($item->finishes_1D) . "</td>
                    <td{$finishes2_class}	id='{$item->block}_finishes_2D'				onclick='education_design_progress({$project}, \"{$item->block}\", \"finishes_2D\")'>" . 				yesno($item->finishes_2D) . "</td>
                    <td{$complete_class}	id='{$item->block}_completeD'				onclick='education_design_progress({$project}, \"{$item->block}\", \"completeD\")'>" . 					yesno($item->completeD) . "</td>
                    <td id='Dpercent_{$item->block}'>{$percent}</td>
                    <td>" . substr($item->datetime, 0, 10) . "</td>
                </tr>
			";
		}
		else {
			$listing													.= "
				
				<!-- This listing should be similar to education_project_progress_tab($project) 
				<tr>
                	<td></td>
                </tr>
                -->
			";
		}
		$x++;
	}
	
	
	$listing_comment													= "";
	
	
	foreach ($comment_data as $item) {
		$listing_comment												.= "<div class='comment_row'>";		
		$listing_comment												.= "<b class=''>{$item->owner}</b><br>";		
		$listing_comment												.= "<time>{$item->creation_date} </time>";
		$listing_comment												.= "<p>{$item->content}</p>";
		$listing_comment												.= "</div>";
		
	}
	
	# Generate HTML
	$html																= "
			<h2>Design Progress</h2>
            
            <table>
            	<tr>
                	<th>Block</th>
                    <th>Earthworks</th>
                    <th>Foundations</th>
                    <th>Floorslab</th>
                    <th>Brickwork - Window Level</th>
                    <th>Brickwork - Roof Level</th>
                    <th>Roofing</th>
                    <th>Finishes 1</th>
                    <th>Finishes 2</th>
                    <th>Complete</th>
                    <th>%</th>
                    <th>Last Captured Date</th>
                </tr>
                {$listing}
                <tr class='total'>
                	<td>Total</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span id='total_percentD'>{$total_percent}</span></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
			
            <div class='clearfix'>
            	<a class='button' href='{$cur_page}&id={$_GET['id']}&project={$_GET['project']}&action=new_block2'>
            		Add a block
            	</a>
            </div>
            <div class='comment_form'>
	            {$listing_comment}
	            <form name='comment_form' action='{$cur_page}&id={$_GET['id']}&project={$_GET['project']}&action=new_comment&type=1' method='POST'>
	            <div class='progress_comments'>
	          		<label>Add a Comment</label><br>
	          		<textarea id='comment' rows='4' cols='45' name='comment'> </textarea>
	            </div>
	            <div>
	            	<input type='submit' value='Post Comment' name='submit'/>
	            </div></form>
	        </div>
	";
	
    # Return HTML
	return $html;
}
/*
 * =============================== END: Dean EDIT ==================================================
 */
function education_project_blueprint_tab($project) {
	# Global Variables
	global $_db, $validator, $_GLOBALS, $cur_page;
	
	# Get Data
	$project															= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`education_projects`
																							WHERE
																								`uid` = {$project}");
	
	# Generate HTML

	$blueprint_file														= (strlen($project->blueprint_file))? 
			" <div class='gallery_set'>
				<a href='files/{$project->blueprint_file}' target='_blank'><img src='include/images/icon.png' /></a>
                <br />
				<strong>File: </strong>{$project->blueprint_file}<br />
            	<strong>Date Uploaded:</strong> {$project->blueprint_datetime}
           	</div>":" ";
           	
    $tender_file														= (strlen($project->tender_file))? 
			" <div class='gallery_set'>
				<a href='files/{$project->tender_file}' target='_blank'><img src='include/images/icon.png' /></a>
                <br />
				<strong>File: </strong>{$project->tender_file}<br />
            	<strong>Date Uploaded:</strong> {$project->tender_datetime}
           	</div>":" ";
			
	$drawing_file														= (strlen($project->drawing_file))? 
			" <div class='gallery_set'>
				<a href='files/{$project->drawing_file}' target='_blank'><img src='include/images/icon.png' /></a>
                <br />
				<strong>File: </strong>{$project->drawing_file}<br />
            	<strong>Date Uploaded:</strong> {$project->drawing_datetime}
           	</div>":" ";	
   
   $minute_file														= (strlen($project->minute_file))? 
			" <div class='gallery_set'>
				<a href='files/{$project->minute_file}' target='_blank'><img src='include/images/icon.png' /></a>
                <br />
				<strong>File: </strong>{$project->minute_file}<br />
            	<strong>Date Uploaded:</strong> {$project->minute_datetime}
           	</div>":" ";			
			
		
	$html																= "	        	
           
           	<h2>Tender Documents</h2>
             {$tender_file}
            <form id='tender_form' method='POST' action='$cur_page&action=upload_blueprint&id={$_GET['id']}&project={$_GET['project']}&file_type=tender' enctype='multipart/form-data'>
				
				<strong>Select Tender File to Upload</strong>
				<br />
				<input type='file' name='tender' />
				<br /><br />
				<input type='submit' value='Upload' />
           </form>
            <h2>Drawing Documents</h2>
			{$drawing_file}
            <form id='drawing_form' method='POST' action='$cur_page&action=upload_blueprint&id={$_GET['id']}&project={$_GET['project']}&file_type=drawing' enctype='multipart/form-data'>
				
				<strong>Select Drawing File to Upload</strong>
				<br />
				<input type='file' name='drawing' />
				<br /><br />
				<input type='submit' value='Upload' />
           </form>
            <h2>Minutes Documents</h2>
           	{$minute_file}
            <form id='minutes_form' method='POST' action='$cur_page&action=upload_blueprint&id={$_GET['id']}&project={$_GET['project']}&file_type=minute' enctype='multipart/form-data'>
				
				<strong>Select Drawing File to Upload</strong>
				<br />
				<input type='file' name='minute' />
				<br /><br />
				<input type='submit' value='Upload' />

           </form><!-- END: Minutes Documents  -->
	
		";
	//}
	
	# Return HTML
	return $html;
}

function education_project_progress_tab($project) {
	# Global Variables
	global $_db, $validator, $_GLOBALS, $cur_page;
	

	#Get Percent Total
	$total_percent													= $_db->fetch_one("		SELECT  
																								b1.`block`, 
																							(
																								SELECT 
																									`percent` 
																								FROM 
																									`education_project_progress` 
																								WHERE 
																									`block` = b1.`block`
																								LIMIT
																									1
																							) as percent, 
																							SUM(percent)/count(b1.`block`) as total
																							FROM 
																								`education_project_progress` b1  
																							WHERE  
																								b1.`project` = {$project};
																						");
	$total_percent													= sprintf("%01.2f", $total_percent->total) . " %";
	

	# Get Data
	$data															= $_db->fetch("			SELECT
																								*
																							FROM
																								`education_project_progress`
																							WHERE
																								`project` = {$project}
																							ORDER BY
																								`datetime`
																					");
																					
	$comment_data													= $_db->fetch("			SELECT
																									c1.`creation_date`,
																									c1.`created_by`,
																									c1.`project`,
																									c1.`content`,
																									(
																										SELECT
																											`first_name`
																										FROM
																											`users`
																										WHERE
																											`uid`=c1.`created_by`
																									) as 'owner'
																							FROM
																								`comments` c1
																							WHERE
																								c1.`project`={$project}
																								AND c1.`active`=1
																								AND c1.`type`=0
																							ORDER BY
																								c1.`creation_date`
																							
	
																					");																							
	
	# Compile Content
	$listing															= "";
	foreach ($data as $item) {
		$earthworks_class												= ($item->earthworks)? " class='table_graph'" : "";
		$foundations_class												= ($item->foundations)? " class='table_graph'" : "";
		$floorslab_class												= ($item->floorslab)? " class='table_graph'" : "";
		$brickwork1_class												= ($item->windows_level_brickwork)? " class='table_graph'" : "";
		$brickwork2_class												= ($item->roof_level_brickwork)? " class='table_graph'" : "";
		$roofing_class													= ($item->roofing)? " class='table_graph'" : "";
		$finishes1_class												= ($item->finishes_1)? " class='table_graph'" : "";
		$finishes2_class												= ($item->finishes_2)? " class='table_graph'" : "";
		$complete_class													= ($item->complete)? " class='table_graph'" : "";
		$percent														= sprintf("%01.2f", $item->percent) . " %";
		if (has_authority("education_progress_edit")) {
			$listing													.= "
				<tr>
                	<td>{$item->block}</td>
                    <td{$earthworks_class}	id='{$item->block}_earthworks'				onclick='education_project_progress({$project}, \"{$item->block}\", \"earthworks\")'>" . 				yesno($item->earthworks) . "</td>
                    <td{$foundations_class}	id='{$item->block}_foundations'				onclick='education_project_progress({$project}, \"{$item->block}\", \"foundations\")'>" . 				yesno($item->foundations) . "</td>
                    <td{$floorslab_class}	id='{$item->block}_floorslab'				onclick='education_project_progress({$project}, \"{$item->block}\", \"floorslab\")'>" . 				yesno($item->floorslab) . "</td>
                    <td{$brickwork1_class}	id='{$item->block}_windows_level_brickwork'	onclick='education_project_progress({$project}, \"{$item->block}\", \"windows_level_brickwork\")'>" . 	yesno($item->windows_level_brickwork) . "</td>
                    <td{$brickwork2_class}	id='{$item->block}_roof_level_brickwork'	onclick='education_project_progress({$project}, \"{$item->block}\", \"roof_level_brickwork\")'>" . 		yesno($item->roof_level_brickwork) . "</td>
                    <td{$roofing_class}		id='{$item->block}_roofing'					onclick='education_project_progress({$project}, \"{$item->block}\", \"roofing\")'>" . 					yesno($item->roofing) . "</td>
                    <td{$finishes1_class}	id='{$item->block}_finishes_1'				onclick='education_project_progress({$project}, \"{$item->block}\", \"finishes_1\")'>" . 				yesno($item->finishes_1) . "</td>
                    <td{$finishes2_class}	id='{$item->block}_finishes_2'				onclick='education_project_progress({$project}, \"{$item->block}\", \"finishes_2\")'>" . 				yesno($item->finishes_2) . "</td>
                    <td{$complete_class}	id='{$item->block}_complete'				onclick='education_project_progress({$project}, \"{$item->block}\", \"complete\")'>" . 					yesno($item->complete) . "</td>
                    <td id='percent_{$item->block}'>{$percent}</td>
                    <td>" . substr($item->datetime, 0, 10) . "</td>
                </tr>
			";
		}
		else {
			$listing													.= "
				<tr>
                	<td>{$item->block}</td>
                    <td{$earthworks_class}>" . yesno($item->earthworks) . "</td>
                    <td{$foundations_class}>" . yesno($item->foundations) . "</td>
                    <td{$floorslab_class}>" . yesno($item->floorslab) . "</td>
                    <td{$brickwork1_class}>" . yesno($item->windows_level_brickwork) . "</td>
                    <td{$brickwork2_class}>" . yesno($item->roof_level_brickwork) . "</td>
                    <td{$roofing_class}>" . yesno($item->roofing) . "</td>
                    <td{$finishes1_class}>" . yesno($item->finishes_1) . "</td>
                    <td{$finishes2_class}>" . yesno($item->finishes_2) . "</td>
                    <td{$complete_class}>" . yesno($item->complete) . "</td>
                    <td>{$percent}</td>
                    <td>" . substr($item->datetime, 0, 10) . "</td>
                </tr>
			";
		}
		$x++;
	}
	
	
	$listing_comment													= "";
	
	
	foreach ($comment_data as $item) {
		$listing_comment												.= "<div class='comment_row'>";		
		$listing_comment												.= "<b class=''>{$item->owner}</b><br>";		
		$listing_comment												.= "<time>{$item->creation_date} </time>";
		$listing_comment												.= "<p>{$item->content}</p>";
		$listing_comment												.= "</div>";
		
	}
	
	
	# Generate HTML
	$html																= "
			<h2>Construction Progress</h2>
            
            <table>
            	<tr>
                	<th>Block</th>
                    <th>Earthworks</th>
                    <th>Foundations</th>
                    <th>Floorslab</th>
                    <th>Brickwork - Window Level</th>
                    <th>Brickwork - Roof Level</th>
                    <th>Roofing</th>
                    <th>Finishes 1</th>
                    <th>Finishes 2</th>
                    <th>Complete</th>
                    <th>%</th>
                    <th>Last Captured Date</th>
                </tr>
                {$listing}
                <tr class='total'>
                	<td>Total</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span id='total_percent'>{$total_percent}</span></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
			 
            <div class='clearfix'>
            	<a class='button' href='{$cur_page}&id={$_GET['id']}&project={$_GET['project']}&action=new_block'>
            		Add a block
            	</a>
            </div>
            <div class='comment_form'>
	            {$listing_comment}
	            <form name='comment_form' action='{$cur_page}&id={$_GET['id']}&project={$_GET['project']}&action=new_comment&type=0' method='POST'>
	            <div class='progress_comments'>
	          		<label>Add a Comment</label><br>
	          		<textarea id='comment' rows='4' cols='45' name='comment'> </textarea>
	            </div>
	            <div>
	            	<input type='submit' value='Post Comment' name='submit'/>
	            </div></form>
	        </div>
            
	";
	
    # Return HTML
	return $html;
}

function education_project_gallery_tab($project) {
	return item_gallery("ep" . $project);
}

function education_project_hr_tab($project) {
	return item_hr("ep" . $project);
}

function education_project_finance_tab($project) {
	# Global Variables
	global $_db, $validator, $_GLOBALS, $cur_page;
	
	# Get Data
	$data																= $_db->fetch("	SELECT
																							*
																						FROM
																							`project_finances`
																						WHERE
																							`project` = {$project}
																							AND `consultant`=0");
	# Get Data
	$data2																= $_db->fetch("	SELECT
																							*
																						FROM
																							`project_finances`
																						WHERE
																							`project` = {$project}
																							AND `consultant`!=0");	
					
	
	# Generate Construction Listing
	$listing_construction												= "";
	$claim_to_date														= 0;
	foreach ($data as $item) {
		$claim_to_date													+= $item->claim;
		$budget_remaining												= $item->remaining_budget;
		$percent_used													= ($item->budget > 0)? ($claim_to_date / $item->budget * 100) : 0;
		$variation_accept												= ($item->variation_approved == "0000-00-00 00:00:00" && $item->variation > 0)? " <a href='{$cur_page}&id={$_GET['id']}&project={$_GET['project']}&action=approve_variation&finance_id={$item->uid}'>Approve</a>" : "";
		$listing_construction											.= "
		        <tr>
                	<td>" . substr($item->datetime, 0, 10) . "</td>
                    <td align='right'>R " . number_format(sprintf("%01.2f", $item->budget), 2, '.', ',') . "</td>
                    <td align='right'>R " . number_format(sprintf("%01.2f", $item->previous_claim), 2, '.', ',') . "</td>
                    <td align='right'>R " . number_format(sprintf("%01.2f", $item->claim), 2, '.', ',') . "</td>
					<td align='right'>R " . number_format(sprintf("%01.2f", $item->variation), 2, '.', ',') . "{$variation_accept}</td>
                    <td align='right'>R " . number_format(sprintf("%01.2f", $claim_to_date), 2, '.', ',') . "</td>
                    <!--<td align='right'>R " . number_format(sprintf("%01.2f", $budget_remaining), 2, '.', ',') . "</td>-->
                    <td align='right'>" . sprintf("%01.2f", $percent_used) . " %</td>
                </tr>
		";
		
	}		
	
	# Add Button Construction
	$add_button_construction													= "";
	
	//$disabled																	= (get_remaining_budget() == 0.00)?"disabled":"";
	if (has_authority("education_progress_edit")) {
		$add_button_construction														= "
			<input type='button' {$disabled} onclick='fetch_element(\"add_finance_area_construction\").style.display=\"block\";this.style.display=\"none\";' value='Add' />
			
			<div id='add_finance_area_construction' style='display:none; float: left;'>
				<form id='finance_add_form' method='POST' action='{$cur_page}&action=add_finance&id={$_GET['id']}&project={$_GET['project']}'>
				 	<span class='form_input'>
						Variation Order:<br />
						<input type='text' name='variation' />
					</span>
					<span class='form_input'>
						Claim:<br />
						<input type='text' name='claim' id='claim1' onkeyup='validate_claim(this,$project)'/>
					</span>
					<span class='form_input'>
						<input type='submit' value='Add'>
					</span>
				</form>
			</div>
		";
	}
//
# ================================================
#	Dean Edit: I have added a new button and
#   section for adding fincance for consultants
# ================================================
	
	# Generate Consultants Listing
	$listing_consultants												= "";
	$claim_to_date														= 0;
	//$previous_claim														= 0;
	foreach ($data2 as $item) {
		$claim_to_date													+= $item->claim;
		$consultant														= $_db->get_data("consultants","name","uid",$item->consultant);
		$budget_remaining												= $item->remaining_budget;//$item->budget - $claim_to_date;
		$percent_used													= ($item->budget > 0)? ($claim_to_date / $item->budget * 100) : 0;
		$variation_accept												= ($item->variation_approved == "0000-00-00 00:00:00" && $item->variation > 0)? " <a href='{$cur_page}&id={$_GET['id']}&project={$_GET['project']}&action=approve_variation&finance_id={$item->uid}'>Approve</a>" : "";
		$listing_consultants											.= "
		        <tr>
                	<td>" . substr($item->datetime, 0, 10) . "</td>
                	<td>". $consultant ."</td>
                    <td align='right'>R " . number_format(sprintf("%01.2f", $item->budget), 2, '.', ',') . "</td>
                    <td align='right'>R " . number_format(sprintf("%01.2f", $item->previous_claim), 2, '.', ',') . "</td>
                    <td align='right'>R " . number_format(sprintf("%01.2f", $item->claim), 2, '.', ',') . "</td>
				<!--<td align='right'>R " . number_format(sprintf("%01.2f", $item->variation), 2, '.', ',') . "{$variation_accept}</td>-->
                    <td align='right'>R " . number_format(sprintf("%01.2f", $claim_to_date), 2, '.', ',') . "</td>
                    <!--<td align='right'>R " . number_format(sprintf("%01.2f", $budget_remaining), 2, '.', ',') . "</td>-->
                    <td align='right'>" . sprintf("%01.2f", $percent_used) . " %</td>
                </tr>
		";
		
	}
	
	# Add Button Consultants
	$add_button_consultants													= "";
	if (has_authority("education_progress_edit")) {
		$add_button_consultants														= "
			<input type='button' {$disabled} onclick='fetch_element(\"add_finance_area_consultants\").style.display=\"block\";this.style.display=\"none\";' value='Add' />
			
			<div id='add_finance_area_consultants' style='display:none; float: left;'>
				<form id='finance_add_form' method='POST' action='{$cur_page}&action=add_finance&id={$_GET['id']}&project={$_GET['project']}'>
				 	<span class='form_input'>
						Consultant:<br />
						".consultantselect("","",$project)." 	
					</span>
				 	<!--<span class='form_input'>
						Variation Order:<br />
						<input type='text' name='variation' />
					</span>-->
					<span class='form_input'>
						Claim:<br />
						<input type='hidden' id='remaining_value' value=".get_remaining_budget($project).">
						<input type='text' name='claim' id='claim2' onkeyup='validate_claim(this,$project)'/>
					</span>
					<span class='form_input'>
						<input type='submit' id='claimconsultant' value='Add' style='disabled:disabled'>
					</span>
				</form>
			</div>
		";
	}
	
	

	
	
# ================================================
#	END: Dean Edit
# ================================================
	
	# Generate HTML
	$html																= "
			<h2>Finance</h2>
            
            <h3>Construction</h3>
           	<!-- Table -->
            <table>
                <tr>
                	<th>Entry Date</th>                	
                    <th>Project Budget</th>
                    <th>Previously Claimed</th>
                    <th>Current Claim</th>
                    <th>Variation</th>
                    <th>Total Claimed to Date</th>
                    <!--<th>Remaining Budget</th>-->
                    <th>Total Spent</th>
                </tr>
                {$listing_construction}
            </table>
            <!-- END: Table -->
            
            {$add_button_construction}
			
			<h3>Consultants</h3>
			
			<!-- Table -->
            <table>
                <tr>
                	<th>Entry Date</th>
                	<th>Consultant</th>
                    <th>Project Budget</th>
                    <th>Previously Claimed</th>
                    <th>Current Claim</th>
                   <!-- <th>Variation</th>-->
                    <th>Total Claimed to Date</th>
                    <!--<th>Remaining Budget</th>-->
                    <th>Total Spent</th>
                </tr>
                {$listing_consultants}	
            </table>
            <!-- END: Table -->
			{$add_button_consultants}
			<table id='table_total'>
                <tr>
                    <td>Remaining Budget: R " . number_format(sprintf("%01.2f", get_remaining_budget($project)), 2, '.', ',') ."</td>
                    <td>Total Spent:  ". sprintf("%01.2f", (get_total_claims($project)/get_education_project_budget($project)*100)) ." %</td>
                </tr> 
            </table>
	";
	# Return HTML
	return $html;
}

function get_education_project_name($project) {
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->get_data("education_projects", "name", "uid", $project);
	
	# Return Data
	return $data;
}

function education_project_profile($programme, $project) {
	# Global Variables
	global $_db, $cur_page, $validator, $_GLOBALS;
	
	# Generate Tabs
	$tabs																= array(	"Details"					=> education_project_details_tab($project, $programme),
																					"Design Progress"			=> education_project_design_tab($project),
																					"Blueprint"					=> education_project_blueprint_tab($project),
																					"Construction Progress"		=> education_project_progress_tab($project),
																					"Gallery"					=> education_project_gallery_tab($project),
																					"Project HR"				=> education_project_hr_tab($project),
																					"Finance"					=> education_project_finance_tab($project)
																			);
	$tabs_html															= tabbed_page($tabs);
	
	# Generate Page
	$html																= "
	<!-- Breadcrumbs -->
	<div class='breadcrumbs'>

		<a href='{$cur_page}' class='breadcrumb' >Programmes</a>
		<a href='{$cur_page}&action=profile&id={$programme}' class='breadcrumb' >" . get_education_programme_name($programme) . "</a>
			
	</div>
	<!-- END: Breadcrumbs -->
	
	<h1>" . get_education_project_name($project) . "</h1>
	
	{$tabs_html}
	";
	
	# Return Page
	return $html;
}

function get_education_assessment_name($uid) {
	global $_db;
	return $_db->get_data("education_assessments", "school_name", "uid", $uid);
}

function education_assessment_details($uid) {
	# Global Variables
	global $_db;
	
	# Get Data
	$data																= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`education_assessments`
																							WHERE
																								`uid` = {$uid}");
	
	# Generate HTML
	$html																= "
	<h2>Details</h2>
            
            <h3>General</h3>
           
            <div class='details_row'>
            	<span class='details_label'><strong>EMIS Number:</strong></span>
            	<span class='details_result'>{$data->emis}</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Education District:</strong></span>
            	<span class='details_result'>" . get_education_district_name($data->district) . "</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Municipality:</strong></span>
            	<span class='details_result'>" . get_municipality_name($data->municipality) . "</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Municipal Ward:</strong></span>
            	<span class='details_result'>{$data->ward}</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Grades Starting:</strong></span>
            	<span class='details_result'>{$data->start_grades}</span>
            </div>
            
             <div class='details_row'>
            	<span class='details_label'><strong>Grades Ending:</strong></span>
            	<span class='details_result'>{$data->end_grades}</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Learners:</strong></span>
            	<span class='details_result'>{$data->learners}</span>
            </div>
            
            <h3>Contact Information</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Principal:</strong></span>
            	<span class='details_result'>{$data->principle}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Telephone:</strong></span>
            	<span class='details_result'>{$data->comm_tel}</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Fax:</strong></span>
            	<span class='details_result'>{$data->comm_fax}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Email:</strong></span>
            	<span class='details_result'><a href=''>{$data->comm_email}</a></span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Address:</strong></span>
            	<span class='details_result'>{$data->address}</span>
            </div>
            
	
	";
	
	# Return HTML
	return $html;
}

function education_assessment_info($uid) {
	# Global Variables
	global $_db;
	
	# Get Data
	$item																= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`education_assessments`
																							WHERE
																								`uid` = {$uid}");
	
	# Generate HTML
	$html																= "
	
        	<h2>Current Information</h2>
            
            <h3>Last Capture</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Last Updated:</strong></span>
            	<span class='details_result'>{$item->datetime}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Updated by:</strong></span>
            	<span class='details_result'>" . user_get_name($item->user) . "</span>
            </div>
            <br />
            
            <h2>Educators and Enrolment</h2>
            
            <h3>Educators</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Male</strong></span>
            	<span class='details_result'>{$item->educators_male}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Female</strong></span>
            	<span class='details_result'>{$item->educators_female}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Disabled</strong></span>
            	<span class='details_result'>{$item->educators_disabled}</span>
            </div>
            
            <h3>Learners</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Grade R Enrolment</strong></span>
            	<span class='details_result'>{$item->grade_r_enrolement}</span>
            </div>
             <div class='details_row'>
            	<span class='details_label'><strong>Grade 1 - 7 Enrolment</strong></span>
            	<span class='details_result'>{$item->grades_enrolement}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Boys</strong></span>
            	<span class='details_result'>{$item->boys}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Girls</strong></span>
            	<span class='details_result'>{$item->girls}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Disabled Boys</strong></span>
            	<span class='details_result'>{$item->disabled_boys}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Disabled Girls</strong></span>
            	<span class='details_result'>{$item->disabled_girls}</span>
            </div>
            <br />
			                        
            <h2>Services</h2>
            <h3>Electricity</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Available</strong></span>
            	<span class='details_result'>" . yesno($item->electricity_available) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Type</strong></span>
            	<span class='details_result'>{$item->electricity_type}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Reliable</strong></span>
            	<span class='details_result'>" . yesno($item->electricity_reliable) . "</span>
            </div>
            
            <h3>Water</h3>
            <div class='details_row'>
            	<span class='details_label'><strong>Available</strong></span>
            	<span class='details_result'>" . yesno($item->water_available) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Type</strong></span>
            	<span class='details_result'>{$item->water_type}</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Reliable</strong></span>
            	<span class='details_result'>" . yesno($item->water_reliable) . "</span>
            </div>
            
            <h3>Fencing</h3>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
            </div>

            <div class='details_row'>
            	<span class='details_label'><strong>Type</strong></span>
            	<span class='details_result'>{$item->fencing_type}</span>
            </div>
            
            <h3>Parking Bays</h3>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
            </div>

            <div class='details_row'>
            	<span class='details_label'><strong>Normal Parking</strong></span>
            	<span class='details_result'>{$item->normal_parking}</span>
            </div>
              <div class='details_row'>
            	<span class='details_label'><strong>Disabled Parking</strong></span>
            	<span class='details_result'>{$item->disabled_parking}</span>
            </div>
            
            <h3>Hardened Courtyard</h3>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
                <span class='details_condition'>Condition</span>
            </div> 
            
            <div class='details_row'>
            	<span class='details_label'><strong>Available</strong></span>
            	<span class='details_result'>Yes</span>
                <span class='details_condition'>" . condition($item->courtyard_condition) . "</span>
            </div>       

            <div class='details_row'>
            	<span class='details_label'><strong>Size</strong></span>
            	<span class='details_result'>{$item->courtyard_size}</span>
            </div>

            
            <h3>Facilities</h3>
             <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
                <span class='details_condition'>Condition</span>
            </div>

            <div class='details_row'>
            	<span class='details_label'><strong>Paved Combi Area Court</strong></span>
            	<span class='details_result'>" . yesno($item->paved_combi_court) . "</span>
            	<span class='details_condition'>" . condition($item->paved_combi_court_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Soccer Facilities</strong></span>
            	<span class='details_result'>" . yesno($item->soccer) . "</span>
            	<span class='details_condition'>" . condition($item->soccer_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Rugby Facilities</strong></span>
            	<span class='details_result'>" . yesno($item->rugby) . "</span>
            	<span class='details_condition'>" . condition($item->rugby_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Netball Facilities</strong></span>
            	<span class='details_result'>" . yesno($item->netball) . "</span>
            	<span class='details_condition'>" . condition($item->netball_condition) . "</span>           	
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Cricket Facilities</strong></span>
            	<span class='details_result'>" . yesno($item->cricket) . "</span>
            	<span class='details_condition'>" . condition($item->cricket_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Athletics Facilities</strong></span>
            	<span class='details_result'>" . yesno($item->athletics) . "</span>
            	<span class='details_condition'>" . condition($item->athletics_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Swimming Facilities</strong></span>
            	<span class='details_result'>" . yesno($item->swimming) . "</span>
            	<span class='details_condition'>" . condition($item->swimming_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Tennis Facilities</strong></span>
            	<span class='details_result'>" . yesno($item->tennis) . "</span>
            	<span class='details_condition'>" . condition($item->tennis_condition) . "</span>
            </div>
            <br />
            
            <h2>Sanitation</h2>
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
                <span class='details_condition'>Condition</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Girls Toilets</strong></span>
            	<span class='details_result'>{$item->girls_toilets}</span>
            	<span class='details_condition'>" . condition($item->girls_toilets_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Boys' Toilets</strong></span>
            	<span class='details_result'>{$item->boys_toilets}</span>
            	<span class='details_condition'>" . condition($item->boys_toilets_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Boys' Urinals</strong></span>
            	<span class='details_result'>{$item->urinals_boys}</span>
            	<span class='details_condition'>" . condition($item->urinals_boys_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Disabled Toilets</strong></span>
            	<span class='details_result'>{$item->disabled_toilets}</span>
            	<span class='details_condition'>" . condition($item->disabled_toilets_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Male Teacher Toilets</strong></span>
            	<span class='details_result'>{$item->male_teacher_toilets}</span>
            	<span class='details_condition'>" . condition($item->male_teacher_toilets_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Female Teacher Toilets</strong></span>
            	<span class='details_result'>{$item->female_teacher_toilets}</span>
            	<span class='details_condition'>" . condition($item->female_teacher_toilets_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Boys Grade R Toilets</strong></span>
            	<span class='details_result'>{$item->grade_r_boys_toilets}</span>
            	<span class='details_condition'>" . condition($item->grade_r_boys_toilets_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Boys Grade R Urinals</strong></span>
            	<span class='details_result'>{$item->urinals_grade_r_boys}</span>
            	<span class='details_condition'>" . condition($item->urinals_grade_r_boys_condition) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Girls Grade R Toilets</strong></span>
            	<span class='details_result'>{$item->grade_r_girls_toilets}</span>
            	<span class='details_condition'>" . condition($item->grade_r_girls_toilets_condition) . "</span>
            </div>
            <br />
            
            <h2>School Nutrition Programme/Catering</h2>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
                <span class='details_condition'>Condition</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>SNP Kitchen or Tuckshop</strong></span>
            	<span class='details_result'>{$item->tuckshop}</span>
            	<span class='details_condition'>" . condition($item->tuckshop_condition) . "</span>
            </div>
            <br />
            
            <h2>Structure Materials</h2>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
                <span class='details_condition'>Condition</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Type</strong></span>
            	<span class='details_result'>{$item->structure_materials}</span>
            	<span class='details_condition'>" . condition($item->structure_materials_condition) . "</span>

            </div>
            <br />
            
            <h2>Learning Spaces</h2>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
                <span class='details_condition'>Condition</span>
                <span class='details_std'>Meets DoE Standards</span>
                <span class='details_reason'>Reason</span>
            </div>
            <!--
            <div class='details_row'>
            	<span class='details_label'><strong>Standard Classrooms</strong></span>
            	<span class='details_result'>{$item->standard_classrooms}</span>
            	<span class='details_condition'>" . condition($item->standard_classrooms_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->specialist_classrooms_standards) . "</span>
            </div>-->
            ".get_classrooms($item->uid, 'Standard_Classrooms')."<br/><br/>
            ".get_classrooms($item->uid, 'Multipurpose/Specialist')."<br/><br/> 
            ".get_classrooms($item->uid, 'Grade_R_Classrooms')."<br/><br/>
            ".get_classrooms($item->uid, 'Media_Centres/Storerooms')."<br/><br/>
            ".get_classrooms($item->uid, 'Computer_Rooms/Storerooms')."<br/><br/>
            ".get_classrooms($item->uid, 'Team_Teaching_Rooms')."<br/><br/>
           <!--<div class='details_row'>
            	<span class='details_label'><strong>Multipurpose/Specialist</strong></span>
            	<span class='details_result'>{$item->specialist_classrooms}</span>
            	<span class='details_condition'>" . condition($item->specialist_classrooms) . "</span>
            	<span class='details_std yes'>" . yesno($item->specialist_classrooms_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Grade R Classrooms</strong></span>
            	<span class='details_result'>{$item->grade_r_classrooms}</span>
            	<span class='details_condition'>" . condition($item->grade_r_classrooms) . "</span>
            	<span class='details_std yes'>" . yesno($item->grade_r_classrooms_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Media Centres + Storerooms</strong></span>
            	<span class='details_result'>{$item->media_centres}</span>
            	<span class='details_condition'>" . condition($item->media_centres_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->media_centres_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Computer Rooms + Storerooms</strong></span>
            	<span class='details_result'>{$item->computer_rooms}</span>
            	<span class='details_condition'>" . condition($item->computer_rooms_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->computer_rooms_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Team Teaching Room</strong></span>
            	<span class='details_result'>{$item->team_rooms}</span>
            	<span class='details_condition'>" . condition($item->team_rooms_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->team_rooms_standards) . "</span>
            </div>-->
            <br />
            
            <h2>Administration and Support Spaces</h2>
            
            <h3>Administration Block</h3>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
                <span class='details_condition'>Condition</span>
                <span class='details_std'>Meets DoE Standards</span>
                <span class='details_reason'>Reason</span>
            </div>
            ".get_classrooms($item->uid, 'principal_office')."<br/><br/>
            ".get_classrooms($item->uid, 'deputy_office')."<br/><br/> 
            ".get_classrooms($item->uid, 'general_office')."<br/><br/>
            ".get_classrooms($item->uid, 'staffroom')."<br/><br/>
            ".get_classrooms($item->uid, 'strongroom')."<br/><br/>
            ".get_classrooms($item->uid, 'stationery')."<br/><br/>
            ".get_classrooms($item->uid, 'printing_room')."<br/><br/>
            ".get_classrooms($item->uid, 'sick_room')."<br/><br/>
            ".get_classrooms($item->uid, 'entrance_hall')."<br/><br/>
            
            <!--<div class='details_row'>
            	<span class='details_label'><strong>Principal's Office</strong></span>
            	<span class='details_result'>{$item->principals_office}</span>
            	<span class='details_condition'>" . condition($item->principals_office_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->principals_office_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Deputy Principal's Office</strong></span>
            	<span class='details_result'>{$item->deupity_principals_office}</span>
            	<span class='details_condition'>" . condition($item->deupity_principals_office_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->deupity_principals_office_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>General Office</strong></span>
            	<span class='details_result'>{$item->general_office}</span>
            	<span class='details_condition'>" . condition($item->general_office_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->general_office_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Staffroom with Kitchenette</strong></span>
            	<span class='details_result'>{$item->staffroom}</span>
            	<span class='details_condition'>" . condition($item->staffroom_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->staffroom_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Strongroom</strong></span>
            	<span class='details_result'>{$item->strongroom}</span>
            	<span class='details_condition'>" . condition($item->strongroom_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->strongroom_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Stationery/General Store</strong></span>
            	<span class='details_result'>{$item->stationary_room}</span>
            	<span class='details_condition'>" . condition($item->stationary_room_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->stationary_room_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Printing Room</strong></span>
            	<span class='details_result'>{$item->printing_room}</span>
            	<span class='details_condition'>" . condition($item->printing_room_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->printing_room_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Sick Room (Male &amp; Female)</strong></span>
            	<span class='details_result'>{$item->sick_room}</span>
            	<span class='details_condition'>" . condition($item->sick_room_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->sick_room_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Entrance Hall</strong></span>
            	<span class='details_result'>{$item->entrance_hall}</span>
            	<span class='details_condition'>" . condition($item->entrance_hall_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->entrance_hall_standards) . "</span>
            </div>-->
            
            <h3>Support Spaces</h3>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
                <span class='details_condition'>Condition</span>
                <span class='details_std'>Meets DoE Standards</span>
                <span class='details_reason'>Reason</span>
            </div>
            ".get_classrooms($item->uid, 'hod_office')."<br/><br/>
            ".get_classrooms($item->uid, 'counselling_suite')."<br/><br/> 
            ".get_classrooms($item->uid, 'general_storeroom')."<br/><br/>
            ".get_classrooms($item->uid, 'garden_storerooms')."<br/><br/>
            ".get_classrooms($item->uid, 'gate_house')."<br/><br/>  
            <!--<div class='details_row'>
            	<span class='details_label'><strong>HoD Office/Teachers' Workroom</strong></span>
            	<span class='details_result'>{$item->hod_office}</span>
            	<span class='details_condition'>" . condition($item->hod_office_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->hod_office_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Counselling Suite</strong></span>
            	<span class='details_result'>{$item->counselling_suite}</span>
            	<span class='details_condition'>" . condition($item->counselling_suite_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->counselling_suite_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>General Storerooms Outside</strong></span>
            	<span class='details_result'>{$item->general_storerooms}</span>
            	<span class='details_condition'>" . condition($item->general_storerooms_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->general_storerooms_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Garden Stores and Changeroom</strong></span>
            	<span class='details_result'>{$item->garden_storerooms}</span>
            	<span class='details_condition'>" . condition($item->garden_storerooms_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->garden_storerooms_standards) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Gate House</strong></span>
            	<span class='details_result'>{$item->gate_house}</span>
            	<span class='details_condition'>" . condition($item->gate_house_condition) . "</span>
            	<span class='details_std yes'>" . yesno($item->gate_house_standards) . "</span>
            </div>
            <br />-->
            
            <h2>Communication</h2>
            
            <div class='details_row_header'>
            	<span class='details_label'>&nbsp;</span>
            	<span class='details_result'>Details</span>
            </div>
            
            <div class='details_row'>
            	<span class='details_label'><strong>Telephone</strong></span>
            	<span class='details_result'>" . yesno($item->comm_tel) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Internet</strong></span>
            	<span class='details_result'>" . yesno($item->comm_internet) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Fax</strong></span>
            	<span class='details_result'>" . yesno($item->comm_fax) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Callbox</strong></span>
            	<span class='details_result'>" . yesno($item->comm_callbox) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>Cellphone</strong></span>
            	<span class='details_result'>" . yesno($item->comm_cellphone) . "</span>
            </div>
            <div class='details_row'>
            	<span class='details_label'><strong>2way Radio</strong></span>
            	<span class='details_result'>" . yesno($item->comm_radio) . "</span>
            </div>
            <br />
	";
	
	# Return HTML
	return $html;
	
}

function education_assessment_gallery($uid) {
	return item_gallery("ea" . $uid);
	
}

function education_assessment_profile($uid) {
	# Global Variables
	global $_db, $cur_page, $validator, $_GLOBALS;
	
	# Get Data
	$item																= $_db->fetch_one("	SELECT
																								*
																							FROM
																								`education_assessments`
																							WHERE
																								`uid` = {$uid}");
	
	# Generate Tabs
	$tabs																= array(	"Details"				=> education_assessment_details($uid),
																					"Current Information"	=> education_assessment_info($uid),
																					"Gallery"				=> education_assessment_gallery($uid)
																			);
	$tabs_html															= tabbed_page($tabs);
	
	# Generate Page
	$html																= "
	
		<!-- Breadcrumbs -->
		<div class='breadcrumbs'>
	
			<!-- Breadcrumbs -->
			<a href='{$cur_page}' class='breadcrumb' >Schools</a>
				
		</div>
		<!-- END: Breadcrumbs -->
	
		<h1>" . get_education_assessment_name($uid) . "</h1>
		<a href='$cur_page&action=education_assessment_pdf&uid=$uid' target='_blank' ><img class='pdf' src='include/images/pdf.png' /></a>
		<a href='$cur_page&action=education_assessments&action=add&uid=$uid' style='float:right;'>Edit</a>
	
        <div class='details_large'>
        
        	Education District: " . get_education_district_name($item->district) . "<br />
        	EMIS: {$item->emis}<br />
        	GPS: {$item->co_ordinates}
        	
		</div>
        
	{$tabs_html}
	";
	
	# Return Page
	return $html;
}

# =========================================================================
# THE END
# =========================================================================

?>
