<div class="outerMain review">

<?=$this->element('popup')?>
<?=$this->element('menu')?>

<div class="wrapper1" style="display: none">
	<?=$this->element('title', array('title' => 'Ваш отзыв сохранен'))?>
	<div class="article">
		Спасибо вам за оставленный отзыв! Надеемся увидеть вас снова в нашем музее.
	</div>
</div>

</div>
<script type="text/javascript">
$(function(){
	$('.wrapper1').fadeIn(delay.page);
});
</script>