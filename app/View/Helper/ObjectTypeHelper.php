<?php
App::uses('AppHelper', 'View/Helper');
class ObjectTypeHelper extends AppHelper {
    public $helpers = array('Html');
    
    private function _getTitles() {
        $Titles = array(
            'index' => array(
                'Article' => __('Articles'),
                'Page' => __('Static pages'),
                'Exhibit' => __('Exhibits'),
                'ExhibitPhoto' => __('Exhibit Photos'),
                'Collection' => __('Collections'),
                'CollectionPhoto' => __('Collection Photos'),
                'User' => __('Users'),
                'Exposition' => __('Expositions'),
                'Quiz' => __('Quiz'),
            ), 
            'create' => array(
                'Article' => __('Create Article'),
                'Page' => __('Create Static page'),
                'Exhibit' => __('Create Exhibit'),
                'ExhibitPhoto' => __('Create Exhibit Photo'),
                'Collection' => __('Create Collection'),
                'CollectionPhoto' => __('Create Collection Photo'),
                'User' => __('Create User'),
                'Exposition' => __('Create Exposition'),
                'Quiz' => __('Create Quiz'),
            ),
            'edit' => array(
                'Article' => __('Edit Article'),
                'Page' => __('Edit Static page'),
                'Exhibit' => __('Edit Exhibit'),
                'ExhibitPhoto' => __('Edit Exhibit Photo'),
                'Collection' => __('Edit Collection'),
                'CollectionPhoto' => __('Edit Collection Photo'),
                'User' => __('Edit User'),
                'Exposition' => __('Edit Exposition'),
                'Quiz' => __('Edit Quiz')
            ),
            'view' => array(
            	'Article' => __('View Article'),
            )
        );
        return $Titles;
    }
    
    public function getTitle($action, $objectType) {
        $aTitles = $this->_getTitles();
        return (isset($aTitles[$action][$objectType])) ? $aTitles[$action][$objectType] : $aTitles[$action]['Article'];
    }
    
    public function getBaseURL($objectType, $objectID = '') {
        return $this->Html->url(array('action' => 'index', $objectType, $objectID));
    }
}