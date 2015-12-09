function extend(self, fnObj) {
	fnObj.call(self);

	self.parent = {};
	for(var prop in self) {
		if (typeof(self[prop]) == 'function') {
			self.parent[prop] = self[prop];
		}
	}
}

var QuizMe = function(cfg) {
	var self = this, $self;
	
	this.init = function(cfg) {
		self.config = cfg;
		$self = $(cfg.container);
		self.step = 0;
		self.totalSteps = self.getTotalSteps();
		self.score = 0;
		self.answers = {correct: 0, incorrect: 0, total: 0, step: new Array(self.totalSteps)};
		self.totalScore = self.getTotalScore();
		console.log('init', $self);
		self.run();
	}
	
	this.run = function() {
		if (self.config.start) {
			$self.html(Tmpl(self.config.start.tpl).render(self));
		} else {
			self.next();
		}
	}
	
	this.start = function() {
		self.next();
	}
	
	this.render = function() {
		var quiz = self.config.quiz[self.step - 1];
		self.quiz = quiz;
		$self.html(Tmpl(quiz.tpl).render(self));
	}
	
	this.next = function() {
		var _next = function() {
			self.step++;
			if (self.step <= self.totalSteps) {
				self.render();
			} else {
				self.scoring();
			}
		}
		if (self.config.delay) {
			setTimeout(_next, self.config.delay);
		} else {
			_next();
		}
	}
	
	this.scoring = function() {
		if (self.config.scoring) {
			$self.html(Tmpl(self.config.scoring.tpl).render(self));
			if (self.config.scoring.animate) {
				self.config.scoring.animate();
			}
		} else {
			self.finish();
		}
	}
	
	this.finish = function() {
		if (self.config.finish) {
			$self.html(Tmpl(self.config.finish.tpl).render(self));
		}
	}
	
	this.checkAnswer = function(i) {
		var quiz = self.config.quiz[self.step - 1];
		var answer = quiz.options[i];
		if (answer.correct) {
			self.answers.correct++;
			self.answers.total++;
			self.answers.step[self.step - 1] = answer.score;
			self.score+= answer.score;
		} else {
			self.answers.incorrect++;
			self.answers.total++;
			self.answers.step[self.step - 1] = 0;
		}

		var _nextFn = function() {
			if (quiz.behaviour && !answer.correct) {
				if (quiz.behaviour.untilRight) {
					return;
				}
				if (quiz.behaviour.showRight && quiz.animation.right) {
					for(var j = 0; j < quiz.options.length; j++) {
						if (quiz.options[j].correct) {
							break;
						}
					}
					$('#a' + j).addClass('answer-right');
					self.animate('#a' + j, quiz.animation.right, 0, self.next);
					return;
				} else {
					self.next();
				}
				return;
			} else {
				self.next();
			}
		}
		if (quiz.animate) {
			quiz.animate(i, quiz.options);
			return;
		} else if (quiz.animation) {
			if (!answer.correct && quiz.animation.wrong) {
				$('#a' + i).addClass('answer-wrong');
				self.animate('#a' + i, quiz.animation.wrong, 0, _nextFn);
				return;
			} else if (answer.correct && quiz.animation.right) {
				$('#a' + i).addClass('answer-right');
				self.animate('#a' + i, quiz.animation.right, 0, self.next);
				return;
			}
		}
		_nextFn();
	}
	
	this.animate = function(e, effects, i, fnNext) {
		var effect = effects[i];
		if (effect.type == 'animate') {
			$(e).animate(effect.options, effect.duration, null, function(){
				if (++i < effects.length) {
					self.animate(e, effects, i, fnNext);
				} else if (fnNext){
					fnNext();
				}
			});
		} else {
			$(e).effect(effect.type, effect.options, effect.duration, function(){
				if (++i < effects.length) {
					self.animate(e, effects, i,fnNext);
				} else if (fnNext){
					fnNext();
				}
			});
		}
	}
	
	this.getTotalSteps = function() {
		return self.config.quiz.length;
	}
	
	this.getTotalScore = function() {
		var quiz = self.config.quiz;
		var total = 0;
		for (var i = 0; i < quiz.length; i++) {
			for(var j = 0; j < quiz[i].options.length; j++) {
				total+= quiz[i].options[j].score;
			}
		}
		return total;
	}
	
	this.back = function() {
		self.step--;
		self.render();
	}
	
	// this.init(cfg);
}
