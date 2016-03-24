<?php

	class CalendarModel
	{
	    protected $db;

	    public function __construct(PDO $db)
	    {
	        $this->db = $db;
	    }
	    
	    function appt_cleanup()
	    {
	    	try
	    	{
	    		$sql = "UPDATE apptbook set apptstatus = 'Not Attend' WHERE apptstatus = 'Open' AND DATE(apptdate) < DATE(NOW())";

				$stmt = $this->db->prepare($sql);
				//$stmt->bind_param("sss", $firstname, $lastname, $email);
				
				$stmt->execute();
				
				return $smtp."cleanup successfully";
				
				$stmt->close();
			}
			catch(PDOException $e)
		    {
		    	echo $e->getMessage();
		    }
		}

	    function get_all_calendar($typ,$id,$start,$end)
		{
			
			try    
			{
				if($typ=='doctor'){				
					$sql = "SELECT sysno AS id,
							CONCAT(apptdate,'T',appttime) AS `start`,
							CONCAT(apptdate,'T',(appttime + INTERVAL 30 MINUTE)) AS `end`,
							CONCAT(apptstatus,'<br>',icnum) AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' ELSE 'red' END AS 'color'							
							FROM hisdb.apptbook a
							LEFT JOIN sysdb.patient b ON a.mrn = b.mrn 
							WHERE prov_id = '{$id}' AND apptdate BETWEEN '{$start}' AND '{$end}'
							UNION ALL
							SELECT 
							'' AS id,
							datefr AS `start`,
							dateto AS `end`,
							remark AS title,
							'red' AS 'color'
							FROM hisdb.apptph a
							UNION ALL
							SELECT 
							'' AS id,
							datefr AS `start`,
							dateto AS `end`,
							remark AS title,
							'orange' AS 'color'
							FROM hisdb.apptleave a
							WHERE resourcecode = '{$id}' AND datefr BETWEEN '{$start}' AND '{$end}' ";
				}else if ($typ == 'patient'){
					$sql = "SELECT sysno AS id,
							CONCAT(apptdate,'T',appttime) AS `start`,
							CONCAT(apptdate,'T',(appttime + INTERVAL 30 MINUTE)) AS `end`,
							apptstatus AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' ELSE 'red' END AS 'color'
							FROM hisdb.apptbook a
							LEFT JOIN sysdb.patient b ON a.mrn = b.mrn 
							WHERE icnum = '{$id}' AND apptdate BETWEEN '{$start}' AND '{$end}' ORDER BY id DESC ";
				}else if ($typ == 'grid'){
					$sql = "SELECT a.sysno AS id,
							CONCAT(apptdate,'T',appttime) AS `start`,
							CONCAT(apptdate,'T',(appttime + INTERVAL 30 MINUTE)) AS `end`,
							apptstatus AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' ELSE 'red' END AS 'color',
							b.mrn,prov_id AS 'doctor',
							b.name,b.newic as 'noic'
							FROM hisdb.apptbook a
							LEFT JOIN hisdb.membership b ON a.icnum = b.newic ";
							
							if($id != '')
								$sql = $sql." WHERE prov_id = '{$id}' AND apptdate BETWEEN '{$start}' AND '{$end}'";
							else
								$sql = $sql." WHERE apptdate = DATE(NOW())";
								
							$sql = $sql." ORDER BY apptdate DESC";
				}else if ($typ == 'gridpatient'){
					$sql = "SELECT a.sysno AS id,
							CONCAT(apptdate,'T',appttime) AS `start`,
							CONCAT(apptdate,'T',(appttime + INTERVAL 30 MINUTE)) AS `end`,
							apptstatus AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' ELSE 'red' END AS 'color',
							b.mrn,prov_id AS 'doctor',
							b.name,b.newic as 'noic'
							FROM hisdb.apptbook a
							LEFT JOIN hisdb.membership b ON a.icnum = b.newic ";
							
							if($id != '')
								$sql = $sql." WHERE icnum = '{$id}' AND apptdate BETWEEN '{$start}' AND '{$end}'";
							else
								$sql = $sql." WHERE apptdate = DATE(NOW())";

							$sql = $sql." ORDER BY apptdate DESC";
				}else{
					$sql = "SELECT sysno AS id,
							CONCAT(apptdate,'T',appttime) AS `start`,
							CONCAT(apptdate,'T',(appttime + INTERVAL 30 MINUTE)) AS `end`,
							CONCAT(apptstatus,'<br>',icnum) AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' ELSE 'red' END AS 'color'							
							FROM hisdb.apptbook a
							LEFT JOIN sysdb.patient b ON a.mrn = b.mrn 
							WHERE apptdate = DATE(NOW())
							UNION ALL
							SELECT 
							'' AS id,
							datefr AS `start`,
							dateto AS `end`,
							remark AS title,
							'red' AS 'color'
							FROM hisdb.apptph a";
				}
										
				$stmt = $this->db->query($sql);
				$arr = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$arr[] = $row;
				}

				$result = json_encode($arr);

				return $result;
			}
			catch(PDOException $e)
		    {
		    	echo $e->getMessage();
		    }
		}
	}

?>
