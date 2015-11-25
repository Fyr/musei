<?php
App::uses('AdminController', 'Controller');
App::uses('Article', 'Article.Model');
App::uses('Media', 'Media.Model');
App::uses('Page', 'Model');
App::uses('Exhibit', 'Model');
App::uses('ExhibitPhoto', 'Model');
App::uses('Collection', 'Model');
App::uses('CollectionPhoto', 'Model');
class AdminContentController extends AdminController {
    public $name = 'AdminContent';
    public $components = array('Article.PCArticle');
    public $uses = array('Media.Media', 'Article.Article', 'Page', 'Exhibit', 'ExhibitPhoto', 'Collection', 'CollectionPhoto', 'Quiz');

	public function beforeFilter() {
		parent::beforeFilter();
        $aOptions[] = array();
        foreach(array('Exhibit', 'Collection') as $objectType) {
            $aOptions[$objectType.'Photo'] = $this->{$objectType}->getOptions();
        }
        $this->set('aOptions', $aOptions);
		//$this->set('aExhibitOptions', $this->Exhibit->getOptions());
        //$this->set('aCollectionOptions', $this->Collection->getOptions());
	}
    
    public function index($objectType, $objectID = '') {
        $this->paginate = array(
            'Page' => array(
            	'fields' => array('title', 'slug')
            ),
        	'Exhibit' => array(
        		'fields' => array('created', 'title', 'slug', 'published', 'sorting'),
				'order' => array('Exhibit.sorting' => 'ASC')
        	),
        	'ExhibitPhoto' => array(
				'conditions' => array('ExhibitPhoto.object_id' => $objectID),
        		'fields' => array('created', 'title', 'published', 'sorting'),
				'order' => array('ExhibitPhoto.sorting' => 'ASC')
        	),
            'Collection' => array(
                'fields' => array('created', 'title', 'slug', 'published', 'sorting'),
                'order' => array('Collection.sorting' => 'ASC')
            ),
            'CollectionPhoto' => array(
                'conditions' => array('CollectionPhoto.object_id' => $objectID),
                'fields' => array('created', 'title', 'published', 'sorting'),
                'order' => array('CollectionPhoto.sorting' => 'ASC')
            ),
            'Exposition' => array(
                'fields' => array('created', 'title', 'slug', 'published', 'sorting'),
                'order' => array('Exposition.sorting' => 'ASC')
            ),
            'Quiz' => array(
                'fields' => array('title', 'published', 'sorting'),
                'order' => array('Quiz.sorting' => 'ASC')
            ),
        );
        
        $aRowset = $this->PCArticle->setModel($objectType)->index();

		if ($objectType == 'ExhibitPhoto' || $objectType == 'CollectionPhoto') {
			$ids = Hash::extract($aRowset, "{n}.$objectType.id");
			$aMedia = $this->Media->getList(array('Media.media_type' => 'image', 'Media.object_type' => $objectType, 'Media.object_id' => $ids, 'Media.main' => 1));
			$aMedia = Hash::combine($aMedia, '{n}.Media.object_id', '{n}.Media');
			foreach($aRowset as &$row) {
				$id = $row[$objectType]['id'];
				$row['Media'] = $aMedia[$id];
			}
		}
        $this->set('objectType', $objectType);
        $this->set('objectID', $objectID);
        $this->set('aRowset', $aRowset);

		$this->currMenu = $objectType;
    }
    
	public function edit($id = 0, $objectType = '', $objectID = '') {
		if (!$id) {
			// если не задан ID, то objectType+ObjectID должны передаваться
			$this->request->data('Article.object_type', $objectType);
            if ($objectID) {
                $this->request->data('Article.object_id', $objectID);
            }
		}
		
		$this->PCArticle->edit(&$id, &$lSaved);
		$objectType = $this->request->data('Article.object_type');
		$objectID = $this->request->data('Article.object_id');
		
		if ($lSaved) {
			$indexRoute = array('action' => 'index', $objectType, $objectID);
			$editRoute = array('action' => 'edit', $id);
			return $this->redirect(($this->request->data('apply')) ? $indexRoute : $editRoute);
		}

		if (!$this->request->data('Article.sorting')) {
			$this->request->data('Article.sorting', '0');
			$this->request->data('Article.status', 'published');
		}
		
		$this->currMenu = $objectType;
	}
}
