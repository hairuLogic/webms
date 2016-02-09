<?php
	class EditTableArr{
		
		protected $db;
		
		var $oper=array();
		var $table=array();
		var $column=array();
		var $columnid=array();
		var $filter=array();
		var $sysparam=array();
		var $user;
		var $compcode;
		var $post;
		
		public function __construct(PDO $db,$get,$post)
	    {
			include_once('sschecker.php');
			foreach($get['array'] as $value){
				$this->db = $db;
				//set oper
				array_push($this->oper,$value['oper']);
				//set table name
				array_push($this->table,$value['table_name']);
				//set table id
				array_push($this->columnid,$value['table_id']);
				//set column
				if(isset($value['field']) && !empty($value['field'])){
					array_push($this->column,$this->pushSomeIntoArray($value['field']));
				}else if(isset($value['except']) && !empty($value['except'])){
					array_push($this->column,$this->getAllColumnFromTable($value['table_name'],$value['except']));
				}else{
					array_push($this->column,$this->getAllColumnFromTable($value['table_name'],['sysno']));
				}
				//set filter if any
				if(isset($value['filter']) && !empty($value['filter'])){
					array_push($this->filter,$value['filter']);
				}else{
					array_push($this->filter,array());
				}
				//set sysparam if any
				if(isset($value['sysparam']) && !empty($value['sysparam'])){
					array_push($this->sysparam,$value['sysparam']);
				}else{
					array_push($this->sysparam,array() );
				}
			}
			$this->user = $_SESSION['username'];
			$this->compcode = $_SESSION['company'];
			$this->post = $post;
		}
		
		private function pushSomeIntoArray(array $column){
			$arr=['compcode','adduser','adddate','upduser','upddate','deluser','deldate','recstatus'];
			foreach($arr as $value){
				if(!in_array($value, $column)){
					array_push($column, $value);
				}
			}
			return $column;
		}
		
		private function getAllColumnFromTable($table,array $except){//get all column field
			$SQL = "SHOW COLUMNS FROM {$table}";
			$temp=array();
			$result = $this->db->query($SQL);if (!$result) { print_r($this->db->errorInfo()); }
			
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$key=array_search($row['Field'], $except);
				if($key>-1){
				}else{
					array_push($temp,$row['Field']);
				}
			}
			return $temp;
		}
		
		private function chgDate($date){
			$newstr=explode("-", $date);
			return $newstr[2].'-'.$newstr[1].'-'.$newstr[0];
		}
		
		private function duplicate($code,$table,$codetext){
			$sqlDuplicate="select $code from $table where $code = '$codetext'";
			$result = $this->db->query($sqlDuplicate);if (!$result) { print_r($this->db->errorInfo()); }
			return $result->rowCount();
			
		}
		
		private function arrayValue($column,$noNullValue,array $fixColName,array $fixColValue,$del){
			$temp = array();
			
			if($del){
			
				for($x=0;$x<count($fixColName);$x++){
					if($fixColValue[$x] == 'NOW()')continue;
					array_push($temp,$fixColValue[$x]);
				}
				
			}else{
				
				for($x=0;$x<count($column);$x++){
					$key=array_search($column[$x], $fixColName);
					if($noNullValue && empty($_POST[$column[$x]]) && $key===false)continue;
					
					if($key>-1){
						if($fixColValue[$key] == 'NOW()') continue;
						array_push($temp,$fixColValue[$key]);
					}else if(isset($_POST[$column[$x]])){
						if(isset($_POST[$column[$x]]) && $_POST[$column[$x]] == 'NOW()') continue;
						array_push($temp,$_POST[$column[$x]]);
					}else{
						array_push($temp,NULL);
					}
				}
			
			}
			return $temp;
		}
		
		private function arrayValueFilter(array $filter,array $fixColValue){
			$temp = $fixColValue;
			
			foreach ($filter as $key => $value) {
				if (strpos($value, 'session.') !== false) {
					$pieces = explode(".", $value);
					if(isset($_SESSION[$pieces[1]]))array_push($temp,$_SESSION[$pieces[1]]);
				}else if($value == 'IS NULL'){
					continue;
				}else{
					array_push($temp,$value);
				}
			}
			return $temp;
		}
		
		private function autoSyntaxAdd($table,$column,array $fixColName,array $fixColValue){
			
			$string='INSERT INTO '.$table.' (';
			
			for($x=0;$x<count($column);$x++){
				$string.=$column[$x].',';
			}
			
			$string=rtrim($string,',');
			$string.=') VALUES (';
				
			for($x=0;$x<count($column);$x++){
			
				$key=array_search($column[$x], $fixColName);
				
				//fix cant add NOW()to prepare statement
				if($key>-1 && $fixColValue[$key] == 'NOW()'){
					$string.="NOW(),";
				}else if(isset($_POST[$column[$x]]) && $_POST[$column[$x]] == 'NOW()'){
					$string.="NOW(),";
				}else{
					$string.="?,";
				}
			}
			
			$string=rtrim($string,',');
			$string.=')';
			
			return $string;
		}
		
		private function autoSyntaxUpd($table,$column,$columnid,$noNullValue,array $fixColName,array $fixColValue,array $filter){
			$string='UPDATE '.$table.' SET ';
			
			for($x=0;$x<count($column);$x++){
				$key=array_search($column[$x], $fixColName);
				if($noNullValue && empty($_POST[$column[$x]]) && $key===false)continue;
				
				//fix cant add NOW()to prepare statement
				if($key>-1 && $fixColValue[$key] == 'NOW()'){
					$string.=$fixColName[$key].' = NOW(),';
				}else if(isset($_POST[$column[$x]]) && $_POST[$column[$x]] == 'NOW()'){
					$string.=$column[$x].' = NOW(),';
				}else{
					$string.=$column[$x].' = ?,';
				}
				
			}
			$string=rtrim($string,',');
			$string.=" WHERE ".$columnid." = '".$_POST[$columnid]."'";
			
			if(!empty($filter)){
				$string.=$this->filter(false,$filter);	
			}
			return $string;
		}
		
		private function autoSyntaxDel($table,$columnid,array $fixColName,array $fixColValue,array $filter){
			$string='UPDATE '.$table.' SET ';
			
			for($x=0;$x<count($fixColName);$x++){
				if($fixColValue[$x] == 'NOW()'){
					$string.=$fixColName[$x].' = NOW(),';
				}else{
					$string.=$fixColName[$x].' = ?,';
				}
			}
			$string=rtrim($string,',');
			$string.=" WHERE ".$columnid." = '".$_POST[$columnid]."'";
			
			if(!empty($filter)){
				$string.=$this->filter(false,$filter);	
			}
			return $string;
		}
		
		private function filter($first,array $filter){
			$addSql='';
			
			foreach ($filter as $key => $value) {
				if($value == 'IS NULL'){
					$addSql.="AND {$key} IS NULL ";
				}else{
					$addSql.="AND {$key} = ? ";
				}
			}
			if($first){
				return strstr($addSql,' ');
			}else{
				return $addSql;
			}
		}
		
		private function sysparam($sysparam){
			$sqlSysparam="SELECT pvalue1 FROM sysdb.sysparam WHERE source = '{$sysparam['source']}' AND trantype = '{$sysparam['trantype']}'";
			$result = $this->db->query($sqlSysparam);if (!$result) { print_r($this->db->errorInfo()); }
			$row = $result->fetch(PDO::FETCH_ASSOC);
			
			$pvalue1=intval($row['pvalue1'])+1;
			
			$sqlSysparam="UPDATE sysdb.sysparam SET pvalue1 = '{$pvalue1}' WHERE source = '{$sysparam['source']}' AND trantype = '{$sysparam['trantype']}'";
			
			$this->db->query($sqlSysparam);if (!$result) { print_r($this->db->errorInfo()); }
			
			return $pvalue1;
		}
		
		private function readableSyntax($prepare,array $arrayValue){
			foreach($arrayValue as $val){
				$prepare=preg_replace("/\?/", $val, $prepare,1);
			}
			return $prepare;
		}
		
		public function edit_table(){
			$this->db->beginTransaction();
			$prepare=array();
			$arrayValue=array();
			
			$x=0;
			foreach($this->oper as $value){
			
				if($value=='add'){
				
					$addarrField=['compcode','adduser','adddate','recstatus'];
					$addarrValue=[$this->compcode,$this->user,'NOW()','A'];
					
					if(!empty($this->sysparam[$x])){
						$pvalue1 = $this->sysparam($this->sysparam[$x]);
						array_push($addarrField,$this->sysparam[$x]['useOn']);
						array_push($addarrValue,$pvalue1);
					}
				
					array_push($prepare,$this->autoSyntaxAdd($this->table[$x],$this->column[$x],$addarrField,$addarrValue));
					array_push($arrayValue,$this->arrayValue($this->column[$x],false,$addarrField,$addarrValue,false));
					
				}else if($value=='edit'){
					
					$updarrField=['compcode','upduser','upddate','recstatus'];
					$updarrValue=[$this->compcode,$this->user,'NOW()','D'];
					
					
					array_push($prepare,$this->autoSyntaxUpd($this->table[$x],$this->column[$x],$this->columnid[$x],false,$updarrField,$updarrValue,$this->filter[$x]));
					array_push($arrayValue,$this->arrayValue($this->column[$x],false,$updarrField,$updarrValue,false));
					
					if(!empty($this->filter[$x])){
						array_push($arrayValue,$this->arrayValueFilter($this->filter[$x],$arrayValue[$x]));
					}
					
				}else if($value=='del'){
				
					$delarrField=['compcode','deluser','deldate','recstatus'];
					$delarrValue=[$this->compcode,$this->user,'NOW()','D'];
				
					array_push($prepare,$this->autoSyntaxDel($this->table[$x],$this->columnid[$x],$delarrField,$delarrValue,$this->filter[$x]));
					array_push($arrayValue,$this->arrayValue($this->column[$x],true,$delarrField,$delarrValue,true));
					
					if(!empty($this->filter[$x])){
						array_push($arrayValue,$this->arrayValueFilter($this->filter[$x],$arrayValue[$x]));
					}
				
				}
				$x++;
			}
			
			try{
				$x=0;
				foreach($this->oper as $value){
				
					//echo $this->readableSyntax($prepare[$x],$arrayValue[$x]); 
					//echo $prepare[$x];print_r($arrayValue[$x]);
					
					if($this->columnid[$x]!='sysno' && $value=='add' && $this->duplicate($this->columnid[$x],$this->table[$x],$this->post[$this->columnid[$x]])){
						throw new Exception('Duplicate key');
					}
					
					$sth=$this->db->prepare($prepare[$x]);
					if (!$sth->execute($arrayValue[$x])) {
						throw new Exception('error');
					}
					
					$x++;
				}
					$this->db->commit();
					echo '{"msg":"success"}';
				
			}catch( Exception $e ){
				$this->db->rollback();
				http_response_code(400);
				echo $e->getMessage();
				
			}
		}
	}
	
?>