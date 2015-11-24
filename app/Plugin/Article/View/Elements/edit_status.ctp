<?
	echo $this->PHForm->input('status', array('label' => false, 'multiple' => 'checkbox', 'options' => array('published' => __('Published'), 'featured' => __('Featured')), 'class' => 'checkbox inline'));
