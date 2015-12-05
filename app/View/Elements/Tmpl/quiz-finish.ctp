<script id="tmpl-quiz-finish" type="text/x-tmpl">
<div class="wrapper2 win">
	<div class="victorinaName"><div class="inner">Викторина “История края”</div></div>
	<form>
		<div class="clearfix">
			<div class="number">
				Ваш результат: {%=o.score%} / {%=o.totalScore%}<br/>
{%
	if (o.playerPos) {
%}
				Вы поставили новый рекорд!
{%
	}
%}
			</div>
			<div class="currentResults">
{%
	for(var i = 0; i < o.answers.step.length; i++) {
		var _class = '';
		if (i < (o.step - 1)) {
			_class = (o.answers.step[i]) ? 'true' : 'false';
		}
%}
				<span class="item"><span class="{%=_class%}"></span></span>
{%
	}
%}
			</div>
		</div>

		<div class="price">
			<img src="/img/win.png" alt="" />
{%
	if (o.playerPos) {
%}
			<a href="javascript:void(0)" class="btn" onclick="enterPlayerName()">Ввести свое имя!</a>
{%
	} else {
%}
			<a href="javascript:void(0)" class="btn" onclick="showTopPlayers()">Таблица рекордов</a>
{%
	}
%}
		</div>

	</form>
</div>
</script>