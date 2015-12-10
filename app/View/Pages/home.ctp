<div class="outerMain main">

	<?=$this->element('popup')?>
	<?=$this->element('menu')?>

	<div class="pergamentMain" style="display: none">
		<?=$this->element('title', $article['Page'])?>
		<div class="article">
			<?=$this->ArticleVars->body($article)?>
		</div>
	</div>

</div>
<script type="text/javascript">
	$(function(){
		$('.pergamentMain').fadeIn(delay.page);
	});
</script>