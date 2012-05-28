/**
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
var FileManager = Class.create({
	/**
	 * Inits FileManager.
	 */
	initialize: function(key, selectedFiles) {
		this.key = key;
		this.selectedFiles = selectedFiles;
		this.previousSelectedFiles = this.selectedFiles.clone();
		this.options = Object.extend({
			iconCloseSrc:			'',
			iconFileManagerSrc:		'',
			iconFileManagerFileSrc:		'',
			iconFileManagerFolderSrc:	'',
			langClose:			'',
			langFileName:			'',
			langFileSize:			'',
			langFileDate:			'',
			langFilePermissions:		'',
			langFileTypeFolder:		'',
			langFileTypeFile:		'',
			langSelectionApply:		'',
			multipleSelect:			false
		}, arguments[2] || { });
		this.background = null;
		this.container = null;
		this.fileContent = null;
		this.dirs = new Hash();
		this.dir = '';

		// initialize overlay
		this.initializeOverlay();
		$(this.key).observe('click', this.showOverlay.bind(this));
	},

	/**
	 * Loads the files of the current dir.
	 */
	loadFiles: function() {
		if (this.dirs.get(this.dir) == undefined) {
			// start request
			new Ajax.Request('index.php?page=FileManagerFileXMLList&t='+SID_ARG_2ND, {
				method: 'post',
				parameters: {
					dir: this.dir
				},
				onSuccess: function(response) {
					// get files
					var files = response.responseXML.getElementsByTagName('files');
					if (files.length > 0) {
						var newFiles = new Hash();

						for (var i = 0; i < files[0].childNodes.length; i++) {
							newFiles.set(files[0].childNodes[i].childNodes[0].childNodes[0].nodeValue, {
								isDir: files[0].childNodes[i].childNodes[1].childNodes[0].nodeValue,
								size: files[0].childNodes[i].childNodes[2].childNodes[0].nodeValue,
								date: files[0].childNodes[i].childNodes[3].childNodes[0].nodeValue,
								permissions: files[0].childNodes[i].childNodes[4].childNodes[0].nodeValue,
								relativePath: files[0].childNodes[i].childNodes[5].childNodes[0].nodeValue
							});
						}

						this.dirs.set(this.dir, newFiles);
						this.refreshFiles();
					}
				}.bind(this)
			});
		}
		else {
			this.refreshFiles();
		}
	},

	/**
	 * Refreshes the files with the files of the current dir.
	 */
	refreshFiles: function() {
		// headline
		var headline = new Element('h3').update('files/'+(this.dir ? this.dir+'/' : ''));
		var containerHead = new Element('div').addClassName('containerHead').insert(headline);
		var titleBar = new Element('div').addClassName('border').addClassName('titleBarPanel').insert(containerHead);

		// head column icon
		var headColumnIconSpan = new Element('span').addClassName('emptyHead').update('&nbsp;')
		var headColumnIconDiv = new Element('div').insert(headColumnIconSpan);
		var headColumnIconTh = new Element('th', { colspan: 2 }).insert(headColumnIconDiv);

		// head column name
		var headColumnNameSpan = new Element('span').addClassName('emptyHead').update(this.options.langFileName);
		var headColumnNameDiv = new Element('div').insert(headColumnNameSpan);
		var headColumnNameTh = new Element('th').addClassName('columnName').insert(headColumnNameDiv);

		// head column size
		var headColumnSizeSpan = new Element('span').addClassName('emptyHead').update(this.options.langFileSize);
		var headColumnSizeDiv = new Element('div').insert(headColumnSizeSpan);
		var headColumnSizeTh = new Element('th').addClassName('columnSize').insert(headColumnSizeDiv);

		// head column date
		var headColumnDateSpan = new Element('span').addClassName('emptyHead').update(this.options.langFileDate);
		var headColumnDateDiv = new Element('div').insert(headColumnDateSpan);
		var headColumnDateTh = new Element('th').addClassName('columnDate').insert(headColumnDateDiv);

		// head column permissions
		var headColumnPermissionsSpan = new Element('span').addClassName('emptyHead').update(this.options.langFilePermissions);
		var headColumnPermissionsDiv = new Element('div').insert(headColumnPermissionsSpan);
		var headColumnPermissionsTh = new Element('th').addClassName('columnPermissions').insert(headColumnPermissionsDiv);

		// table structure
		var tableHeadRow = new Element('tr').addClassName('tableHead').insert(headColumnIconTh).insert(headColumnNameTh).insert(headColumnSizeTh).insert(headColumnDateTh).insert(headColumnPermissionsTh);
		var tableHead = new Element('thead').insert(tableHeadRow);
		var tableBody = new Element('tbody');

		// files
		var files = this.dirs.get(this.dir);
		files.each(function(item) {
			var name = item.key;
			var file = item.value;

			// column icon
			var fileImage = new Element('img', {
				src: (file.isDir == 1 ? this.options.iconFileManagerFolderSrc : this.options.iconFileManagerFileSrc),
				alt: (file.isDir == 1 ? this.options.langFileTypeFolder : this.options.langFileTypeFile),
				title: (file.isDir == 1 ? this.options.langFileTypeFolder : this.options.langFileTypeFile)
			});
			var columnIcon = new Element('td').addClassName('columnIcon').insert(fileImage);

			// column select
			var columnSelect = new Element('td').addClassName('columnIcon').addClassName('columnSelect');
			if (file.isDir == 0) {
				var fileSelect = new Element('input', { name: 'fileManagerFileSelect', type: (this.options.multipleSelect ? 'checkbox' : 'radio') });
				if (this.selectedFiles.indexOf(file.relativePath) != -1) {
					fileSelect.checked = 1;
				}
				fileSelect.observe('change', function(file, fileSelect) {
					if (!this.options.multipleSelect) {
						this.uncheckAll();
					}
					if (fileSelect.checked) {
						this.selectedFiles.push(file.relativePath);
					}
					else {
						this.selectedFiles.splice(this.selectedFiles.indexOf(file.relativePath), 1);
					}
				}.bind(this, file, fileSelect));
				columnSelect.insert(fileSelect);
			}

			// column name
			var fileLink = new Element('a').update(name);
			if (file.isDir == 0) {
				fileLink.setAttribute('href', 'index.php?page=FileManagerFileDownload&file='+encodeURIComponent(file.relativePath)+'&packageID='+PACKAGE_ID+SID_ARG_2ND);
			}
			else {
				fileLink.observe('click', function(name, file) {
					this.dir = file.relativePath;
					this.loadFiles(this.dir+name);
				}.bind(this, name, file));
			}
			var columnName = new Element('td').addClassName('columnName').addClassName('columnText').insert(fileLink);

			// column size
			var columnSize = new Element('td').addClassName('columnDate').addClassName('columnText').update(file.size);

			// column date
			var columnDate = new Element('td').addClassName('columnDate').addClassName('columnText').update(file.date);

			// column permissions
			var columnPermissions = new Element('td').addClassName('columnPermissions').addClassName('columnNumbers');
			if (file.permissions != 0) {
				columnPermissions.update(file.permissions);
			}

			// file row
			var fileRow = new Element('tr').insert(columnIcon).insert(columnSelect).insert(columnName).insert(columnSize).insert(columnDate).insert(columnPermissions);
			tableBody.insert(fileRow);
		}.bind(this));

		// table
		var table = new Element('table').addClassName('tableList').insert(tableHead).insert(tableBody);
		var tableDiv = new Element('div').addClassName('border').addClassName('borderMarginRemove').insert(table);

		// update content
		this.fileContent.update();
		this.fileContent.insert(titleBar).insert(tableDiv);
	},

	/**
	 * Unchecks all files.
	 */
	uncheckAll: function() {
		this.dirs.each(function(item) {
			var files = item.value;
			files.each(function(item) {
				var file = item.value;
				this.selectedFiles.splice(this.selectedFiles.indexOf(file.relativePath), 1);
			}.bind(this));
		}.bind(this));
	},

	/**
	 * Initializes the overlay.
 	 */
	initializeOverlay: function() {
		// create overlay background
		this.background = new Element('div').addClassName('overlayBackground').hide();

		// create headline
		var iconClose = new Element('img', { src: this.options.iconCloseSrc, title: this.options.langClose }).addClassName('pointer');
		var spanButtons = new Element('span').addClassName('buttons').insert(iconClose);
		var headline = new Element('h3').addClassName('subHeadline').update(this.options.langFileManager).insert(spanButtons);

		// create submit button
		var submitButton = new Element('input', { type: 'submit', value: this.options.langSelectionApply }).observe('click', function() { this.closeOverlay(false); }.bind(this));
		var formSubmit = new Element('div').addClassName('formSubmit').insert(submitButton);

		// create button bar
		var iconFileManager = new Element('img', { src: this.options.iconFileManagerSrc });
		var span = new Element('span').update(this.options.langFileManager);
		var link = new Element('a', { href: 'index.php?page=FileManager'+SID_ARG_2ND, title: this.options.langFileManager }).insert(iconFileManager).insert(' ').insert(span);
		var listItem = new Element('li').insert(link);
		var list = new Element('ul').insert(listItem);
		var smallButtons = new Element('div').addClassName('smallButtons').insert(list);
		var buttonBar = new Element('div').addClassName('buttonBar').insert(smallButtons);

		// create container
		this.fileContent = new Element('div');
		var content = new Element('div').addClassName('container-1').insert(headline).insert(this.fileContent).insert(formSubmit).insert(buttonBar);
		this.container = new Element('div').addClassName('overlay border content').insert(content).hide();

		// insert elements
		$$('body')[0].insert(this.background).insert(this.container);

		// update overlay
		this.updateOverlay();

		// bind event listeners
		this.background.observe('click', function() { this.closeOverlay(true); }.bind(this));
		iconClose.observe('click', function() { this.closeOverlay(true); }.bind(this));
		Event.observe(window, 'resize', this.updateOverlay.bind(this));
	},

	/**
	 * Stores the values in hidden fields.
	 */
	submit: function(form) {
		this.selectedFiles.each(function(relativePath) {
			// create field
			var field = new Element('input', { 'type': 'hidden', 'name': this.key+(this.options.multipleSelect ? '[]' : ''), 'value': relativePath });

			// insert field
			form.insert(field);
		}.bind(this));
	},

	/**
	 * Shows the overlay.
	 */
	showOverlay: function() {
		if (this.background.visible()) return;

		this.background.appear({
			duration: 0.3,
			from: 0.0,
			to: 0.6,
			afterFinish: function() {
				// save initial selected files
				this.previousSelectedFiles = this.selectedFiles.clone();

				// load files
				this.loadFiles();

				// show container
				this.container.show();
			}.bind(this)
		});
	},

	/**
	 * Updates the position of the overlay.
	 */
	updateOverlay: function() {
		// get container dimensions
		var dimensions = document.viewport.getDimensions();
		var height = dimensions.height * 0.8;
		var width = dimensions.width * 0.8;

		// get offsets
		var leftOffset = (dimensions.width - width) / 2;
		var topOffset = (dimensions.height - height) / 2;

		// set style
		this.container.setStyle({
			left: leftOffset+'px',
			top: topOffset+'px',
			width: width+'px'
		});
	},

	/**
	 * Closes the overlay.
	 */
	closeOverlay: function(discardChanges) {
		// discard changes
		if (discardChanges) {
			this.selectedFiles = this.previousSelectedFiles;
		}

		// hide background
		this.background.fade({
			duration: 0.3,
			from: 0.6,
			to: 0.0,
			beforeStart: function() {
				// hide container
				this.container.hide();
			}.bind(this)
		});
	}
});