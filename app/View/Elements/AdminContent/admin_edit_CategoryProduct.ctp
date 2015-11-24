<?
	// echo $this->PHForm->input('status', array('label' => false, 'multiple' => 'checkbox', 'options' => array('published' => __('Published', true), 'featured' => __('Featured', true)), 'class' => 'checkbox inline'));
	echo $this->element('Article.edit_title');
	echo $this->element('Article.edit_slug');
	// echo $this->PHForm->input('subcat_id', array('options' => $aCategoryOptions, 'style' => 'width: auto'));
