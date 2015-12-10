<?
	$this->Html->css('bookblock', array('inline' => false));
	$this->Html->script(array('vendor/jquery/jquery.dotdotdot', 'vendor/modernizr.custom', 'vendor/jquery/jquery.bookblock', 'page'), array('inline' => false));
?>
<div class="outerMain review">

	<?=$this->element('popup')?>
	<?=$this->element('menu')?>

	<div class="wrapper3">
		<div id="bb-bookblock" class="bb-bookblock">

<?
	$count = 0;
	for($count = 0; $count < count($aRows); $count+=6) {
?>
			<div class="bb-item">
				<div class="clearfix">
					<div class="leftSide">
<?
		for ($i = 0; ($i + $count) < count($aRows) && $i < 3; $i++) {
			$article = $aRows[$i + $count];
			echo $this->element('feedback', compact('article'));
		}
?>
					</div>
					<div class="rightSide">
<?
		for ($i = 3; ($i + $count) < count($aRows) && $i < 6; $i++) {
			$article = $aRows[$i + $count];
			echo $this->element('feedback', compact('article'));
		}
?>
					</div>
				</div>
			</div>
<?
	}
?>
		</div>

		<a id="bb-nav-prev" href="javascript: void(0)"></a>
		<a id="bb-nav-next" href="javascript: void(0)"></a>

	</div>

	<div class="modal fullReview" style="display: none">
		<a href="#" class="close"></a>
	</div>
</div>
<script type="text/javascript">
$(function(){
	initPage();
	$('.wrapper3').hide();
	$('.wrapper3').fadeIn(delay.page);
});
</script>