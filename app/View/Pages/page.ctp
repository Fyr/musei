<div class="outerMain about">

<?=$this->element('popup')?>
<?=$this->element('menu')?>

<div class="wrapper1" style="display: none;">
	<?=$this->element('title', $article['Page'])?>
	<div class="article mCustomScroller">
		<?=$this->ArticleVars->body($article)?>
	</div>
</div>

</div>
<script type="text/javascript">
$(function(){
	$('.wrapper1').fadeIn(delay.page);
});
</script>