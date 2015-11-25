<?php
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
App::uses('Media', 'Media.Model');
class CollectionPhoto extends Article {
	protected $objectType = 'CollectionPhoto';

	var $hasOne = array(
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.media_type' => 'image', 'Media.object_type' => 'CollectionPhoto', 'Media.main' => 1),
			'dependent' => true
		)
	);

}
