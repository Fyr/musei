<?
App::uses('Router', 'Cake/Routing');
class SiteRouter extends Router {

	static public function getObjectType($article) {
		list($objectType) = array_keys($article);
		return $objectType;
	}
	
	static public function url($article) {
		$objectType = self::getObjectType($article);
		if ($objectType == 'Product') {
			$url = array(
				'controller' => 'SiteProducts', 
				'action' => 'view',
				'category' => $article['Category']['slug'],
				'objectType' => 'Product',
				'slug' => $article['Product']['slug']
			);
		} elseif ($objectType == 'CategoryProduct') {
			$url = array(
				'controller' => 'SiteProducts', 
				'action' => 'index',
				'category' => $article['CategoryProduct']['slug'],
				'objectType' => 'Product'
			);
		} else {
			$url = array(
				'controller' => 'Articles', 
				'action' => 'view',
				'objectType' => $objectType,
				'slug' => $article[$objectType]['slug']
			);
		}
		return parent::url($url);
	}
	
}