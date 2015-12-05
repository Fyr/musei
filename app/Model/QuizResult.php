<?php
App::uses('AppModel', 'Model');
class QuizResult extends AppModel {
	const TOP = 8;

	public function getPlayerPos($score) {
		$aRows = $this->find('list', array('fields' => array('id', 'player_name'), 'conditions' => array('score >= ' => $score), 'order' => 'score DESC'));
		fdebug(array($score, $aRows, count($aRows), self::TOP));
		return (count($aRows) >= self::TOP) ? 0 : count($aRows);
	}
}
