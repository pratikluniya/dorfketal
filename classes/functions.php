<?php

/**
 * Description of functions
 *
 * @author sms
 */

ini_set('memory_limit', '2048M');

include_once 'db_connect.php';

class functions extends db_connect {
    
    public function test_input($data)
    {
      $data = trim(strtolower($data));
      $data = strip_tags($data);
      $data = htmlspecialchars($data);
      $data = mysqli_real_escape_string($this->mysqli,$data);
      return $data;
    }
    /* Test_Input Function closed Here */
    
    public function get_datetime()
    {
         date_default_timezone_set('Asia/Calcutta');
         $date1=date( "Y-m-d h:i:s");
         return $date1;
    }
    public function get_datetime_html()
    {
         date_default_timezone_set('Asia/Calcutta');
         $date1=date( "Y-m-d\TH:i:s");
         return $date1;
    }
    /* Function get_datetime closed here*/
    
    public function data_insert($sql)
    {
        $result= $this->mysqli->query($sql) or die($this->mysqli->error);
		return $result;
    }
	
	public function data_insert_return_id($sql)
    {
        $result= $this->mysqli->query($sql) or die($this->mysqli->error);
		return $id=$this->mysqli->insert_id;
    }
    /* Insert Function Closed here  */
    
    public function data_select($sql)
    { 
            $select=$this->mysqli->query($sql) or die($this->mysqli->error);      
            if($select->num_rows==0){
               return 'no';
            }  else {
               while ($row = $select->fetch_array(MYSQLI_ASSOC)) {
                   $data[]=$row;
               }
               return $data;
            }   
    }
    /* Select function closed here */
    
    public function data_update($sql)
    {
        $update=  $this->mysqli->query($sql) or die($this->mysqli->error);
        return $update;
    } 
	
	public function data_delete($sql)
    {
        $update=  $this->mysqli->query($sql) or die($this->mysqli->error);
        return $update;
    } 
    // Update Function Closed Here
    function mobile_validate($mobile)
    {
        if(preg_match('/^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1})?([0-9]{10})$/', $mobile,$matches)){
          //  print_r($matches);
        return true;
        }
     return false;
    }
	
	
}

?>
