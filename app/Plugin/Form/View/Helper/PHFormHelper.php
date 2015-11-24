<?php
/**
 * Wrapper for standart Form helper
 * Customizes default HTML inputs
 */
App::uses('FormHelper', 'View/Helper');
class PHFormHelper extends FormHelper {
	// var $helpers = array('Form', 'Html');
	public function create($model, $options = array()) {
		$options['class'] = (isset($options['class']) && $options['class']) ? $options['class'] : 'form-horizontal';
		$options['inputDefaults'] = (isset($options['inputDefaults']) && $options['inputDefaults']) ? $options['inputDefaults'] : array(
			'div' => 'control-group',
			'label' => array('class' => 'control-label'),
			'between' => '<div class="controls">',
			'after' => '</div>'
		);
		
		// Fix validation errors translation
		foreach($this->validationErrors as $_model => $fields) {
			if (is_array($fields)) {
				foreach($fields as $field => $messages) {
					foreach($messages as $i => $msg) {
						$this->validationErrors[$_model][$field][$i] = __($msg);
					}
				}
			}
		}
		return parent::create($model, $options);
	}

	public function input($fieldName, $options = array()) {
		$this->setEntity($fieldName);
		$options = $this->_parseOptions($options);
		if ($options['type'] == 'checkbox') {
			$options['format'] = array('before', 'label', 'between', 'input', 'after', 'error');
		} elseif ($options['type'] == 'text' || $options['type'] == 'textarea') {
			$options = array_merge(array('class' => 'input-xxlarge'), $options);
		}
		return parent::input($fieldName, $options);
	}

	public function submit($fieldName = 'Save', $options = array()) {
		$options = array_merge(array('class' => 'btn btn-primary', 'type' => 'submit', 'div' => 'form-actions'), $options);
		return $this->button($fieldName, $options);
	}
	
	public function button($fieldName, $options = array()) {
	    $options = array_merge(array('class' => 'btn', 'type' => 'button'), $options);
		return parent::button($fieldName, $options);
	}
	
	public function formActions(array $buttons) {
	    $html = '<div class="form-actions">';
	    $html.= implode(' ', $buttons);
        $html.= '</div>';
        echo $html;
	}

	/**
	 * Create a input with CKEditor
	 *
	 * @param string $name - field name
	 * @param array $options - input options
	 * @return string
	 */
	public function editor($fieldName, $options = array()) {
        $this->Html->script('vendor/ckeditor/ckeditor', array('inline' => false));
        $this->Html->css('/js/vendor/ckeditor/fixes', array('inline' => false));
        $options = array_merge(array('class' => 'ckeditor'), $options); // 
        // $options['class'] = 'ckeditor '.$options['class'];
        
        if (isset($options['fullwidth']) && $options['fullwidth']) {
            return '<div class="control-group"><div class="clearfix"></div><div class="shadow text-center">'.$this->textarea($fieldName, $options).'</div></div>';
        }
        
        return parent::input($fieldName, $options);
    }
}