<?php
	include_once('../../connection/connect_db.php');
	include_once('../../connection/sschecker.php');
	
	$table='material.supplier';
	
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
	
	if($_POST['oper']=='add'){
		
		$sql="INSERT INTO {$table} 
				(CompCode, SuppCode, SuppGroup, Name, ContPers ,Addr1,Addr2, Addr3, Addr4, TelNo, Faxno, TermOthers, TermNonDisp, TermDisp, CostCode, GlAccNo,  AccNo, AddUser, AddDate, SuppFlg, recstatus) 
			VALUES 
				('$compcode','".clr($_POST['SuppCode'])."','".clr($_POST['SuppGroup'])."', '".clr($_POST['Name'])."', '".clr($_POST['ContPers'])."', '".clr($_POST['Addr1'])."', '".clr($_POST['Addr2'])."', '".clr($_POST['Addr3'])."', '".clr($_POST['Addr4'])."', '".clr($_POST['TelNo'])."', '".clr($_POST['Faxno'])."', '".clr($_POST['TermOthers'])."', '".clr($_POST['TermNonDisp'])."', '".clr($_POST['TermDisp'])."', '".clr($_POST['CostCode'])."', '".clr($_POST['GlAccNo'])."', '".clr($_POST['AccNo'])."', '$user', NOW(), '".clr($_POST['SuppFlg'])."', '".clr($_POST['recstatus'])."')";
			//	OutAmt,  DepAmt, MiscAmt, Advccode, AdvGlaccnorecstatus
			echo "$sql";
			
	}else if($_POST['oper']=='edit'){
		if($_POST['recstatus']=='D')	{
			$sql="UPDATE {$table} SET
				SuppGroup = '".clr($_POST['SuppGroup'])."', 
				Name = '".clr($_POST['Name'])."',
				ContPers = '".clr($_POST['ContPers'])."',
				Addr1 = '".clr($_POST['Addr1'])."',
				Addr2 = '".clr($_POST['Addr2'])."',
				Addr3 = '".clr($_POST['Addr3'])."',
				Addr1 = '".clr($_POST['Addr1'])."',
				Addr4 = '".clr($_POST['Addr4'])."',
				TelNo = '".clr($_POST['TelNo'])."',
				Faxno = '".clr($_POST['Faxno'])."',
				TermOthers = '".clr($_POST['TermOthers'])."',
				TermNonDisp = '".clr($_POST['TermNonDisp'])."',
				TermDisp = '".clr($_POST['TermDisp'])."',
				CostCode = '".clr($_POST['CostCode'])."',
				GlAccNo = '".clr($_POST['GlAccNo'])."',
				AccNo = '".clr($_POST['AccNo'])."',
				recstatus ='D',
				DelUser = '$user',
				DelDate = NOW()
				WHERE 
				compcode = '$compcode' AND SuppCode='{$_POST['SuppCode']}'";
		}else {
			$sql="UPDATE {$table} SET
				SuppGroup = '".clr($_POST['SuppGroup'])."', 
				Name = '".clr($_POST['Name'])."',
				ContPers = '".clr($_POST['ContPers'])."',
				Addr1 = '".clr($_POST['Addr1'])."',
				Addr2 = '".clr($_POST['Addr2'])."',
				Addr3 = '".clr($_POST['Addr3'])."',
				Addr1 = '".clr($_POST['Addr1'])."',
				Addr4 = '".clr($_POST['Addr4'])."',
				TelNo = '".clr($_POST['TelNo'])."',
				Faxno = '".clr($_POST['Faxno'])."',
				TermOthers = '".clr($_POST['TermOthers'])."',
				TermNonDisp = '".clr($_POST['TermNonDisp'])."',
				TermDisp = '".clr($_POST['TermDisp'])."',
				CostCode = '".clr($_POST['CostCode'])."',
				GlAccNo = '".clr($_POST['GlAccNo'])."',
				AccNo = '".clr($_POST['AccNo'])."',
				recstatus = '".clr($_POST['recstatus'])."',
				UpdUser = '$user',
				UpdDate = NOW()
				WHERE 
				compcode = '$compcode' AND SuppCode='{$_POST['SuppCode']}'";
		}
		//echo "$sql";
	}else if($_POST['oper']=='del'){
		$sql="UPDATE {$table} SET  recstatus = 'D', DelUser= '$user', DelDate = NOW()
		 WHERE compcode = '$compcode' AND SuppCode='{$_POST['id']}'";
	}
	
	try{
		
		if($_POST['oper']=='add' && duplicate('SuppCode',$table,clr($_POST['SuppCode']))){
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