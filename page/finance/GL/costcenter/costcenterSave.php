<?php
	include_once('../../connection/connect_db.php');
	include_once('../../connection/sschecker.php');
	
	$table='costcenter';
	
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	
	$recstatus = 'A';
	
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
				(compcode, costcode, description, adduser, adddate, recstatus) 
			VALUES 
				('$compcode','".clr($_POST['costcode'])."', '".clr($_POST['description'])."', '$user', NOW(), '$recstatus')";
				
	}else if($_POST['oper']=='edit'){
		
		$sql="UPDATE {$table} SET
				description = '".clr($_POST['description'])."',
				upduser = '$user',
				upddate = NOW()
				
			WHERE 
				sysno='{$_POST['sysno']}'";
				
	}else if($_POST['oper']=='del'){
		$sql="UPDATE {$table} SET  recstatus = 'D', deluser= '$user', deldate = NOW()
		 WHERE sysno='{$_POST['id']}'";
	}
	
	try{
		
		if($_POST['oper']=='add' && duplicate('costcode',$table,clr($_POST['costcode']))){
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