<?=$this->element('admin_title', array('title' => __('Utils')))?>
<div class="span8 offset2">
<?=$this->element('admin_content')?>
<?
	$backURL = $this->Html->url(array('plugin' => '', 'controller' => 'AdminUtils', 'action' => 'index'));
	$aURL = array(
		__('Generate static labels') => array('plugin' => 'translate', 'controller' => 'index', 'action' => 'generate'),
		__('Clean image cache') => array('controller' => 'AdminUtils', 'action' => 'cleanImageCache')
	);
	foreach($aURL as $title => $url) {
		echo $this->Html->link($title, $url, array('class' => 'btn btn-primary')).'&nbsp;';
	}
?>
<?=$this->element('admin_content_end')?>
</div>