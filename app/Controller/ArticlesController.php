<?php
App::uses('AppController', 'Controller');
App::uses('AppModel', 'Model');
class ArticlesController extends AppController {
	public $name = 'Articles';
	public $uses = array('Exhibit');
	public $helpers = array('ObjectType');
	
	const PER_PAGE = 5;
	
	protected $objectType;

	public function beforeFilter() {
		$this->objectType = $this->getObjectType();
		
		parent::beforeFilter();
	}
	
	public function beforeRender() {
		$this->currMenu = ($this->objectType == 'News') ? 'News' : 'Articles';
		$this->set('objectType', $this->objectType);
		
		parent::beforeRender();
	}
	
	public function index() {
		$articles = $this->Exhibit->find('all');
		
		// $this->aBreadCrumbs = array(__('Home page') => '/', )
	}
	/*
	public function exhibit() {
		$article = $this->{$this->objectType}->findBySlug($slug);
		
		if (!$article && !TEST_ENV) {
			// return $this->redirect('/');
		}
		
		$this->set('article', $article);
	}
	*/
}
