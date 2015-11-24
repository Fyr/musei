<?
App::uses('AppModel', 'Model');
class PMFormKey extends AppModel {
	public $useTable = 'form_keys';
	
	public $belongsTo = array(
		'FormField' => array(
			'foreignKey' => 'field_id'
		)
	);
}
