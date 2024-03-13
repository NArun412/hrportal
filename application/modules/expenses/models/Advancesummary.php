<?php
 

class Expenses_Model_Advancesummary extends Zend_Db_Table_Abstract
{
	/**
	 * The advance table name
	 */
    protected $_name = 'expense_advacne_summary';
    protected $_primary = 'id';
	
	
	public function SaveAdvanceData($data, $where)
	{
			//$where = "isactive = 1";
			
		
		if($where != ''){
			$this->update($data, $where);
			return 'update';
		} else {
			
			//echo "here";exit;
			$this->insert($data);
			//$id=$this->getAdapter()->lastInsertId($this->_name);
			//echo $id;exit;
			 return 1;
		}
	}
	
	/**
	 * This method is used to fetch advance summary of employ  based on employ id.
	 * 
	 * @param number $id
	 */
	public function getAdvanceDetailsById($emp_id)
	{
		$select = $this->select()
						->setIntegrityCheck(false)
						->from(array('c'=>$this->_name),array('c.*'))						
						->where('c.isactive = 1 AND c.employee_id='.$emp_id.' ');
						
		return $this->fetchAll($select)->toArray();
	}
	
}