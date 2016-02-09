<?php
	include_once('../connection/sschecker.php');
	include_once('../connection/connect_db.php');
	$table=$_GET['table'];
	$compcode=$_SESSION['company'];
	$colsArray=explode(",", $_GET['cols']);
	$responce = new stdClass();
	
	if(isset($_GET['Dcol']) && $_GET['Dtext'] != ''){
		$addSql='';
		$searchcol=$_GET['Dcol'];
		$searchStext=$_GET['Dtext'];
		
		$parts = explode(' ', $searchStext);
		$partsLength  = count($parts);
		while($partsLength>0){
			$partsLength--;
			$addSql.=" AND {$_GET['Dcol']} like '%{$parts[$partsLength]}%'";
		}
		$SQL = "SELECT {$_GET['cols']} FROM $table 
			WHERE compcode='$compcode' AND mainstore ='1' AND recstatus='A'".$addSql.
			"ORDER BY sysno DESC";
			
	}else{
		$SQL = "SELECT {$_GET['cols']} FROM $table  WHERE compcode='$compcode' AND mainstore ='1' AND recstatus='A' ORDER BY sysno DESC";
	}
	
	$result = $mysqli->query($SQL);
	if (!$result) { echo $mysqli->error; }
	
	$i=0;
	while($row = $result->fetch_array(MYSQLI_BOTH)) {
		$responce->rows[$i]['id']=$row[0];
		$temp=array();
		foreach ($colsArray as $col){
			array_push($temp,$row[$col]);
		}
		$responce->rows[$i]['cell']=$temp;
		$i++;
	}
	$result->close();
	
	echo json_encode($responce);
	$mysqli->close();

	
	
?>