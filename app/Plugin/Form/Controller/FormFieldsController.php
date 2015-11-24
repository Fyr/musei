<?php
App::uses('AdminController', 'Controller');
class FormFieldsController extends AdminController {
    public $name = 'FormFields';
    public $components = array('Table.PCtableGrid');
    public $uses = array('Form.FormField');
    
    public function index() {
        $this->paginate = array(
        	'fields' => array('label', 'field_type', 'required')
        );
        $this->PCTableGrid->paginate('FormField');
    }
}
