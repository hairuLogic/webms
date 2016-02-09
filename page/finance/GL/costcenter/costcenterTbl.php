<?php
	include_once('../../connection/sschecker.php');
	include_once('../../connection/connect_db.php');
	
	$table='costcenter';
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	$responce = new stdClass();
	
	if(isset($_GET['Stext']) && $_GET['Scol'] == 'costcode'){
		$SQL = "SELECT * FROM $table 
				WHERE recstatus = 'A' AND compcode='$compcode'  AND {$_GET['Scol']}   
			LIKE '{$_GET['Stext']}%' 
			ORDER BY sysno ASC";
	}
			
	else if(isset($_GET['Scol']) && $_GET['Stext'] != ''){			
		$addSql='';
		$searchcol=$_GET['Scol'];
		$searchStext=$_GET['Stext'];
		
		$parts = explode(' ', $searchStext);
		$partsLength  = count($parts);
		while($partsLength>0){
			$partsLength--;
			$addSql.=" AND {$_GET['Scol']} like '%{$parts[$partsLength]}%' ";
		}
		$SQL = "SELECT * FROM $table 
			WHERE  recstatus = 'A' AND compcode='$compcode'".$addSql.
			"ORDER BY sysno ASC"; 
	}else{
		$SQL = "SELECT * FROM $table WHERE recstatus ='A' AND compcode='$compcode' ORDER BY sysno ASC";
	}
	
	$result = $mysqli->query($SQL);
	if (!$result) { echo $mysqli->error; }
	
	$i=0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$responce->rows[$i]['id']=$row['sysno'];
		$responce->rows[$i]['cell']=array($row['sysno'], $row['compcode'], $row['costcode'], $row['description'], $row['adduser'], $row['adddate'], $row['upduser'], $row['upddate'], $row['deluser'], $row['deldate'], $row['recstatus']);
		$i++;
	}
	$result->close();
	
	echo json_encode($responce);
	$mysqli->close();

?>