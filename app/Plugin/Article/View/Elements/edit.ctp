<?
	echo $this->PHForm->input('status', array('label' => false, 'multiple' => 'checkbox', 'options' => array('published' => 'Published', 'featured' => 'Featured'), 'class' => 'checkbox inline'));
	echo $this->PHForm->input('title', array('onkeyup' => 'article_onChangeTitle()'));
	echo $this->element('Article.edit_slug');
	echo $this->PHForm->input('teaser');