<?
    $this->Html->script('admin_tabs', array('inline' => false));
?>
<ul class="nav nav-tabs">
<?
	if (!isset($active)) {
		list($active) = array_keys($aTabs); // activate 1st tab
	}
	foreach($aTabs as $tab => $content) {
		$class = (isset($active) && $active == $tab) ? ' class="active"' : '';
?>
	<li id="tab-<?=Inflector::slug($tab)?>"<?=$class?>><a href="javascript:void(0)"><?=__($tab)?></a></li>
<?
	}
?>
</ul>
<?=$this->element('admin_content')?>
<div class="tab-content-all">
<?
	$i = 0;
	foreach($aTabs as $tab => $content) {
		$i++;
		$class = (isset($active) && $active == $tab) ? ' active' : '';
?>
	<div class="tab-content<?=$class?>" id="tab-content-<?=Inflector::slug($tab)?>"><?=$content?></div>
<?
	}
?>
</div>
<?=$this->element('admin_content_end')?>