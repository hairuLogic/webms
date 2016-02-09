<?php
	include_once('../../connection/connect_db.php');
	include_once('../../connection/sschecker.php');
	
	$table='material.suppbonus';
	
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
	
	if($_POST['operBonus']=='add'){
		
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
				(compcode, suppcode, pricecode, lineno_, itemcode, uomcode, purqty, bonpricecode, bonitemcode, bonuomcode, bonqty, bonsitemcode, recstatus, adduser, adddate) 
			VALUES 
				('$compcode','".clr($_POST['suppcode'])."', '".clr($_POST['pricecode'])."', '$lineno_', '".clr($_POST['itemcode'])."', '".clr($_POST['uomcode'])."', '".clr($_POST['purqty'])."', '".clr($_POST['bonpricecode'])."', '".clr($_POST['bonitemcode'])."', '".clr($_POST['bonuomcode'])."', '".clr($_POST['bonqty'])."', '".clr($_POST['bonsitemcode'])."', '".clr($_POST['recstatus'])."', '$user', NOW())";
			
	}else if($_POST['operBonus']=='edit'){
		if($_POST['recstatus']=='D')	{
			$sql="UPDATE {$table} SET
				bonpricecode = '".clr($_POST['bonpricecode'])."',
				bonitemcode = '".clr($_POST['bonitemcode'])."',
				bonuomcode = '".clr($_POST['bonuomcode'])."',
				bonqty = '".clr($_POST['bonqty'])."',
				bonsitemcode = '".clr($_POST['bonsitemcode'])."',
				recstatus = 'D',
				deluser = '$user',
				deldate = NOW()
				WHERE compcode = '$compcode' AND suppcode='".clr($_POST['suppcode'])."'
				AND lineno_='".clr($_POST['lineno_'])."'";
		} else {
			$sql="UPDATE {$table} SET
				bonpricecode = '".clr($_POST['bonpricecode'])."',
				bonitemcode = '".clr($_POST['bonitemcode'])."',
				bonuomcode = '".clr($_POST['bonuomcode'])."',
				bonqty = '".clr($_POST['bonqty'])."',
				bonsitemcode = '".clr($_POST['bonsitemcode'])."',
				recstatus = '".clr($_POST['recstatus'])."',
				upduser = '$user',
				upddate = NOW()
				WHERE compcode = '$compcode' AND suppcode='".clr($_POST['suppcode'])."'
				AND lineno_='".clr($_POST['lineno_'])."'";
		}	
	}else if($_POST['operBonus']=='del'){
		$sql="UPDATE {$table} SET  
		recstatus = 'D',
		deluser = '$user',
		deldate = NOW()
		WHERE compcode = '$compcode' AND suppcode='".clr($_POST['suppcode'])."'
				AND lineno_='{$_POST['id']}'";
				//echo "$sql";
	}
	try{
		
		/*if($_POST['operBonus']=='add' && duplicate('suppcode','itemcode',$table,clr($_POST['suppcode']),clr($_POST['itemcode']))){
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