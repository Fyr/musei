<script id="tmpl-quiz-item" type="text/x-tmpl">
		<div class="wrapper2">
			<?=$this->element('quiz-title')?>
			<form>
				<div class="clearfix">
					<div class="number">{%=o.quiz.q%}</div>
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
				<div class="questionText">{%#o.quiz.q_body%}</div>
				<div class="clearfix">
					<div class="answers">
{%
	for(var i = 0; i < o.quiz.options.length; i++) {
		var item = o.quiz.options[i];
%}
					
						<label id="a{%=i%}">
							<input id="{%=i%}" type="radio" name="qwerty" onchange="console.log($('.answers button').get(0)); $('.answers button').get(0).disabled = false;" />
							<span class="text">{%=item.text%} </span>
						</label>
					
{%
	}
%}
						<div>
							<button type="button" class="btn" disabled="disabled" onclick="quiz.checkAnswer($('input:checked').prop('id'));">Ответить</button>
						</div>
					</div>
{%
	if (o.quiz.q_img) {
%}
					<img src="{%=o.quiz.q_img%}" alt="" class="image" />
{%
	}
%}
				</div>
			</form>
		</div>
</script>
