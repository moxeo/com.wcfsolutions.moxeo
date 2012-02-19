<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

/**
 * Outputs a file.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.page
 * @category	Moxeo Open Source CMS
 */
class FileManagerFileDownloadPage extends AbstractPage {
	// system
	public $neededPermissions = 'admin.site.canUseFileManager';
	
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
	 * @see	Page::readParameters()
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
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		parent::show();
		
		// send headers
		// mime type
		@header('Content-Type: application/octet-stream');
			
		// filename
		@header('Content-disposition: attachment; filename="'.basename($this->path).'"');
			
		// filesize
		@header('Content-Length: '.filesize($this->path));
			
		// no cache headers
		@header('Pragma: no-cache');
		@header('Expires: 0');
			
		// show file
		readfile($this->path);
		exit;
	}
}
?>