<?php
 

class Default_Model_Disciplinaryviolation extends Zend_Db_Table_Abstract
{
    protected $_name = 'main_disciplinary_violation_types';
    protected $_primary = 'id';
	
	public function getDisciplinaryViolationTypesData($sort, $by, $pageNo, $perPage,$searchQuery)
	{
		$where = "sd.isactive = 1";
		if($searchQuery)
			$where .= " AND ".$searchQuery;
		$db = Zend_Db_Table::getDefaultAdapter();		
		
		$disciplinaryViolationTypesData = $this->select()
    					   ->setIntegrityCheck(false)	
                           ->from(array('sd'=>'main_disciplinary_violation_types'),array('sd.*'))
                           ->where($where)
    					   ->order("$by $sort") 
    					   ->limitPage($pageNo, $perPage);
		
        
		return $disciplinaryViolationTypesData;       		
	}
	
	public function getGrid($sort,$by,$perPage,$pageNo,$searchData,$call,$dashboardcall,$a='',$b='',$c='',$d='')
	{		
        $searchQuery = '';
        $searchArray = array();
        $data = array();
		
		if($searchData != '' && $searchData!='undefined')
			{
				$searchValues = json_decode($searchData);
				foreach($searchValues as $key => $val)
				{
							$searchQuery .= " ".$key." like '%".$val."%' AND ";
                           $searchArray[$key] = $val;
				}
				$searchQuery = rtrim($searchQuery," AND");					
			}
			
		$objName = 'disciplinaryviolation';
		
		$tableFields = array('action'=>'Action','violationname' => 'Violation Type','description' => 'Description');
		
		$tablecontent = $this->getDisciplinaryViolationTypesData($sort, $by, $pageNo, $perPage,$searchQuery);     
		
		$dataTmp = array(
			'sort' => $sort,
			'by' => $by,
			'pageNo' => $pageNo,
			'perPage' => $perPage,				
			'tablecontent' => $tablecontent,
			'objectname' => $objName,
			'extra' => array(),
			'tableheader' => $tableFields,
			'jsGridFnName' => 'getAjaxgridData',
			'jsFillFnName' => '',
			'searchArray' => $searchArray,
			'add' =>'add',
			'call'=>$call,
			'dashboardcall'=>$dashboardcall,
		);
		return $dataTmp;
	}
	
	public function getDisciplinaryViolationTypeDatabyID($id)
	{
	    $select = $this->select()
						->setIntegrityCheck(false)
						->from(array('sd'=>'main_disciplinary_violation_types'),array('sd.*'))
					    ->where('sd.isactive = 1 AND sd.id='.$id.' ');
					   
		return $this->fetchAll($select)->toArray();
	
	}
public function getallDisciplinaryViolationTypesData()
	{
	    $select = $this->select()
						->setIntegrityCheck(false)
						->from(array('sd'=>'main_disciplinary_violation_types'),array('sd.*'))
					    ->where('sd.isactive = 1');
		return $this->fetchAll($select)->toArray();
	
	}
	
	public function SaveorUpdateDisciplinaryViolationTypesData($data, $where)
	{
	    if($where != ''){
	    	$this->update($data, $where);
			return 'update';
		} else {
			$this->insert($data);
			$id=$this->getAdapter()->lastInsertId('main_disciplinary_violation_types');
			return $id;
		}
		
	
	}
	public function getDisciplinaryIncidentCount($id)
	{
		
		$where = 'mdi.isactive=1'; 
		$where.= ' AND mdi.violation_id ='.$id.' ';
			$db = Zend_Db_Table::getDefaultAdapter();
		$qry = "select count(*) as count from main_disciplinary_incident mdi where ".$where." ";
		$res = $db->query($qry)->fetchAll();	
		return $res;	
	}

}