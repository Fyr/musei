<script id="tmpl-quiz-scoring" type="text/x-tmpl">
<div class="wrapper2 win">
	<div class="victorinaName"><div class="inner">Викторина “История края”</div></div>
	<form>
		<div class="clearfix">
			<div class="number">Подсчет результатов...</div>
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
			<img src="/img/ajax_loader_big3.gif" alt="" />
			<img src="/img/ajax_loader_big3.gif" alt="" />
			<img src="/img/ajax_loader_big3.gif" alt="" />
		</div>

	</form>
</div>
</script>