<div class="wrapper2 records">
	<div class="victorinaName"><div class="inner">Викторина “История края”</div></div>
	<div class="nameRecord">Таблица рекордов</div>
<?
	foreach($aResults as $row) {
		$row = $row['QuizResult'];
?>
		<div class="itemList clearfix">
			<div class="name"><span class="value"><?=$row['player_name']?></span> <span class="date"><?=$this->PHTime->niceShort($row['created'])?></span></div>
			<div class="result"><?=$row['score']?><span class="all">/<?=$total?></span></div>
		</div>
		<br/>
<?
	}
?>
</div>
