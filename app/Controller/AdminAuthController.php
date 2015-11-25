<?php
App::uses('AppController', 'Controller');
class AdminAuthController extends AppController {
	public $name = 'AdminAuth';
	public $components = array('Core.PCAuth');
	public $layout = 'login';

	public function beforeRender() {
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(AUTH_ERROR, null, null, 'auth');
			}
		}
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

}
