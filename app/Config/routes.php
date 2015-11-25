<?php
Router::parseExtensions('json');
/*
Router::connectNamed(
    array('page' => '[\d]+'),
    array('default' => false, 'greedy' => false)
);
*/
Router::connect('/', array('controller' => 'Admin', 'action' => 'index'));
Router::connect('/pages/view/:slug.html', 
	array(
		'controller' => 'pages', 
		'action' => 'view',
	),
	array(
		'pass' => array('slug')
	)
);
/*
Router::connect('/articles/:slug.html', 
	array(
		'controller' => 'Articles', 
		'action' => 'view',
		'objectType' => 'SiteArticle'
	),
	array(
		'pass' => array('slug')
	)
);
Router::connect('/articles/page/:page', array(
	'controller' => 'Articles', 
	'action' => 'index',
	'objectType' => 'SiteArticle'
));
Router::connect('/articles/', array(
	'controller' => 'Articles', 
	'action' => 'index',
	'objectType' => 'SiteArticle'
)
);
Router::connect('/articles', array(
	'controller' => 'Articles', 
	'action' => 'index',
	'objectType' => 'SiteArticle'
)
);
*/
/*
Router::connect('/news/:slug.html', 
	array(
		'controller' => 'Articles', 
		'action' => 'view',
		'objectType' => 'News'
	),
	array(
		'pass' => array('slug')
	)
);
Router::connect('/news/page/:page', array(
	'controller' => 'Articles', 
	'action' => 'index',
	'objectType' => 'News'
));
Router::connect('/news/', array(
	'controller' => 'Articles', 
	'action' => 'index',
	'objectType' => 'News'
));
Router::connect('/news', array(
	'controller' => 'Articles', 
	'action' => 'index',
	'objectType' => 'News'
));
*/

Router::connect('/articles', array(
		'controller' => 'Articles', 
		'action' => 'index',
		'objectType' => 'SiteArticle',
	),
	array('named' => array('page' => 1))
);
Router::connect('/articles/:slug', 
	array(
		'controller' => 'Articles', 
		'action' => 'view',
		'objectType' => 'SiteArticle'
	),
	array('pass' => array('slug'))
);
Router::connect('/articles/page/:page', array(
	'controller' => 'Articles', 
	'action' => 'index',
	'objectType' => 'SiteArticle'
),
	array('named' => array('page' => '[\d]*'))
);

Router::connect('/news', array(
		'controller' => 'Articles', 
		'action' => 'index',
		'objectType' => 'News',
	),
	array('named' => array('page' => 1))
);
Router::connect('/news/:slug', 
	array(
		'controller' => 'Articles', 
		'action' => 'view',
		'objectType' => 'News'
	),
	array('pass' => array('slug'))
);
Router::connect('/news/page/:page', array(
	'controller' => 'Articles', 
	'action' => 'index',
	'objectType' => 'News'
),
	array('named' => array('page' => '[\d]*'))
);

Router::connect('/logo', 
	array(
		'controller' => 'SiteProducts', 
		'action' => 'index',
		'objectType' => 'Product',
	),
	array('named' => array('page' => 1))
);
Router::connect('/logo/:category', 
	array(
		'controller' => 'SiteProducts', 
		'action' => 'index',
		'objectType' => 'Product',
	),
	array('pass' => array('category'))
);
Router::connect('/logo/page/:page', 
	array(
		'controller' => 'SiteProducts', 
		'action' => 'index',
		'objectType' => 'Product',
	),
	array('named' => array('page' => '[\d]*'))
);
Router::connect('/logo/:category/page/:page', 
	array(
		'controller' => 'SiteProducts', 
		'action' => 'index',
		'objectType' => 'Product',
	),
	array(
		'pass' => array('category'),
		'named' => array('page' => '[\d]*')
	)
);
Router::connect('/logo/:category/:slug', 
	array(
		'controller' => 'SiteProducts', 
		'action' => 'view',
		'objectType' => 'Product',
	),
	array('pass' => array('slug'))
);
Router::connect('/logo/:category/:slug/:media', 
	array(
		'controller' => 'SiteProducts', 
		'action' => 'download',
		'objectType' => 'Product',
	),
	array('pass' => array('slug', 'media'))
);


CakePlugin::routes();

require CAKE.'Config'.DS.'routes.php';
