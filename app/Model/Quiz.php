<?php
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
class Quiz extends Article {
	protected $objectType = 'Quiz';

	var $hasOne = array(
		'Media' => array(
			'foreignKey' => 'object_id',
			'conditions' => array('Media.media_type' => 'image', 'Media.object_type' => 'Quiz', 'Media.main' => 1),
			'dependent' => true
		)
	);
}
