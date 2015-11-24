			<a href="#" class="brand">CMS <?=DOMAIN_TITLE?></a>
			<ul class="nav nav-pills">
				<li class="divider-vertical"></li>
<?
	foreach($aNavBar as $id => $item) {
		$class = array();
		$linkOptions = array();
		$label = $item['label'];
		$url = '#';
		if (isset($item['submenu'])) {
			$class[] = 'dropdown';
			$label.= ' <b class="caret"></b>';
			$linkOptions = array('escape' => false, 'class' => "dropdown-toggle", 'data-toggle' => "dropdown");
		} else {
			$url = $this->Html->url($item['href']);
		}
		if ($id == $currMenu) {
			$class[] = 'active';
		}
?>
				<li class="<?=implode(' ', $class)?>">
<?
		echo $this->Html->link($label, $url, $linkOptions);
		echo '<ul class="dropdown-menu">';
		if (isset($item['submenu'])) {
			foreach($item['submenu'] as $_item) {
				echo '<li>'.$this->Html->link($_item['label'], $_item['href']).'</li>';
			}
		}
		echo '</ul>';
?>
				</li>
<?
	}
?>
				<li class="divider-vertical"></li>
			</ul>