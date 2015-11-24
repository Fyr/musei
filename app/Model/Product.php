<?
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
App::uses('Media', 'Media.Model');
App::uses('CategoryProduct', 'Model');
App::uses('Seo', 'Seo.Model');
class Product extends Article {
	var $belongsTo = array(
		'Category' => array(
			'className' => 'Article.Article',
			'foreignKey' => 'cat_id',
			'conditions' => array('Category.object_type' => 'CategoryProduct'),
			'dependent' => true
		)
	);
	
	public $hasOne = array(
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Product', 'Media.main' => 1),
			'dependent' => true
		),
		'Seo' => array(
			'className' => 'Seo.Seo',
			'foreignKey' => 'object_id',
			'conditions' => array('Seo.object_type' => 'Product'),
			'dependent' => true
		)
	);
	
	public $objectType = 'Product';
	
	public function getMedia($id) {
		$this->Media = $this->loadModel('Media.Media');
		$aMedia = $this->Media->getObjectList('Product', $id);
		
		// for bin-file we just upload an image with the same name + _thumb
		$aThumbs = array();
		foreach($aMedia as $media) {
			if ($media['Media']['media_type'] == 'image' && strpos($media['Media']['orig_fname'], '_thumb') !== false) {
				list($fname) = explode('.', str_replace('_thumb', '', $media['Media']['orig_fname']));
				$aThumbs[$fname] = $media;
			}
		}
		$aMedia = Hash::combine($aMedia, '{n}.Media.id', '{n}', '{n}.Media.media_type');
		return array('MediaTypes' => $aMedia, 'Thumbs' => $aThumbs);
	}
}
