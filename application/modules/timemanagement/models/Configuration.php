<?php
 
/**
 *
 * @model Configuration Model
 * @author sagarsoft
 *
 */
class Timemanagement_Model_Configuration extends Zend_Db_Table_Abstract
{
    protected $_name = 'tm_configuration';
    protected $_primary = 'id';
	
	public function getActiveRecord()
	{
	   $select = $this->select()
						->setIntegrityCheck(false)
						->from(array('c'=>$this->_name),array('c.*'))
					    ->where('c.is_active = 1');
		return $this->fetchAll($select)->toArray();
	
	}
	
	public function SaveorUpdateConfigurationData($data, $where)
	{	
	    if($where != ''){
		    $this->update($data, $where);
			return 'update';
		} else {
			$this->insert($data);
			$id=$this->getAdapter()->lastInsertId($this->_name);
			return $id;
		}
	}	
	
}