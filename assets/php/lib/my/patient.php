<?php

	class PatientModel
	{
	    protected $db;

	    public function __construct(PDO $db)
	    {
	        $this->db = $db;
	    }

	    function get_all_patient($typ,$term)
		{
			
			try    
			{
				//$sql = "SELECT MRN AS 'value',Name AS 'label' FROM hisdb.patmast";
				$sql = "SELECT * FROM hisdb.membership WHERE category = 'SUBSCRIBER' AND {$typ} like '%{$term}%'";

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

				$result = '{"patient":' . json_encode($arr) . '}';
				//$result = json_encode($arr);

				return $result;
			}
			catch(PDOException $e)
		    {
		    	echo $e->getMessage();
		    }
		}
		
	    function get_patient_dtl($patid)
		{
			
			try    
			{
				$sql = "SELECT * FROM hisdb.patmast WHERE Newic = '{$patid}'";

				$stmt = $this->db->query($sql);
				$arr = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$arr[] = $row;
				}

				$result = '{"patient":' . json_encode($arr) . '}';

				return $result;
			}
			catch(PDOException $e)
		    {
		    	echo $e->getMessage();
		    }
		}
		
	}

?>
