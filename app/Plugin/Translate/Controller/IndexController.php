<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
class IndexController extends AdminController {
	public $name = 'Index';
	public $uses = array();
	
	public $msgFile = '', $count = 0;
	
	public function _process($fname, $path, $aParams = array()) {
		$file = file_get_contents($path.$fname);
		$msgFile = file_get_contents($this->msgFile);
		preg_match_all('/__\(\'([\w\s\d\%\,\.\!\-]+)\'\)/', $file, $matches);
		if (isset($matches[1]) && $matches[1]) {
			echo $path.$fname.' - '.count($matches[1]).'<br>';
			foreach($matches[1] as $phrase) {
				if (strpos($msgFile, $phrase) === false) {
					// добавить метку в файл
					$this->count++;
					file_put_contents($this->msgFile, 'msgid "'.$phrase.'"'."\r\n".'msgstr "'.Configure::read('Config.language').':'.$phrase.'!"'."\r\n\r\n", FILE_APPEND);
					$msgFile = file_get_contents($this->msgFile);
					
					echo $phrase."<br>";
				}
			}
			echo "<br>";
		}
	}
	
	public function generate() {
		set_time_limit(600);

		$this->autoRender = false;
		App::uses('Path', 'Core.Vendor');
		
		Configure::write('Config.language', 'rus');
		$msgFile = '../Locale/'.Configure::read('Config.language').'/LC_MESSAGES/default.';
		$this->msgFile = $msgFile.'po';
		file_put_contents($msgFile.'bak', file_get_contents($msgFile.'po'), false);
		
		Path::process(Path::dirContent('../'), array($this, '_process'), true);
		echo $this->count.' label(s) processed';
	}
}
