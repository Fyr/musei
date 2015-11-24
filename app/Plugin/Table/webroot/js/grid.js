/* TODO:
- events and callbacks
- refactor all code into modules (especiially filters)
- replace URL with  param values, not concat
- replace .first with .grid-header
- разобраться с тултипами для фильтра и поля
*/
Grid = function(config) {
	var self = this;

	self.container = config.container;
	var $self = $(config.container);

	self.columns = [];
	self.data = [];
	self.settings = {
		model: '',
		primaryKey: 'id',
		baseURL: window.location.href,
		checkRecords: true,
		showActions: true,
		sort: '',
		direction: '',
		valueDiv: ':',
		paramDiv: '/',
		urlDiv: '/'
	};
	self.paging = {
		curr: 0,
		total: 0,
		count: '',
		limit: 0,
		perPageList: [10, 20, 50, 100, 300, 500, 1000, 2000, 5000, 10000]
	};

	self.actions = {
		table: [
			{class: 'icon-color icon-add', label: 'Add record'},
			{class: 'icon-color icon-filter-settings grid-show-filter', label: 'Show filter settings'}
		],
		row: [
			{class: 'icon-color icon-edit', label: 'Edit record'},
			{class: 'icon-color icon-delete', label: 'Delete record'}
		],
		checked: [
			{class: 'icon-color icon-delete', label: 'Delete checked records'},
		]
	};

	self.filters = {};
	self.defaults = {page: 1, sort: '', direction: 'asc', limit: 10};

	this.init = function(config) {
		self.setData(config.data);
		self.initDefaults(config.defaults);
		self.initSettings(config.settings);
		self.initColumns(config.columns);
		self.initPaging(config.paging);
		self.initActions(config.actions);
		self.initFilters(config.filters);

		self.render();
	}

	this.initColumns = function(columns) {
		self.columns = columns;
		for(var i = 0; i < self.columns.length; i++) {
			var col = self.columns[i];
			if (col.key.indexOf('.') == -1 && self.settings.model) {
				self.columns[i].key = self.settings.model + '.' + col.key;
				// self.columns[i].model = self.settings.model;
			} else {

			}
			if (typeof(col.label) == 'undefined') {
				var key = (self.settings.model) ? self.getModelField(col.key).field : col.key;
				self.columns[i].label = key.ucFirst();
			}
			if (typeof(col.format) != 'undefined') {
				if (col.format == 'boolean' || col.format == 'date' || col.format == 'datetime') {
					self.columns[i].align = 'center';
				} else if (col.format == 'integer' || col.format == 'filesize')  {
					self.columns[i].align = 'right';
				}
			} else {
				self.columns[i].format = 'string';
			}
			if (typeof(col.align) == 'undefined') {
				self.columns[i].align = 'left';
			}
			if (typeof(col.showFilter) == 'undefined') {
				self.columns[i].showFilter = true;
			}
			/*
			if (typeof(col.sort) == 'undefined') {
				self.columns[i].sorting = 'asc';
			}
			*/
			if (typeof(col.showSorting) == 'undefined') {
				self.columns[i].showSorting = true;
			}
		}
	}

	this.initDefaults = function(settings) {
		self.defaults = $.extend(self.defaults, settings);
	}

	this.initSettings = function(settings) {
		self.settings = $.extend(self.settings, self.defaults, self.cookie(), settings);
		/*
		if (!self.settings.model) {
			if (typeof(self.data[0]) != 'undefined') {
				for(var i in self.data[0]) {
					self.settings.model = i;
					break;
				}
			}
		}
		if (!self.settings.model) {
			alert('Cannot determine model from rowset! Please specify model property in config');
		}
		*/
		if (self.settings.primaryKey.indexOf('.') == -1) {
			self.settings.primaryKey = (self.settings.model) ? self.settings.model + '.' + self.settings.primaryKey : 'id';
		}
		if (!self.defaults.sort) {
			self.defaults.sort = self.settings.primaryKey;
		}
		if (!self.settings.sort) {
			self.settings.sort = self.settings.primaryKey;
		}
		if (self.settings.direction) {
			self.settings.direction = self.settings.direction.toLowerCase();
		}
	}

	this.initPaging = function(paging) {
		self.paging = $.extend(self.paging, paging);
		if (!self.paging.curr) {
			self.paging.curr = 1;
		}
		if (!self.paging.limit) {
			self.paging.limit = self.defaults.limit;
		}
	}

	this.initActions = function(actions) {
		self.actions = $.extend(self.actions, actions);

		for(var i in self.actions) {
			for(var j = 0; j < self.actions[i].length; j++) {
				if (typeof(self.actions[i][j].class) == 'undefined') {
					self.actions[i][j].class = '';
				}
                                
				if (typeof(self.actions[i][j].href) == 'undefined') {
					if (self.actions[i][j].class == 'icon-edit') {
						self.actions[i][j].href = self.settings.baseURL + '/edit/{$id}';
					} else if (self.actions[i][j].class == 'icon-add') {
						self.actions[i][j].href = self.settings.baseURL + '/edit/';
					} else if (self.actions[i][j].class == 'icon-delete') {
						self.actions[i][j].href = self.settings.baseURL + '/delete/{$id}';
					} else {
						self.actions[i][j].href = 'javascript:void(0)';
					}
				}
			}
		}
	}

	this.getURLParams = function(){
		var params = {}, col, cols = [], re, url = window.location.href, pos, pairs;
		for(var i = 0; i < self.columns.length; i++) {
			cols.push(self.columns[i].key);
		}
		cols.push('page');
		cols.push('sort');
		cols.push('direction');
		cols.push('limit');
		
		pos = url.indexOf(self.settings.baseURL);
		url = url.substr(pos + self.settings.baseURL.length);
		pos = url.indexOf(self.settings.urlDiv)
		if (pos >= 0) {
			url = url.substr(pos + self.settings.urlDiv.length);
		}
		pairs = url.split(self.settings.paramDiv);
		for(var i = 0; i < pairs.length; i++) {
			col = pairs[i].split(self.settings.valueDiv);
			params[col[0]] = decodeURI(col[1]);
		}
		return params;
	}

	this.initFilters = function(filters) {
		self.filters = $.extend(self.filters, filters);
		var params = self.getURLParams();
		for(var i in params) {
			if (typeof(self.settings[i]) != 'undefined') {
				self.settings[i] = params[i];
			}
		}
		for(var i in params) {
			for(var j = 0; j < self.columns.length; j++) {
				if (self.columns[j].key == i) {
					self.filters[i] = params[i];
				}
			}
		}
	}

	this.setData = function(data) {
		self.data = data;
	}

	this.render = function() {
		var html = '<table class="grid table-bordered shadow">';
		html+= self.renderTableHeader();
		html+= '<tbody>';
		html+= self.renderBody();
		html+= self.renderTableFooter();
		html+= '</tbody></table>';
		$self.html(html);
		
		self.bindAll();
	}

	this.renderTableHeader = function() {
		var html = '<thead>';
		html+= this.renderTableColumns();
		html+= this.renderTableFilter();
		html+= '</thead>';
		return html;
	}

	this.renderTableColumns = function() {
		var html = '<tr class="first table-gradient">';
		html+= '<th><input type="checkbox" rel="tooltip" title="Check All" class="grid-chbx-checkAll"></th>';
		html+= self.renderTableActions();
		html+= self.renderColumns();
		html+= '</tr>';
		return html;
	}

	this.renderTableActions = function() {
		var html = '<th class="nowrap">';
		html+= self.renderActions();
		html+= '</th>';
		return html;
	}

	this.renderActions = function() {
		var html = '';
		for(var i = 0; i < self.actions.table.length; i++) {
			var action = self.actions.table[i];
			html+= '<a class="' + action.class + '" href="' + action.href + '" rel="tooltip" title="' + action.label + '"></a>';
		}
		return html;
	}

	this.renderColumns = function() {
		var html = '';
		for(var i = 0; i < self.columns.length; i++) {
			html+= self.renderTableColumn(self.columns[i]);
		}
		return html;
	}

	this.renderTableColumn = function(col) {
		return '<th class="nowrap" data-grid_col="' + col.key + '">' + self.renderColumn(col) + '</th>';
	}

	this.renderColumn = function(col) {
		var sort = [];
		if (col.showSorting) {
			sort.push('grid-sortable');
			if (self.settings.sort == col.key && (self.settings.direction == 'asc' || self.settings.direction == 'desc')) {
				sort.push('grid-sortable-active');
				sort.push('grid-sortable-' + self.settings.direction);
			}
		} else {
			sort.push('grid-unsortable');
		}
		var html = '<a href="javascript:void(0)" class="' + sort.join(' ') + '">' + col.label + '</a>';
		return html;
	}

	this.renderTableFilter = function() {
		var hide = (!self.settings.showFilter) ? ' hide' : ''
		var html= '<tr class="grid-filter' + hide + '">';
		html+= '<th></th>';
		html+= '<th>';
		html+= '<a class="icon-color icon-accept-filter grid-filter-submit" href="javascript:void(0)" rel="tooltip" title="Apply filter setting"></a>';
		html+= '<a class="icon-color icon-clear-filter grid-filter-clear" href="javascript:void(0)" rel="tooltip" title="Clear filter setting"></a>';
		html+= '</th>';
		for(var i = 0; i < self.columns.length; i++) {
			html+= self.renderTableFilterCell(self.columns[i], self.getFilterParamValue(self.columns[i]));
		}
		html+= '</tr>';
		return html;
	}

	this.getFilterParamValue = function(col) {
		var val = '';
		if (typeof(self.filters[col.key]) != 'undefined') {
			val = self.filters[col.key];
			if (col.format == 'date') {
				val = val.split('-').reverse().join('.');
			}
		}
		return val;
	}

	this.renderTableFilterCell = function(col, val) {
		var html = '<th>';
		if (col.showFilter) {
			if (col.format == 'boolean') {
				html+= self.renderFilterBoolean(col, val);
			} else if (col.format == 'date' || col.format == 'datetime') {
				html+= self.renderFilterDate(col, val);
			} else if (col.format == 'integer') {
				html+= self.renderFilterInteger(col, val);
			} else {
				html+= self.renderFilterString(col, val);
			}
		}
		html+= '</th>';
		return html;
	}
	
	this.getFilterID = function(col) {
		return col.key.replace(/\./g, '-');
	}

	this.renderFilterBoolean = function(col, val) {
		options = {'': '- any -', '1': 'yes', '0': 'no'};
		return self.renderFilterSelect(col, options, val);
	}

	this.renderFilterDate = function(col, val) {
		val = val.split('-').reverse().join('.');
		return '<input type="text" class="grid-filter-input grid-filter-date" name="' + self.getFilterName(col) + '" value="' + val + '">';
	}

	this.renderFilterInteger = function(col, val) {
		return '<input type="text" class="grid-filter-input grid-filter-int" name="' + self.getFilterName(col) + '" value="' + val + '">';
	}

	this.renderFilterString = function(col, val) {
		return Format.tag('input', {
			id: 'grid-filter-' + self.getFilterID(col),
			type: 'text', 
			class: 'big-input grid-filter-input', 
			rel: 'tooltip', 
			name: self.getFilterName(col),
			value: val,
			title: '* - Any characters'
		});
		// return '<input type="text" class="big-input grid-filter-input" rel="tooltip" name="' + self.getFilterName(col) + '" value="' + val + '" title="* - Any characters">';
	}

	this.renderFilterSelect = function(col, options, val) {
		var html = '<select class="input-small grid-filter-input grid-filter-select" name="' + self.getFilterName(col) + '">';
		var selected;
		for (var i in options) {
			selected = (val == i) ? ' selected="selected"' : ''
			html+= '<option value="' + i + '"' + selected + '>' + options[i] + '</option>';
		}
		html+= '</select>';
		return html;
	}

	this.getFilterName = function(col) {
		return 'gridFilter[' + col.key + ']';
	}

	this.cleanFilterName = function(name) {
		return name.replace(/gridFilter/ig, '').replace(/\[/ig, '').replace(/\]/ig, '');
	}

	this.renderBody = function() {
		var html = '';
		if (self.data.length) {
		for(var i = 0; i < self.data.length; i++) {
			html+= '<tr id="row_' + this.getID(self.data[i]) + '" class="grid-row">';
			html+= self.renderRow(self.data[i]);
			html+= '</tr>';
		}
		} else {
			html+= '<tr class="grid-row">';
			html+= '<td class="grid-no-data" colspan="' + self.totalCols() +'">No records found</td>';
			html+= '</tr>';
		}
		return html;
	}
	
	this.totalCols = function() {
	    return self.columns.length + 2;
	}

	this.renderRow = function(rowData) {
		var html = '<td class="text-center"><input type="checkbox" class="grid-chbx-row" name="gridChecked[]" value="' + self.getID(rowData) + '"></td>';
		html+= self.renderTableRowActions(rowData);
		var col;
		for(var i = 0; i < self.columns.length; i++) {
			col = self.columns[i];
			html+= self.renderTableCell(self.getValue(col, rowData), col, rowData);
		}
		return html;
	}

	this.getModelField = function(col_key) {
		var field = col_key.split('.');
		return {model: field[0], field: field[1]};
	}

	this.getValue = function(column, rowData) {
		if (self.settings.model) {
			var col = self.getModelField(column.key);
			return rowData[col.model][col.field];
		}
		return rowData[column.key];
	}

	this.renderTableRowActions = function(rowData) {
		var html = '<td class="nowrap text-center">';
		html+= self.renderRowActions(rowData);
		html+= '</td>';
		return html;
	}

	this.renderRowActions = function(rowData) {
		var html = '';
		for(var i = 0; i < self.actions.row.length; i++) {
			var actionData = self.actions.row[i], action = '';
			if (typeof(actionData) == 'object') {
				action = '<a class="' + actionData.class + '" href="' + actionData.href + '" title="' + actionData.label + '"></a>';
			} else if (typeof(actionData) == 'string') {
				action = actionData;
			}
			html+= self.getRowURL(rowData, action);
		}
		return html;
	}

	this.getID = function(rowData) {
		if (self.settings.model) {
			var col = self.getModelField(self.settings.primaryKey);
			return rowData[col.model][col.field];
		}
		return rowData[self.settings.primaryKey];
	}

	this.getRowURL = function(rowData, href) {
		var id = self.getID(rowData);
		return href.replace(/\{\$id\}/ig, id).replace(/~id/ig, id).replace(/\%7Eid/ig, id);
	}

	this.renderTableCell = function(value, col, rowData) {
		var _class = new Array();
		_class.push('text-' + col.align);
		if (typeof(col.nowrap) != 'undefined' && col.nowrap) {
			_class.push('nowrap');
		}
		if (col.format == 'text') {
			_class.push('format-text');
		}
		var td = '<td';
		var attr = _class.join(' ');
		if (attr) {
			td+= ' class="' + attr + '"';
		}
		td+= '>';
		return td + self.renderCell(value, col, rowData) + '</td>';
	}

	this.renderCell = function(value, col, rowData) {
		if (value === null || typeof(value) == 'undefined') {
			return '';
		}
		if (col.format == 'text') {
			return '<span>' + value + '</span>';
		} else if (col.format == 'boolean') {
			return (value) ? '<i class="icon-color icon-check"></i>' : '';
		} else if (col.format == 'filesize') {
			return Format.fileSize(value);
		} else if (col.format == 'img') {
			return Format.img(value);
		}
		return value;
	}

	this.renderTableFooter = function() {
		var html = '<tr id="last-tr" class="grid-footer table-gradient"><td colspan="' + self.totalCols() +'" class="nowrap">';
		html+= self.renderFooter();
		html+= '</td></tr>';
		return html;
	}

	this.renderFooter = function() {
		var html = '<table><tbody><tr>';
		html+= self.renderTableCheckedActions();
		html+= self.renderTablePaging();
		html+= self.renderTableRecordsCount();
		html+= '</tr></tbody></table>';
		return html;
	}

	this.renderTableCheckedActions = function() {
		var html = '<td class="grid-checked-actions">';
		html+= self.renderCheckedActions();
		html+= '</td>';
		return html;
	}

	this.renderCheckedActions = function() {
		var html = '<div class="hide"><small></small><div class="btn-group">';
		html+= '<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
		html+= '<ul class="dropdown-menu">';
		for(var i = 0; i < self.actions.checked.length; i++) {
			var action = self.actions.checked[i];
			var label = (action.icon) ? '<i class="' + action.icon + '"></i>' + action.label : action.label;
			//html+= '<li><a class="' + action.class + '" href="' + action.href + '">' + label + '</a></li>';
			html+= '<li>' + Format.tag('a', {class: action.class, href: action.href, onclick: action.onclick}, label) + '</li>';
		}
		html+= '</ul>';
		html+= '</div></div>';
		return html;
	}

	this.renderTablePaging = function() {
		var html = '<td class="text-center grid-paging">';
		if (self.paging.total > 1) {
			html+= self.renderPageIcons();
			html+= self.renderItemsPerPage();
		} else {
			// html+= '<div style="height: 16px;"></div>';
		}
		html+= '</td>';
		return html;
	}

	this.renderPageIcons = function() {
		var html = '';
		var pagination = self.paging;
		if (pagination.total > 1) {
			html = '<span>Page</span>';
			if (pagination.curr > 1) {
				html+= '<a class="icon-color icon-first grid-paging-first" href="javascript:void(0)" title="Go to first page" rel="tooltip-bottom"></a>';
				html+= '<a class="icon-color icon-prev grid-paging-prev" href="javascript:void(0)" title="Go to previous page" rel="tooltip-bottom"></a>';
			}
			html+= '<input type="text" class="grid-paging-page" value="' + pagination.curr + '" style="width: 17px;">';
			if (pagination.curr < pagination.total) {
				html+= '<a class="icon-color icon-next grid-paging-next" href="javascript:void(0)" title="Go to next page" rel="tooltip-bottom"></a>';
				html+= '<a class="icon-color icon-last grid-paging-last" href="javascript:void(0)" title="Go to last page" rel="tooltip-bottom"></a>';
			}
		}
		return html;
	}

	this.renderItemsPerPage = function() {
		var html = '';
		if (self.paging.total > 1) {
			html = '<span></span><select class="grid-paging-perpage">';
			for(var i = 0; i < self.paging.perPageList.length; i++) {
				var perPage = self.paging.perPageList[i];
				var selected = (perPage == self.paging.limit) ? ' selected="selected"' : '';
				html+= '<option value="' + perPage + '"' + selected + '>' + self.paging.perPageList[i] + '</option>';
			}
			html+= '</select><span>records per page</span>';
		}
		return html;
	}

	this.renderTableRecordsCount = function() {
		// var style = (self.paging.total > 1 && self.paging.count) ? '' : ' style="height: 24px;"';
		var style = '';
		var html = '<td class="text-right grid-records-count">';
		html+= self.renderRecordsCount();
		html+= '</td>';
		return html;
	}

	this.renderRecordsCount = function() {
		var pagination = self.paging;
		if (pagination.total > 1 && pagination.count) {
			return '<span>' + pagination.count + '</span>';
		}
		return ''; //'<span>&nbsp;</span>';
	}
	
	this.bindAll = function() {
	    self.bindCheckAll();
		self.bindCheckboxes();
		self.bindFilter();
		self.bindPaging();
		self.bindSorting();
		self.bindTooltips();
	}

	this.bindCheckAll = function() {
		$('.grid-chbx-checkAll', $self).change(function(){
			var allChecked = this.checked;
			$('.grid-chbx-row', $self).each(function(){
				this.checked = allChecked;
				var tr = $(this).parent().parent();
				tr.removeClass('grid-row-selected');
				if (allChecked) {
					tr.addClass('grid-row-selected');
				}
			});
			self.updateCheckedActions();
		});

	}

	this.bindCheckboxes = function() {
		$('.grid-chbx-row', $self).change(function(){
			$(this).parent().parent().toggleClass('grid-row-selected');
			self.updateCheckedActions();
		});
	}

	this.updateCheckedActions = function() {
		var checked = $('.grid-chbx-row:checked', $self).size();
		$('.grid-checked-actions div', $self).removeClass('hide');
		if (!checked) {
			$('.grid-checked-actions div', $self).addClass('hide');
		} else {
			$('.grid-checked-actions small', $self).html(checked + ' records checked');
		}
	}

	this.cookie = function(property, val) {
		var grid = {};
		grid[self.container] = {};
		grid = $.extend(grid, JSON.parse($.cookie('grid')));
		if (typeof(property) == 'undefined') {
			return grid[self.container];
		}
		if (typeof(val) == 'undefined') {
			return grid[self.container][property];
		}
		grid[self.container][property] = val;
		return $.cookie('grid', JSON.stringify(grid), {expires: 365, path: '/'});
	}

	this.bindFilter = function() {
		$('.grid-show-filter', $self).click(function(){
			$('.grid-filter', $self).toggleClass('hide');
			self.cookie('showFilter', !$('.grid-filter', $self).hasClass('hide'));
		});
		$('.grid-filter-date', $self).datepicker({
			dateFormat: "dd.mm.yy",
			buttonImage: "/Icons/img/calendar.png",
			showOn: "button",
			buttonImageOnly: true,
			changeYear: true,
			changeMonth: true
		});
		$('.grid-filter-submit', $self).click(function(){
			self.submitFilter();
		});
		$('.grid-filter-clear', $self).click(function(){
			self.clearFilter();
		});
	}

	this.bindPaging = function() {
		$('.grid-paging-page', $self).change(function(){
			self.paging.curr = this.value;
			self.update();
		});
		$('.grid-paging-first', $self).click(function(){
			self.paging.curr = 1;
			self.update();
		});
		$('.grid-paging-last', $self).click(function(){
			self.paging.curr = self.paging.total;
			self.update();
		});
		$('.grid-paging-prev', $self).click(function(){
			self.paging.curr = self.paging.curr - 1;
			self.update();
		});
		$('.grid-paging-next', $self).click(function(){
			self.paging.curr = self.paging.curr + 1;
			self.update();
		});
		$('.grid-paging-perpage', $self).change(function(){
			self.paging.limit = this.value;
			self.update();
		});
	}

	this.bindSorting = function(){
		$('.grid-sortable', $self).click(function(){
			var key = $(this).parent().data('grid_col');
			self.settings.sort = key;
			self.settings.direction = (!self.settings.direction || self.settings.direction == 'desc') ? 'asc' : 'desc';
			self.update();
		});
	}

	this.bindTooltips = function() {
		$('*[rel="tooltip"]', $self).tooltip();
	    $('*[rel="tooltip-bottom"]', $self).tooltip({
	        placement: "bottom"
	    });
	}

	this.submitFilter = function() {
		self.update();
	}

	this.clearFilter = function() {
		$('.grid-filter-input', $self).val('');
		// self.update();
    }

	this.getURL = function() {
		// handle pagination
		var pagination = self.paging;
		var params = {};
		if (self.paging.curr > self.defaults.page) {
			params.page = self.paging.curr;
		}
		// if (self.paging.limit != self.defaults.limit) {
			params.limit = self.paging.limit;
		// }
		// handle sorting
		if ((self.settings.sort != self.defaults.sort) || (self.settings.direction != self.defaults.direction)) {
			params.sort = self.settings.sort;
			params.direction = self.settings.direction;
		}
		// handle filter
		$('.grid-filter-input', $self).each(function(){
			if (this.value) {
				params[self.cleanFilterName(this.name)] = self.getFilterValue(this);
			}
		});
		var url = self.settings.baseURL;
		url+= self.settings.urlDiv + self.getFilterURL(params);
		return url;
	}

	this.getFilterValue = function(e) {
		var val = e.value;
		if ($(e).hasClass('grid-filter-date')) {
			val = val.split('.').reverse().join('-');
		}
		return escape(val);
	}

	this.getFilterURL = function(params) {
		var pairs = [];
		for(var key in params) {
			// if (self.settings.baseURL) {
				pairs.push(key + self.settings.valueDiv + unescape(params[key]));
			// } else {
				// TODO: replace URL parts
				// var re = new RegExp('/' + param + self.valueDiv + '/');
				// url.replace(re, )
			// }
		}
		return pairs.join(self.settings.paramDiv);
	}

	this.update = function() {
		// console.log(self.getURL());
		window.location.href = self.getURL();
	}
                
	self.init(config);
}