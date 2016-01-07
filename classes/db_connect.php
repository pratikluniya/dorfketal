<?php

/**
 * Description of db_connect
 *
 *  @author sms
 *  Database connection Class
 */
class db_connect {
    protected $mysqli;
    
    function __construct() {
        //create Database connection 
		@$this->mysqli = new mysqli("localhost", "root", "", "commerce");
      //  @$this->mysqli = new mysqli("localhost", "root", "", "trackingsystem");
		//@$this->mysqli = new mysqli("localhost", "makemysm_whatsap", "H{RV6M^t+3S2", "makemysm_whatsapp");
        if (mysqli_connect_errno()) {
            printf("Error: Unable To Connect Database");
            exit();
        }else{
            // return database object
            return $this->mysqli;   
        }
    }
    
    function __destruct() {
        @$this->mysqli->close(); // Close Database connection
        
    }  
}
//$obj = new db_connect();
?>