<?php
	include_once('../../connection/sschecker.php');
	include_once('../../connection/connect_db.php');
	
	$table='material.suppbonus';
	$table2='material.product';
	$table3='material.suppitems';
	
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	
	$responce = new stdClass();
	
	$suppCode=$_GET['suppcode'];
	$itemcode = $_GET['itemcode'];
	
	/*$SQL = "SELECT sb.lineno_, sb.bonitemcode, p.description, sb.bonuomcode, sb.bonqty, si.itemcode FROM $table sb, $table2 p, $table3 si
	WHERE sb.suppcode=p.suppcode AND sb.suppcode='$suppCode' AND sb.itemcode=si.itemcode  AND sb.itemcode=p.itemcode 
	AND sb.compcode='$compcode' AND p.compcode='$compcode' AND si.compcode='$compcode'
	ORDER BY sb.lineno_ ASC";*/
	
/*	$SQL = "SELECT sb.compcode, sb.suppcode, sb.pricecode, sb.lineno_, sb.uomcode, sb.purqty,
			sb.bonpricecode, sb.bonitemcode,   p.description, sb.bonuomcode, sb.bonqty, sb.bonsitemcode, sb.itemcode, 
			sb.adduser, sb.adddate, sb.upduser, sb.upddate
			FROM material.suppbonus sb, material.product p
			WHERE  sb.compcode=p.compcode AND sb.compcode='$compcode' 
			AND sb.itemcode=p.itemcode AND sb.suppcode='$suppCode' AND sb.itemcode='$itemcode'";*/
			//AND sb.itemcode='as' AND sb.suppcode='d'
			//echo"$SQL";
			
/*	$SQL = "SELECT si.compcode, si.suppcode, si.pricecode, sb.lineno_, si.uomcode, si.purqty,
			sb.bonpricecode, sb.bonitemcode,   p.description, sb.bonuomcode, sb.bonqty, sb.bonsitemcode, sb.itemcode, 
			sb.adduser, sb.adddate, sb.upduser, sb.upddate
			FROM material.suppbonus sb, material.product p, material.suppitems si
			WHERE  sb.compcode=p.compcode AND si.compcode=sb.compcode AND si.compcode='$compcode' 
			AND sb.itemcode=p.itemcode AND si.itemcode=sb.itemcode AND si.itemcode='$itemcode'  
			AND si.suppcode=sb.suppcode AND si.suppcode='$suppCode' ";*/
			
	$SQL = "SELECT sb.compcode, sb.suppcode, sb.pricecode, sb.lineno_, sb.uomcode, sb.purqty, 
			sb.bonpricecode, sb.bonitemcode,p.description, sb.bonuomcode, sb.bonqty, 
			sb.bonsitemcode, sb.itemcode, sb.adduser, sb.adddate, sb.upduser, sb.upddate, sb.recstatus 
			FROM material.suppbonus sb, material.product p, material.suppitems si 
			WHERE sb.compcode=p.compcode AND si.compcode=sb.compcode AND si.compcode='$compcode' 
			AND sb.bonitemcode=p.itemcode  
			AND si.itemcode=sb.itemcode AND si.itemcode='$itemcode' 
			AND si.suppcode=sb.suppcode AND si.suppcode='$suppCode'
			ORDER BY sb.lineno_ ASC";
	
	$result = $mysqli->query($SQL);
	if (!$result) { echo $mysqli->error; }
	
	$i=0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$responce->rows[$i]['id']=$row['itemcode'];
		$responce->rows[$i]['cell']=array($row['compcode'], $row['suppcode'], $row['pricecode'], $row['lineno_'], $row['uomcode'], $row['purqty'], $row['bonpricecode'], $row['bonitemcode'], $row['description'], $row['bonuomcode'], $row['bonqty'], $row['bonsitemcode'], $row['itemcode'], $row['adduser'], $row['adddate'], $row['upduser'], $row['upddate'], $row['recstatus']);
		$i++;
	}
	$result->close();
	
	echo json_encode($responce);
	$mysqli->close();

?>