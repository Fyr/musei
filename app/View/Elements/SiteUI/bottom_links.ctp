			
<?
	foreach($aBottomLinks as $id => $item) {
		$options = array();
		if (strtolower($id) == strtolower($currMenu)) {
			$options['class'] = 'active';
		}
?>
				<?=$this->Html->link($item['label'], $item['href'], $options)?>
<?
	}
?>
