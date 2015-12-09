<?
	$this->Html->css(array('jquery.formstyler'), array('inline' => false));
	$aScripts = array(
		'vendor/jquery/jquery-ui.effects.min',
		'vendor/jquery/jquery.formstyler.min',
		'vendor/tmpl.min',
		'vendor/xtmpl',
		'vendor/quiz-me'
	);
	$this->Html->script($aScripts, array('inline' => false));
?>

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
		
		<div class="wrapper2 records" id="playerName" style="display: none">
			<?=$this->element('quiz-title')?>
			<form class="writeReview">
				<div class="nameRecord">Таблица рекордов</div>
				<input type="text" class="styler" value="" placeholder="Введите ваше имя" autocomplete="off" />
				<?=$this->element('keyboard')?>
			</form>
		</div>
		
		<div class="wrapper2 records" id="topPlayers" style="display: none;"></div>
		
	</div>

<script type="text/javascript">
function enterPlayerName() {
	console.log('enterPlayerName');
	$('.quizme').fadeOut(delay.quiz.next, function(){
		setTimeout(function(){
			$('.outerMain').removeClass('quiz').addClass('quizFinish');
			$('#playerName').fadeIn(delay.quiz.next);
		}, 10);
	});
}

function showTopPlayers() {
	$.get('<?=Router::url(array('action' => 'topPlayers'))?>', null, function(response){
		if ($('#playerName:visible').length) {
			$('#playerName').fadeOut(delay.quiz.next, function(){
				setTimeout(function(){
					$('.outerMain').removeClass('quiz').addClass('quizFinish');
					$('#topPlayers').html(response);
					$('#topPlayers').fadeIn(delay.quiz.next);
				}, 10);
			});
		} else {
			$('.quizme').fadeOut(delay.quiz.next, function(){
				setTimeout(function(){
					$('.outerMain').removeClass('quiz').addClass('quizFinish');
					$('#topPlayers').html(response);
					$('#topPlayers').fadeIn(delay.quiz.next);
				}, 10);
			});
		}
	});
}

var CustomQuiz = function() {
	var self = this, $self;

	extend(this, QuizMe);

	this.run = function() {
		if (self.config.start) {
			$('.quizme').html(Tmpl(self.config.start.tpl).render(self));
			$('.result').fadeIn(delay.quiz.start);
		} else {
			self.next();
		}
	}

	this.render = function() {
		var _next = function(){
			self.parent.render();
			$('input').styler({});
			console.log('render.fadeIn');
			$('.quizme').fadeIn(delay.quiz.next);
		};

		if (self.step > 1) {
			console.log('render.fadeOut');
			$('.quizme').fadeOut(delay.quiz.next, function(){
				setTimeout(function(){
					_next();
				}, 10);
			});
		} else {
			$('.quizme').hide();
			_next();
		}

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
				animation: { // анимация для ответов - стэк эффектов
					// каждый эффект применяется по очереди после предыдущего
					// т.о. их можно комбинировать
					// что задавать для эффектов можно почитать тут:
					// http://api.jqueryui.com/color-animation/
					// http://api.jqueryui.com/category/effects/
					wrong: [
						{type: 'animate', duration: delay.quiz.effects, options: {backgroundColor: "#AA0000", color: "#fff"}},
						{type: 'shake', duration: delay.quiz.effects},
						{type: 'animate', duration: delay.quiz.effects, options: {backgroundColor: "transparent", color: "#62553e"}},
					],
					right: [
						{type: 'animate', duration: delay.quiz.effects, options: {backgroundColor: "#00AA00", color: "#000"}},
						{type: 'pulsate', duration: delay.quiz.effects},
						{type: 'animate', duration: delay.quiz.effects, options: {backgroundColor: "transparent", color: "#62553e"}},
					]
				}
			},
<?
	}
?>
		],
		scoring: {
			tpl: 'quiz-scoring',
			animate: function() {
				console.log('scoring.animate');
				$('.quizme').hide();
				$('.quizme').fadeIn(delay.quiz.next, function(){
					$.post('<?=Router::url(array('controller' => 'Ajax', 'action' => 'scoring.json'))?>', {data: {score: quiz.score}}, function(response){
						quiz.playerPos = response.data.pos;
						$('.quizme').fadeOut(delay.quiz.next, function() {
							setTimeout(function(){
								quiz.finish();
								$('.quizme').fadeIn(delay.quiz.next);
							}, 10);
						});
					});
				});
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
