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
# DATABASE ENGINE CLASS
# ==================================================================================

class db_engine {
	# --- Variables ---
	/**
	* Contains the MySQL Host
	* @access var
	* @var string
	*/
	var $mysql_host;
	/**
	* Contains the MySQL Username
	* @access var
	* @var string
	*/
	var $mysql_user;
	/**
	* Contains the MySQL Password
	* @access var
	* @var string
	*/
	var $mysql_pass;
	/**
	* Contains the MySQL Database to acces
	* @access var
	* @var string
	*/
	var $mysql_db;
	/**
	* Contains the Database Handler
	* @access var
	* @var mysql_connection
	*/
	var $link;
	/**
	* Contains the Logging Engine
	* @access var
	* @var global_log
	*/
	var $logger;
	/**
	* Contains the Database Connection Status
	* @access var
	* @var string
	*/
	var $status;
	/**
	* Sets whether or not to turn Debuggin on
	* @access var
	* @var string
	*/
	var $debug;
	/**
	 * Contains the current query.
	 * @access var
	 * @var string
	 */
	var $query;
	
	# --- Functions ---
	/**
	* Constructor sets up {$mysql_host, $mysql_user, $mysql_pass, $mysql_db, $debug}
	*/
	function db_engine($mysql_host="", $mysql_user="", $mysql_pass="", $mysql_db="", $debug="0"){
		# Initialise Variables
		$this->mysql_host = $mysql_host;
		$this->mysql_user = $mysql_user;
		$this->mysql_pass = $mysql_pass;
		$this->mysql_db = $mysql_db;
		$this->debug = $debug;
	}

	/**
	 * Connects to the MySQL database and sets up the database handler.
	*/
	function db_connect(){
		# Create Connection To Database
		if ($this->mysql_host && $this->mysql_user && $this->mysql_pass){
			$this->link = mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_pass);
		}
		else if ($this->mysql_host && $this->mysql_user && !($tyhis->mysql_pass)){
			$this->link = mysql_connect($this->mysql_host, $this->mysql_user);
		}
		else if ($this->mysql_host && !($this->mysql_user) && !($tyhis->mysql_pass)){
			$this->link = mysql_connect($this->mysql_host);
		}
		
		# Handle any errors
		$this->err_handler(mysql_error());
		
		# Set Database
		if ($this->mysql_db){
			mysql_select_db($this->mysql_db, $this->link);
		}
		
		# Handle any errors
		$this->err_handler(mysql_error());
	}
	
	/**
	 * Connects to the database, executes a query, returns the result
	 * if needed, and closes the connection.
	 * @param string $query The SQL query to execute. 
	 * @return mysql_result
	*/
	function query($query){
		# Connect To Database
		$this->db_connect();
		
		# Execute SQL Command
		$result = mysql_query($query);
		
		# Handle Errors
		$this->err_handler(mysql_error());
		
		# Return Result
		return $result;
	}
	
	/**
	 * Connects to the database, executes a query, returns an array
	 * of objects.
	 * @param string $query The SQL query to execute. 
	 * @return Array
	*/
	function fetch($query){
		# Connect To Database
		$this->db_connect();
		
		# Execute SQL Command
		$result 	= mysql_query($query);
		
		# Handle Errors
		$this->err_handler(mysql_error());
		
		# Get Array
		$arr		= array();
		while ($item	= mysql_fetch_object($result)) {
			$arr[]	= $item;
		}
		
		# Return array
		return $arr;
	}
	
	/**
	 * Connects to the database, executes a query, returns an array
	 * of objects.
	 * @param string $query The SQL query to execute. 
	 * @return Array
	*/
	function fetch_one($query){
		# Connect To Database
		$this->db_connect();
		
		# Execute SQL Command
		$result 	= mysql_query($query);
		
		# Handle Errors
		$this->err_handler(mysql_error());
		
		# Get Array
		$item	= mysql_fetch_object($result);
		
		# Return array
		return $item;
	}
	
	/**
	 * Connects to the database, executes a query, returns a single value.
	 * @param string $query The SQL query to execute. 
	 * @return Array
	*/
	function fetch_single($query){
		# Connect To Database
		$this->db_connect();
		
		# Execute SQL Command
		$result 	= mysql_query($query);
		
		# Handle Errors
		$this->err_handler(mysql_error());
		
		# Get Data
		$row		= mysql_fetch_row($result);
		$data		= $row[0];
		
		# Return Data
		return $data;
	}
	
	/**
	 * Handles any errors that are generated by MySQL. If $debug is set
	 * to true, then the error will be displayed.
	 * @param mysql_error $err The MySQL Error object.
	*/
	function err_handler($err){
		# Global Variables
		global $_GLOBALS;
		
		# Check for the existance of an error message
		if (strlen($err)){
			# Output error
			$err 					.= ($this->query)? "<br />QUERY = {$query}" : "";
			$trace 					= print_r(debug_backtrace(), 1);
			$error_message			= "<b>DB Error</b>: " . $err . "<br /><br /><b>Stack Trace</b><br /><br />$trace";
			//print "<div class='info'>Oops... It seems there has been an error on the system. A message has been sent to the system admins to sort out.<br /><br />\n";
			//print "<a href='?p=home'>Click Here to Continue</a></div>\n";
			
			# Send Email to Admin
			mail($_GLOBALS['admin_email'], "DB ERROR", $error_message);
			
			# Display Error if in Debug Mode
			if ($this->debug) {
				print $error_message;
			}
			
			# Log Error
			logg("DB ERROR: $err", "ERROR");
			logg("Stack Trace: $trace", "DEBUG");
			
			# Halt Execution
			die();
		}
	}
	
	/**
	 * Inserts a record into a table and returns the uid
	 * @param string $table The table to insert into
	 * @param array $data An array with the row data
	 * @return Integer
	 */
	function insert($table, $data) {
		# Construct Insert Query
		$query										= "INSERT INTO `$table` (";
		$x											= 0;
		foreach ($data as $field => $value) {
			$query									.= ($x)? ", " : "";
			$query									.= " `$field` ";
			$x++;
		}
		$query										.= " ) VALUES ( ";
		$x											= 0;
		foreach ($data as $field => $value) {
			$query									.= ($x)? ", " : "";
			$query									.= " \"{$value}\" ";
			$x++;
		}
		$query										.= ")";
		
		# Execute Query
		$this->query($query);
		
		# Return UID
		return mysql_insert_id();
	}
	
	/**
	 * Updates the data of a row in a table.
	 * @param string $table The table name to update.
	 * @param array $data An array with the new values.
	 * @param array $id The index of the row to update.
	*/
	function update($table, $data, $id) {
		# Construct Where Clause
		$x = 0;
		$where = "";
		foreach ($id as $field => $value) {
			$where		.= ($x)? " AND " : "";
			$where		.= "`{$field}` = \"{$value}\" ";
			$x++;
		}
		
		# Construct Update Query
		$query = "UPDATE `$table` ";
		$x = 0;
		foreach ($data as $field => $value){
			# Add To Query
			if ($x == 0){
				$query	.= "SET ";
				$query	.= "`{$field}` = \"{$value}\" ";
				$x++;
			}
			else {
				$query	.= ", `{$field}` = \"{$value}\" ";
			}
			$x++;
		}
		$query .= " WHERE {$where}";
		
		# Execute Query
		$this->query($query);
	}
	
	/**
	 * Delete data from a table
	 * @param String $table The Table from which to delete
	 * @param String $field The field to match
	 * @param String $value The value to match
	 */
	function delete($table, $field, $value) {
		$this->query("DELETE FROM `$table`
						WHERE `$field` = \"$value\"");
	}
	
	/**
	 * Returns a single value from a table using search criteria
	 * @param String $table The table to search withing
	 * @param String $return_field The field to return
	 * @param String $search_field The field to match against
	 * @param String $search_value The value to match the search_field with 
	 * @return String
	 */
	function get_data($table, $return_field, $search_field, $search_value) {
		# Construct Query
		$query								= "SELECT `$return_field`
												FROM `$table`
												WHERE `$search_field` = \"{$search_value}\"";
		
		# Fetch Data
		$data								= $this->fetch_single($query);
		
		# Return Data
		return $data;
	}
	
	/**
	 * Sets the MySQL Host
	*/
	function set_mysql_host($data){
		$this->mysql_host = $data;
	}
	
	/**
	 * Sets the MySQL Host
	*/
	function set_logger($logger){
		$this->logger = $logger;
	}
	
	/**
	 * Sets the MySQL Username
	*/
	function set_mysql_user($data){
		$this->mysql_user = $data;
	}
	
	/**
	 * Sets the MySQL Password
	*/
	function set_mysql_pass($data){
		$this->mysql_pass = $data;
	}
	
	/**
	 * Sets the MySQL Database
	*/
	function set_mysql_db($data){
		$this->mysql_db = $data;
	}
	
	/**
	 * Turns debuggin mode on or off
	*/
	function set_debug($debug){
		$this->debug = $debug;
	}
	
	/**
	 * Checks the status of a table
	 * @param String $table The table name
	 * @return String $result
	 */
	function check_table($table) {
		$result				= $this->fetch_one("CHECK TABLE `{$table}`");
		return $result->Msg_text;
	}
}

# ==================================================================================
# THE END
# ==================================================================================

?>