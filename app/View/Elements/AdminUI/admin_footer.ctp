	<div>
		<a href="/admin/">Admin Home</a>
<?
	foreach($aBottomLinks as $_curr => $link) {
		echo ' | '.$this->Html->link($link['label'], $link['href'], ($currLink == strtolower($_curr)) ? array('class' => 'active') : null);
	}
?>
	</div>
	<div class="small-text">
		<?=__('CMS Development')?> - PHPPainKiller.ru
	</div>
