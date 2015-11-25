<?php
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
App::uses('Media', 'Media.Model');
class Exhibit extends Article {
	protected $objectType = 'Exhibit';

	var $hasOne = array(
		'Media' => array(
            'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.media_type' => 'image', 'Media.object_type' => 'Exhibit', 'Media.main' => 1),
			'dependent' => true
		)
	);

	public function getOptions() {
		$order = 'sorting';
		return $this->find('list', compact('order'));
	}

}
