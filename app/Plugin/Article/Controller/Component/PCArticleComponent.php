<?php
App::uses('Component', 'Controller');
class PCArticleComponent extends Component {
	private $_;
	private $model = 'Article', $modelName = 'Article.Article', $object_type = ''; // object settings

	public function initialize(Controller $controller) {
		$this->_ = $controller;
		// $this->_->loadModel('Article.Article');
		// $this->model = (object) array('name' => 'Article', 'alias' => 'Article');
	}
	
	public function setModel($modelName) {
		$this->model = $modelName;
		$this->modelName = $modelName;
		if (strpos($modelName, '.') !== false) {
			list($plugin, $this->model) = explode('.', $this->modelName);
		}
		return $this;
	}
	
	public function model() {
		if (!isset($this->_->{$this->model})) {
			$this->_->loadModel($this->modelName);
		}
		// fdebug($this->_->{$this->model}->name);
		return $this->_->{$this->model};
	}

	public function index() {
		$this->PCTableGrid = $this->_->Components->load('Table.PCTableGrid');
		$this->PCTableGrid->initialize($this->_);
		if (!isset($this->_->paginate)) {
    		$this->_->paginate = array(
    			'fields' => array('id', 'created', 'title', 'teaser', 'slug', 'published')
    		);
		}
		return $this->PCTableGrid->paginate($this->model()->name);
	}
	
	/**
	 * Returns a model's field named according to model's name
	 *
	 * @param str $fieldName
	 */
	private function field($fieldName) {
		return $this->model()->alias.'.'.$fieldName;
	}
	
	public function edit($id = 0, $lSaved = false) {
		$aFlags = array('published', 'featured');
		$article = $this->model()->findById($id);
		if ($this->_->request->is(array('post', 'put'))) {
			if ($id && !$this->_->request->data($this->field('id'))) {
				// auto add ID for update a record
				$this->_->request->data($this->field('id'), $id);
			}
			if (!$this->_->request->data($this->field('status')) || !is_array($this->_->request->data($this->field('status')))) {
				$this->_->request->data($this->field('status'), array());
			}
			if (is_array($this->_->request->data($this->field('status')))) {
				foreach($aFlags as $field) {
					$this->_->request->data($this->field($field), in_array($field, $this->_->request->data($this->field('status'))));
				}
			}
			if ($this->model()->saveAll($this->_->request->data)) {
				$id = $this->model()->id;
				$lSaved = true;
			}
			$this->_->request->data = array_merge($this->_->request->data, $article);
		} elseif ($id) {
			// Set up flags
			foreach($aFlags as $field) {
				if ($article[$this->model()->alias][$field]) {
					$article[$this->model()->alias]['status'][] = $field;
				}
			}
			$this->_->request->data = array_merge($this->_->request->data, $article);
		}
	}
}