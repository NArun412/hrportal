<?php
 

class Expenses_Form_Returnadvance extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		
		$this->setAttrib('action',BASE_URL.'expenses/advances/addreturnpopup');
		
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'Advance');


        $id = new Zend_Form_Element_Hidden('id');
		
        $employeess = new Zend_Form_Element_Select('to_id');
        $employeess->setLabel('Employee');	
		$employeess->setRequired(true);
		$employeess->setAttrib('onchange', 'getProjects()');
		$usersModel = new Expenses_Model_Advances();
		
		//$usersData = $usersModel->fetchAll('isactive=1','userfullname');
		$usersData = $usersModel->getAdvanceUserList();
		
		
	    $employeess->addMultiOption('','Select Employee');
			foreach ($usersData as $data){
					$employeess->addMultiOption($data['from_id'],utf8_encode($data['userfullname']));
			}
		$employeess->setRegisterInArrayValidator(false);
        $employeess->addValidator('NotEmpty', false, array('messages' => 'Please select employee.')); 
		
		
		
		$currency = new Zend_Form_Element_Select('currency_id');
		//$currency->addMultiOption('','Select Currency');
		$currency->setLabel("Amount");
		$currency->setAttrib('onchange', 'getCurrencyAdvances();');
		$currency->setRegisterInArrayValidator(false);	
        $currency->setRequired(true);
        $currency->addValidator('NotEmpty', false, array('messages' => 'Please select currency.'));
         
		$currency->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_currency',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$currency->getValidator('Db_RecordExists')->setMessage('Selected currency is inactivated.');
		
        $amount = new Zend_Form_Element_Text('amount');
        $amount->setAttrib('maxLength', 180);
        $amount->setLabel("Advance amount");
		$amount->setRequired(true);
        $amount->addFilter(new Zend_Filter_StringTrim());
		$amount->addValidator('NotEmpty', false, array('messages' => 'Please enter amount.'));
          $amount->addValidator("regex",true,array(
						 'pattern'=>'/^[0-9]*\.?[0-9]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Please enter only numbers.'
                           )
        	));
		
			
		$payment_mode = new Zend_Form_Element_Select('payment_mode_id');
		$payment_mode ->addMultiOption('','Select payment');
		$payment_mode ->setRegisterInArrayValidator(false);	
        $payment_mode ->setRequired(true);
        $payment_mode ->addValidator('NotEmpty', false, array('messages' => 'Please select payment mode.'));
		
		$paymentref = new Zend_Form_Element_Text('payment_ref_number');
		$paymentref->setLabel("Payment Ref#");
        $paymentref ->setAttrib('maxLength', 20);
        $paymentref ->addFilter(new Zend_Filter_StringTrim());
		$paymentref->setRequired(false);
		//$paymentref->addValidator('NotEmpty', false, array('messages' => 'Please enter Payment Ref.'));
	   			
		$description = new Zend_Form_Element_Textarea('description');
        $description->setAttrib('rows', 10);
        $description->setAttrib('cols', 50);
		$description ->setAttrib('maxlength', '500');
	
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('onclick', 'getAmount()');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save');
		
		$this->addElements(array($id,$employeess,$currency,$amount,$payment_mode,$paymentref,$description,$submit));
		
		
        $this->setElementDecorators(array('ViewHelper')); 
	}
}
?>