<?php
Router::parseExtensions('json');

Router::connect('/', array('controller' => 'Pages', 'action' => 'home'));
Router::connect('/Pages/page/home', array('controller' => 'Pages', 'action' => 'home'));
Router::connect('/Pages/page/history', array('controller' => 'Pages', 'action' => 'history'));

CakePlugin::routes();

require CAKE.'Config'.DS.'routes.php';
