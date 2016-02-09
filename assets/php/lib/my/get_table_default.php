<?php
	class TableModel{
		
		protected $db;
		
		var $page;
		var $limit;
		var $sidx; //order by
		var $sord; //sort, asc desc
		var $searchCol;
		var $searchVal;
		//var $scol;
		//var $stext='';
		var $total_pages;
		var $counts;
		var $start;
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
			$this->page = $get['page']; // paging number
			$this->limit = $get['rows']; // get how many rows we want to have into the grid
			$this->sidx = $get['sidx']; // get index row - i.e. user click to sort
			$this->sord = $get['sord']; // get the direction
			$this->table = $get['table_name'];

			if(!empty($get['filter'])){
				$this->filter=$get['filter'];
			}

			if(!empty($get['searchCol'])){
				$this->searchCol=$get['searchCol'];
				$this->searchVal=$get['searchVal'];
			}

			if(empty($get['table_id'])){
				$this->columnid = 'adddate';//error if table doesn't have adddate
			}else{
				$this->columnid = $get['table_id'];
			}
			$this->compcode=$_SESSION['company'];

			if(isset($get['field']) && !empty($get['field'])){
				$this->column=$get['field'];
			}else if(isset($get['except']) && !empty($get['except'])){
				$this->column=$this->getAllColumnFromTable($get['except']);
			}else{
				$this->column=$this->getAllColumnFromTable(['']);
			}

		}
		
		private function getPagerInfo(){
		
			if(!$this->sidx) $this->sidx = $this->columnid;
			
			$prepare = $this->autoPrepStmt(!empty($this->searchCol),!empty($this->filter),true);
			$arrayValue = (!empty($this->searchCol)) ? $this->arrayValueSearch([$this->compcode]) : [$this->compcode];
			$arrayValue = (!empty($this->filter)) ? $this->arrayValueFilter($arrayValue) : $arrayValue;


			//echo $prepare; print_r($arrayValue);

			$sth=$this->db->prepare($prepare);
			if(!$sth->execute($arrayValue)){
				throw new Exception('error');
			}
			$row = $sth->fetch(PDO::FETCH_ASSOC);
			$this->counts = $row['count'];
			
			if( $this->counts >0 ) {
				$this->total_pages = ceil($this->counts/$this->limit);
			} else {
				$this->total_pages = 0;
			}
			
			if ($this->page > $this->total_pages && $this->counts>0 ) {$this->page=$this->total_pages;}
			$this->start = $this->limit*$this->page - $this->limit;
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

		private function arrayValueSearch(array $fixColValue){
			$search=$this->searchVal;$temp = $fixColValue;
			
			foreach ($search as $value) {
				array_push($temp,$value);
			}
			return $temp;
		}

		private function search($first){
			$addSql='';
			if(!isset($this->searchCol) || empty($this->searchCol)){
				return $addSql;
			}else{
				$search=$this->searchCol;
				foreach($search as $value){
					$addSql.="AND {$value} LIKE ? ";
				}
				if($first){
					return strstr($addSql,' ');
				}else{
					return $addSql;
				}
			}
		}

		private function autoPrepStmt($needSearch,$needFilter,$countOnly){
			$column=$this->column;
			
			$string='SELECT ';

			if ($countOnly) {
				 $string.="COUNT(*) AS count";
			}else{
				for($x=0;$x<count($column);$x++){
					$string.=$column[$x].',';
				}
				$string=rtrim($string,',');
			}
			
			
			$string.=" FROM ";

			if(is_array($this->table)){
				$string.=implode(",", $this->table)." WHERE {$this->table[0]}.compcode=? ";;
			}else{
				$string.= $this->table." WHERE compcode=? ";
			}
			
			if($needSearch){
				$string.=$this->search(false);	
			}

			if($needFilter){
				$string.=$this->filter(false);	
			}
			if(!$countOnly){
				$string.= " ORDER BY {$this->sidx} {$this->sord} LIMIT {$this->start},{$this->limit}";
			}
			
			return $string;
		}
			
		public function get_table(){
			
			$this->getPagerInfo();

			$prepare = $this->autoPrepStmt(!empty($this->searchCol),!empty($this->filter),false);
			$arrayValue = (!empty($this->searchCol)) ? $this->arrayValueSearch([$this->compcode]) : [$this->compcode];
			$arrayValue = (!empty($this->filter)) ? $this->arrayValueFilter($arrayValue) : $arrayValue;
			//echo $prepare; print_r($arrayValue);


			$sth=$this->db->prepare($prepare);
			if(!$sth->execute($arrayValue)){
				throw new Exception('error');
			}


			$this->responce->page = $this->page;
			$this->responce->total = $this->total_pages;
			$this->responce->records = $this->counts;
			$i=0;
			
			while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$this->responce->rows[$i]['id']=$row[$this->columnid];
				$this->responce->rows[$i]['cell']=$this->cellArray($row);
				$i++;
			}
			return json_encode($this->responce);
		}

	}
?>