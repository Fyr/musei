<?
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class AjaxController extends PAjaxController {
	public $name = 'Ajax';

	public function beforeFilter() {
	}

	public function scoring() {
		$score = intval($this->request->data('score'));
		$this->loadModel('QuizResult');
		$pos = $this->QuizResult->getPlayerPos($score);
		$this->setResponse(compact('pos'));
	}

	public function savePlayer() {
		$this->loadModel('QuizResult');
		$this->QuizResult->save($this->request->data);
		$this->setResponse(true);
	}
}
