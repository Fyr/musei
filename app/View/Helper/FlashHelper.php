<?php
App::uses('AppHelper', 'View/Helper');
class FlashHelper extends AppHelper {

	/**
	 * Enter description here...
	 * type = error|success
	 * @return unknown
	 */
	public function render() {
		$msg = '';
		$type = '';
		return '<div class="alert alert-'.$type.'"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$msg.'</div>';
	}
}
