			<p class="navbar-text text-right small-text right-bottom">
				<a href="<?=$this->Html->url(array('plugin' => '', 'controller' => 'admin', 'action' => 'index'))?>" rel="tooltip-bottom" title="<?=__('Admin Home Page')?>" class="navbar-link"><i class="icon-home"></i><span><?=__('Dashboard')?></span></a> |
				<a href="/" rel="tooltip-bottom" title="<?=__('Open Home page of Front-end in a new tab')?>" target="_blank" class="navbar-link"><i class="icon-globe"></i><span><?=__('Go to Site')?></span></a> |
				<a href="<?=$this->Html->url(array('plugin' => '', 'controller' => 'adminAuth', 'action' => 'logout'))?>" rel="tooltip-bottom" title="<?=__('Log out')?>" class="navbar-link"><i class="icon-off"></i><span><?=__('Log out')?></span></a>
			</p>