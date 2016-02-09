<?php
	class TableModel{
		
		protected $db;
		
		var $scol;
		var $stext='';
		
		var $filter;
		var $responce;
		var $table;
		var $column;
		var $columnid;
		var $compcode;

	    public function __construct(PDO $db,$get)
	    {	
			include_once('sschecker.php');
			if (empty($except)){
				$except = [''];
			}
			
			$this->responce = new stdClass();
	        $this->db = $db; // connection
			$this->table = $get['table_name'];
			if(!empty($get['filter'])){
				$this->filter=$get['filter'];;
			}
			if(empty($get['table_id'])){
				$this->columnid = 'adddate';//error if table doesn't have adddate
			}else{
				$this->columnid = $get['table_id'];
			}
			$this->compcode=$_SESSION['company'];
			
			if(isset($get['Scol']) && !empty($get['Stext'])){
				$this->scol=$get['Scol']; // search column if any
				$this->stext=$get['Stext']; // search text if any
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
		
		private function cellArray($row){
			$temp=array();
			for($x=0;$x<count($this->column);$x++){
				array_push($temp,$row[$this->column[$x]]);
			}
			return $temp;
		}
		
		private function indexWord(){
			$addSql='';
			$parts = explode(' ', $this->stext);
			$partsLength  = count($parts);
			while($partsLength>0){
				$partsLength--;
				$addSql.=" AND {$this->scol} like '%{$this->stext}%' ";
			}
			return $addSql;
		}
		
		public function filter(){
			$addSql='';
			if(!isset($this->filter) || empty($this->filter)){
				return $addSql;
			}else{
				foreach ($this->filter as $key => $value) {
					$addSql.=" AND {$key} = '{$value}'";
				}
				return $addSql;
			}
		}
			
		public function get_table(){
			
			if(isset($this->scol) && $this->stext != ''){
				
				$SQL = "SELECT * FROM {$this->table} 
					WHERE compcode='{$this->compcode}'".$this->indexWord().$this->filter();
			}else{
			
				$SQL = "SELECT * FROM {$this->table} 
				WHERE compcode='{$this->compcode}'".$this->filter();
			}
			
			//echo $SQL;
			$result = $this->db->query($SQL);
			if (!$result) { print_r($this->db->errorInfo()); }

			$i=0;
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$this->responce->rows[$i]['id']=$row[$this->columnid];
				$this->responce->rows[$i]['cell']=$this->cellArray($row);
				$i++;
			}
			return json_encode($this->responce);
		}

	}
?>