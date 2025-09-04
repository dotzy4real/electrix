<?php


class Database {
	
	/**
	 * Allows multiple database connections
	 * each connection is stored as an element in the array, and the active connection is maintained in a variable (see below)
	 */
	private $connections = array();
	
	/**
	 * Tells the DB object which connection to use
	 * setActiveConnection($id) allows us to change this
	 */
	private $activeConnection = 0;
	
	/**
	 * Queries which have been executed and the results cached for later, primarily for use within the template engine
	 */
	private $queryCache = array();
	
	/**
	 * Data which has been prepared and then cached for later usage, primarily within the template engine
	 */
	private $dataCache = array();
	
	/**
	 * Number of queries made during execution process
	 */
	private $queryCounter = 0;
	
	/**
	 * Record of the last query
	 */
	private $last;
	
	/**
	 * Reference to the registry object
	 */
	private $registry;
	
	/**
	 * Construct our database object
	 */
    public function __construct()// Registry $registry ) 
    {
    	//$this->registry = $registry;	
    }
    
    /**
     * Create a new database connection
     * @param String database hostname
     * @param String database username
     * @param String database password
     * @param String database we are using
     * @return int the id of the new connection
     */
    public function newConnection( $host, $username, $password, $database )
    {
		if(!mysqli_connect($host, $username, $password)){
			throw new Exception('Unable to connect to the database at this time, please try again.');
		}else{		
		//print "all good?";
			$this->connections[] = mysqli_connect( $host, $username, $password);
			$connection_id = count( $this->connections )-1;
		}
		
		if(!mysqli_select_db($this->connections[$connection_id],$database)){
			throw new Exception('Unable to connect to the right database, please try again later.');
		}				
		//var_dump($this->connections);									 
		//print "no issues"; print $connection_id;
    	return $connection_id;
    }
    
    /**
     * Close the active connection
     * @return void
     */
    public function closeConnection()
    {
    	mysqli_close($this->connections[$this->activeConnection]);
    }
    
    /**
     * Change which database connection is actively used for the next operation
     * @param int the new connection id
     * @return void
     */
    public function setActiveConnection( int $new )
    {
    	$this->activeConnection = $new;
    }
	
	public function returnActiveConnection()
	{
		return $this->connections[$this->activeConnection];
	}
    
    /**
     * Store a query in the query cache for processing later
     * @param String the query string
     * @return the pointed to the query in the cache
     */
    public function cacheQuery( $queryStr )
    {
    	if( !$result = $this->connections[$this->activeConnection]->mysqli_query( $queryStr ) )
    	{
		    throw new Exception('Error executing and caching query: ');
		    return -1;
		}
		else
		{
			$this->queryCache[] = $result;
			return count($this->queryCache)-1;
		}
    }
    
    /**
     * Get the number of rows from the cache
     * @param int the query cache pointer
     * @return int the number of rows
     */
    public function numRowsFromCache( $cache_id )
    {
    	return mysqli_num_rows($this->queryCache[$cache_id]);	
    }
    
    /**
     * Get the rows from a cached query
     * @param int the query cache pointer
     * @return array the row
     */
    public function resultsFromCache( $cache_id )
    {
    	return mysqli_fetch_assoc($this->queryCache[$cache_id]);
    }
    
    /**
     * Store some data in a cache for later
     * @param array the data
     * @return int the pointed to the array in the data cache
     */
    public function cacheData( $data )
    {
    	$this->dataCache[] = $data;
    	return count( $this->dataCache )-1;
    }
    
    /**
     * Get data from the data cache
     * @param int data cache pointed
     * @return array the data
     */
    public function dataFromCache( $cache_id )
    {
    	return $this->dataCache[$cache_id];
    }
    
    /**
     * Delete records from the database
     * @param String the table to remove rows from
     * @param String the condition for which rows are to be removed
     * @param int the number of rows to be removed
     * @return void
     */
    public function deleteRecords( $table, $condition, $limit )
    {
    	$limit = ( $limit == '' ) ? '' : ' LIMIT ' . $limit;
    	$delete = "DELETE FROM {$table} WHERE {$condition} {$limit}";
    	$this->executeQuery( $delete );
    }
    
    /**
     * Update records in the database
     * @param String the table
     * @param array of changes field => value
     * @param String the condition
     * @return bool
     */
    public function updateRecords( $table, $changes, $condition )
    {
    	$update = "UPDATE " . $table . " SET ";
    	foreach( $changes as $field => $value )
    	{
    		$update .= "`" . $field . "`='{$value}',";
    	}
    	   	
    	// remove our trailing ,
    	$update = substr($update, 0, -1);
    	if( $condition != '' )
    	{
    		$update .= "WHERE " . $condition;
    	}
    	$this->executeQuery( $update );
    	
    	return true;
    	
    }
    
    /**
     * Insert records into the database
     * @param String the database table
     * @param array data to insert field => value
     * @return bool
     */
    public function insertRecords( $table, $data )
    {
    	// setup some variables for fields and values
    	$fields  = "";
		$values = "";
		
		// populate them
		foreach ($data as $f => $v)
		{
			
			$fields  .= "`$f`,";
			$values .= ( is_numeric( $v ) && ( intval( $v ) == $v ) ) ? $v."," : "'$v',";
		
		}
		
		// remove our trailing ,
    	$fields = substr($fields, 0, -1);
    	// remove our trailing ,
    	$values = substr($values, 0, -1);
    	
		$insert = "INSERT INTO $table ({$fields}) VALUES({$values})";
		//echo $insert;
		$this->executeQuery( $insert );
		return true;
    }
    
    public function lastInsertID()
    {
	    return mysqli_insert_id($this->connections[$this->activeConnection]);
    }
    
    /**
     * Execute a query string
     * @param String the query
     * @return void
     */
    public function executeQuery( $queryStr )
    {
		//var_dump($this->connections); exit;
		//var_dump($this->connections[$this->activeConnection]); var_dump($queryStr); exit;
    	if( !$result = mysqli_query( $this->connections[$this->activeConnection],$queryStr ) )
    	{
			//print $queryStr; exit;
		    throw new Exception('Error executing query: ' . $queryStr );
		}
		else
		{ 
			$this->last = $result;
		}
		
    }
	
	
    
    /**
     * Get the rows from the most recently executed query, excluding cached queries
     * @return array 
     */
    public function getRows()
    {
		$rows = array();
		while($results = mysqli_fetch_assoc($this->last)){
			$rows[] = $results;
		}
		return $rows;
    }
    
    public function numRows()
    {
	    return mysqli_num_rows($this->last);
    }
    
    /**
     * Gets the number of affected rows from the previous query
     * @return int the number of affected rows
     */
    public function affectedRows()
    {
    	return mysqli_affected_rows($this->last);
    }
    
    /**
     * Sanitize data
     * @param String the data to be sanitized
     * @return String the sanitized data
     */
    public function sanitizeData( $value )
    {
    	// Quote value
		
		$value = mysqli_real_escape_string( $value );
		
    	return $value;
    }
    
    /**
     * Deconstruct the object
     * close all of the database connections
     */
    public function __deconstruct()
    {
    	foreach( $this->connections as $connection )
    	{
    		mysqli_close($connection);
    	}
    }
}


$database = new Database();

?>