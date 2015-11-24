<?php
/**
 * Wrapper for standart Form helper
 * Customizes default HTML inputs
 */
App::uses('FieldTypes', 'Form.Vendor');
App::uses('FormHelper', 'View/Helper');
App::uses('PHFormHelper', 'Form.View/Helper');
class PHFormFieldsHelper extends AppHelper {
	public $helpers = array('Form.PHForm');
	
	private function _inputName($i, $key) {
		return sprintf('data[PMFormValue][%d][%s]', $i, $key);
	}
	
	private function _inputID($i, $key) {
		return 'PMFormValue'.ucfirst($key).'_'.$i;
	}
	
	private function _options($i, $key) {
		return array(
			'id' => $this->_inputID($i, $key), // id must be unique for HTML doc
			'name' => $this->_inputName($i, $key),
		);
	}
	
	public function getSelectOptions($options) {
		$_options = explode(',', str_replace(array("\r\n", "\n", "<br>", "<br/>", "<br />"), ',', $options));
		return array_combine($_options, $_options);
	}
	/*
	private function _inputOptions($field) {
		// fdebug($field);
		$aDefaultOptions = array(
			FieldTypes::STRING => array('class' => 'input-xlarge', 'type' => 'text'),
			FieldTypes::INT => array('class' => 'input-medium', 'type' => 'text'),
			FieldTypes::MULTISELECT => array('options' => $this->getSelectOptions($field['options']), 'multiple' => true),
		);
		$key = ($field['key']) ? $field['key'] : 'value';
		
		$options = array('label' => array('text' => $field['label'], 'class' => 'control-label'));
		if (isset($aDefaultOptions[$field['field_type']])) {
			$options = array_merge($aDefaultOptions[$field['field_type']], $options);
		}
		
		return $options; // array_merge($this->_options($i, $key), $options);
	}
	*/
	private function _renderInput($field, $value, $i) {
		$aDefaultOptions = array(
			FieldTypes::STRING => array('class' => 'input-medium', 'type' => 'text'),
			FieldTypes::INT => array('class' => 'input-medium', 'type' => 'text'),
			FieldTypes::SELECT => array('class' => 'input-medium', 'options' => $this->getSelectOptions($field['options'])),
			FieldTypes::MULTISELECT => array('class' => 'input-medium', 'options' => $this->getSelectOptions($field['options']), 'multiple' => true),
			// FieldTypes::UPLOAD_FILE => array('class' => 'input-medium', 'type' => 'text'),
		);
		$key = ($field['key']) ? $field['key'] : 'value';
		
		if ($field['field_type'] == FieldTypes::MULTISELECT) {
			$value = explode(',', $value);
		}
		
		$options = array_merge(
			$this->_options($i, 'value'),
			array('value' => $value, 'label' => array('text' => $field['label'], 'class' => 'control-label'))
		);
		
		if (isset($aDefaultOptions[$field['field_type']])) {
			$options = array_merge($aDefaultOptions[$field['field_type']], $options);
		}
		return $this->PHForm->input('PMFormValue.value', $options);
	}
	
	public function render($form, $values, $offset = 0) {
		$html = '';
		$_values = array();
		if ($values) {
			$_values = array_combine(
				Hash::extract($values, '{n}.PMFormValue.field_id'), 
				Hash::extract($values, '{n}.PMFormValue.value')
			);
		}
		$_ids = array();
		if ($values) {
			$_ids = array_combine(
				Hash::extract($values, '{n}.PMFormValue.field_id'), 
				Hash::extract($values, '{n}.PMFormValue.id')
			);
		}
		foreach($form as $i => $row) {
			$field = $row['FormField'];
			$value = Hash::get($_values, $field['id']);
			/*
			if ($field['id'] == 6) {
				fdebug($field);
				fdebug(array_merge(
					$this->_options($i, 'value'), $this->_inputOptions($field), array('value' => $value)
				));
			}
			*/
			$html.= $this->_renderInput($field, $value, $i + $offset);
			if (isset($_values[$field['id']])) {
				$html.= $this->PHForm->hidden('PMFormValue.id', array_merge(
					$this->_options($i + $offset, 'id'), array('value' => Hash::get($_ids, $field['id']))
				));
			}
			$html.= $this->PHForm->hidden('PMFormValue.field_id', array_merge(
				$this->_options($i + $offset, 'field_id'), array('value' => $field['id'])
			));
		}
		return $html;
	}
}