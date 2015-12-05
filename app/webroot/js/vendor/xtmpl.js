var Tmpl = function(tpl) {
	var self = this;
	
	this.loadModules = function(aModules, successFn) {
		self.modules = 0;
		self.aModules = aModules;
		self.successFn = successFn;
		
		if (!$('body #tmpl').length) {
			$('body').append('<div id="tmpl" />');
		}
		
		for(var i = 0; i < aModules.length; i++) {
			self.load(aModules[i]);
		}
	};
	
	this.load = function(module) {
		$.get('./tmpl/' + module + '.tmpl', null, function(html){
			// если надо склеить 2 tmpl в 1 - можно сделать через поиск и замену <!-- Section: -->
			
			if (html.indexOf('<!-- Template') > -1) {
				html = html.replace(/<!-- Template: ([a-zA-Z0-9_\-]+) -->/g, '<script type="text/x-tmpl" id="tmpl-$1">');
				html = html.replace(/<!-- end -->/g, '</script>');
				html = html.replace(/include\(\'/g, 'include(\'tmpl-');
				html = html.replace(/include\(\"/g, 'include(\"tmpl-');
			} else {
				html = '<script type="text/x-tmpl" id="tmpl-' + module + '">' + html + '</script>';
			}
			$('#tmpl').append(html);
			self.modules++;
			if (self.modules >= self.aModules.length) {
				for(i = 0; i < self.aModules.length; i++) {
					var _module = self.aModules[i];
					if ($('.tmpl-' + _module).length) {
						$('.tmpl-' + _module).html(tmpl('tmpl-' + _module, {}));
					}
				}
				
				if (self.successFn) {
					self.successFn();
				}
			}
		}, 'html');
	};
	
	this.render = function(tpl, params) {
		if (!document.getElementById('tmpl-' + tpl)) {
			throw 'Tmpl: You must load `' + tpl + '` template';
		}
		return tmpl('tmpl-' + tpl, (params) ? params : {});
	};
	
	if (tpl) {
		return { render: function(params){ return self.render(tpl, params); } };
	}
	return this;
};
