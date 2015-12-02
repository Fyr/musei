<?
	$this->Html->css('jquery.formstyler', array('inline' => false));
	$this->Html->script('vendor/jquery/jquery.formstyler.min', array('inline' => false));
?>
<body class="review">

<?=$this->element('popup')?>
<?=$this->element('menu')?>

<div class="wrapper3">
	<div class="bottomUzor">
		<form action="" method="post">
			<div class="clearfix">
				<div class="writeReview">
					<?=$this->element('title', array('title' => 'Ваше имя и отзыв'))?>
					<input type="hidden" name="data[Feedback][published]" value="1" />
					<input type="text" class="styler" placeholder="Ваше имя" name="data[Feedback][title]" value="" autocomplete="off" />
					<textarea class="styler mCustomScroller-mini" placeholder="Отзыв" name="data[Feedback][body]" aria-autocomplete="none"></textarea>
					<div class="bottomButtons clearfix">
						<input type="button" value="Сохранить отзыв" class="styler left" onclick="onSubmitForm()" />
						<!-- input type="reset" value="Удалить" class="styler empty right" /-->
					</div>
				</div>
				<div class="inputDates">
					<?=$this->element('title', array('title' => 'Введите данные'))?>
					<?=$this->element('keyboard')?>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
function onSubmitForm() {
	$('.writeReview input, .writeReview textarea').removeClass('error');

	if (!$('.writeReview input:first').val()) {
		$('.writeReview input:first').addClass('error');
	}
	if (!$('.writeReview textarea').val()) {
		$('.writeReview textarea').addClass('error');
	}

	if (!$('.writeReview .error').length) {
		$('.wrapper3 form').submit();
	}
}
$(function(){
	$('input').styler({});
});
</script>
