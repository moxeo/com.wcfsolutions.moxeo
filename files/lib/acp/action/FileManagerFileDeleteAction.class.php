<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Deletes a file.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.action
 * @category	Moxeo Open Source CMS
 */
class FileManagerFileDeleteAction extends AbstractAction {
	/**
	 * file name
	 *
	 * @var string
	 */
	public $file = '';

	/**
	 * path
	 *
	 * @var	string
	 */
	public $path = '';

	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		// get file
		if (isset($_REQUEST['file'])) $this->file = $_REQUEST['file'];
		if (!$this->file) {
			throw new IllegalLinkException();
		}

		// get path
		$this->path = FileUtil::getRealPath(MOXEO_DIR.'files/'.$this->file);
		if (!FileManagerUtil::isValidPath($this->path)) {
			throw new IllegalLinkException();
		}
		if ($this->path == FileManagerUtil::getRootDir()) {
			throw new IllegalLinkException();
		}
	}

	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();

		// check permission
		WCF::getUser()->checkPermission('admin.moxeo.canUseFileManager');

		// delete file
		if (is_dir($this->path)) {
			FileManagerUtil::removeDir(FileUtil::addTrailingSlash($this->path));
		}
		else {
			unlink($this->path);
		}
		$this->executed();

		// forward to list page
		HeaderUtil::redirect('index.php?page=FileManager&dir='.urlencode(dirname($this->file)).'&deletedFile='.urlencode($this->file).'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>