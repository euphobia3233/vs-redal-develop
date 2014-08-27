<?php
require_once('config.php');
class Connection
{
	private $connect;
	public function __construct($db_config)
	{
		$this->Connect($db_config['server'],$db_config['username'],$db_config['password'],$db_config['database']);
	}
	public function Connect($host,$username,$password,$database)
	{
		$this->connect = mysqli_connect($host,$username,$password,$database);
		if(mysqli_connect_errno())
		{
			echo "Failed to connect to data". mysqli_connect_error();
		}
	}
	public function getData($table,$where=null)
	{
		$query_form = "select *from ".$table;
		if(count($where)>0){
			$condition_array = array('or','and');
			$query_form .= " where ";
			while(list($key,$value) = each($where)){
				if(	is_numeric($key) ){
					if( in_array($where[$key],$condition_array) )
						$query_form .= $value." ";
					else
						return "false";
				}
				else
					$query_form .= $key."="."'".$value."' ";	
			}
		}
		$temp_array = array();
		$result = mysqli_query($this->connect,$query_form);
		if(mysqli_num_rows($result)){	
			while($row = mysqli_fetch_object($result))
				array_push($temp_array,$row);
		}
		else
			return "false";
		return $temp_array;
	}
}
?>