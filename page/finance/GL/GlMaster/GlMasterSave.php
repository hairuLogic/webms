<?php
	include_once('../../connection/connect_db.php');
	include_once('../../connection/sschecker.php');
	
	$table='glmasref';
	
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
				(compcode,glaccount,description,accgroup, recstatus, adduser,adddate) 
			VALUES 
				('$compcode', '".clr($_POST['glaccount'])."', '".clr($_POST['description'])."', '".clr($_POST['accgroup'])."', '".clr($_POST['recstatus'])."', '$user', NOW())";
				//(compcode,glaccount,description,acttype,repgroup,accgroup, recstatus, adduser,adddate, nprefid) 
				
	}else if($_POST['oper']=='edit'){
		if($_POST['recstatus']=='D')	{
			$sql="UPDATE {$table} SET
					description = '".clr($_POST['description'])."',
					recstatus = 'D',
					accgroup = '".clr($_POST['accgroup'])."',
					deluser= '$user', 
					deldate = NOW()
				WHERE 
					sysno='{$_POST['sysno']}'";
		}
		else{
			$sql="UPDATE {$table} SET
					description = '".clr($_POST['description'])."', 
					recstatus = '".clr($_POST['recstatus'])."',
					accgroup = '".clr($_POST['accgroup'])."',
					upduser = '$user',
					upddate = NOW()
				WHERE 
					sysno='{$_POST['sysno']}'";
			//echo"$sql";
		}
				
	}else if($_POST['oper']=='del'){
		$sql="UPDATE {$table} SET  recstatus = 'D', deluser= '$user', deldate = NOW()
		 WHERE sysno='{$_POST['id']}'";
	}
	
	try{
		
		if($_POST['oper']=='add' && duplicate('glaccount',$table,clr($_POST['glaccount']))){
			throw new Exception('Duplicate key');
		}
		//if($_POST['oper']=='add' && duplicate('compcode',$table,'$compcode') && duplicate('glaccount',$table,clr($_POST['glaccount']))){
		
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