<?php
App::uses('AppController', 'Controller');
class PAjaxController extends AppController {
    public $name = 'PAjax';
    
	const STATUS_OK = 'OK';
	const STATUS_ERROR = 'ERROR';
	
	protected $_response = null;
	
	protected function _beforeInit() {
	    $this->components[] = 'RequestHandler';
	}
	
	public function beforeRender() {
	    if ($this->_response) {
    	    $this->set('_response', $this->_response);
    	    $this->set('_serialize', '_response');
	    }
	}
    
	public function setResponse($data = array()) {
	    $this->_response = array('status' => self::STATUS_OK);
	    if ($data) {
	    	$this->_response['data'] = $data;
	    }
	}
	
	public function getResponse() {
	    return $this->_response;
	}
	
	public function setError($errMsg) {
	    $this->_response = array('status' => self::STATUS_ERROR, 'errMsg' => $errMsg);
	}
	
	
}