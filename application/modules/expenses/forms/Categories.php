<?php
 

class Expenses_Form_Categories extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('action',BASE_URL.'expenses/expensecategories/edit');
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'Categories');


        $id = new Zend_Form_Element_Hidden('id');
		
		$expense_category_name = new Zend_Form_Element_Text('expense_category_name');
        $expense_category_name ->setAttrib('maxLength', 20);
        
       $expense_category_name ->addFilter(new Zend_Filter_StringTrim());
	   $expense_category_name->setRequired(true);
       $expense_category_name ->addValidator('NotEmpty', false, array('messages' => 'Please enter Category Name.'));  
        
	   $expense_category_name ->addValidator("regex",true,array(
                           'pattern'=>'/^([a-zA-Z0-9_@.]+ ?)+$/', 
        
                           'messages'=>array(
                               'regexNotMatch'=>'Enter valid Category Name.'
                           )
        	));	

		$expense_category_name->addValidator(new Zend_Validate_Db_NoRecordExists(
                                                        array('table' => 'expense_categories',
                                                        'field' => 'expense_category_name',
                                                        'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('id',0).'" and isactive=1',
                                                        )));
        $expense_category_name->getValidator('Db_NoRecordExists')->setMessage('Category already  exist.');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save');
		
		$this->addElements(array($id,$expense_category_name,$submit));
		
		
        $this->setElementDecorators(array('ViewHelper')); 
	}
}
?>