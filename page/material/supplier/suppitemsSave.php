<?php
	include_once('../../connection/connect_db.php');
	include_once('../../connection/sschecker.php');
	
	$table='material.suppitems';
	
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	
	//$recstatus = 'A';
	
	function clr($str){
		global $mysqli;
		return $mysqli->real_escape_string($str);
	}
	
	function duplicate($code,$table,$codetext){
		global $mysqli;
		$sqlDuplicate="select $code from $table where $code = '$codetext'";
		$resultDuplicate=$mysqli->query($sqlDuplicate);
		return $resultDuplicate->num_rows;
	}
	
	$mysqli->autocommit(FALSE);  
	
	
	
	if($_POST['operItem']=='add'){
		
		$suppcode = $_REQUEST['suppcode'];

   $sqlln = "SELECT COUNT(lineno_) as COUNT from $table 
		WHERE suppcode = '$suppcode' AND compcode='$compcode'";
		
		$result = $mysqli->query($sqlln);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$lineno_=$row['COUNT'];
		
		if ($lineno_ == "0") {
				$lineno_ = 1;
            } else {
                $lineno_++;
            }
		
		$sql="INSERT INTO {$table} 
				(compcode, suppcode, lineno_, pricecode, itemcode , uomcode, purqty, unitprice, perdiscount, amtdisc, amtslstax, perslstax, expirydate, sitemcode, recstatus, adduser, adddate) 
			VALUES 
				('$compcode','".clr($_POST['suppcode'])."','$lineno_', '".clr($_POST['pricecode'])."', '".clr($_POST['itemcode'])."', '".clr($_POST['uomcode'])."', '".clr($_POST['purqty'])."', '".clr($_POST['unitprice'])."', '".clr($_POST['perdiscount'])."', '".clr($_POST['amtdisc'])."', '".clr($_POST['amtslstax'])."', '".clr($_POST['perslstax'])."', '".clr($_POST['expirydate'])."', '".clr($_POST['sitemcode'])."', '".clr($_POST['recstatus'])."', '$user', NOW())";
			
	}else if($_POST['operItem']=='edit'){
		if($_POST['recstatus']=='D')	{
			$sql="UPDATE {$table} SET
				pricecode = '".clr($_POST['pricecode'])."',
				itemcode = '".clr($_POST['itemcode'])."',
				uomcode = '".clr($_POST['uomcode'])."',
				purqty = '".clr($_POST['purqty'])."',
				unitprice = '".clr($_POST['unitprice'])."',
				perdiscount = '".clr($_POST['perdiscount'])."',
				amtdisc = '".clr($_POST['amtdisc'])."',
				perslstax = '".clr($_POST['perslstax'])."',
				amtslstax = '".clr($_POST['amtslstax'])."',
				expirydate = '".clr($_POST['expirydate'])."',
				sitemcode = '".clr($_POST['sitemcode'])."',
				recstatus = 'D',
				deluser = '$user',
				deldate = NOW()
				WHERE compcode = '$compcode' AND suppcode='".clr($_POST['suppcode'])."'
				AND lineno_='".clr($_POST['lineno_'])."'";
				echo "$sql";
		}else{
			$sql="UPDATE {$table} SET
				pricecode = '".clr($_POST['pricecode'])."',
				itemcode = '".clr($_POST['itemcode'])."',
				uomcode = '".clr($_POST['uomcode'])."',
				purqty = '".clr($_POST['purqty'])."',
				unitprice = '".clr($_POST['unitprice'])."',
				perdiscount = '".clr($_POST['perdiscount'])."',
				amtdisc = '".clr($_POST['amtdisc'])."',
				perslstax = '".clr($_POST['perslstax'])."',
				amtslstax = '".clr($_POST['amtslstax'])."',
				expirydate = '".clr($_POST['expirydate'])."',
				sitemcode = '".clr($_POST['sitemcode'])."',
				recstatus = '".clr($_POST['recstatus'])."',
				upduser = '$user',
				upddate = NOW()
				WHERE compcode = '$compcode' AND suppcode='".clr($_POST['suppcode'])."'
				AND lineno_='".clr($_POST['lineno_'])."'";
		}	
	}else if($_POST['operItem']=='del'){
		$sql="UPDATE {$table} SET  
				recstatus = 'D',
				deluser = '$user',
				deldate = NOW()
				WHERE compcode = '$compcode' AND suppcode='".clr($_POST['suppcode'])."'
				AND lineno_='{$_POST['id']}'";
				//echo "$sql";
	}
	try{
		
		/*if($_POST['operItem']=='add' && duplicate('suppcode','itemcode',$table,clr($_POST['suppcode']),clr($_POST['itemcode']))){
			throw new Exception('Duplicate key');
		}*/
		
		if (!$mysqli->query($sql)) {
			throw new Exception($sql);
		}
		
		$mysqli->commit(); 
		
	}catch( Exception $e ){
		http_response_code(400);
		echo $e->getMessage();
		$mysqli->rollback(); 
	}
	
	$mysqli->close();
	
?>