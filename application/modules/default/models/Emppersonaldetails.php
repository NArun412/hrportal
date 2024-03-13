<?php
 

class Default_Model_Emppersonaldetails extends Zend_Db_Table_Abstract
{
	protected $_name = 'main_emppersonaldetails';
    protected $_primary = 'id';
	
	public function getsingleEmpPerDetailsData($id)
	{
		$select = $this->select()
						->setIntegrityCheck(false)
						->from(array('ep'=>'main_emppersonaldetails'),array('ep.*'))
						->where('ep.user_id='.$id.' AND ep.isactive = 1');
					
		return $this->fetchAll($select)->toArray();
	}
	
	public function SaveorUpdateEmpPersonalData($data, $where)
	{
	    if($where != ''){
			$this->update($data, $where);
			return 'update';
		} else {
			$this->insert($data);
			$id=$this->getAdapter()->lastInsertId('main_emppersonaldetails');
			return $id;
		}
		
	}
	
	
}
?>