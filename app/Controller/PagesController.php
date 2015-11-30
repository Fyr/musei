<?php
App::uses('AppController', 'Controller');
App::uses('AppModel', 'Model');
App::uses('Page', 'Model');
App::uses('Exhibit', 'Model');
App::uses('ExhibitPhoto', 'Model');

class PagesController extends AppController {
	public $name = 'Pages';
	public $uses = array('Page', 'Exhibit', 'ExhibitPhoto', 'Collection', 'CollectionPhoto', 'Exposition');
	public $helpers = array('ArticleVars', 'Media.PHMedia');

	public function home() {
		$article = $this->Page->findBySlug('home');
		$this->set('article', $article);
		$this->currMenu = 'Page';
	}
	
	public function page($slug) {
		$article = $this->Page->findBySlug($slug);
		$this->set('article', $article);
		$this->currMenu = 'Page';
	}

	public function exhibit($slug) {
		$article = $this->Exhibit->findBySlug($slug);
		$this->set('article', $article);

		$conditions = array('ExhibitPhoto.object_id' => $article['Exhibit']['id']);
		$order = 'ExhibitPhoto.sorting';
		$aPhoto = $this->ExhibitPhoto->find('all', compact('conditions', 'order'));
		$this->set('aPhoto', $aPhoto);

		$this->currMenu = 'Exhibit';
	}

	public function collection($slug) {
		$article = $this->Collection->findBySlug($slug);
		$this->set('article', $article);

		$conditions = array('CollectionPhoto.object_id' => $article['Collection']['id']);
		$order = 'CollectionPhoto.sorting';
		$aPhoto = $this->CollectionPhoto->find('all', compact('conditions', 'order'));
		$this->set('aPhoto', $aPhoto);

		$this->currMenu = 'Collection';
		$this->render('exhibit');
	}

	public function exposition($slug) {
		$article = $this->Exposition->findBySlug($slug);
		$this->set('article', $article);

		$aExposition = $this->Exposition->find('all', array('order' => 'Exposition.sorting DESC'));
		$this->set('aExposition', $aExposition);
	}
}
