<?php
App::uses('AdminController', 'Controller');
class AdminContentController extends AdminController {
    public $name = 'AdminContent';
    public $components = array('Article.PCArticle');
    public $uses = array('Article.Article', 'CategoryArticle', 'SubcategoryArticle', 'CarType');
    public $helpers = array('ObjectType');
    
    public function index($objectType, $objectID = '') {
        $this->paginate = array(
            'Page' => array(
            	'fields' => array('title', 'slug')
            ),
        	'News' => array(
        		'fields' => array('created', 'title', 'slug', 'featured', 'published')
        	),
        	'SiteArticle' => array(
        		'fields' => array('created', 'title', 'slug', 'featured', 'published')
        	),
        	'CategoryNews' => array(
        		'fields' => array('title', 'slug', 'sorting'),
        		'order' => array('sorting')
        	),
        	'CategoryArticle' => array(
        		'fields' => array('title', 'slug', 'sorting')
        	),
        	'SubcategoryArticle' => array(
        		'conditions' => array('SubcategoryArticle.cat_id' => $objectID),
        		'fields' => array('id', 'title', 'sorting')
        	),
        	'CategoryProduct' => array(
        		'fields' => array('title', 'slug'),
        	),
        	'Product' => array(
        		'fields' => array('created', 'title', 'slug', 'featured'),
        	),
        );
        
        $aRowset = $this->PCArticle->setModel($objectType)->index();
        $this->set('objectType', $objectType);
        $this->set('objectID', $objectID);
        $this->set('aRowset', $aRowset);
        /*
        if ($objectType == 'SubcategoryArticle') {
        	$this->set('categoryArticle', $this->CategoryArticle->findById($objectID));
        } elseif ($objectType == 'CarSubtype') {
        	$this->set('carType', $this->CarType->findById($objectID));
        }
        */
        if (in_array($objectType, array('CategoryProduct', 'Product'))) {
        	$this->currMenu = 'Catalog';
        }
    }
    
	public function edit($id = 0, $objectType = '', $objectID = '') {
		$this->loadModel('Media.Media');
		
		if (!$id) {
			// если не задан ID, то objectType+ObjectID должны передаваться
			$this->request->data('Article.object_type', $objectType);
			// $this->request->data('Article.object_id', $objectID);
			$this->request->data('Seo.object_type', $objectType);
		}
		
		if ($objectType == 'SubcategoryArticle') {
			$this->request->data('Article.cat_id', $objectID);
		}
		
		// Здесь работаем с моделью Article, т.к. если задавать только $id, 
		// непонятно какую модель загружать, чтобы определить $objectType
		$this->Article->bindModel(array(
			'hasOne' => array(
				'Seo' => array(
					'className' => 'Seo.Seo',
					'foreignKey' => 'object_id',
					'conditions' => array('Seo.object_type' => $objectType),
					'dependent' => true
				)
			)
		), false);
		
		$this->PCArticle->edit(&$id, &$lSaved);
		$objectType = $this->request->data('Article.object_type');
		// $objectID = $this->request->data('Article.object_id');
		
		if ($lSaved) {
			if ($objectType == 'SiteArticle') {
				$subcategory = $this->SubcategoryArticle->findById($this->request->data('Article.subcat_id'));
				$this->request->data('Article.cat_id', $subcategory['CategoryArticle']['id']);
			}
			
			$indexRoute = array('action' => 'index', $objectType, $objectID);
			$editRoute = array('action' => 'edit', $id, $objectType, $objectID);
			return $this->redirect(($this->request->data('apply')) ? $indexRoute : $editRoute);
		}
		
		if ($objectType == 'Product') {
			$this->set('aCategoryOptions', $this->Article->getObjectOptions('CategoryProduct'));
		} elseif ($objectType == 'SiteArticle') {
			$aCategoryOptions = $this->SubcategoryArticle->find('all');
			$aCategoryOptions = Hash::combine($aCategoryOptions, '{n}.SubcategoryArticle.id', '{n}.SubcategoryArticle.title', '{n}.CategoryArticle.title');
			$this->set('aCategoryOptions', $aCategoryOptions);
		} elseif ($objectType == 'SubcategoryArticle') {
			$this->set('categoryArticle', $this->CategoryArticle->findById($objectID));
		}
		
		if (!$this->request->data('Article.sorting')) {
			$this->request->data('Article.sorting', '0');
		}
		
		$this->currMenu = ($objectType == 'Product' || $objectType == 'CategoryProduct') ? 'Catalog' : 'Content';
	}
}
