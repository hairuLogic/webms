<?php

	class ApptModel
	{
	    protected $db;

	    public function __construct(PDO $db)
	    {
	        $this->db = $db;
	    }

	    function save_appt_dtl($icnum,$apptdate,$appttime,$mrn,$pat_name,$remarks)
		{
			
			try    
			{
			
				$sql = "INSERT INTO hisdb.apptbook (icnum,apptdate,appttime,mrn,pat_name,remarks) VALUES (
						'{$icnum}',
						'{$apptdate}',
						'{$appttime}',
						'{$mrn}',
						'{$pat_name}',
						'{$remarks}')";

				$stmt = $this->db->prepare($sql);
				//$stmt->bind_param("sss", $firstname, $lastname, $email);
				
				$stmt->execute();
				
				return "New records created successfully";
				
				$stmt->close();
				$conn->close();

			
//				$stmt = $this->db->query($sql);

//				return('result:'.$stmt);
			}
			catch(PDOException $e)
		    {
		    	echo $e->getMessage();
		    }
		}
		
	    function upd_appt_dtl($patid)
		{
			
			try    
			{
				$sql = "SELECT * FROM hisdb.patmast WHERE mrn = '{$patid}'";

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
		
	    function get_appt_dtl($apptid)
		{
			
			try    
			{
				$sql = "SELECT a.*, b.*, c.*
						FROM hisdb.apptbook a
						LEFT JOIN hisdb.membership b ON a.icnum = b.Newic
						LEFT JOIN hisdb.apptresrc c ON c.resourcecode = a.prov_id
						WHERE a.sysno = '{$apptid}'";
						
						//return $sql;

				$stmt = $this->db->query($sql);
				$arr = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$arr[] = $row;
				}

				$result = '{"appt":' . json_encode($arr) . '}';

				return $result;
			}
			catch(PDOException $e)
		    {
		    	echo $e->getMessage();
		    }
		}
	}

?>
