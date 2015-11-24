<?php
/**
 * TODO:
 * - for date range filters: put 2 dates into 1 value with "~"
 * - for string filters: implement * mask
 */
App::uses('Component', 'Controller');
class PCTableGridComponent extends Component {
	public $components = array('Paginator');

	const LIMIT = 20;
	
	private $_;
	private $model, $paginate = array(), $defaults = array();
	private $pgFilter = array();

	public function initialize(Controller $controller) {
		$this->_ = $controller;
	}

	public function startup(Controller $controller) {
		if (isset($this->_->params['named']) && $this->_->params['named']) {
			// Reset page number to show first page for applied filter
			// $this->_->request->params['named']['page'] = 1;
		}
	}

	/**
	 * Returns a default order that is set for pagination, if 'order' options was ommited
	 *
	 * @return array()
	 */
	private function _getDefaultOrder() {
		//$order = array($this->model->name.'.'.$this->model->primaryKey => 'asc');
		if (isset($this->paginate['order'])) {
			/*
			if (is_array($this->paginate['order'])) {
				
			}
			return $this->_normalizeField($this->model->alias, $this->paginate['order']);
			*/
			return $this->paginate['order'];
		}
		if (in_array($this->model->alias.'.modified', $this->paginate['fields'])) {
			$order = array($this->model->alias.'.modified' => 'desc');
		} else if (in_array($this->model->alias.'.created', $this->paginate['fields'])) {
			$order = array($this->model->alias.'.created' => 'desc');
		} else {
			$order = array($this->paginate['fields'][0] => 'asc');
		}
		return $order;
	}

	/**
	 * Initialize default settings for pagination
	 *
	 */
	private function _init() {
		$modelName = $this->model->name;
		if (!isset($this->_->paginate[$modelName])) {
			if (isset($this->_->paginate) && is_array($this->_->paginate) && $this->_->paginate) {
				$this->paginate = $this->_->paginate;
			}
		} else {
			$this->paginate = $this->_->paginate[$modelName];
		}
	}

	private function _normalizeField($modelName, $field) {
		if (strpos($field, '.') === false) {
			$field = $modelName.'.'.$field;
		}
		return $field;
	}

	private function _normalizeKeys($modelName, $aSrc) {
		$aDest = array();
		// Normalize fields
		foreach($aSrc as $field => $value) {
			$aDest[$this->_normalizeField($modelName, $field)] = $value;
		}
		return $aDest;
	}

	private function _normalizeValues($modelName, $aSrc) {
		$aDest = array();
		// Normalize fields
		foreach($aSrc as $field) {
			$aDest[] = $this->_normalizeField($modelName, $field);
		}
		return $aDest;
	}

	private function _denormalizeField($field) {
		$aInfo = explode('.', $field);
		return array('model' => $aInfo[0], 'alias' => $aInfo[0], 'field' => $aInfo[1]);
	}

	private function _getFieldType($field) {
		$key = $this->_denormalizeField($field);
		if (!isset($this->_->{$key['model']})) {
			$key['model'] = $this->model->name;
		}
		$schema = $this->_->{$key['model']}->schema();
		if (isset($schema[$key['field']])) {
			return $schema[$key['field']]['type'];
		}
		// throw new Exception('Grid plugin: Cannot find schema for '.$field);
		return 'string';
	}

	private function _getColumn($field) {
		$key = $this->_denormalizeField($field);
		$label = __(ucfirst(str_replace('_', ' ', $key['field'])));
		return array('key' => $field, 'label' => $label, 'format' => $this->_getFieldType($field));
	}

	private function _initFields() {
		$modelName = $this->modelName;
		$aFields = (isset($this->paginate['fields'])) ? $this->paginate['fields'] : array_keys($this->model->schema());
		$this->paginate['fields'] = $this->_normalizeValues($this->model->alias, $aFields);
		foreach($this->paginate['fields'] as $field) {
			$this->paginate['_columns'][] = $this->_getColumn($field);
		}
		if (!isset($this->paginate['fields'][$this->model->primaryKey])) {
			$this->paginate['fields'][] = $this->model->alias.'.'.$this->model->primaryKey;
		}
	}

	private function _initDefaults() {
		$order = $this->_getDefaultOrder();
		$params = $this->_->request->params;
		$limit = (Hash::get($params, 'named.limit')) ? Hash::get($params, 'named.limit') : self::LIMIT;
		$this->paginate = Hash::merge(array('order' => $order, 'limit' => $limit), $this->paginate);
		if (is_array($this->paginate['order'])) {
			list($sort) = array_keys($this->paginate['order']);
			list($direction) = array_values($this->paginate['order']);
		} else {
			$sort = $this->paginate['order']; 
			$direction;
		}
		$this->paginate['_defaults'] = compact('sort', 'direction', 'limit');
	}

	/*
	private function _initConditions() {

	}
	*/
	public function paginate($modelName, $filters = array()) {
		$this->model = $this->_->{$modelName};
		// fdebug($this->model);
		$this->_init();
		$this->_initFields();
		$this->_initDefaults();
		// $this->_initConditions();
		
		// $this->Paginator->settings = array($modelName => $this->paginate); // force to load our settings into Paginator
		// $this->_->paginate = array($modelName => $this->paginate);
		$this->_->paginate[$modelName] = $this->paginate;
		// fdebug($this->paginate, 'paginate.log');
		$filters = ($filters) ? $filters : $this->_->params['named'];
		$this->setFilter($filters);
		// $aRowset = $this->Paginator->paginate($modelName, $this->getFilter());
		$aRowset = $this->_->paginate($modelName, $this->getFilter());
		// $this->paginate[$modelName]['_rowset'] = $aRowset;
		$_paginate = array();
		$_paginate[$modelName] = $this->paginate;
		$_paginate[$modelName]['_rowset'] = $aRowset;
		$this->_->set('_paginate', $_paginate);
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
				// $_filter[$field] = $value;
				$this->addFilter($field, $value);
			}
		}
		// $this->_->params['named'] = array_merge($this->_->params['named'], $_filter);

		// $this->pgFilter = $_filter;
		// $this->_->set('filterValues', $filterData);
	}

	/**
	 * Adds a filter value to a pagination filter
	 *
	 * @param str $key - filter param
	 * @param mixed $value - value for filter or direct SQL expr to filter table
	 */
	public function addFilter($key, $value) {
		$type = $this->_getFieldType($key);
		if ($type == 'date' || $type == 'datetime') { // consider as exact date range
			$this->pgFilter = array_merge($this->pgFilter, array($key.'>="'.$value.' 00:00:00"'));
			$value = $key.'<="'.$value.' 23:59:59"';
			$key = '';
		} elseif ($type == 'string') {
			if (strpos($value, '*') === false) {
				$value.= '*'; // by default we search first chars in string
			}
			$value = $key.' LIKE "'.str_replace('*', '%', $value).'"';
			$key = '';
		}
		
		// add key->value pair to filter and overload existing pair
		if ($key) {
			$this->pgFilter[$key] = $value;
		} else {
			$this->pgFilter = array_merge($this->pgFilter, array($value));
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