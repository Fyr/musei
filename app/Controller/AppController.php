<?php
App::uses('Controller', 'Controller');
App::uses('AppModel', 'Model');
App::uses('Media', 'Media.Model');
App::uses('News', 'Model');
App::uses('Product', 'Model');
App::uses('CategoryProduct', 'Model');

class AppController extends Controller {
	public $paginate;
	public $aNavBar = array(), $currMenu = '', $aBottomLinks, $currLink = '';
	public $pageTitle = '';
	
	public function __construct($request = null, $response = null) {
		$this->_beforeInit();
		parent::__construct($request, $response);
		$this->_afterInit();
	}
	
	protected function _beforeInit() {
	    $this->helpers = array_merge(array('Html', 'Form', 'Paginator', 'Media', 'ArticleVars', 'ObjectType'), $this->helpers);
	}

	protected function _afterInit() {
	    // after construct actions here
	}
	
	public function isAuthorized($user) {
    	$this->set('currUser', $user);
		return Hash::get($user, 'active');
	}
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->beforeFilterLayout();
	}
	
	protected function beforeFilterLayout() {
		$this->aNavBar = array(
			'Page' => array('label' => 'О музее', 'href' => '', 'class' => 'aboutMuseum', 'submenu' => array()),
			'Exhibit' => array('label' => __('Exhibits'), 'href' => '', 'class' => 'collections', 'submenu' => array()),
			'Collection' => array('label' => __('Collections'), 'href' => '', 'class' => 'collections', 'submenu' => array()),
			'Logo',
			'Exposition' => array('label' => __('Expositions'), 'href' => array('controller' => 'Pages', 'action' => 'exposition')),
			'Quiz' => array('label' => __('Quiz'), 'href' => array('controller' => 'Quiz', 'action' => 'index')),
			'Feedback' => array('label' => __('Feedbacks'), 'href' => '', 'class' => 'reviews', 'submenu' => array(
				array('label' => 'Написать отзыв', 'href' => array('controller' => 'Feedback', 'action' => 'submit')),
				array('label' => 'Посмотреть отзывы', 'href' => array('controller' => 'Feedback', 'action' => 'index')),
			))
		);

		$this->currMenu = $this->_getCurrMenu();
	}
	
	protected function _getCurrMenu() {
		$curr_menu = strtolower(str_ireplace('Site', '', $this->request->controller)); // By default curr.menu is the same as controller name
		return $curr_menu;
	}
	
	public function beforeRender() {
		$this->set('aNavBar', $this->aNavBar);
		$this->set('currMenu', $this->currMenu);
		$this->set('aBottomLinks', $this->aBottomLinks);
		$this->set('currLink', $this->currLink);
		$this->set('pageTitle', $this->pageTitle);

		$this->beforeRenderLayout();
	}
	
	protected function beforeRenderLayout() {
		foreach(array('Page', 'Exhibit', 'Collection') as $objectType) {
			$this->loadModel($objectType);
			$aPages = $this->{$objectType}->find('all', array('order' => $objectType.'.sorting'));
			foreach ($aPages as $article) {
				$this->aNavBar[$objectType]['submenu'][] = array(
					'label' => $article[$objectType]['title'],
					'href' => array('controller' => 'Pages', 'action' => strtolower($objectType), $article[$objectType]['slug'])
				);
			}
		}
		$this->loadModel('Exposition');
		$article = $this->Exposition->find('first', array('order' => 'Exposition.sorting DESC'));
		$this->aNavBar['Exposition']['href'][] = $article['Exposition']['slug'];
		$this->set('aNavBar', $this->aNavBar);
	}
	
	/**
	 * Sets flashing message
	 *
	 * @param str $msg
	 * @param str $type - must be 'success', 'error' or empty
	 */
	protected function setFlash($msg, $type = 'info') {
		$this->Session->setFlash($msg, 'default', array(), $type);
	}

	
	protected function getObjectType() {
		$objectType = $this->request->param('objectType');
		return ($objectType) ? $objectType : 'SiteArticle';
	}
	
	protected function redirect404() {
		$this->autoRender = false;
		return $this->redirect(array('controller' => 'Pages', 'action' => 'notExists'));
	}
}
