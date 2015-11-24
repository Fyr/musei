<?php
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class SiteNewsController extends SiteController {
	public $name = 'SiteNews';
	public $uses = array('News');
	public $helpers = array('Paginator');

	public function index() {
		$this->pageTitle = __('News');
		$this->paginate = array(
			'conditions' => array('published' => 1),
			'limit' => 10, 
			'order' => 'News.created DESC'
		);
		$this->set('news', $this->paginate('News'));
	}
	
	public function view($id) {
		$article = $this->News->findById($id);
		$this->pageTitle = $article['News']['title'];
		$this->set('article', $article);
	}
}
