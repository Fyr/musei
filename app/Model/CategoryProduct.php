<?php
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
App::uses('Seo', 'Seo.Model');
class CategoryProduct extends Article {
	protected $objectType = 'CategoryProduct';
	
	var $hasOne = array(
		'Seo' => array(
			'className' => 'Seo.Seo',
			'foreignKey' => 'object_id',
			'conditions' => array('Seo.object_type' => 'CategoryProduct'),
			'dependent' => true
		)
	);
	
}
