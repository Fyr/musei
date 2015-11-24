<?php
App::uses('AppController', 'Controller');
class AdminController extends AppController {
	public $name = 'Admin';
	public $layout = 'admin';
	// public $components = array();
	public $uses = array();

	public function _beforeInit() {
	    // auto-add included modules - did not included if child controller extends AdminController
	    $this->components = array_merge(array('Auth', 'Core.PCAuth', 'Table.PCTableGrid'), $this->components);
	    $this->helpers = array_merge(array('Html', 'Table.PHTableGrid', 'Form.PHForm'), $this->helpers);
	    
		$this->aNavBar = array(
			'Content' => array('label' => __('Content'), 'href' => '', 'submenu' => array(
				array('label' => __('Static pages'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'Page')),
				array('label' => __('News'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'News')),
				array('label' => __('Articles'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'SiteArticle')),
			)),
			'Catalog' => array('label' => __('Catalog'), 'href' => '', 'submenu' => array(
				array('label' => __('Categories'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'CategoryProduct')),
				array('label' => __('Products'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'Product')),
			)),
			/*[
			'Products' => array('label' => __('Products'), 'href' => '', 'submenu' => array(
				'Category' => array('label' => __('Categories'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'Category')),
				'Brands' => array('label' => __('Brands'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'Brand')),
				'Forms' => array('label' => __('Tech.params'), 'href' => array('controller' => 'AdminForms', 'action' => 'index')),
				'Products' => array('label' => __('Products'), 'href' => array('controller' => 'AdminProducts', 'action' => 'index')),
			)),
			
			'Users' => array('label' => __('Users'), 'href' => array('controller' => 'AdminUsers', 'action' => 'index')),
			// 'slider' => array('label' => __('Slider'), 'href' => array('controller' => 'AdminSlider', 'action' => 'index')),
			'Upload' => array('label' => __('Uploadings'), 'href' => '', 'submenu' => array(
				array('label' => __('Upload counters'), 'href' => array('controller' => 'AdminUploadCsv', 'action' => 'index')),
				array('label' => __('Upload new products'), 'href' => array('controller' => 'AdminUploadCsv', 'action' => 'uploadNewProducts')),
			)),
			
			'Settings' => array('label' => __('Settings'), 'href' => '', 'submenu' => array(
				array('label' => __('System'), 'href' => array('controller' => 'AdminSettings', 'action' => 'index')),
				array('label' => __('Slider'), 'href' => array('controller' => 'AdminSlider', 'action' => 'index'))
			))
			*/
		);
		$this->aBottomLinks = $this->aNavBar;
	}
	
	public function beforeFilter() {
		/*
		$this->loadModel('Section');
		foreach($this->Section->find('list') as $id => $title) {
			$this->aNavBar['Products']['submenu'][] = array(
				'label' => $title, 'href' => array('controller' => 'AdminProducts', 'Product.section' => $id)
			);
		}
		*/
	    $this->currMenu = $this->_getCurrMenu();
	    $this->currLink = $this->currMenu;
	}
	
	public function beforeRenderLayout() {
		$this->set('isAdmin', $this->isAdmin());
	}
	
	public function isAdmin() {
		return AuthComponent::user('id') == 1;
	}

	public function index() {
		//$this->redirect(array('controller' => 'AdminProducts'));
	}
	
	protected function _getCurrMenu() {
		$curr_menu = str_ireplace('Admin', '', $this->request->controller); // By default curr.menu is the same as controller name
		return $curr_menu;
	}

	public function delete($id) {
		$this->autoRender = false;

		$model = $this->request->query('model');
		if ($model) {
			$this->loadModel($model);
			if (strpos($model, '.') !== false) {
				list($plugin, $model) = explode('.',$model);
			}
			$this->{$model}->delete($id);
		}
		if ($backURL = $this->request->query('backURL')) {
			$this->redirect($backURL);
			return;
		}
		$this->redirect(array('controller' => 'Admin', 'action' => 'index'));
	}
	
}
