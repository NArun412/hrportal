<?php
 
/**
 * 
 * Create or Edit Clients Form.
 * @author Sagarsoft
 *
 */
class Expenses_Form_Trips extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('action',BASE_URL.'expenses/trips/edit');
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'addOrEditTrips');


        $id = new Zend_Form_Element_Hidden('id');
        
        $tripname = new Zend_Form_Element_Text('trip_name');
        $tripname->setLabel("Trip");
        $tripname->setAttrib('maxLength', 50);
        $tripname->addFilter(new Zend_Filter_StringTrim());
        $tripname->setRequired(TRUE);
        $tripname->addValidator('NotEmpty', false, array('messages' => 'Please enter trip name.'));  
		$tripname->addValidator("regex",true,array(                           
                           'pattern'=>'/^(?![0-9]*$)[a-zA-Z0-9.,&\(\)\/\-_\' ?]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Please enter a valid client name.'
                           )
        			));

    		
		$fromdate = new ZendX_JQuery_Form_Element_DatePicker('from_date');
		$fromdate->setOptions(array('class' => 'brdr_none'));
		$fromdate->setLabel("From date");
		$fromdate->setAttrib('readonly', 'true');
		$fromdate->setAttrib('onfocus', 'this.blur()');
		
		$todate = new ZendX_JQuery_Form_Element_DatePicker('to_date');
		$todate->setOptions(array('class' => 'brdr_none'));
		$todate->setLabel("To date");
		$todate->setAttrib('readonly', 'true');
		$todate->setAttrib('onfocus', 'this.blur()');
				

		
        $description = new Zend_Form_Element_Textarea('description');
        $description->setAttrib('maxLength', 180);
        $description->setLabel("Description");
        $description->addFilter(new Zend_Filter_StringTrim());
        			
       		
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save');
		


		$this->addElements(array($id,$tripname,$fromdate,$todate,$description,$submit));
        $this->setElementDecorators(array('ViewHelper')); 
		 $this->setElementDecorators(array(
                    'UiWidgetElement',
        ),array('from_date','to_date')); 
         
	}
	
}