<?php
App::uses('AppController', 'Controller');
App::uses('AppModel', 'Model');
App::uses('SiteArticle', 'Model');
App::uses('News', 'Model');
class ArticlesController extends AppController {
	public $name = 'Articles';
	public $uses = array('SiteArticle', 'News');
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
		$this->paginate = array(
			'conditions' => array($this->objectType.'.published' => 1),
			'limit' => self::PER_PAGE, 
			'order' => $this->objectType.'.created DESC',
			'page' => $this->request->param('page')
		);
		$this->set('aArticles', $this->paginate($this->objectType));
		
		// $this->aBreadCrumbs = array(__('Home page') => '/', )
	}
	
	public function view($slug) {
		$article = $this->{$this->objectType}->findBySlug($slug);
		
		if (!$article && !TEST_ENV) {
			// return $this->redirect('/');
		}
		
		$this->set('article', $article);
	}
}
