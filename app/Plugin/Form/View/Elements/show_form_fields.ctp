<?
/**
 * Requires:
 * @param $form - array of data for a from with fields
 */

App::uses('FieldTypes', 'Form.Vendor');

$aDefaultOptions = array(
	// FieldTypes::STRING => array('class' => 'input-large'),
	FieldTypes::INT => array('class' => 'input-medium')
);
foreach($form as $i => $row) {
	$field = $row['FormField'];
	$key = ($field['key']) ? $field['key'] : 'key_'.$field['id'];
	$options = array(
		'label' => array('text' => $field['label'], 'class' => 'control-label'),
		'name' => sprintf('data[FormField][%d][%s]', $i, $key)
	);
	if (isset($aDefaultOptions[$field['field_type']])) {
		$options = array_merge($options, $aDefaultOptions[$field['field_type']]);
	}
	echo $this->PHForm->input('FormField.'.$key, $options);
}
?>
