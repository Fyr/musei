<?php
App::uses('AdminController', 'Controller');
App::uses('Feedback', 'Model');
class AdminFeedbackController extends AdminController {
    public $name = 'AdminFeedback';
    public $components = array('Article.PCArticle', 'Table.PCTableGrid');
    public $uses = array('Feedback');

	public function beforeFilter() {
		parent::beforeFilter();
       $this->currMenu = 'Feedback';
	}
    
    public function index() {
        $this->paginate = array(
            'Feedback' => array(
            	'fields' => array('created', 'title', 'body', 'published'),
				'order' => array('Feedback.created' => 'DESC')
            )
        );

		$aRowset = $this->PCTableGrid->paginate('Feedback');
		$this->set('aRowset', $aRowset);
    }
    
	public function edit($id = 0) {
		if ($this->request->is(array('put', 'post'))) {
			$this->request->data('Feedback.published', $this->request->data('Feedback.status.0') == 'published');
			$this->Feedback->save($this->request->data);
			$indexRoute = array('action' => 'index');
			$editRoute = array('action' => 'edit', $id);
			return $this->redirect(($this->request->data('apply')) ? $indexRoute : $editRoute);
		} else {
			$this->request->data = $this->Feedback->findById($id);
			$status = ($this->request->data('Feedback.published')) ? array('published') : array();
			$this->request->data('Feedback.status', $status);
		}

		if (!$id) {
			$this->request->data('Feedback.status', array('published'));
		}
	}
}
