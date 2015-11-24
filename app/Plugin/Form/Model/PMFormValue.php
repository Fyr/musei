<?
App::uses('AppModel', 'Model');
App::uses('FormField', 'Form.Model');
class PMFormValue extends AppModel {
	public $useTable = 'form_values';

	public $belongsTo = array(
		'FormField' => array(
			'foreignKey' => 'field_id'
		)
	);
	
	public function getValues($object_type, $object_id = '') {
		return $this->getObjectList($object_type, $object_id);
	}
	
	public function saveForm($object_type, $object_id = '', $form_id, $data = array()) {
		foreach($data as $_data) {
			$this->clear();
			if (is_array($_data['value'])) {
				$_data['value'] = implode(',', $_data['value']);
			}
			$this->save(array_merge($_data, compact('object_type', 'object_id', 'form_id')));
		}
	}
}
