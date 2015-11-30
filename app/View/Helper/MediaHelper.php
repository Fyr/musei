<?php
App::uses('AppHelper', 'View/Helper');
class MediaHelper extends AppHelper {
	public $MediaPath;
	
	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		
		App::uses('MediaPath', 'Media.Vendor');
		$this->MediaPath = new MediaPath();
	}
	
	function imageUrl($article, $size) {
		if (isset($article['Media']) && isset($article['Media']['id']) && $article['Media']['id']) {
			$media = $article['Media'];
		} else {
			return '';
		}
		
		return str_replace('noresize', $size, $media['url_img']);
	}
}
