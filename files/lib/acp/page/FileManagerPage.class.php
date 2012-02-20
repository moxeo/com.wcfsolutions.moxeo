<?php
// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');

/**
 * Shows a list of all files.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.page
 * @category	Moxeo Open Source CMS
 */
class FileManagerPage extends SortablePage {
	// system
	public $templateName = 'fileManager';
	public $neededPermissions = 'admin.moxeo.canUseFileManager';
	public $defaultSortField = 'name';

	/**
	 * dir name
	 *
	 * @var string
	 */
	public $dir = '';

	/**
	 * path
	 *
	 * @var	string
	 */
	public $path = '';

	/**
	 * list of files
	 *
	 * @var	array
	 */
	public $files = array();

	/**
	 * deleted file
	 *
	 * @var	integer
	 */
	public $deletedFile = '';

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_REQUEST['deletedFile'])) $this->deletedFile = $_REQUEST['deletedFile'];

		// get dir
		if (isset($_REQUEST['dir'])) $this->dir = FileUtil::addTrailingSlash($_REQUEST['dir']);

		// get path
		$this->path = FileManagerUtil::getPath($this->dir);
		if ($this->path === false) {
			throw new IllegalLinkException();
		}
		$this->dir = FileManagerUtil::getRelativePath($this->path);
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();

		// get files
		$this->files = FileManagerUtil::getFiles($this->path);

		// sort files
		usort($this->files, array($this, 'compareFiles'));

		// add up link
		if ($this->path != FileManagerUtil::getRootDir()) {
			array_unshift($this->files, FileManagerUtil::getParentDirInfo($this->dir));
		}
	}

	/**
	 * @see	SortablePage::validateSortField()
	 */
	public function validateSortField() {
		parent::validateSortField();

		switch ($this->sortField) {
			case 'name':
			case 'date':
			case 'size':
			case 'permissions': break;
			default: $this->sortField = $this->defaultSortField;
		}
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		// init file add form
		require_once(MOXEO_DIR.'lib/acp/form/FileManagerFileAddForm.class.php');
		new FileManagerFileAddForm($this->dir, $this->path);

		WCF::getTPL()->assign(array(
			'dir' => $this->dir,
			'path' => $this->path,
			'files' => $this->files,
			'deletedFile' => $this->deletedFile
		));
	}

	/**
	 * @see	Page::show()
	 */
	public function show() {
		// enable menu item
		WCFACP::getMenu()->setActiveMenuItem('moxeo.acp.menu.link.system.fileManager');

		parent::show();
	}

	/**
	 * Compares the two given files.
	 *
	 * @param	array		$fileA
	 * @param	array		$fileB
	 * @return	integer
	 */
	public function compareFiles($fileA, $fileB) {
		if ($fileA['isDir'] > $fileB['isDir']) {
			return -1;
		}
		else if ($fileA['isDir'] < $fileB['isDir']) {
			return 1;
		}
		else {
			if ($this->sortField != 'name') {
				if ($fileA[$this->sortField] != $fileB[$this->sortField]) {
					if ($this->sortOrder == 'ASC') {
						if ($fileA[$this->sortField] > $fileB[$this->sortField]) return 1;
						else return -1;
					}
					else {
						if ($fileA[$this->sortField] > $fileB[$this->sortField]) return -1;
						else return 1;
					}
				}
			}

			if ($this->sortOrder == 'ASC') {
				return strcmp($fileA['name'], $fileB['name']);
			}
			else {
				return strcmp($fileB['name'], $fileA['name']);
			}
		}
	}
}
?>