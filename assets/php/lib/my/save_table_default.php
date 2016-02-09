<?php
	class EditTable{
		
		protected $db;
		
		var $oper;
		var $table;
		var $column;
		var $columnid;
		var $user;
		var $compcode;
		var $post;
		var $filter = array();
		var $sysparam;
		
		public function __construct(PDO $db,$get,$post){
			include_once('sschecker.php');
			//set operation
			$this->oper = $get['oper'];
	        //set connection
			$this->db = $db;
			//set table
			$this->table = $get['table_name'];
			//set tableid
			$this->columnid = $get['table_id'];
			//set column
			if(isset($get['field']) && !empty($get['field'])){
				$this->column=$this->pushSomeIntoArray($value['field']);
			}else if(isset($get['except']) && !empty($get['except'])){
				$this->column=$this->getAllColumnFromTable($get['except']);
			}else{
				$this->column=$this->getAllColumnFromTable(['']);
			}
			//set sysparam if any
			if(isset($get['sysparam']) && !empty($get['sysparam']))$this->sysparam = $get['sysparam'];
			//set filter if any
			if(isset($get['filter']) && !empty($get['filter']))$this->filter = $get['filter'];
			//set others
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
		
		private function getAllColumnFromTable(array $except){//get all column field
			$SQL = "SHOW COLUMNS FROM {$this->table}";
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
		
		private function readableSyntax($prepare,array $arrayValue){
			foreach($arrayValue as $val){
				$prepare=preg_replace("/\?/", $val, $prepare,1);
			}
			return $prepare;
		}
		
		private function arrayValue($noNullValue,array $fixColName,array $fixColValue,$del){
			$column=$this->column;$temp = array();
			
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
		
		private function autoSyntaxAdd(array $fixColName,array $fixColValue){
			$column=$this->column;$table=$this->table;
			
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
		
		private function autoSyntaxUpd($noNullValue,array $fixColName,array $fixColValue,array $filter){
			$column=$this->column;
			
			$string='UPDATE '.$this->table.' SET ';
			
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
			$string.=" WHERE ".$this->columnid." = '".$_POST[$this->columnid]."'";
			
			if(!empty($filter)){
				$string.=$this->filter(false,$filter);	
			}
			return $string;
		}
		
		private function autoSyntaxDel(array $fixColName,array $fixColValue,array $filter){
			$string='UPDATE '.$this->table.' SET ';
			
			for($x=0;$x<count($fixColName);$x++){
				if($fixColValue[$x] == 'NOW()'){
					$string.=$fixColName[$x].' = NOW(),';
				}else{
					$string.=$fixColName[$x].' = ?,';
				}
			}
			$string=rtrim($string,',');
			$string.=" WHERE ".$this->columnid." = '".$_POST[$this->columnid]."'";
			
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
		
		private function sysparam(){
			$sysparam = $this->sysparam;
			
			$sqlSysparam="SELECT pvalue1 FROM sysdb.sysparam WHERE source = '{$sysparam['source']}' AND trantype = '{$sysparam['trantype']}'";
			$result = $this->db->query($sqlSysparam);if (!$result) { print_r($this->db->errorInfo()); }
			$row = $result->fetch(PDO::FETCH_ASSOC);
			
			$pvalue1=intval($row['pvalue1'])+1;
			
			$sqlSysparam="UPDATE sysdb.sysparam SET pvalue1 = '{$pvalue1}' WHERE source = '{$sysparam['source']}' AND trantype = '{$sysparam['trantype']}'";
			
			$this->db->query($sqlSysparam);if (!$result) { print_r($this->db->errorInfo()); }
			
			return $pvalue1;
		}
		
		public function edit_table(){
			$this->db->beginTransaction();
			
			
			if($this->oper=='add'){
			
				$addarrField=['compcode','adduser','adddate','recstatus'];
				$addarrValue=[$this->compcode,$this->user,'NOW()','A'];
				
				if(!empty($this->sysparam)){
					$pvalue1 = $this->sysparam();
					array_push($addarrField,$this->sysparam['useOn']);
					array_push($addarrValue,$pvalue1);
				}
			
				$prepare=$this->autoSyntaxAdd($addarrField,$addarrValue);
				$arrayValue=$this->arrayValue(false,$addarrField,$addarrValue,false);
				
			}else if($this->oper=='edit'){
			
				$updarrField=['compcode','upduser','upddate','recstatus'];
				$updarrValue=[$this->compcode,$this->user,'NOW()','A'];
				
				$prepare=$this->autoSyntaxUpd(false,$updarrField,$updarrValue,$this->filter);
				$arrayValue=$this->arrayValue(false,$updarrField,$updarrValue,false);
				if(!empty($this->filter)){
					$arrayValue=$this->arrayValueFilter($this->filter,$arrayValue);
				}
				
			}else if($this->oper=='del'){
			
				$delarrField=['compcode','deluser','deldate','recstatus'];
				$delarrValue=[$this->compcode,$this->user,'NOW()','D'];
			
				$prepare=$this->autoSyntaxDel($delarrField,$delarrValue,$this->filter);
				$arrayValue=$this->arrayValue(true,$delarrField,$delarrValue,true);
				if(!empty($this->filter)){
					$arrayValue=$this->arrayValueFilter($this->filter,$arrayValue);
				}
				
			}
			echo $prepare;print_r($arrayValue);
			
			try{
				
				if($this->columnid!='sysno' && $this->oper=='add' && $this->duplicate($this->columnid,$this->table,$this->post[$this->columnid])){
					throw new Exception('Duplicate key');
				}
				
				$sth=$this->db->prepare($prepare);
				if (!$sth->execute($arrayValue)) {
					throw new Exception($prepare);
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