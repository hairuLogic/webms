<?php
	include_once('../../connection/sschecker.php');
	include_once('../../connection/connect_db.php');
	
	$table='material.suppitems';
	$table2='material.product';
	$table3='material.supplier';
	
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	
	$responce = new stdClass();
	
	$suppCode=$_GET['suppcode'];//DATE_FORMAT(si.expirydate, '%d/%m/%Y') as expirydate
	
	$SQL = "SELECT si.suppcode, si.lineno_, si.pricecode, si.itemcode, p.description, si.uomcode, si.unitprice, si.purqty,
si.perdiscount, si.amtdisc, si.amtslstax, si.perslstax, si.expirydate, si.sitemcode, si.adduser, si.adddate, si.upduser,
si.upddate, si.recstatus, si.deluser, si.deldate
FROM material.suppitems si, material.product p, material.supplier s
WHERE si.compcode=p.compcode AND si.compcode = '$compcode' AND si.itemcode=p.itemcode AND si.suppcode=s.SuppCode AND s.SuppCode='$suppCode'
ORDER BY si.lineno_ ASC";
//echo "$SQL";


	
	$result = $mysqli->query($SQL);
	if (!$result) { echo $mysqli->error; }
	
	$i=0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$responce->rows[$i]['id']=$row['lineno_'];
		$responce->rows[$i]['cell']=array($row['suppcode'], $row['lineno_'], $row['itemcode'] , $row['description'], $row['pricecode'], $row['uomcode'], $row['unitprice'], $row['purqty'], $row['perdiscount'], $row['amtdisc'], $row['amtslstax'], $row['perslstax'], $row['expirydate'], $row['sitemcode'], $row['adduser'], $row['adddate'], $row['upduser'], $row['upddate'], $row['recstatus'], $row['deluser'], $row['deldate']);
		$i++;
	}
	$result->close();
	
	echo json_encode($responce);
	$mysqli->close();

?>