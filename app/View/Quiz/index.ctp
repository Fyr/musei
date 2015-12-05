<?
	$this->Html->css(array('jquery.formstyler'), array('inline' => false));
	$this->Html->script(array('vendor/jquery/jquery.formstyler.min', 'vendor/tmpl.min', 'vendor/xtmpl', 'vendor/quiz-me'), array('inline' => false));
?>
<body>
	<div class="quiz outerMain">
		<?=$this->element('popup')?>
		<?=$this->element('menu')?>
		<div id="tmpl">
<?
	$aTmpl = array('quiz-start', 'quiz-item', 'quiz-scoring', 'quiz-finish');
	foreach($aTmpl as $tmpl) {
		echo $this->element('/Tmpl/'.$tmpl);
	}
?>
		</div>
		<div class="quizme"></div>
	</div>
	<div id="playerName" class="quizFinish outerMain" style="display: none">
		<div class="wrapper2 records">
			<div class="victorinaName"><div class="inner">Викторина “История края”</div></div>
			<form class="writeReview">
				<div class="nameRecord">Таблица рекордов</div>
				<input type="text" class="styler" value="" placeholder="Введите ваше имя" autocomplete="off" />
				<?=$this->element('keyboard')?>
			</form>
		</div>
	</div>
	<div id="topPlayers" class="quizFinish outerMain"></div>
<script type="text/javascript">
function enterPlayerName() {
	$('.quizme').hide();
	$('#playerName').show();
	console.log('enterPlayerName');
}

function showTopPlayers() {
	console.log('showTopPlayers');
	$.get('<?=Router::url(array('action' => 'topPlayers'))?>', null, function(response){
		$('.quizme').hide();
		$('#playerName').hide();
		$('#topPlayers').html(response);
	});
}

var CustomQuiz = function() {
	var self = this;

	extend(this, QuizMe);

	this.render = function() {
		self.parent.render();
		$('input').styler({});
	}
}

$(function(){
	$('input').styler({});

	$('.keyboard button').click(function(){
		$.post('<?=Router::url(array('controller' => 'ajax', 'action' => 'savePlayer.json'))?>', {data: {player_name: $('#playerName input').val(), score: quiz.score}}, function(response){
			showTopPlayers();
		});
	});

	var quizCfg = {
		container: '.quizme', // контейнер для элементов викторины
		// delay: 1000, // пауза после ответа
		start: {
			tpl: 'quiz-start' // шаблон стартовой страницы, здесь можно доработать и добавить анимацию
		},
		quiz: [ // Вопросы викторины
<?
	foreach($aQuiz as $article) {
		$options = explode(',', str_replace(array("\r\n", "\n"), ',', trim($article['Quiz']['options'])));
		$media = $article['Media'];
?>
			{
				tpl: 'quiz-item',
				q: '<?=$article['Quiz']['title']?>',
				q_body: '<?=str_replace(array("\r\n", "\n"), '', $article['Quiz']['body'])?>',
				q_img: '<?=$this->PHMedia->MediaPath->getImageUrl('Quiz', $media['id'], 'noresize', $media['file'].$media['ext'])?>',
				options: [
<?
		foreach($options as $i => $option) {
			$correct = ($i == $article['Quiz']['correct']);
?>
					{text: '<?=$option?>', correct: <?=($correct) ? 'true' : 'false'?>, score: <?=($correct) ? '1' : '0'?>},
<?
		}
?>
				],
			},
<?
	}
?>
		],
		scoring: {
			tpl: 'quiz-scoring',
			animate: function() {
				setTimeout(function(){
					$.post('<?=Router::url(array('controller' => 'Ajax', 'action' => 'scoring.json'))?>', {data: {score: quiz.score}}, function(response){
						quiz.playerPos = response.data.pos;
						quiz.finish();
					});
				}, 3000);
			}
		},
		finish: {
			tpl: 'quiz-finish'
		}
	};
	quiz = new CustomQuiz();
	quiz.init(quizCfg);
	quiz.playerPos = 0;
});

</script>
</body>