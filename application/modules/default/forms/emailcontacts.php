<?php
 

class Default_Form_emailcontacts extends Zend_Form
{ 
	public function init()
	{
                    $this->setMethod('post');		
                    $this->setAttrib('id', 'formid');
                    $this->setAttrib('name','emailcontacts');
                    $this->setAttrib('action',BASE_URL.'emailcontacts/add/');
		
                    $id = new Zend_Form_Element_Hidden('id');
       
        $group_id = new Zend_Form_Element_Select("group_id");
        $group_id->setRegisterInArrayValidator(false);
        $group_id->setRequired(true);
        $group_id->addValidator('NotEmpty', false, array('messages' => 'Please select group.')); 
        
        $business_unit_id = new Zend_Form_Element_Select("business_unit_id");
        $business_unit_id->setRegisterInArrayValidator(false);
        $business_unit_id->setRequired(true);
        $business_unit_id->addValidator('NotEmpty', false, array('messages' => 'Please select business unit.')); 
        $business_unit_id->setAttrib('onchange', "bunit_emailcontacts('business_unit_id');");
         
          //Group Email....
         $grpEmail = new Zend_Form_Element_Text('groupEmail');
         $grpEmail->addFilters(array('StringTrim', 'StripTags'));
         $grpEmail->setRequired(true);
         $grpEmail->addValidator('NotEmpty', false, array('messages' => 'Please enter group email.')); 
        
         $grpEmail->addValidator("regex",true,array(
                           
						    'pattern'=>'/^(?!.*\.{2})[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',                            
                           'messages'=>array(
                               'regexNotMatch'=>'Please enter valid email.'
                           )
        	));
        	
         $grpEmail->addValidator(new Zend_Validate_Db_NoRecordExists(
                                            array(  'table'=>'main_emailcontacts',
                                                       'field'=>'groupEmail',
                                                      'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('id').'" and isactive = 1',    
                                                    

                                                      ) )  
);
          $grpEmail->getValidator('Db_NoRecordExists')->setMessage('Group email already exists.');
     
        // Form Submit ......... 
        $submit = new Zend_Form_Element_Submit('submit');
         $submit->setAttrib('id', 'submitbutton');
        $submit->setLabel('Save');

         $this->addElements(array($id,$group_id,$grpEmail,$submit,$business_unit_id));
        $this->setElementDecorators(array('ViewHelper')); 
		
        }
}
?>