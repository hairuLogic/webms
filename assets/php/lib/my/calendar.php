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
							CONCAT(pat_name) AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' WHEN 'Not Attend' THEN 'brown' WHEN 'Cancel' THEN 'grey' ELSE 'red' END AS 'color',
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Open' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Open',					
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Attend' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Attend',						
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Not Attend' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Not Attend',						
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Cancel' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Cancel'
							,a.*						
							FROM hisdb.apptbook a
							WHERE prov_id = '{$id}' AND apptdate BETWEEN '{$start}' AND '{$end}' ";
/*							UNION ALL
							SELECT 
							'' AS id,
							datefr AS `start`,
							dateto AS `end`,
							remark AS title,
							'red' AS 'color'
							,'' AS 'Open','' AS 'Attend','' AS 'Not Attend','' AS 'Cancel'
							FROM hisdb.apptph a
							UNION ALL
							SELECT 
							'' AS id,
							datefr AS `start`,
							dateto AS `end`,
							remark AS title,
							'orange' AS 'color'
							,'' AS 'Open','' AS 'Attend','' AS 'Not Attend','' AS 'Cancel'
							FROM hisdb.apptleave a
							WHERE resourcecode = '{$id}' AND datefr BETWEEN '{$start}' AND '{$end}' ";
*/
				}else if ($typ == 'patient'){
					$sql = "SELECT sysno AS id,
							CONCAT(apptdate,'T',appttime) AS `start`,
							CONCAT(apptdate,'T',(appttime + INTERVAL 30 MINUTE)) AS `end`,
							apptstatus AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' WHEN 'Not Attend' THEN 'brown' WHEN 'Cancel' THEN 'grey' ELSE 'red' END AS 'color',
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Open' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Open',					
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Attend' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Attend',						
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Not Attend' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Not Attend',						
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Cancel' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Cancel'						
							FROM hisdb.apptbook a
							WHERE icnum = '{$id}' AND apptdate BETWEEN '{$start}' AND '{$end}' ORDER BY id DESC ";
				}else if ($typ == 'grid'){
					$sql = "SELECT a.sysno AS id,
							CONCAT(apptdate,'T',appttime) AS `start`,
							CONCAT(apptdate,'T',(appttime + INTERVAL 30 MINUTE)) AS `end`,
							apptstatus AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' WHEN 'Not Attend' THEN 'brown' WHEN 'Cancel' THEN 'grey' ELSE 'red' END AS 'color',
							b.mrn,prov_id AS 'doctor',
							b.name,b.newic as 'noic'
							,'' AS 'Open','' AS 'Attend','' AS 'Not Attend','' AS 'Cancel'
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
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' WHEN 'Not Attend' THEN 'brown' WHEN 'Cancel' THEN 'grey' ELSE 'red' END AS 'color',
							b.mrn,prov_id AS 'doctor',
							b.name,b.newic as 'noic'
							,'' AS 'Open','' AS 'Attend','' AS 'Not Attend','' AS 'Cancel'
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
							CONCAT(pat_name) AS title,
							CASE apptstatus WHEN 'Open' THEN 'blue' WHEN 'Attend' THEN 'green' WHEN 'Not Attend' THEN 'brown' WHEN 'Cancel' THEN 'grey' ELSE 'red' END AS 'color',
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Open' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Open',					
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Attend' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Attend',						
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Not Attend' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Not Attend',						
							(SELECT COUNT(*) FROM hisdb.apptbook WHERE apptstatus = 'Cancel' AND DATE(apptdate) = DATE(a.apptdate)) AS 'Cancel'						
							FROM hisdb.apptbook a
							WHERE apptdate = DATE(NOW())
							UNION ALL
							SELECT 
							'' AS id,
							datefr AS `start`,
							dateto AS `end`,
							remark AS title,
							'red' AS 'color',
							'' AS 'Open','' AS 'Attend','' AS 'Not Attend','' AS 'Cancel'
							FROM hisdb.apptph a";
				}

				$stmt = $this->db->query($sql);
				$arr = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$ttl = $row['Open']+$row['Attend']+$row['Not Attend']+$row['Cancel'];
					$row['test'] = '<table style="font-size:14px"><tr style="text-align:center"><td><img alt="Open" src="../../../../assets/img/icon/i-open.jpg" width="15" /></td><td><img alt="Open" src="../../../../assets/img/icon/i-attend.jpg" width="15" /></td><td> <img alt="Open" src="../../../../assets/img/icon/i-xattend.jpg" width="15" /></td><td> <img alt="Open" src="../../../../assets/img/icon/i-cancel.jpg" width="15" /></td><td>Total</td></tr>
									<tr style="text-align:center"><td>'.$row['Open'].'</td><td>'.$row['Attend'].'</td><td>'.$row['Not Attend'].'</td><td>'.$row['Cancel'].'</td><td>'.$ttl.'</td></tr></table>';					
					
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
