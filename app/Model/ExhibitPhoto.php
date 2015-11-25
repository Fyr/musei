<?php
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
App::uses('Media', 'Media.Model');
class ExhibitPhoto extends Article {
	protected $objectType = 'ExhibitPhoto';

	var $hasOne = array(
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.media_type' => 'image', 'Media.object_type' => 'ExhibitPhoto', 'Media.main' => 1),
			'dependent' => true
		)
	);

}
