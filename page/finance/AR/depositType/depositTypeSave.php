<?php
	include_once('../../connection/connect_db.php');
	include_once('../../connection/sschecker.php');
	
	$table='debtor.hdrtypmst';
	
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	
	$recstatus = 'A';
	$source = 'PB';
	
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
	
	if($_POST['updpayername']=='Yes'){
		$vUpdpayername='1';	
	}else{
		$vUpdpayername='0';
	}
	
	if($_POST['updepisode']=='Yes'){
		$vUpdepisode='1';	
	}else{
		$vUpdepisode='0';
	}

	if($_POST['manualalloc']=='Yes'){
		$vManualalloc='1';	
	}else{
		$vManualalloc='0';
	}
	
	$mysqli->autocommit(FALSE);  
	
	if($_POST['oper']=='add'){
		
		$sql="INSERT INTO {$table} 
				(compcode,source,trantype,description,updpayername,updepisode,depccode, depglacc, manualalloc, recstatus, adduser, adddate) 
			VALUES 
				('$compcode','$source','".clr($_POST['trantype'])."', '".clr($_POST['description'])."', '$vUpdpayername', '$vUpdepisode', '".clr($_POST['depccode'])."', '".clr($_POST['depglacc'])."', '$vManualalloc', '".clr($_POST['recstatus'])."', '$user', NOW())";
				
	}else if($_POST['oper']=='edit'){
		if($_POST['recstatus']=='D')	{
			$sql="UPDATE {$table} SET 
				description = '".clr($_POST['description'])."',
				updpayername = '$vUpdpayername',
				updepisode = '$vUpdepisode',
				depccode = '".clr($_POST['depccode'])."',
				depglacc = '".clr($_POST['depglacc'])."',
				manualalloc = '$vManualalloc',
				deluser = '$user',
				deldate = NOW(),
				recstatus = 'D'
			WHERE 
				sysno='{$_POST['sysno']}'";
		}else{
			$sql="UPDATE {$table} SET 
				description = '".clr($_POST['description'])."',
				updpayername = '$vUpdpayername',
				updepisode = '$vUpdepisode',
				depccode = '".clr($_POST['depccode'])."',
				depglacc = '".clr($_POST['depglacc'])."',
				manualalloc = '$vManualalloc',
				upduser = '$user',
				upddate = NOW(),
				recstatus = '".clr($_POST['recstatus'])."'
			WHERE 
				sysno='{$_POST['sysno']}'";
		}
			
	}else if($_POST['oper']=='del'){
		$sql="UPDATE {$table} SET  recstatus = 'D', deluser= '$user', deldate = NOW()
		 WHERE sysno='{$_POST['id']}'";
		
	}
	
	try{
		
		if($_POST['oper']=='add' && duplicate('trantype',$table,clr($_POST['trantype']))){
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