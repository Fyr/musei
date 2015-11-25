<?
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
App::uses('Media', 'Media.Model');
class Exposition extends Article {
	protected $objectType = 'Exposition';
	
	var $hasOne = array(
		'Media' => array(
			'foreignKey' => 'object_id',
			'conditions' => array('Media.media_type' => 'image', 'Media.object_type' => 'Exposition', 'Media.main' => 1),
			'dependent' => true
		)
	);
	
}
