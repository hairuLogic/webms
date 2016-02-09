<?php
	include_once('../../connection/sschecker.php');
	include_once('../../connection/connect_db.php');
	
	$table='debtor.paymode ';
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	$responce = new stdClass();
	
	 $s=$_GET['source'];
	
	/*if(isset($_GET['Scol']) && $_GET['Stext'] != 'paymode'){
		$SQL = "SELECT * FROM $table
			WHERE source='$s' AND {$_GET['Scol']} 
			LIKE '{$_GET['Stext']}%' 
			ORDER BY paymode ASC";	
	}
	
	else */
	
	if(isset($_GET['Scol']) && $_GET['Stext'] != ''){
		
		$addSql='';
		$searchcol=$_GET['Scol'];
		$searchStext=$_GET['Stext'];
		
		$parts = explode(' ', $searchStext);
		$partsLength  = count($parts);
		while($partsLength>0){
			$partsLength--;
			$addSql.="AND {$_GET['Scol']} like '%{$parts[$partsLength]}%' ";
		}
		
		$SQL = "SELECT * FROM $table 
			WHERE source='$s' AND compcode='$compcode'".$addSql.
			"ORDER BY paymode ASC";
			
			
			
	}
	
	
	
	else{
		$SQL = "SELECT * FROM debtor.paymode WHERE source='$s' ORDER BY paymode ASC";
		
		
	}
	
	$result = $mysqli->query($SQL);
	if (!$result) { echo $mysqli->error; }
	
	$i=0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$responce->rows[$i]['id']=$row['paymode'];
		$responce->rows[$i]['cell']=array($row['paymode'],
		$row['paytype'],
		$row['description'],
		$row['compcode'],
		$row['ccode'], 
		$row['glaccno'],
		$row['source'],
		$row['cardflag'],
		$row['recstatus'],
		$row['valexpdate'],  
	    $row['comrate'], 
		$row['lastupdate'],
		$row['lastuser'], 
		$row['drcommrate'], 
	    $row['drpayment'], 
		$row['cardcent']);
			  
		$i++;
	}
	$result->close();
	
	echo json_encode($responce);
	$mysqli->close();

?>