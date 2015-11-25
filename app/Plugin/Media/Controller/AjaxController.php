<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class AjaxController extends PAjaxController {
	public $name = 'Ajax';

	public $uses = array('Media.Media');

	public function beforeFilter() {
	}

	public function upload() {
		$this->autoRender = false;
		App::uses('UploadHandler', 'Media.Vendor');
		$upload_handler = new UploadHandler();
	}

	public function move() {
		$orig_fname = $this->request->data('name');
		$tmp_name = PATH_FILES_UPLOAD.$orig_fname;
		list($media_type) = explode('/', $this->request->data('type'));
		if (!in_array($media_type, $this->Media->types)) {
		    $media_type = 'bin_file';
		}
		$object_type = $this->request->data('object_type');
		$object_id = $this->request->data('object_id');
		$path = pathinfo($tmp_name);
		$file = $media_type; // $path['filename'];
		$ext = '.'.$path['extension'];
		
		if ($crop = $this->request->data('crop')) {
			$crop = (is_array($crop)) ? implode(',', $crop): $crop;
		}
		
		$data = compact('media_type', 'object_type', 'object_id', 'tmp_name', 'file', 'ext', 'orig_fname', 'crop');
		$media_id = $this->Media->uploadMedia($data);
		
		$this->getList($object_type, $object_id);
	}
	
	public function getList($object_type, $object_id) {
	    $this->setResponse($this->Media->getList(compact('object_type', 'object_id'), array('Media.id' => 'DESC')));
	}
	
	public function delete($object_type = '', $object_id = '', $id = '') {
		if (!$object_type) {
			$object_type = $this->request->data('object_type');
		}
		if (!$object_id) {
			$object_id = $this->request->data('object_id');
		}
		if (!$id) {
			$id = $this->request->data('id');
		}
		$this->Media->delete($id);
		$this->Media->initMain($object_type, $object_id);
		$this->setResponse($this->Media->getList(compact('object_type', 'object_id')));
	}
	
	public function setMain($object_type, $object_id, $id) {
		$this->Media->setMain($id, $object_type, $object_id);
		$this->setResponse($this->Media->getList(compact('object_type', 'object_id')));
	}
	
}
