<?php
App::uses('AppModel', 'Model');
class Article extends AppModel {
	public $useTable = 'articles';

	public $validate = array(
		'title' => 'notempty'
	);
}
