<?php
class AppModel extends Model{
	function toggleBoolean($field, $id){
		$data=$this->read(null,$id);
		if(empty($data)) return false;
		if($data[$this->name][$field]) $toNext=0;
		else $toNext=1;
		return $this->updateAll(array("{$this->name}.$field"=>$toNext),array("{$this->name}.id"=>$id));
	}	
}
?>