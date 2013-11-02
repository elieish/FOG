<?php
/**
 *FOG Project 
 * 
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
 * @package FOG
 */

# =========================================================================
# SCRIPT SETTINGS
# =========================================================================

$cur_page = "?p=members";

# =========================================================================
# DISPLAY FUNCTIONS
# =========================================================================

/**
 * The default function called when the script loads
 */
function display(){
	# Global Variables
	global $cur_page, $_db;
	
	# Get Data
	$data																= $_db->fetch("SELECT
																							*
																						FROM
																							`members`
																						ORDER BY
																							`datetime` DESC");
	
	$listing															= "";
	foreach ($data as $item) {
		$listing														.= "
            <tr onclick='window.location.href=\"{$cur_page}&action=profile&id={$item->uid}\";'>
            	<td>{$item->name}</td>
                <td>" . $_db->fetch_single("SELECT COUNT(*) FROM `education_projects` WHERE `programme` = {$item->uid}") . "</td>
                <td>{$item->financial_year}</td>
                <td>{$item->budget}</td>
                <td>" . get_education_programme_expenditure($item->uid) . "</td>
                <td>" . get_education_programme_completion($item->uid) . "</td>
                <td><a href='{$cur_page}&action=delete&id={$item->uid}' style='color:red;'>x</a></td>
            </tr>
		";
	}
	
	# Generate HTML
	$html																= "
		<h1>Infrastructure Programmes</h1>
        
        <!-- Department of Education -->
        <h2>KwaZulu-Natal Department of Education</h2>
        
		<!-- Add New Programme -->
		<a href='{$cur_page}&action=add' class='button left margin'><img src='include/images/add.png' align='absmiddle'>Add New Programme</a>
	    
        <!-- Table -->
        <table>
            <tr>
                <th>Programme Name</th>
                <th>Projects In Programme</th>
                <th>Financial Year</th>
                <th>Budget <br />&prime;000</th>
                <th>Expenditure <br />&prime;000</th>
                <th>Completion in %</th>
                <th width='40'>Delete</th>
			</tr>
            {$listing}
        </table>
        <!-- END: Table -->
    
	";
	
	# Display HTML
	print $html;
}

function profile() {
	# Global Variables
	global $cur_page, $_db, $validator;
	
	# Get GET Data
	$programme															= $validator->validate($_GET['id'], "Integer");
	
	# Filters
	$search_string														= (isset($_GET['search_string']))? 		$validator->validate($_GET['search_string']		, "String") 	: "";
	$region																= (isset($_GET['region']))?				$validator->validate($_GET['region']			, "Integer") 	: "%";
	$region																= ($region == "0")? "%" : $region;
	$province															= (isset($_GET['province']))?			$validator->validate($_GET['province']			, "Integer") 	: "%";
	$province															= ($province == "0")? "%" : $province;
	$implementing_agent													= (isset($_GET['implementing_agent']))?	$validator->validate($_GET['implementing_agent'], "Integer") 	: "%";
	$implementing_agent													= ($implementing_agent == "0")? "%" : $implementing_agent;
	
	# Get Data
	$data																= $_db->fetch("SELECT
																							*
																						FROM
																							`education_projects`
																						WHERE
																							`programme` = {$programme}
																							AND `name` LIKE \"%{$search_string}%\"
																							AND `region` LIKE '{$region}'
																							AND `implementing_agent` LIKE '{$implementing_agent}'
																						ORDER BY
																							`name`");
	
	$listing														= "";
	foreach ($data as $item) {
		$listing														.= "
            <tr onclick='window.location.href=\"$cur_page&action=project_profile&id={$programme}&project={$item->uid}\";'>
            	<td>{$item->name}</td>
                <td>" . str_replace($search_string, "<strong style='color:red;'>{$search_string}</strong>", get_education_programme_name($item->programme)) . "</td>
                <td>" . get_education_district_name($item->district) . "</td>
                <td>" . get_implementing_agent_name($item->implementing_agent) . "</td>
                <td>{$item->budget}</td>
                <td>" . get_education_project_expenditure($item->uid) . "</td>
				<td>" . get_education_project_duration($item->uid) . "</td>
                <td>" . get_education_project_time_lapse($item->uid) . "</td>
                <td>" . get_education_project_progress($item->uid) . "</td>
                <td>" . get_education_project_time_percentage($item->uid) . "</td> 
                <td>" . get_education_project_num_employed($item->uid) . "</td>
                <td>" . get_education_project_num_dependants($item->uid) . "</td>
                <td><a href='{$cur_page}&action=delete_project&id={$item->uid}' style='color:red;'>x</a></td>
            </tr>
		";
	}
	
	# Generate HTML
	$html																= "
		<!-- Breadcrumbs -->
		<div class='breadcrumbs'>
	
			<a href='{$cur_page}' class='breadcrumb'>Programmes</a>
				
		</div>
		<!-- END: Breadcrumbs -->
		
        <!-- Programme Title -->        
        <h1>" . get_education_programme_name($programme) . "</h1>
    	
		<!-- Search and Filters -->
	    <div class='search_filters'>
	    
			<form id='search_form' method='GET' action='{$cur_page}'>
				
					<input type='hidden' name='p' value='education_programmes' />
        			<input type='hidden' name='action' value='profile' />
        			<input type='hidden' name='id' value='{$programme}' />
	    
					<!-- Search -->
		        	<div class='search left clear'>
        		
						<h3>Search</h3>
			        	<span class='form_input'>
			        		<input name='search_string' type='text' placeholder='Search' value=\"{$search_string}\" />
			        		<input type='submit' value='Search'/>
			        	</span>
			        	
		        	</div>
	        		<!-- END: Search -->
	        		
	        		<!-- Filters -->
	        		<div class='left clear'>
	        		
	        			<h3>Filters</h3>
	        			
	        			<label>Region</label><br />
	        			" . region_select("", $region) . "
	        			
	        			<br />
	        			
	        			<label>Implementing Agent</label><br />
	        			" . implementing_agent_select("", $implementing_agent) . "
	       				
	       				<br />
						
	       				<label>Completed</label><br />       				
						<select>
			            	<option>Completed</option>
			            	<option>> 10%</option>
			                <option>10% - 20%</option>
			                <option>20% - 30%</option>
			                <option>30% - 40%</option>
			                <option>40% - 50%</option>
			                <option>50% - 60%</option>
			                <option>60% - 70%</option>
			                <option>70% - 80%</option>
			                <option>80% - 90%</option>
			                <option>90% - 99%</option>
			                <option>100%</option>
			            </select>
			            
						<br />
						<input type='submit' value='Filter'/>
	        		
	        		</div>
	        		<!-- END: Filters -->
	        
	        </form>
	        
	        <!-- Clearfix -->
	        <div class='clearfix'></div>
	        <!-- END: Clearfix -->
	        	
		</div>
		<!-- END: Search and Filters -->

        " . button("Add Project", "$cur_page&action=add_project&programme={$programme}") . "
		
		<!-- Table -->
        <table>
            <tr>
                <th>Project Name</th>
                <th>Programme</th>
                <th>Region</th>
                <th>Implementing Agent</th>
                <th>Budget &prime;000</th>
                <th>Expenditure &prime;000</th>
                <th>Project Duration (Months)</th>
                <th>Time Elapsed (Months)</th>
                <th>Progress (%)</th>
                <th>Time Elapsed (%)</th>
                <th>Employed</th>
                <th>Dependants</th>
                <th>Delete</th>
            </tr>
            
            {$listing}
			
            <tr class='social'>
            	<td>Social Impact</td>
                <td colspan=\"10\">&nbsp;</td>
                <td>total of employed and dependants</td>
                <td>&nbsp;</td>     
            </tr>
        </table>
        <!-- END: Table -->
        
        <!-- Clearfix-->
        <div class='clearfix'>
        </div>
        <!-- END: Clearfix-->
        
	";
	
	# Display HTML
	print $html;
}


function request() {
	# Global Variables
	global $cur_page, $_db, $validator;
	
	# Display Page
	print new_request();
}




# =========================================================================
# PROCESSING FUNCTIONS
# =========================================================================

function save_request() {
	
	# Global Variables
	global $cur_page, $_db, $validator;
	
	## Get POST Data Get GET Data
	$surname															= $validator->validate($_POST['Surname']						, "String");
	$name																= $validator->validate($_POST['Name']							, "String");
	$telephonework														= $validator->validate($_POST['Telephonework']					, "String");
	$cellphone															= $validator->validate($_POST['cellphone']						, "String");
	$emailaddress														= $validator->validate($_POST['EmailAddress']					, "String");
	
	if (isset($data)) {
		# Set UID of Project for Redirect
		$uid															= $project;
	
		# Update the Database
		$_db->update(
			"request",
			array(
				
				"datetime"												=> date("Y-m-d H:i:s"),
				"Surname"												=> $surname,
				"Name"													=> $name,	
				"Telephone"												=> $telephonework,
				"cellphone"												=> $cellphone,
				"Email"													=> $emailaddress,	
			),
			array(
				"uid"													=> $project
			)
		);
	}
	else {	
		# Add to Database
		$uid															= $_db->insert(
			"request",
			array(
				"datetime"												=> date("Y-m-d H:i:s"),
				"Surname"												=> $surname,
				"Name"													=> $name,
				"Telephone"												=> $telephonework,
				"cellphone"												=> $cellphone,
				"Email"													=> $emailaddress,
				
			)
		);
	}


	# Redirect
	print "<h3>One of our Agents will contact you soon</h3>";
	
}

function new_comment() {
	# Global Variables
	global $_db, $cur_page, $validator;
	
	# Get GET Data
	$comment															= $validator->validate($_POST['comment']		, "String");
	$project															= $validator->validate($_GET['project']		    , "Integer");
	$type																= $validator->validate($_GET['type']		    , "Integer");
	
	# Create New Block
	if (has_authority("education_progress_edit")) {
		$_db->insert(
			"comments",
			array(
				"created_by"											=> get_user_uid(),
				"creation_date"											=> date("Y-m-d H:i:s"),
				"project"												=> $project,
				"content"												=> $comment,
				"type"													=> $type
				
			)
		);
	}
	
	# Redirect
	redirect("{$cur_page}&action=project_profile&id={$id}&project={$project}");
}



function approve_variation() {
	# Global Variables
	global $_db, $cur_page, $validator;
	
	# Get GET Data
	$project															= $validator->validate($_GET['project']			, "Integer");
	$id																	= $validator->validate($_GET['id']				, "Ingeger");
	$finance_id															= $validator->validate($_GET['finance_id']		, "Integer");
	
	# Update Finance Table
	$_db->update(
		"project_finances",
		array(
			"variation_approved"										=> date("Y-m-d H:i:s")
		),
		array(
			"uid"														=> $finance_id
		)
	);
	
	# Redirect
	redirect("{$cur_page}&action=project_profile&id={$id}&project={$project}");
}

function delete() {
	# Global Variables
	global $_db, $cur_page, $validator;
	
	# Get GET Data
	$id																	= $validator->validate($_GET['id'], "Integer");
	
	# Log Activity
	logg("Education Programmes: Deleting Programme {$id}.");
	
	# Delete from Databse
	$_db->delete("education_programmes", "uid", $id);
	
	# Redirect
	redirect($cur_page);
}

function delete_project() {
	# Global Variables
	global $_db, $cur_page, $validator;
	
	# Get GET Data
	$id																	= $validator->validate($_GET['id'], "Integer");
	
	# Log Activity
	logg("Education Programmes: Deleting Project {$id}.");
	
	# Delete from Databse
	$_db->delete("education_projects", "uid", $id);
	
	# Redirect
	redirect($cur_page);
}

# =========================================================================
# ACTION HANDLER
# =========================================================================

if (isset($_GET['action'])){
	$action 															= $_GET['action'];
	if ($action															== "display"){
		display();
	}
	else if ($action													== "delete") {
		delete();
	}
	else if ($action 													== "profile") {
		profile();
	}
	else if ($action													== "delete_project") {
		delete_project();
	}
	else if ($action													== "delete_sub_contractor") {
		delete_sub_contractor();
	}
	else if ($action 													== "project_profile") {
		project_profile();
	}
	else if ($action													== "upload_blueprint") {
		upload_blueprint();
	}
	else if ($action 													== "new_block") {
		new_block();
	}
	else if ($action 													== "new_block2") {
		new_block2();
	}
	else if ($action 													== "new_comment") {
		new_comment();
	}
	else if ($action													== "message") {
		message();
	}
	else if ($action													== "add_finance") {
		add_finance();
	}
	else if ($action 													== "add") {
		add();
	}
	else if ($action 													== "save") {
		save();
	}
	else if ($action 													== "add_project") {
		add_project();
	}
	else if ($action 													== "save_member") {
		save_member();
	}
	else if ($action 													== "save_request") {
		save_request();
	}
	else if ($action													== "edit_project") {
		edit_project();
	}
	else if ($action													== "approve_variation") {
		approve_variation();
	}
	
	else if ($action													== "request") {
		request();
	}
	else {
		error("Invalid action `$action`.");
	}
}
else {
	display();
}

# =========================================================================
# THE END
# =========================================================================

?>