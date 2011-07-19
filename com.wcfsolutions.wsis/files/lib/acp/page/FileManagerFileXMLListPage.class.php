<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

/**
 * Outputs an XML document with a list of files.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.page
 * @category	Infinite Site
 */
class FileManagerFileXMLListPage extends AbstractPage {
	// system
	public $neededPermissions = 'admin.site.canUseFileManager';
	
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
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
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
	 * @see Page::readData()
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
	 * @see Page::show()
	 */
	public function show() {
		parent::show();
		
		// output files (xml)
		header('Content-type: text/xml; charset='.CHARSET);
		echo "<?xml version=\"1.0\" encoding=\"".CHARSET."\"?>\n<files>";
		foreach ($this->files as $file) {
			echo "<file>";
			echo "<name><![CDATA[".StringUtil::escapeCDATA($file['name'])."]]></name>";
			echo "<isDir>".intval($file['isDir'])."</isDir>";
			echo "<size><![CDATA[".($file['size'] ? FileUtil::formatFilesize($file['size']) : '')."]]></size>";
			echo "<date><![CDATA[".($file['date'] ? DateUtil::formatShortTime(null, $file['date'], true) : '')."]]></date>";
			echo "<permissions>".intval($file['permissions'])."</permissions>";
			echo "<relativePath><![CDATA[".$file['relativePath']."]]></relativePath>";
			echo "</file>";
		}
		echo '</files>';
		exit;
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
			return strcmp($fileA['name'], $fileB['name']);
		}
	}
}