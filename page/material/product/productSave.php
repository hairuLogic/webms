<?php
	include_once('../../connection/connect_db.php');
	include_once('../../connection/sschecker.php');
	
	$table='material.product';
	
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	
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
	
	if($_POST['reuse']=='Yes'){
		$vReuse='1';	
	}else{
		$vReuse='0';
	}
	
	if($_POST['expdtflg']=='Yes'){
		$vExpdtflg='1';	
	}else{
		$vExpdtflg='0';
	}

	if($_POST['rpkitem']=='Yes'){
		$vRpkitem='1';	
	}else{
		$vRpkitem='0';
	} 
	
	if($_POST['chgflag']=='Yes'){
		$vChgflag='1';	
	}else{
		$vChgflag='0';
	}  
	
	if($_POST['tagging']=='Yes'){
		$vTagging='1';	
	}else{
		$vTagging='0';
	}  
	
	if($_POST['active']=='Yes'){
		$vActive='1';	
	}else{
		$vActive='0';
	} 
	
	if($_POST['oper']=='add'){
		
		$sql="INSERT INTO {$table} 
				(compcode, itemcode, description, generic, groupcode, productcat, subcatcode, uomcode, pouom, itemtype, suppcode, mstore, minqty, maxqty, reordlevel,  reordqty, reuse, expdtflg,  rpkitem, chgflag, tagging, active, adduser, adddate) 
			VALUES 
				('$compcode','".clr($_POST['itemcode'])."','".clr($_POST['description'])."', '".clr($_POST['generic'])."', '".clr($_POST['groupcode'])."', '".clr($_POST['productcat'])."', '".clr($_POST['subcatcode'])."', '".clr($_POST['uomcode'])."', '".clr($_POST['pouom'])."', '".clr($_POST['itemtype'])."', '".clr($_POST['suppcode'])."', '".clr($_POST['mstore'])."', '".clr($_POST['minqty'])."', '".clr($_POST['maxqty'])."', '".clr($_POST['reordlevel'])."', '".clr($_POST['reordqty'])."', '$vReuse',  '$vExpdtflg',  '$vRpkitem',  '$vChgflag',  '$vTagging',  '$vActive', '$user', NOW())";
				//qtyonhand, currprice, avgcost, actavgcost,  bonqty, , costmargin, trqty, deactivedate 
				echo "$sql";
			
	}else if($_POST['oper']=='edit'){
		if($_POST['active']=='0')	{
			$sql="UPDATE {$table} SET
				description = '".clr($_POST['description'])."', 
				generic = '".clr($_POST['generic'])."',
				groupcode = '".clr($_POST['groupcode'])."',
				uomcode = '".clr($_POST['uomcode'])."',
				pouom = '".clr($_POST['pouom'])."',
				itemtype = '".clr($_POST['itemtype'])."',
				suppcode = '".clr($_POST['suppcode'])."',
				mstore = '".clr($_POST['mstore'])."',
				minqty = '".clr($_POST['minqty'])."',
				maxqty = '".clr($_POST['maxqty'])."',
				reordlevel = '".clr($_POST['reordlevel'])."',
				reordqty = '".clr($_POST['reordqty'])."',
				reuse = '$vReuse', 
				expdtflg = '$vExpdtflg',  
				rpkitem = 'vRpkitem', 
				chgflag = '$vChgflag', 
				tagging = '$vTagging', 
				active = '0',
				deluser = '$user',
				deldate = NOW()
				WHERE 
				compcode = '$compcode' AND itemcode='{$_POST['itemcode']}'";
				//echo "$sql";
				/*qtyonhand = '".clr($_POST['qtyonhand'])."',
				currprice = '".clr($_POST['currprice'])."',
				currprice = '".clr($_POST['currprice'])."',*/
		}
		else{
			$sql="UPDATE {$table} SET
				description = '".clr($_POST['description'])."', 
				generic = '".clr($_POST['generic'])."',
				groupcode = '".clr($_POST['groupcode'])."',
				uomcode = '".clr($_POST['uomcode'])."',
				pouom = '".clr($_POST['pouom'])."',
				itemtype = '".clr($_POST['itemtype'])."',
				suppcode = '".clr($_POST['suppcode'])."',
				mstore = '".clr($_POST['mstore'])."',
				minqty = '".clr($_POST['minqty'])."',
				maxqty = '".clr($_POST['maxqty'])."',
				reordlevel = '".clr($_POST['reordlevel'])."',
				reordqty = '".clr($_POST['reordqty'])."',
				reuse = '$vReuse', 
				expdtflg = '$vExpdtflg',  
				rpkitem = 'vRpkitem', 
				chgflag = '$vChgflag', 
				tagging = '$vTagging', 
				active = '$vActive',
				upduser = '$user',
				upddate = NOW()
				WHERE 
				compcode = '$compcode' AND itemcode='{$_POST['itemcode']}'";
				//echo "$sql";
				/*qtyonhand = '".clr($_POST['qtyonhand'])."',
				currprice = '".clr($_POST['currprice'])."',
				currprice = '".clr($_POST['currprice'])."',*/
		}
	}else if($_POST['oper']=='del'){
		$sql="UPDATE {$table} SET  active = '0', deluser= '$user', deldate = NOW()
		 WHERE compcode = '$compcode' AND itemcode='{$_POST['id']}'";
		 echo "$sql";
	}
	
	try{
		
		if($_POST['oper']=='add' && duplicate('itemcode',$table,clr($_POST['itemcode']))){
			throw new Exception('Duplicate key');
		}
		
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