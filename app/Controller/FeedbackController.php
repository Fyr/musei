<?php
App::uses('AppController', 'Controller');
App::uses('AppModel', 'Model');
class FeedbackController extends AppController {
	public $name = 'Feedback';
	public $uses = array('Feedback');
	public $helpers = array('Core.PHTime');
	
	protected $objectType;

	public function beforeFilter() {
		$this->objectType = $this->getObjectType();
		
		parent::beforeFilter();
	}
	
	public function beforeRender() {
		$this->currMenu = 'Feedback';

		parent::beforeRender();
	}

	public function index() {
		/*
		$this->paginate= array(
			'Feedback' => array(
				'conditions' => array('published' => 1),
				'order' => array('created' => 'DESC'),
				'limit' => 6
			)
		);
		$aRows = $this->paginate('Feedback');
		*/
		$conditions = array('published' => 1);
		$order = array('created' => 'DESC');
		$aRows = $this->Feedback->find('all', compact('conditions', 'order'));
		$this->set('aRows', $aRows);
	}
	
	public function submit() {
		if ($this->request->is(array('put', 'post'))) {
			$this->Feedback->save($this->data);
			$this->redirect(array('action' => 'success'));
			return;
		}
	}

	public function success() {
	}

}
