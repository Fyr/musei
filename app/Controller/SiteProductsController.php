<?php
App::uses('AppController', 'Controller');
App::uses('AppModel', 'Model');
App::uses('Product', 'Model');
App::uses('Media', 'Media.Model');
App::uses('PHMediaHelper', 'Media.View/Helper');
App::uses('PHTimeHelper', 'Core.View/Helper');

class SiteProductsController extends AppController {
	public $name = 'SiteProducts';
	public $uses = array('Media.Media', 'CategoryProduct', 'Product');
	public $components = array('Recaptcha.Recaptcha');
	public $helpers = array('Media.PHMedia', 'Core.PHTime', 'Recaptcha.Recaptcha');
	
	const PER_PAGE = 15;
	
	public function beforeFilter() {
		$this->objectType = $this->getObjectType();
		$this->set('objectType', $this->objectType);
		parent::beforeFilter();
	}
	
	/*
	public function beforeRender() {
		$this->currMenu = 'Products';
		
		parent::beforeRender();
	}
	*/
	
	public function index($catSlug = '') {
		$this->paginate = array(
			'conditions' => array('Product.published' => 1),
			'limit' => self::PER_PAGE, 
			'page' => $this->request->param('page'),
			'order' => 'Product.created DESC'
		);
		
		if ($q = $this->request->query('q')) {
			$this->paginate['conditions']['Product.title LIKE '] = '%'.$q.'%';
		} elseif ($q = $this->request->query('L')) {
			$this->paginate['conditions']['Product.title LIKE '] = $q.'%';
		} elseif ($q = $this->request->query('D')) {
			$this->paginate['conditions'][] = 'LEFT(Product.title, 1) BETWEEN "0" AND "9"';
			$q = '0-9';
		} elseif ($catSlug) {
			$this->paginate['conditions']['Category.slug'] = $catSlug;
			$this->set('category', $this->CategoryProduct->findBySlug($catSlug));
		}
		$this->set('q', $q);
		
		
		$aProducts = $this->paginate('Product');
		if (!$aProducts) {
			return $this->redirect404();
		}
		
		foreach($aProducts as &$article) {
			$article = array_merge($article, $this->Product->getMedia($article['Product']['id']));
		}
		$this->set('aArticles', $aProducts);
		$this->set('objectType', 'Product');
	}
	
	public function view($slug) {
		$article = $this->Product->findBySlug($slug);
		if (!$article) {
			return $this->redirect404();
		}
		$id = $article['Product']['id'];
		$this->Product->save(array('id' => $id, 'views' => $article['Product']['views'] + 1, 'modified' => false));
		$article = array_merge($article, $this->Product->getMedia($id));
		$this->set('article', $article);
		$this->set('category', array('CategoryProduct' => $article['Category']));
		/*
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
		$this->set('aMedia', $aMedia);
		$this->set('aThumbs', $aThumbs);
		*/
	}
	
	public function download($slug, $media_id) {
		$article = $this->Product->findBySlug($slug);
		$media = $this->Media->findById($media_id);
		$media = Hash::get($media, 'Media');
		if (!($article && $media && isset($media['id']) && $media['id'])) {
			return $this->redirect404();
		}
		
		App::uses('MediaPath', 'Media.Vendor');
		$this->MediaPath = new MediaPath();
		
		$file = $this->MediaPath->getFileName($media['object_type'], $media['id'], 'noresize', $media['file'].$media['ext']);
		if ($file && file_exists($file)) {
			header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename=logo-'.$slug.'-from-'.str_replace('.', '_', DOMAIN_TITLE).$media['ext']);
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: '.filesize($file));
		    readfile($file);
		} else {
			return $this->redirect404();
		}

	}
}
