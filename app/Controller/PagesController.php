<?php
App::uses('AppController', 'Controller');
App::uses('AppModel', 'Model');
App::uses('Page', 'Model');
App::uses('News', 'Model');
App::uses('SiteArticle', 'Model');

class PagesController extends AppController {
	public $name = 'Pages';
	public $uses = array('Page', 'SiteArticle', 'Product', 'News');
	public $helpers = array('ArticleVars', 'Media.PHMedia', 'Core.PHTime');

	public function home() {
		if (!TEST_ENV) {
			$this->layout = 'soon';
		}
		// Welcome block
		$article = $this->Page->findBySlug('home');
		$this->set('home_article', $article);
		
		// Featured articles
		$conditions = array('SiteArticle.published' => 1, 'SiteArticle.featured' => 1);
		$order = 'SiteArticle.created DESC';
		$limit = 3;
		$aFeaturedArticles = $this->SiteArticle->find('all', compact('conditions', 'order', 'limit'));
		$this->set('aFeaturedArticles', $aFeaturedArticles);
		
		// News
		$conditions = array('News.published' => 1);
		$order = 'News.created DESC';
		$limit = 3;
		$news = $this->News->find('all', compact('conditions', 'order', 'limit'));
		$this->set('news', $news);
		
		// New products
		$conditions = array('Product.published' => 1);
		$order = 'Product.created DESC';
		$limit = 3;
		$aProducts = $this->Product->find('all', compact('conditions', 'order', 'limit'));
		
		foreach($aProducts as &$article) {
			$article = array_merge($article, $this->Product->getMedia($article['Product']['id']));
		}
		
		$this->set('aProducts', $aProducts);
		/*
		$products = $this->Product->find('all', array('conditions' => array('Product.published' => 1), 'order' => 'Product.created DESC', 'limit' => 2));
		$this->set('products', $products);
		*/
		
		$this->currMenu = 'Home';
	}
	
	public function view($slug) {
		$this->request->params['objectType'] = 'Page';
		
		$article = $this->Page->findBySlug($slug);
		$this->set('article', $article);
		
		$this->currMenu = $slug;
	}
	
	public function notExists() {
	}
}
