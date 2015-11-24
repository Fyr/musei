<?
App::uses('AppModel', 'Model');
class FormField extends AppModel {
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
        
	public function beforeDelete($cascade = true) {
		App::uses('PMFormValue', 'Form.Model');
		$this->PMFormValue = new PMFormValue();
		$this->PMFormValue->deleteAll(array('PMFormValue.field_id' => $this->id));
		
		App::uses('PMFormKey', 'Form.Model');
		$this->PMFormKey = new PMFormKey();
		$this->PMFormKey->deleteAll(array('PMFormKey.field_id' => $this->id));
		return true;
	}
	
	public function packFormulaOptions($data) {
		extract($data);
		return serialize(compact('formula', 'decimals', 'div_float', 'div_int'));
	}
	
	public function unpackFormulaOptions($options) {
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
}
