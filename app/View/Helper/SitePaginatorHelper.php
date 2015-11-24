<?php
App::uses('AppHelper', 'View/Helper');
App::uses('PaginatorHelper', 'View/Helper');
class SitePaginatorHelper extends PaginatorHelper {

	public function numbers($options = array()) {
		// return str_replace('index/page:', 'page/', parent::numbers(array('separator' => ' ')));
		return parent::numbers(array('separator' => ' '));
	}
	
}
