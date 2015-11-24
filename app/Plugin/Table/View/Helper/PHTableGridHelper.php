<?php
App::uses('AppHelper', 'View/Helper');
class PHTableGridHelper extends AppHelper {
    public $helpers = array('Paginator', 'Html');
    private $paginate;
    
    /*
    private function _getDefaults($modelName, $options = array()) {
        $defaulOptions = array(
            'baseURL' => $this->Html->url(array('')),
            'actions' => $this->getDefaultActions($modelName)
        );
        return $defaulOptions;
    }
	*/
    /**
     * Used to reassign Grid actions.
     *
     * @param str $modelName
     * @return array
     */
	public function getDefaultActions($modelName) {
		$table = array(
			'add' => array('class' => 'icon-color icon-add', 'label' => __('Add record'), 'href' => $this->Html->url(array('action' => 'edit'))),
			'filter' => array('class' => 'icon-color icon-filter-settings grid-show-filter', 'label' => __('Show filter settings'))
		);
		$objectType = $this->viewVar('objectType');
		$objectID = $this->viewVar('objectID');
		$backURL = $this->Html->url(array('action' => 'index', $objectType, $objectID));
		$editURL = $this->Html->url(array('action' => 'edit')).'/{$id}';
		$deleteURL = $this->Html->url(array('action' => 'delete')).'/{$id}?model='.$modelName.'&backURL='.urlencode($backURL);
		$row = array(
			'edit' => array('class' => 'icon-color icon-edit', 'label' => __('Edit record'), 'href' => $editURL),
			// array('class' => 'icon-color icon-delete', 'label' => __('Delete record'), 'href' => urldecode($deleteURL).'?model='.$modelName.'&backURL='.urlencode($backURL))
			'delete' => $this->Html->link('', $deleteURL, array('class' => 'icon-color icon-delete', 'title' => __('Delete record')), __('Are you sure to delete this record?'))
		);
		$checked = array(
			array('icon' => 'icon-color icon-delete', 'label' => __('Delete checked records'))
		);
		return compact('table', 'row', 'checked');
	}
	
	public function getDefaultColumns($modelName) {
		$aCols = $this->viewVar('_paginate.'.$modelName.'._columns');
		$aKeys = Hash::extract($aCols, '{n}.key');
		return array_combine($aKeys, $aCols);
	}

	public function render($modelName, $options = array()) {
		$this->Html->css(array('/Table/css/grid', '/Icons/css/icons'), array('inline' => false));
		$this->Html->script(array('/Table/js/grid', '/Table/js/format'), array('inline' => false));

		$this->paginate = $this->viewVar('_paginate.'.$modelName);
		$container_id = 'grid_'.$modelName;
		$paging = array(
			'curr' => intval($this->Paginator->counter(array('model' => $modelName, 'format' => '{:page}'))),
			'total' => intval($this->Paginator->counter(array('model' => $modelName, 'format' => '{:pages}'))),
			'count' => $this->Paginator->counter(array('model' => $modelName, 'format' => __('Shown {:start}-{:end} of {:count} records'))),
		);
		$defaults = Hash::get($this->paginate, '_defaults');
		$options['baseURL'] = (isset($options['baseURL'])) ? $options['baseURL'] : $this->Html->url(array(''));
		$options['actions'] = (isset($options['actions'])) ? $options['actions'] : $this->getDefaultActions($modelName);
		
		$options['columns'] = (isset($options['columns'])) ? $options['columns'] : $this->getDefaultColumns($modelName);
		$options['data'] = (isset($options['data'])) ? $options['data'] : $this->paginate['_rowset'];
		
		// Т.к. я добавил ключи в $actions, для JS их надо выкосить
		$actions = $options['actions'];
		foreach($actions as $type => $array) {
            $actions[$type] = array_values($array);
		}
		
		$html = '
<span id="'.$container_id.'"></span>
<script type="text/javascript">
var '.$container_id.' = null;
$(document).ready(function(){
	var config = {
		container: "#'.$container_id.'",
		columns: '.json_encode(array_values($options['columns'])).',
		data: '.json_encode($options['data']).',
		paging: '.json_encode($paging).',
		settings: {model: "'.$modelName.'", baseURL: "'.$options['baseURL'].'"},
		defaults: '.json_encode($defaults).',
		actions: '.json_encode($actions).'
	};
	'.$container_id.' = new Grid(config);
});
</script>
';
		return $html;
	}

}