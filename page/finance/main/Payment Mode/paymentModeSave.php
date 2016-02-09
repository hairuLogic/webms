<?php
	include_once('../../connection/sschecker.php');
	include_once('../../connection/connect_db.php');
	$table='debtor.paymode';
	
	$user=$_SESSION['username'];
	$compcode=$_SESSION['company'];
	$recstatus = '1';
	
	$s=$_REQUEST['source'];
	
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
	
	/*if($_POST['cardflag']=='Yes'){
		$vcardflag='1';	
	}else{
		$vcardflag='0';
	}
	
	
	if($_POST['recstatus']=='Yes'){
		$vrecstatus='1';	
	}else{
		$vrecstatus='0';
	}
	
	if($_POST['drpayment']=='Yes'){
		$vdrpayment='1';	
	}else{
		$vdrpayment='0';
	}
	
	if($_POST['valexpdate']=='Yes'){
		$vvalexpdate='1';	
	}else{
		$vvalexpdate='0';
	}
*/	
	if($_POST['oper']=='add'){
		
		$sql="INSERT INTO {$table} 
	           (compcode,source,paymode,description,ccode,glaccno,paytype,cardflag,recstatus,valexpdate,
			   lastuser,drpayment) 
			   
			VALUES 
				( '$compcode',
				'$s', 
				'".clr($_POST['paymode'])."', 
				'".clr($_POST['description'])."',
				'".clr($_POST['ccode'])."',
				'".clr($_POST['glaccno'])."', 
				'".clr($_POST['paytype'])."', 
				'".clr($_POST['cardflag'])."', 
				'".clr($_POST['recstatus'])."', 
				'".clr($_POST['valexpdate'])."',
				'".clr($_POST['lastuser'])."',
				'".clr($_POST['drpayment'])."'
				)";
				//'".clr($_POST['comrate'])."',
				//'".clr($_POST['lastupdate'])."',
				//'".clr($_POST['drcommrate'])."',
				//'".clr($_POST['cardcent'])."'
	}else if($_POST['oper']=='edit'){
		
		$sql="UPDATE {$table} SET
				
				description = '".clr($_POST['description'])."',
				ccode = '".clr($_POST['ccode'])."',
				glaccno = '".clr($_POST['glaccno'])."',
				paytype = '".clr($_POST['paytype'])."',
				cardflag = '".clr($_POST['cardflag'])."',
				recstatus = '".clr($_POST['recstatus'])."',
				valexpdate = '".clr($_POST['valexpdate'])."',
				lastupdate = '$user',
				drcommrate = '".clr($_POST['drcommrate'])."',	
				drpayment = '".clr($_POST['drpayment'])."',
				cardcent = '".clr($_POST['cardcent'])."'
						
			WHERE 
				paymode='{$_POST['paymode']}'";
				
	}else if($_POST['oper']=='del'){
		$sql="DELETE FROM {$table} WHERE paymode='{$_POST['id']}'";
		
	}
	
	try{
		
		if($_POST['oper']=='add' && duplicate('paymode',$table,clr($_POST['paymode']))){
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