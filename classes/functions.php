<?php

include_once 'db_connect.php';

class functions extends db_connect {
    
    
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
	// Update Function Closed Here
	public function data_delete($sql)
    {
        $update=  $this->mysqli->query($sql) or die($this->mysqli->error);
        return $update;
    } 
}

?>
