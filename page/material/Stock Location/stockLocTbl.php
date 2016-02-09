<?php
    include_once('../../connection/sschecker.php');
	include_once('../../connection/connect_db.php');
	
	$table='material.stockloc';
	$itemcode=$_GET['itemcode'];
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	$responce = new stdClass();
	
	
	if(isset($_GET['Scol']) && $_GET['Stext'] == 'itemcode'){
		$SQL = "SELECT * FROM $table 
			WHERE {$_GET['Scol']} 
			LIKE '%{$_GET['Stext']}%' 
			ORDER BY itemcode ASC";
			
			}
	
	else if(isset($_GET['Scol']) && $_GET['Stext'] != ''){
		
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
			WHERE compcode='$compcode' and itemcode='$itemcode' ".$addSql. 
			"ORDER BY itemcode ASC";
			}
	
	else{
	
		$SQL = "SELECT * FROM $table where itemcode = '$itemcode' ORDER BY itemcode ASC";
	}
	
	$result = $mysqli->query($SQL);
	if (!$result) { echo $mysqli->error; }
	
	$i=0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$responce->rows[$i]['id']=$row['itemcode'];
		$responce->rows[$i]['cell']=array($row['compcode'],
		$row['deptcode'],
		$row['itemcode'], 
		$row['uomcode'],
		$row['bincode'], 
		$row['rackno'], 
		$row['year'],
		$row['openbalqty'],
		$row['openbalval'],
		$row['netmvqty1'],
		$row['netmvval1'], 
		$row['stocktxntype'], 
		$row['disptype'],
		$row['qtyonhand'], 
		$row['minqty'],
		$row['maxqty'],
		$row['reordlevel'],
		$row['reordqty'],
		$row['lastissdate'],
		$row['frozen'],
		$row['adduser'],
		$row['adddate'],
		$row['upduser'],
		$row['upddate'],
		$row['cntdocno'],
		$row['fix_uom'],
		$row['locavgcs'],
		$row['lstfrzdt'],
		$row['lstfrztm'],
		$row['frzqty']);
		$i++;
	}
	$result->close();
	
	echo json_encode($responce);
	$mysqli->close();

?>