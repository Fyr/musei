Format = {
	tag: function(tagName, attrs, innerHtml) {
		var html = '<' + tagName;
		for(var i in attrs) {
			html+= ' ' + i + '="' + attrs[i] + '"';
		}
		if (innerHtml) {
			html+= '>' + innerHtml + '</' + tagName + '>';
		} else {
			html+= '/>';
		}
		return html;
	},
	img: function(attrs) {
		if (typeof(attrs) == 'string') {
			attrs = {src: attrs, alt: ''}
		}
		return Format.tag('img', attrs);
	},
	fileSize: function(bytes) {
		var sizes = ['', 'Kb', 'Mb', 'Gb'];
		var value = bytes;
		for (var i = 0; i < sizes.length; i++) {
			if (value < 1024) {
				return Math.round(value * 10, 1) / 10 + sizes[i];
			}
			value = value / 1024;
		}
		return value;
	}
}