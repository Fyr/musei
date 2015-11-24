<?
App::uses('AppHelper', 'View/Helper');
class PHMediaHelper extends AppHelper {
	public $MediaPath;
	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		
		App::uses('MediaPath', 'Media.Vendor');
		$this->MediaPath = new MediaPath();
	}

}
