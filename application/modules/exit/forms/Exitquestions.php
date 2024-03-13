<?php
 

class Exit_Form_Exitquestions extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'exitquestions');


        $id = new Zend_Form_Element_Hidden('id');
		
		$exittypes = new Zend_Form_Element_Select('exit_type_id');
		$exittypes->setLabel("Exit Type");
        $exittypes->setAttrib('class', 'selectoption');
        $exittypes->addMultiOption('','Select exit type');
        $exittypes->setRegisterInArrayValidator(false);
        $exittypes->setRequired(true);
		$exittypes->addValidator('NotEmpty', false, array('messages' => 'Please select exit type.'));
		
		$postid = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		if($postid !='')
		{
			$question = new Zend_Form_Element_Text("question");
			$question->setLabel('Question');
			$question->setAttrib('maxLength', 100);
			$question->addFilter(new Zend_Filter_StringTrim());
			$question->setRequired(true);
	        $question->addValidator('NotEmpty', false, array('messages' => 'Please enter question.'));
			$question->addValidator("regex",true,array(                           
	                           'pattern'=>'/^[a-zA-Z0-9.\- ?\',\/#@$&*()!]+$/',
	                           'messages'=>array(
	                               'regexNotMatch'=>'Please enter valid question.'
	                           )
	        	));
	       
			$description = new Zend_Form_Element_Textarea('description');
			$description->setLabel("Description");
	        $description->setAttrib('rows', 10);
	        $description->setAttrib('cols', 50);
			$description ->setAttrib('maxlength', '200');
		}

        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save'); 
		
		$submitadd = new Zend_Form_Element_Button('submitbutton');
		$submitadd->setAttrib('id', 'submitbuttons');
		$submitadd->setAttrib('onclick', 'validatequestiononsubmit(this)');
		$submitadd->setLabel('Save');
		
		if($postid !='')
			 $this->addElements(array($id,$exittypes,$question,$description,$submit));
	    else		 
		 	$this->addElements(array($id,$exittypes,$submitadd));
         $this->setElementDecorators(array('ViewHelper')); 
	}
}