<div class="outerMain about">

	<?=$this->element('popup')?>
	<?=$this->element('menu')?>

	<div class="wrapper1" style="display: none">
		<?=$this->element('title', $article['Exposition'])?>
		<div class="article mCustomScroller">
			<?=$this->ArticleVars->body($article)?>
		</div>
	</div>

	<div class="exhibitions mCustomScroller-mini">
<?
	foreach($aExposition as $article) {
		$media = $article['Media'];
?>
		<a href="<?=Router::url(array('action' => 'exposition', $article['Exposition']['slug']))?>" class="item">
			<div class="outerImg"><img src="<?=$this->PHMedia->MediaPath->getImageUrl('Exposition', $media['id'], '220x', $media['file'].$media['ext'])?>" alt=""/></div>
			<div class="date"><?=$article['Exposition']['options']?>5</div>
			<div class="title"><?=$article['Exposition']['title']?></div>
		</a>
<?
	}
?>
	</div>

</div>

<script type="text/javascript">
$(function(){
	$('.wrapper1').fadeIn(delay.page);
});
</script>