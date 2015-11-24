<?
App::uses('AppModel', 'Model');
App::uses('FieldTypes', 'Form.Vendor');
class PMFormField extends AppModel {
	public $useTable = 'form_fields';
	
	public $validate = array(
		'key' => array(
			'rule' => '/^[A-Z]+[0-9]+$/',
			'allowEmpty' => true,
			'message' => 'Неверный формат ключа. Пример: A1, B1, AA1, BB1'
		),
		'sort_order' => array(
			'rule' => '/^[0-9]+$/',
			'allowEmpty' => false,
			'message' => 'Введите сортировку'
		)
	);
	
	protected $PMFormData;
	
	public function afterFind($results, $primary = false) {
		foreach($results as &$_row) {
			if (is_array($_row) && isset($_row[$this->alias])) {
				$row = $_row[$this->alias];
				if (isset($row['field_type']) && $row['field_type'] == FieldTypes::FORMULA) {
					if (isset($row['options']) && $row['options']) {
						$_row[$this->alias] = array_merge($_row[$this->alias], $this->unpackFormulaOptions($row['options']));
					}
				}
			}
		}
		return $results;
	}

	public function beforeSave($options = array()) {
		// Set default values for formula
		if (!$fOptions = Hash::get($this->data, 'PMFormField.decimals')) {
			$this->data['PMFormField']['decimals'] = 2;
		}
		if (!$fOptions = Hash::get($this->data, 'PMFormField.div_float')) {
			$this->data['PMFormField']['div_float'] = ',';
		}
		if (!$fOptions = Hash::get($this->data, 'PMFormField.div_int')) {
			$this->data['PMFormField']['div_int'] = ' ';
		}
		if ($fOptions = Hash::get($this->data, 'PMFormField.formula')) {
			$this->data['PMFormField']['options'] = $this->packFormulaOptions($this->data['PMFormField']);
		}
		return true;
	}
	
	public function afterSave($created, $options = array()) {
		$this->loadModel('Form.PMFormData');
		$sql_field = sprintf(FieldTypes::getSqlTypes($this->data['PMFormField']['field_type']), $this->id);
		$created = $created || (isset($options['forceCreate']) && $options['forceCreate']);
		$sql = 'ALTER TABLE '.$this->PMFormData->getTableName().(($created) ? ' ADD ' : ' MODIFY ').$sql_field;
		fdebug($sql."\r\n", 'form_field.log');
		$this->query($sql);
	}
	
	public function beforeDelete($cascade = true) {
		App::uses('PMFormValue', 'Form.Model');
		$this->PMFormValue = new PMFormValue();
		$this->PMFormValue->deleteAll(array('PMFormValue.field_id' => $this->id));
		
		App::uses('PMFormKey', 'Form.Model');
		$this->PMFormKey = new PMFormKey();
		$this->PMFormKey->deleteAll(array('PMFormKey.field_id' => $this->id));
		return true;
	}
	
	private function packFormulaOptions($data) {
		extract($data);
		return serialize(compact('formula', 'decimals', 'div_float', 'div_int'));
	}
	
	private function unpackFormulaOptions($options) {
		return ($options) ? unserialize($options) : array();
	}
	
	public function calcFormula($options, $aData) {
		$formula = $this->unpackFormulaOptions($options);
    	extract($aData);
    	$_res = 0;
    	eval('$_res = '.$formula['formula'].';');
    	return $this->formatFormula($_res, $formula);
    }
    
	public function formatFormula($_res, $formula) {
    	return ($_res) ? number_format($_res, $formula['decimals'], $formula['div_float'], $formula['div_int']) : '';
    }
    
    public function getFieldsList($object_type, $object_id) {
    	$aFields = $this->getObjectList($object_type, $object_id, 'PMFormField.sort_order');
    	return Hash::combine($aFields, '{n}.PMFormField.id', '{n}');
    }
}
