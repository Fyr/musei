<?
	echo $this->PHForm->input('status', array('label' => false, 'multiple' => 'checkbox', 'options' => array('published' => __('Published', true)), 'class' => 'checkbox inline'));
    echo $this->PHForm->input('title');
	// echo $this->element('Article.edit_title');
	// echo $this->element('Article.edit_slug');
	echo $this->PHForm->input('teaser');
	echo $this->PHForm->input('sorting', array('class' => 'input-small'));
	
