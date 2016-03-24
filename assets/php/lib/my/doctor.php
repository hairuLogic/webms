<?php

	class DoctorModel
	{
	    protected $db;

	    public function __construct(PDO $db)
	    {
	        $this->db = $db;
	    }

	    function get_all_doctor($docid)
		{
			
			try    
			{
				$docid = str_replace(" ","%",$docid);
				$sql = "SELECT * FROM hisdb.apptresrc WHERE type = 'doc' AND description LIKE '%{$docid}%'";

				// $arr = array();
				// while($obj = mysql_fetch_object($rs)) 
				// {
				// 	$arr[] = $obj;
				// }

				$stmt = $this->db->query($sql);
				$arr = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$arr[] = $row;
				}

				$result = '{"doctor":' . json_encode($arr) . '}';

				return $result;
			}
			catch(PDOException $e)
		    {
		    	echo $e->getMessage();
		    }
		}
	}

?>
