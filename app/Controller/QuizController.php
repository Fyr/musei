<?php
App::uses('AppController', 'Controller');
App::uses('AppModel', 'Model');
App::uses('Quiz', 'Model');
App::uses('QuizResult', 'Model');

class QuizController extends AppController {
	public $name = 'Quiz';
	public $uses = array('Quiz');
	public $helpers = array('Media.PHMedia', 'Core.PHTime');
	
	public function beforeRender() {
		$this->currMenu = 'Quiz';
		parent::beforeRender();
	}

	public function index() {
		$conditions = array('Quiz.published' => 1);
		$order = 'Quiz.sorting';
		$aQuiz = $this->Quiz->find('all', compact('conditions', 'order'));
		$this->set('aQuiz', $aQuiz);
	}

	public function topPlayers() {
		$this->layout = 'ajax';
		$this->loadModel('QuizResult');
		$aResults = $this->QuizResult->find('all', array('limit' => QuizResult::TOP, 'order' => array('score' => 'DESC', 'created' => 'ASC')));
		$this->set('aResults', $aResults);

		$this->loadModel('Quiz');
		$this->set('total', count($this->Quiz->find('list')));
	}
}
