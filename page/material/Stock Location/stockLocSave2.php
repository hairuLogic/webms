<?php
	include_once('../../connection/sschecker.php');
	include_once('../../connection/connect_db.php');
	
	$table='material.stockloc';
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
	
	if($_POST['oper']=='add'){
		
		$sql="INSERT INTO {$table} 
			(compcode,deptcode,itemcode,uomcode,bincode,rackno,year,openbalqty,openbalval,netmvqty1,netmvval1,
		stocktxntype,disptype,qtyonhand,minqty,maxqty,reordlevel,reordqty,lastissdate,
			frozen,adduser,adddate,cntdocno,fix_uom,locavgcs,lstfrzdt,lstfrztm,frzqty) 
			
			VALUES 
				('9A',   
				'".clr($_POST['deptcode'])."',  
				'".clr($_POST['itemcode'])."',
				'".clr($_POST['uomcode'])."', 
				'".clr($_POST['bincode'])."', 
				'".clr($_POST['rackno'])."', 
				'".clr($_POST['year'])."',
				'".clr($_POST['openbalqty'])."',
				'".clr($_POST['openbalval'])."',
				'".clr($_POST['netmvqty1'])."',
				'".clr($_POST['netmvval1'])."',
				'".clr($_POST['stocktxntype'])."',
				'".clr($_POST['disptype'])."',
				'".clr($_POST['qtyonhand'])."',
				'".clr($_POST['minqty'])."',
				'".clr($_POST['maxqty'])."',
				'".clr($_POST['reordlevel'])."',
				'".clr($_POST['reordqty'])."',
				'".clr($_POST['lastissdate'])."',
				'".clr($_POST['frozen'])."',
				'$user',
				NOW(),
				'".clr($_POST['cntdocno'])."',
				'".clr($_POST['fix_uom'])."',
				'".clr($_POST['locavgcs'])."',
				'".clr($_POST['lstfrzdt'])."',
				'".clr($_POST['lstfrztm'])."',
				'".clr($_POST['frzqty'])."')";
				echo"$sql";
				
	}else if($_POST['oper']=='edit'){
		
		$sql="UPDATE {$table} SET
				
				compcode = '$compcode',	
				deptcode = '".clr($_POST['deptcode'])."',
                itemcode = '".clr($_POST['itemcode'])."',
				uomcode = '".clr($_POST['uomcode'])."',
				bincode = '".clr($_POST['bincode'])."',
				rackno = '".clr($_POST['rackno'])."',
				year = '".clr($_POST['year'])."',
				openbalqty = '".clr($_POST['openbalqty'])."',
				openbalval = '".clr($_POST['openbalval'])."',
				netmvqty1 = '".clr($_POST['netmvqty1'])."',
				netmvval1 = '".clr($_POST['netmvval1'])."',
				stocktxntype = '".clr($_POST['stocktxntype'])."',
				disptype = '".clr($_POST['disptype'])."',
				qtyonhand = '".clr($_POST['qtyonhand'])."',
				minqty = '".clr($_POST['minqty'])."',
				maxqty = '".clr($_POST['maxqty'])."',
				reordlevel = '".clr($_POST['reordlevel'])."',
				reordqty = '".clr($_POST['reordqty'])."',
				lastissdate = '".clr($_POST['lastissdate'])."',
				frozen = '".clr($_POST['frozen'])."',
				adduser = '$user',
				adddate = NOW(),
				cntdocno = '".clr($_POST['cntdocno'])."',
				fix_uom = '".clr($_POST['fix_uom'])."',
				locavgcs = '".clr($_POST['locavgcs'])."',
				lstfrzdt = '".clr($_POST['lstfrzdt'])."',
				lstfrztm = '".clr($_POST['lstfrztm'])."',
				frzqty = '".clr($_POST['frzqty'])."'

			WHERE 
			
				itemcode='{$_POST['itemcode']}'";
				
	}else if($_POST['oper']=='del'){
		$sql="DELETE FROM {$table} WHERE itemcode='{$_POST['id']}'";
		
	}
	
	try{
		
		if($_POST['oper']=='add' && duplicate('itemcode',$table,clr($_POST['itemcode']))){
			throw new Exception('Duplicate key');
		}
		
		if (!$mysqli->query($sql)) {
			throw new Exception($mysqli->error.'</br>'.$sql);
		}
		
		$mysqli->commit();
		
	}catch( Exception $e ){
		http_response_code(400);
		echo $e->getMessage();
		$mysqli->rollback();
		
	}
	
	$mysqli->close();
	
?>