<?php
App::uses('AppController', 'Controller');
App::uses('AppModel', 'Model');

class SiteController extends AppController {
	public $name = 'Site';
	
	public function _beforeInit() {
		// $this->components = array_merge(array('Table.PCTableGrid'), $this->components);
	    $this->helpers = array_merge(array('Html', 'Form', 'Paginator', 'Media', 'ArticleVars'), $this->helpers);
		// $this->uses = array_merge(array('Settings', 'Media.Media', 'CategoryProduct', 'News'), $this->uses);
	}
	
	public function _afterInit() {
	}
}
