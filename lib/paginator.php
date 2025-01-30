<?php
	class Paginator{
		
		var $base_url			= ''; // The page we are linking to
		var $total_rows			=  0; // Total number of items (database results)
		var $per_page			= 10; // Max number of items you want shown per page	
		var $cur_page			=  0;
		
		public function __construct($params = array()){
			if(count($params)>0){
				$this->init($params);
			}	
		}
		public function init($params = array()){
			if(count($params)>0){
				foreach($params as $key => $val){
					if(isset($this->$key)){
						$this->$key = $val;
					}
				}
			}
			return $this->total_rows;
			
		}

		public function createLinks() {
			
			$end = ceil( $this->total_rows / $this->per_page );
		 
			$start = 1;
			$html = "<nav aria-label='Page navigation'>";
			$html .= "<ul class='pagination'>";
		 
			$class = ( $this->cur_page == 1 ) ? "disabled" : "";
			
			$html  .= "<li><a aria-label='Previous' class = '" . $class . "' href='".$this->base_url . "&currentPage=".($this->cur_page - 1). "'><span aria-hidden='true'>&laquo;</span></a></li>";
		 
			for ( $i = $start ; $i <= $end; $i++ ) {
				$class  = ( $this->cur_page == $i ) ? "active" : "";
				$html  .= "<li><a class = '" .$class. "' href='".$this->base_url."&currentPage=" . $i . "'>".$i."</a></li>";
			}
		 
			$class = ( $this->cur_page == $end ) ? "disabled" : "";
			
			$html  .= "<li><a aria-label='Next' class = '" .$class. "' href='".$this->base_url."&currentPage=" . ($this->cur_page + 1). "'><span aria-hidden='true'>&raquo;</span></a></li>";	
		 
			$html       .= "</ul>";
			$html .= "</nav>";
			return $html;
		}			
	}
?>