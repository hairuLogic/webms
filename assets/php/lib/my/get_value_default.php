<?php
	class ValModel{
		
		protected $db;
		
		var $responce;
		var $table;
		var $column;
		var $filter;
		var $compcode;

	    public function __construct(PDO $db,$get)
	    {	
			include_once('sschecker.php');
			//set return value object holder
			$this->responce = new stdClass();
			$this->responce->rows = array();
			//set connection
	        $this->db = $db;
			//set table
			$this->table = $get['table_name'];
			//set filter
			if(!empty($get['filter'])){
				$this->filter=$get['filter'];;
			}
			//set compcode
			$this->compcode=$_SESSION['company'];
			//set column
			if (empty($except)){
				$except = [''];
			}
			if(isset($get['field']) && !empty($get['field'])){
				$this->column=$get['field'];
			}else if(isset($get['except']) && !empty($get['except'])){
				$this->column=$this->getAllColumnFromTable($get['except']);
			}else{
				$this->column=$this->getAllColumnFromTable(['']);
			}

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
		
		private function autoPrepStmt($needFilter){
			$column=$this->column;
			
			$string='SELECT ';
			
			for($x=0;$x<count($column);$x++){
				$string.=$column[$x].',';
			}
			$string=rtrim($string,',');
			
			$string.=" FROM ".$this->table." WHERE compcode=? ";
			
			if($needFilter){
				$string.=$this->filter(false);	
			}
			
			return $string;
		}
		
		private function arrayValueFilter(array $fixColValue){
			$filter=$this->filter;$temp = $fixColValue;
			
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
		
		private function filter($first){
			$addSql='';
			if(!isset($this->filter) || empty($this->filter)){
				return $addSql;
			}else{
				foreach ($this->filter as $key => $value) {
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
		}
			
		public function get_value(){
			try{
				
				$prepare = $this->autoPrepStmt(!empty($this->filter));
				$arrayValue = $this->arrayValueFilter([$this->compcode]);
				
				echo $prepare; print_r($arrayValue);
				
				$sth=$this->db->prepare($prepare);
				if(!$sth->execute($arrayValue)){
					throw new Exception('error');
				}else{
					$i=0;
					while($row = $sth->fetch(PDO::FETCH_OBJ)) {
						$this->responce->rows[$i]=$row;
						$i++;
					}
					return json_encode($this->responce);
				}
				
			}catch( Exception $e ){
				http_response_code(400);
				echo $e->getMessage();
				
			}
		}

	}
?>