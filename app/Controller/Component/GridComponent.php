<?php
App::uses('Component', 'Controller');
class GridComponent extends Component {

	/**
	 * Parent controller
	 *
	 * @var object
	 */
	protected $_;
	protected $model, $paginate = array(), $defaults = array();
	protected $pgFilter = array();

	public function initialize(Controller $controller) {
		$this->_ = $controller;
	}

	public function startup(Controller $controller) {
		if (isset($this->_->params['named']) && $this->_->params['named']) {
			// Reset page number to show first page for applied filter
			// $this->_->request->params['named']['page'] = 1;
		}
		$this->setFilter($this->_->params['named']);
	}

	/**
	 * Returns a default order that is set for pagination, if 'order' options was ommited
	 *
	 * @return array()
	 */
	protected function _getDefaultOrder() {
		//$order = array($this->model->name.'.'.$this->model->primaryKey => 'asc');
		if (in_array($this->model->alias.'.modified', $this->paginate['fields'])) {
			$order = array($this->model->alias.'.modified' => 'desc');
		} else {
			$order = array($this->paginate['fields'][0] => 'asc');
		}
		return $order;
	}

	/**
	 * Initialize default settings for pagination
	 *
	 */
	protected function _initDefaults() {
		$modelName = $this->model->name;
		if (!isset($this->_->paginate[$modelName])) {
			if (isset($this->_->paginate) && is_array($this->_->paginate) && $this->_->paginate) {
				$this->paginate = $this->_->paginate;
			}
		} else {
			$this->paginate = $this->_->paginate[$modelName];
		}
		$this->paginate = Hash::merge(array('order' => $this->_getDefaultOrder(), 'limit' => 10), $this->paginate);
	}

	protected function _normalizeField($modelName, $field) {
		if (strpos($field, '.') === false) {
			$field = $modelName.'.'.$field;
		}
		return $field;
	}

	protected function _normalizeKeys($modelName, $aSrc) {
		$aDest = array();
		// Normalize fields
		foreach($aSrc as $field => $value) {
			$aDest[$this->_normalizeField($modelName, $field)] = $value;
		}
		return $aDest;
	}

	protected function _normalizeValues($modelName, $aSrc) {
		$aDest = array();
		// Normalize fields
		foreach($aSrc as $field) {
			$aDest[] = $this->_normalizeField($modelName, $field);
		}
		return $aDest;
	}

	protected function _denormalizeField($field) {
		$aInfo = explode('.', $field);
		return array('model' => $aInfo[0], 'field' => $aInfo[1]);
	}

	protected function _initFields() {
		$modelName = $this->modelName;
		$aFields = (isset($this->paginate['fields'])) ? $this->paginate['fields'] : array_keys($this->model->schema());
		$this->paginate['fields'] = $this->_normalizeValues($this->model->alias, $aFields);
		/*
		foreach($aFields as $fieldID) {
			$this->paginate['fields'][$fieldID] = $this->_denormalizeField($fieldID);
		}
		*/
	}

	public function paginate($modelName, $filter = array()) {
		$this->model = $this->_->{$modelName};
		$this->_initFields();
		$this->_initDefaults();
		fdebug($this->paginate);
		$this->_->paginate[$modelName] = $this->paginate;
		$aRowset = $this->_->paginate($modelName, $this->getFilter());
		$this->_->paginate[$modelName]['_rowset'] = $aRowset;
		$this->_->set('_paginate', $this->_->paginate);
		return $aRowset;
	}

	/**
	 * Setup a filter for pagination
	 *
	 * @param array $filter - conditions for filter as array of elements like [Model.field] => value
	 */
	public function setFilter($filterData) {
		$_filter = array();
		foreach ($filterData as $field => $value) {
			if (!in_array($field, array('sort', 'direction', 'page', 'limit')) && $value) {
				$_filter[$field] = $value;
			}
		}
		// $this->_->params['named'] = array_merge($this->_->params['named'], $_filter);
		$this->pgFilter = $_filter;
		// $this->_->set('filterValues', $filterData);
	}

	/**
	 * Adds a filter value to a pagination filter
	 *
	 * @param str $key - filter param
	 * @param mixed $value - value for filter or direct SQL expr to filter table
	 */
	public function addFilter($key, $value) {
		if ($key) {
			$this->pgFilter[$key] = $value;
		} else {
			$this->pgFilter = array_merge($this->get(), array($value));
		}
	}

	/**
	 * Removes a filter value from a pagination filter
	 *
	 * @param str $key - filter param
	 * @param unknown_type $value - value for filter or direct SQL expr to filter table
	 */
	public function removeFilter($key, $value = '') {
		if ($key && isset($this->pgFilter[$key])) {
			unset($this->pgFilter[$key]);
		} elseif ($value) {
			// TODO: unset value
		}
	}

	/**
	 * Checks if filter value is set
	 *
	 * @param str $key - filter param
	 * @param unknown_type $value - value for filter or direct SQL expr to filter table
	 * @return bool
	 */
	public function checkFilter($key, $value = '') {
		return isset($this->pgFilter[$key]) || in_array($this->pgFilter, $value);
	}

	/**
	 * Get a filter for pagination
	 *
	 * @return array
	 */
	public function getFilter($key = '', $value = '') {
		if ($key) {
			return (isset($this->pgFilter[$key])) ? $this->pgFilter[$key] : null;
		} elseif ($value) {
			return in_array($this->pgFilter, $value);
		}
		return $this->pgFilter;
	}
}