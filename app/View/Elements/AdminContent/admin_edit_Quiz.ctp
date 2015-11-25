<?
	echo $this->PHForm->input('status', array('label' => false, 'multiple' => 'checkbox', 'options' => array('published' => __('Published', true)), 'class' => 'checkbox inline'));
	echo $this->PHForm->input('title', array('label' => array('class' => 'control-label', 'text' => 'Заголовок вопроса')));
	echo $this->PHForm->input('sorting', array('class' => 'input-small'));
